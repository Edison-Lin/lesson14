<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Content-Type: application/json;charset=utf-8'); //return json string

if(isset($_POST['token']) && $_POST['token']!='') {
   $token=$_POST['token']; //從token取得sessionId
    session_id($token);
    session_start();
	if($_SESSION['token']==$_POST['token']){
        unset($_SESSION['token']);
        unset($_SESSION['adid']);
        unset($_SESSION['adlogin']);
        unset($_SESSION['adname']);
        unset($_SESSION['ademail']);
        unset($_SESSION['groupid']);
        unset($_SESSION['gpname']);
        unset($_SESSION['gpename']);
        unset($_SESSION['avatar']);
        unset($_SESSION['lastlogin']);
        unset($_SESSION['sip']);
        $retcode =array("code"=>"20000","data"=>"","message"=>"系統成功登出！！","status"=>"OK");
        setcookie(session_name(), '', time() - 42000);
        session_destroy();
    }else{
        $retcode =array("code"=>"50008","data"=>"","message"=>"token無效，請重新登入！！","status"=>"Fail");
        }
    echo json_encode($retcode, JSON_UNESCAPED_UNICODE);
}
return ;
