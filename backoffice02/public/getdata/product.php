<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Content-Type: application/json;charset=utf-8'); //return json string

require_once('conn_db.php');    //取得資料連線設定
$retcode = array("code" => "50008", "data" => "", "message" => "token無效，請重新登入！！", "status" => "Fail");
$SQLstr = "SELECT p_id,p_name,p_intro,p_price,p_date FROM product";
$result = $link->query($SQLstr);
if ($result) {
    $data=$result->fetchAll(PDO::FETCH_ASSOC);
        $retcode = array("code" => "20000", "data" => $data, "message" => "success", "status" => "OK");
}
echo json_encode($retcode, JSON_UNESCAPED_UNICODE);
return;
