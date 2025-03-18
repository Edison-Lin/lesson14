<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Content-Type: application/json;charset=utf-8'); //return json string
require_once('conn_db.php');
//取得資料庫的寫入表格與模式，只能存取單一表格
if (isset($_POST['mode']) && $_POST['mode'] != '') {
    $mode = $_POST['mode'];
    switch ($mode) {
        case 'caro_Online':     //carousel表格，資料更新模式
            $caro_online = $_POST['caro_online'];
            $caro_id = $_POST['caro_id'];
            //carousel資料庫更新指令
            $SQL=sprintf("UPDATE carousel SET caro_online='%d' WHERE carousel.caro_id='%d'",$caro_online,$caro_id);
            $msg="carousel資料更新成功！";
            break;
        case 'caro_Delete':     //carousel表格，單筆資料刪除模式
            $caro_id = $_POST['caro_id'];
            //carousel資料庫刪除指令
            $SQL=sprintf("DELETE FROM carousel WHERE carousel.caro_id='%d'",$caro_id);
            $msg="carousel資料刪除成功！";
            break;
        case 'caro_Update':     //carousel表格，資料更新模式
            $caro_title = $_POST['caro_title'];
            $caro_content = $_POST['caro_content'];
            $caro_online = $_POST['caro_online'];
            $caro_sort = $_POST['caro_sort'];
            $p_id = $_POST['p_id'];
            $caro_pic = $_POST['caro_pic'];
            $caro_id = $_POST['caro_id'];
            //carousel資料庫更新指令
            $SQL=sprintf("UPDATE carousel SET caro_title='%s', caro_content='%s', caro_online='%d', caro_sort='%d', p_id='%d', caro_pic='%s' WHERE carousel.caro_id='%d'",$caro_title,$caro_content,$caro_online,$caro_sort,$p_id,$caro_pic,$caro_id);
            $msg="carousel資料更新成功！";
            break;
        case 'caro_Append':     //carousel表格，資料新增模式
            $caro_title = $_POST['caro_title'];
            $caro_content = $_POST['caro_content'];
            $caro_online = $_POST['caro_online'];
            $caro_sort = $_POST['caro_sort'];
            $p_id = $_POST['p_id'];
            $caro_pic = $_POST['caro_pic'];
            $SQL = sprintf("INSERT INTO `carousel` (caro_title, caro_content, caro_online, caro_sort, p_id, caro_pic) VALUES ('%s', '%s', '%d', '%d', '%d', '%s');",$caro_title,$caro_content,$caro_online,$caro_sort,$p_id,$caro_pic);
            $msg="carousel資料新增成功！";
            break;
        case 'InsertProductImg':
            $fileName=$_POST['fileName']; 
            $p_id=$_POST['p_id'];
            $sort=$_POST['sort'];
            $SQL=sprintf("INSERT INTO product_img (p_id, img_file, sort) VALUES ('%d','%s','%d');",$p_id,$fileName,$sort);
            $msg="產品圖片資料新增成功！";
            break;
        case 'product':
            $SQL = sprintf("SELECT product.* FROM product WHERE 1");
            break;
    }
    $result = $link->query($SQL);
    if ($result) {
        //建立回傳陣列
        $retcode = array("code" => "200", "data" =>"" , "message" => $msg, "status" => "OK");
    } else {
        $retcode = array("code" => "0", "data" => "", "message" => "抱歉！資料無法取得後台資料庫，請連絡管理人員。", "status" => "ERROR");
    }
    echo json_encode($retcode, JSON_UNESCAPED_UNICODE);
}
return;
