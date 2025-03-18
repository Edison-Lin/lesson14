<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Content-Type: application/json;charset=utf-8'); //return json string

if(isset($_GET['token']) && $_GET['token']!='') {
    $token=$_GET['token'];
    session_id($token);
    session_start();
	if($_SESSION['token']==$token){
        $retcode =array("code"=>"20000","data"=>array(
            "token"=>$_SESSION['token'],
            "adid"=>$_SESSION['adid'],
            "adlogin"=>$_SESSION['adlogin'],
            "adname"=>$_SESSION['adname'],
            "ademail"=>$_SESSION['ademail'],
            "groupid"=>$_SESSION['groupid'],
            "gpname"=>$_SESSION['gpname'],
            "gpename"=>$_SESSION['gpename'],
            "avatar"=>$_SESSION['avatar'],
        ),"message"=>"success","status"=>"OK");
    }else{
        $retcode =array("code"=>"50008","data"=>"","message"=>"token無效，請重新登入！！","status"=>"Fail");
        }
    echo json_encode($retcode, JSON_UNESCAPED_UNICODE);
}
return ;
?>
