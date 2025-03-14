<?php
//PDO sql資料庫連線程式
$dsn = "mysql:host=sql313.infinityfree.com;dbname=if0_38102345_pharmacy;charset=utf8";
$user="if0_38102345";
$password="Wl02257385";
$link=new PDO($dsn,$user,$password);
date_default_timezone_set("Asia/Taipei");
//php 5.3.6 以前版本
$link->exec("set names utf8");
