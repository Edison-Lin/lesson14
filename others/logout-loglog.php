<?php
(!isset($_SESSION)) ? session_start() : "";

// 清空 session 資料
$_SESSION['login'] = null;
$_SESSION['emailid'] = null;
$_SESSION['email'] = null;
$_SESSION['cname'] = null;

// 移除 session 變數
unset($_SESSION['login']);
unset($_SESSION['emailid']);
unset($_SESSION['email']);
unset($_SESSION['cname']);

// 重定向到首頁
$sPath = "index.php";
header(sprintf("Location: %s", $sPath));
?>
