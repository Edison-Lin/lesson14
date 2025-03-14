<?php
$Connection="../Connections/";
include_once($Connection."conn_db.php");
if(isset($_GET['email'])){
    $email=$_GET['email'];
    $query="SELECT emailid FROM member WHERE email='".$email."'";
    
    $result=$link->query($query);
    $row=$result->rowCount();
    if($row==0){
        echo 'true';
        exit();
    }
}
echo 'false';
exit();
?>