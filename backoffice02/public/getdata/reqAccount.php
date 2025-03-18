<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json;charset=utf-8'); //return json string

require_once('conn_db.php');    //取得資料連線設定
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    //進行帳號密碼查詢
    $SQLstr = sprintf("SELECT ad_user.*,ad_group.gpname,ad_group.gpename, ad_group.active as gActive  FROM ad_user,ad_group WHERE ad_user.groupid=ad_group.groupid AND adlogin='%s' AND adpasswd='%s' ", $username, $password);
    $result = $link->query($SQLstr);
    if ($result && $result->rowCount() != 0) {
        $data = $result->fetch();
        if ($data['active'] == 1) {
                (!isset($_SESSION)) ? session_start() : '';
                $_SESSION['token'] = session_id(); //使用session編碼為token值
                $_SESSION['adid'] = $data['adid'];
                $_SESSION['adlogin'] = $data['adlogin'];
                $_SESSION['adname'] = $data['adname'];
                $_SESSION['ademail'] = $data['ademail'];
                $_SESSION['groupid'] = $data['groupid'];
                $_SESSION['gpname'] = $data['gpname'];
                $_SESSION['gpename'] = $data['gpename'];
                $_SESSION['avatar'] = $data['avatar'];
                $_SESSION['lastlogin'] = $data['lastlogin'];
                $_SESSION['allowip'] = $data['allowip'];
                $_SESSION['sip'] = $data['sip'];

                $retcode = array("code" => "20000", "data" => array("token" => $_SESSION['token'],),"message" => "success", "status" => "OK");
        } else {
            $retcode = array("code" => "50002", "data" => "", "message" => "帳號或是群組被停用，請連絡管理人員！！", "status" => "ERROR");
        }
    } elseif ($result->rowCount() == 0) {
        $retcode = array("code" => "50006", "data" => "", "message" => "帳號或密碼錯誤，請重新輸入！！", "status" => "ERROR");
    } else {
        $retcode = array("code" => "40002", "data" => "", "message" => "抱歉！資料無法取得後台資料庫，請連絡管理人員。", "status" => "ERROR");
    }
    echo json_encode($retcode, JSON_UNESCAPED_UNICODE);
}
return;
