<?php
$path = "../config.ini";
$ini = parse_ini_file($path);
$host = $ini['host'];
$user = $ini['user'];
$password = $ini['password'];
$database = $ini['database'];
$charset = $ini['charset'];
$timezone = $ini['timezone'];
// $SIGNATURE = $ini['SIGNATURE'];
// php時區設定
date_default_timezone_set($timezone);

//PDO SQL連線變數$link，與設定資料庫時區 
$dsn = "mysql:host=" . $host . ";dbname=" . $database . ";charset=" . $charset;
$link = new PDO($dsn, $user, $password);
$link->exec("SET TIME_ZONE = '" . date('P') . "';");
?>