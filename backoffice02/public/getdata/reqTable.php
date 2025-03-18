<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Content-Type: application/json;charset=utf-8'); //return json string
// page     取得第page的資料
// table    取得那個的資料表查詢
// limit    每頁的資料筆數上限
// 測試範例
// http://localhost/getdata/reqTable.php?page=1&table=product&limit=3
// 返迴變數定義：
// current:1    目前的頁數
// pages:6      總頁數
// records:     回傳的資料
// searchCount:true  搜尋功能
// size:3       每頁筆數
// total:17     總筆數
require_once('conn_db.php');

if (isset($_GET['table']) && $_GET['table'] != '') {
    $table = $_GET['table'];
    $page = 0;                              //起啟頁=0
    if (isset($_GET['page']) && $_GET['page'] != 0) {
        $page = $_GET['page'] - 1;
        $current = $_GET['page'];           //取得目前的頁數
    }
    $startRow = $page * $_GET['limit'];     //計算每頁在資料庫起啟的筆數
    $size = $_GET['limit'];                 //設定每頁的筆數

    switch ($table) {
        case 'member':
            $keyWord=$_GET['keyWord'];
            $firstSQL = sprintf("SELECT * FROM member WHERE (member.email LIKE '%s' OR member.cname LIKE '%s' ) ORDER BY member.create_date DESC","%".$keyWord."%","%".$keyWord."%");
            break;
        case 'uorder':
            $orderId="'%".$_GET['orderId']."%'";
            $account="'%".$_GET['account']."%'";
            $receiver="'%".$_GET['receiver']."%'";
            if(isset($_GET['dateRange0']) && $_GET['dateRange0']!="" ){
                $dateRange0=$_GET['dateRange0'];
                $dateRange1=$_GET['dateRange1'];
                $dateStr="AND (uorder.create_date >='".$dateRange0."' AND uorder.create_date <='".$dateRange1."')";
            }else {
                $dateStr="";
            }
            $howpay=($_GET['howpay']=="")?"":"AND uorder.howpay=".$_GET['howpay'];
            $status=($_GET['status']=="")?"":"AND uorder.status=".$_GET['status'];
            $emailid=($_GET['emailid']=="")?"":"AND uorder.emailid=".$_GET['emailid'];
            $whereSQL=sprintf("(uorder.orderid LIKE %s AND (member.email LIKE %s OR member.cname LIKE %s) AND (addbook.cname LIKE %s OR addbook.mobile LIKE %s ) %s ) %s %s %s",$orderId,$account,$account,$receiver,$receiver,$dateStr,$howpay,$status,$emailid);
            $firstSQL = sprintf("SELECT uorder.orderid,uorder.create_date,uorder.status,uorder.remark,member.email,member.cname,addbook.cname as addname,addbook.mobile,addbook.myzip,addbook.address,sum(product.p_price*cart.qty) as ototal,ms1.msname as howpayName,ms2.msname as statusName FROM uorder JOIN member ON uorder.emailid=member.emailid JOIN addbook ON uorder.addressid=addbook.addressid JOIN cart ON uorder.orderid=cart.orderid JOIN product ON cart.p_id=product.p_id JOIN multiselect as ms1 ON uorder.howpay=ms1.msid JOIN multiselect as ms2 ON uorder.status=ms2.msid WHERE (%s) GROUP BY uorder.orderid ORDER BY uorder.create_date DESC",$whereSQL);
            break;
        case 'ad_group':
            $keyWord=$_GET['keyWord'];
            $firstSQL = sprintf("SELECT * FROM ad_group WHERE ad_group.gpname LIKE '%s' OR ad_group.gpename LIKE '%s' ORDER BY create_date DESC ","%".$keyWord."%","%".$keyWord."%");
            break;
        case 'ad_user':
            $keyWord=$_GET['keyWord'];
            $firstSQL = sprintf("SELECT ad_user.*,ad_group.gpname,ad_group.gpename FROM ad_user,ad_group WHERE ad_user.groupid=ad_group.groupid AND (ad_user.adlogin LIKE '%s' OR ad_user.adname LIKE '%s' ) ORDER BY ad_user.update_date DESC","%".$keyWord."%","%".$keyWord."%");
            break;
        case 'carousel':
            $firstSQL = sprintf("SELECT carousel.*,product.p_name FROM carousel,product WHERE carousel.p_id=product.p_id ORDER BY caro_id DESC",$table);
            // $firstSQL = sprintf("SELECT carousel.*,product.p_name FROM carousel,product WHERE carousel.p_id=product.p_id ");
            break;
        case 'product':
            $keyWord=$_GET['keyWord'];
            $firstSQL = sprintf("SELECT product.*,product_img.img_file FROM product,product_img WHERE product.p_id=product_img.p_id AND product_img.sort=1 AND (product.p_name LIKE '%s' OR product.p_id LIKE '%s')","%".$keyWord."%","%".$keyWord."%");
            break;    
        case 'product01':
            //建立產品的分類查詢
            $classid=$_GET['classid'];
            $firstSQL = sprintf("SELECT * FROM product WHERE classid='%d' ORDER BY product.p_id DESC",$classid);
            break;    
    }
    // echo "<h1>$firstSQL</h1>";
    $result = $link->query($firstSQL);
    if ($result) {
        $total = $result->rowCount();     //取得總筆數
        $pages = ceil($total / $size);      //計算總頁數
        $SQLstr = sprintf("%s LIMIT %d,%d;", $firstSQL, $startRow, $_GET['limit']);
        $result = $link->query($SQLstr);
        //整合各參數
        $integrate = array("current" => $current, "pages" => $pages, "records" => $result->fetchAll(PDO::FETCH_ASSOC), "searchCount" => true, "size" => $size, "total" => $total);
        //建立回傳陣列
        $retcode = array("code" => "200", "data" => $integrate, "message" => "success", "status" => "OK");
    } else {
        $retcode = array("code" => "0", "data" => "", "message" => "抱歉！資料無法取得後台資料庫，請連絡管理人員。", "status" => "ERROR");
    }
    echo json_encode($retcode, JSON_UNESCAPED_UNICODE);
}
return;
