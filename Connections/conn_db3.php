<?php
//PDO sql資料庫連線程式
$dsn = "mysql:host=mysql-esonboy1024.alwaysdata.net:3306;dbname=esonboy1024_pharmacy;charset=utf8";
$user="404790_esonboy";
$password="Wl02257385";
$link=new PDO($dsn,$user,$password);
date_default_timezone_set("Asia/Taipei");
//php 5.3.6 以前版本
$link->exec("set names utf8");
