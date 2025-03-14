<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type:application/json;charset=utf-8'); //return json string

$Connection="../Connections/";
require_once($Connection.'conn_db.php');

if (isset($_GET['p_id']) && isset($_GET['qty'])) {
    $p_id = $_GET['p_id'];
    $qty = $_GET['qty'];
    $u_ip = $_SERVER['REMOTE_ADDR'];
    //查詢是否有相同的產品編號
    $query = "SELECT * FROM cart WHERE p_id=" . $p_id . " AND ip='" . $_SERVER['REMOTE_ADDR'] . "' AND orderid IS NULL";
    
    $result = $link->query($query);
    if ($result) {
        if ($result->rowCount() == 0) {
            $query = "INSERT INTO cart (p_id,qty,ip) VALUES (" . $p_id . "," . $qty . ",'" . $u_ip . "')";
            
            $string="謝謝您!訂購產品已加入購物車。";
        } else {
            $cart_data = $result->fetch();
            if ($cart_data['qty'] + $qty > 20) {
                $qty = 20;
                $string="很抱歉，訂購產品已達限購上限20個，\n故本次訂購將本項產品訂購總數量紀錄為20個。";
            } else {
                $qty = $qty + $cart_data['qty'];
                $string="謝謝您的訂購!本產品項目，目前共下訂".$qty."個";
            }
            $query = "UPDATE cart SET qty='$qty' WHERE cart.cartid=" . $cart_data['cartid'];
        }
        $result = $link->query($query);
        $retcode = array('c' => "1", 'm' => $string);
    } else {
        //當寫入資料庫超時，會直接回傳錯誤訊息
        $retcode = array('c' => "0", 'm' => "抱歉!資料無法寫入後台資料庫，請聯絡管理人員。");
    }    
    echo json_encode($retcode, JSON_UNESCAPED_UNICODE);
}
return;
