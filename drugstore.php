<?php
(!isset($_SESSION)) ? session_start() : "";
// if(!isset($_SESSION))session_start(); 
// 如果SESSION沒有啟動，則啟動SESSION功能，這是跨網頁變數存取
?>
<!-- 這是將資料庫，連接程式載入 -->
<?php require('Connections/conn_db.php') ?>
<!-- 載入共用php函式庫 -->
<?php $phpFileDir = "./include/"; ?>
<?php require_once($phpFileDir . "php_lib.php"); ?>

<!doctype html>
<html lang="zh-tw">

<head>
    <!-- 引入網頁標頭 -->
    <?php require_once($phpFileDir . "headfile.php"); ?>
</head>

<body>
    <!-- 頁首 Header -->
    <section id="header">
        <!-- 引入導覽列 -->
        <?php require_once($phpFileDir . "navbar.php"); ?>
    </section>
    <!-- 內容區 Content -->
    <section id="content">
        <div class="container-fluid">
            <div class="row">
                <!-- 左側內容區 -->
                <div class="col-md-2">
                    <!-- 搜尋欄 -->
                    <!-- 引入sidebar分類導覽 -->
                    <?php require_once($phpFileDir . "sidebar.php"); ?>
                    <!-- 引入熱銷商品模組 -->
                    <?php require_once($phpFileDir . "hot.php"); ?>
                </div>
                <!-- 右側內容區 -->
                <div class="col-md-10">
                     <!-- 引入breadcrumb -->
                     <?php require_once($phpFileDir . "breadcrumb.php"); ?>
                    
                    <!-- 引入product藥妝商品 -->
                    <?php require_once($phpFileDir . "product_list.php"); ?>
                </div>
            </div>
        </div>
    </section>
    <hr>
    <section id="scontent">
        <!-- 引入scontent 服務說明-->
        <?php require_once($phpFileDir . "scontent.php"); ?>
    </section>
    <section id="footer">
        <!-- 引入footer 聯絡資訊-->
        <?php require_once($phpFileDir . "footer.php"); ?>
    </section>
</body>

</html>
<!-- 引入js.php -->
<?php require_once($phpFileDir . "jsfile.php"); ?>
