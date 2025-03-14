<?php
(!isset($_SESSION)) ? session_start() : "";
// if(!isset($_SESSION))session_start(); 
// 如果SESSION沒有啟動，則啟動SESSION功能，這是跨網頁變數存取
?>
<!-- 這是將資料庫，連接程式載入 -->
<?php require('./Connections/conn_db.php') ?>
<?php require_once("./php_lib.php"); ?>

<!doctype html>
<html lang="zh-tw">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>電商藥粧</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.2.1/css/all.css">
    <link rel="stylesheet" href="./website_s01.css">
    <style>
        li {
            margin-left: 1px;
            margin-right: 1px;
        }
    </style>
</head>

<body>
    <!-- 頁首 Header -->
    <section id="header">
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container-fluid">
                <!-- 頁首LOGO-連結 -->
                <a class="navbar-brand" href="#">
                    <img src="./images/logo.jpg" class="img-fluid rounded-circle" alt="電商藥粧">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- 標頭選單 -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <!-- 產品資訊<list> -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                產品資訊
                            </a>
                            <?php
                            $SQLstring = "SELECT * FROM pyclass WHERE level=1 ORDER BY sort";
                            $pyclass01 = $link->query($SQLstring);
                            ?>
                            <ul class="dropdown-menu">
                                <?php
                                while ($pyclass01_Rows = $pyclass01->fetch()) {
                                ?>
                                    <li class="nav-item dropend">
                                        <a class="dropdown-item dropdown-toggle" href="#"><i class="fas <?php echo $pyclass01_Rows['fonticon']; ?> fa-fw"></i><?php echo $pyclass01_Rows['cname']; ?></a>
                                        <?php
                                        $SQLstring = sprintf("SELECT * FROM pyclass WHERE level=2 AND uplink=%d ORDER BY sort", $pyclass01_Rows['classid']);
                                        $pyclass02 = $link->query($SQLstring);
                                        ?>
                                        <ul class="dropdown-menu">
                                            <?php
                                            while ($pyclass02_Rows = $pyclass02->fetch()) {
                                            ?>
                                                <li><a class="dropdown-item" href="#"><em class="fas <?= $pyclass02_Rows['fonticon']; ?> fa-fw"></em><?= $pyclass02_Rows['cname'] ?></a></li>
                                            <?php } ?>

                                        </ul>
                                    </li>
                                <? } ?>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">會員註冊</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">會員登入</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">會員中心</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">最新活動</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">查訂單</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">折價券</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">購物車</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                企業專區
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">認識企業文化</a></li>
                                <li><a class="dropdown-item" href="#">全台門市資訊</a></li>
                                <li><a class="dropdown-item" href="#">供應商報價服務</a></li>
                                <li><a class="dropdown-item" href="#">加盟專區</a></li>
                                <li><a class="dropdown-item" href="#">投資人專區</a></li>
                            </ul>
                        </li>
                        <?php
                        // multiList01();
                        ?>
                    </ul>

                </div>
            </div>
        </nav>
        <?php
        function multiList01()
        {
            global $link;  //宣告全域變數
            //查詢產品第一層
            $SQLstring = "SELECT * FROM pyclass WHERE level=1 ORDER BY sort";
            $pyclass01 = $link->query($SQLstring);
        ?>
            <?php while ($pyclass01_Rows = $pyclass01->fetch()) { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?= $pyclass01_Rows['cname'] ?>
                    </a>
                    <?php
                    $SQLstring = sprintf("SELECT * FROM pyclass WHERE level=2 AND uplink=%d ORDER BY sort", $pyclass01_Rows['classid']);
                    $pyclass02 = $link->query($SQLstring);
                    ?>
                    <ul class="dropdown-menu">
                        <?php while ($pyclass02_Rows = $pyclass02->fetch()) { ?>
                            <li><a class="dropdown-item" href="#"><em class="fas <?= $pyclass02_Rows['fonticon'] ?> fa-fw"></em><?= $pyclass02_Rows['cname'] ?></a></li>
                        <?php } ?>
                    </ul>
                </li>
        <?php }
        }
        ?>
    </section>
    <!-- 內容區 Content -->
    <section id="content">
        <div class="container-fluid">
            <div class="row">
                <!-- 左側內容區 -->
                <div class="col-md-2">
                    <!-- 搜尋欄 -->
                    <div class="sidebar">
                        <form action="" method="get" id="search" name="search">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search_name" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit"><i class="fas fa-search fa-lg"></i></button>
                                </span>
                            </div>
                        </form>
                    </div>
                    <!-- 產品資訊欄 -->
                    <div class="accordion" id="accordionExample">
                        <?php
                        $SQLstring = "SELECT * FROM pyclass WHERE level=1 ORDER BY sort";
                        $pyclass01 = $link->query($SQLstring);
                        $i = 1;
                        ?>
                        <?php
                        while ($pyclass01_Rows = $pyclass01->fetch()) {
                        ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne<?php echo $i; ?>">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne<?php echo $i; ?>" aria-expanded="true" aria-controls="collapseOne<?php echo $i; ?>">
                                        <i class="fas <?php echo $pyclass01_Rows['fonticon']; ?> fa-fw"></i><?php echo $pyclass01_Rows['cname']; ?>
                                    </button>
                                </h2>
                                <?php
                                $SQLstring = sprintf("SELECT * FROM pyclass WHERE level=2 AND uplink=%d ORDER BY sort", $pyclass01_Rows['classid']);
                                $pyclass02 = $link->query($SQLstring);
                                ?>
                                <div id="collapseOne<?php echo $i; ?>" class="accordion-collapse collapse <?php echo ($i == 1) ? 'show' : ''; ?>" aria-labelledby="headingOne<?php echo $i; ?>" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <table class="table">
                                            <tbody>
                                                <?php
                                                while ($pyclass02_Rows = $pyclass02->fetch()) {
                                                ?>
                                                    <tr>
                                                        <td><a href="#"><em class="fas <?= $pyclass02_Rows['fonticon']; ?> fa-fw"></em><?= $pyclass02_Rows['cname'] ?></a></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php
                            $i++;
                        }
                        ?><!-- 迴圈尾 -->
                    </div>
                    <!-- 站長推薦，熱銷產品 -->
                    <div class="card text-center mt-3" style="border:none;">
                        <div class="card-body">
                            <h3 class="card-title">站長推薦，熱銷產品</h3>
                        </div>
                        <?php
                        //建立熱銷商品查詢
                        $SQLstring = "SELECT * FROM hot,product,product_img WHERE hot.p_id=product_img.p_id AND hot.p_id=product.p_id AND product_img.sort=1 ORDER BY h_sort";
                        $hot = $link->query($SQLstring);
                        ?>
                        <?php
                        while ($data = $hot->fetch()) { ?>
                            <img src="product_img/<?= $data['img_file'] ?>" class="card-img-top" alt="HOT<?= $data['h_sort'] ?>" title="<?= $data['p_name'] ?>">
                        <?php } ?>
                    </div>
                </div>
                <!-- 右側內容區 -->
                <div class="col-md-10">
                    <!-- 廣告輪播carousel區 -->
                     <?php $carouse_start=0;//廣告輪播起始頁?>
                    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                        <?php //建立廣告輪播carousel資料查詢
                        $SQLstring = "SELECT * FROM carousel WHERE caro_online=1 ORDER BY caro_sort";
                        $carousel = $link->query($SQLstring);
                        ?>
                        <div class="carousel-indicators">
                            <?php
                            for ($i = 0; $i < $carousel->rowCount(); $i++) {
                            ?>
                                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?= $i ?>" class="<?= activeshow($i, $carouse_start) ?>" aria-current="true" aria-label="Slide <?= $i ?>">
                                </button>

                            <?php } ?>
                        </div>
                        <div class="carousel-inner">
                            <?php $i = 0;
                            while ($data = $carousel->fetch()) { ?>
                                <div class="carousel-item <?php echo activeshow($i, $carouse_start); ?>">
                                    <img src="./product_img/<?php echo $data['caro_pic'] ?>" class="d-block w-100" alt="<?php echo $data['caro_title']; ?>">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5><?php echo $data['caro_title']; ?></h5>
                                        <h3><?php echo $data['caro_content']; ?></h3>
                                    </div>
                                </div>
                            <?php $i++; } ?>                            
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <!-- 換區水平線hr -->
                    <hr>

                    <!-- 產品資料表 -->
                    <?php //建立product藥妝商品RS
                    $maxRows_rs =12;
                    $pageNum_rs=0;
                    if(isset($_GET['pageNum_rs'])){
                        $pageNum_rs=$_GET['pageNum_rs'];
                    }
                    $startRow_rs=$pageNum_rs * $maxRows_rs;
                    //列出產品資料查詢
                    $queryFirst=sprintf("SELECT * FROM product,product_img WHERE p_open=1 AND product.p_id=product_img.p_id AND product_img.sort=1 ORDER BY product.p_id DESC");
                    $query=sprintf("%s LIMIT %d,%d",$queryFirst,$startRow_rs,$maxRows_rs);
                    $pList01=$link->query($query);
                    $i=1;//控制每列row產生
                    ?>
                    <?php while($pList01_Rows=$pList01->fetch()){ ?>
                        <?php if($i%4==1){ ?>
                            <div class="row text-center">
                        <?php } ?>
                                <!-- 卡片Card樣板 -->
                                <div class="card col-md-3">
                                    <img src="./product_img/<?php echo $pList01_Rows['img_file'];?>" class="card-img-top" alt="<?php echo $pList01_Rows['p_name'];?>" title="<?php echo $pList01_Rows['p_name'];?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $pList01_Rows['p_name'];?></h5>
                                        <p class="card-text"><?php echo mb_substr($pList01_Rows['p_intro'],0,30,"utf-8");?></p>
                                        <p>
                                        <?php echo $pList01_Rows['p_price'];?></p>
                                        <a href="#" class="btn btn-primary">更多資訊</a>
                                        <a href="#" class="btn btn-success">放購物車</a>
                                    </div>
                                </div>
                        <?php if($i%4==0 || $i==$pList01->rowCount()){ ?>
                            </div>                    
                        <?php } ?>
                    <?php $i++;} ?>
                        
                    
                    <!-- 換頁按鈕 -->
                    <div class="row mt-2">
                        <?php 
                        if(isset($_GET['totalRows_rs'])){
                            $totalRows_rs=$_GET['totalRows_rs'];
                        }else{
                            $all_rs=$link->query($queryFirst);
                            $totalRows_rs=$all_rs->rowCount();
                        }
                        $totalPage_rs=ceil($totalRows_rs/$maxRows_rs)-1;
                        $prev_rs="&laquo;";
                        $next_rs="&laquo;";
                        $separator="|";
                        $max_links=20;
                        $pages_rs=buildNavigation($pageNum_rs,$totalPage_rs,$prev_rs,$next_rs,$separator,$max_links,true,3,"rs");
                        ?>                        
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <?php echo $pages_rs[0].$pages_rs[1].$pages_rs[2]; ?>
                            </ul>
                        </nav>

                        <!-- 換頁按鈕樣板
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item active"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav> -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <hr>
    <section id="scontent">
        <div class="container-fluid">
            <div id="aboutme" class="row text-center">
                <div class="col-md-2">
                    <img src="images/QRcode02.png" alt="QRcode" class="img-fluid mx-auto">
                </div>
                <div class="col-md-2">
                    <i class="fas fa-thumbs-up fa-5x"></i>
                    <h3>關於我們</h3>
                    關於我們<br>
                    企業官網<br>
                    招商專區<br>
                    人才招募<br>
                </div>
                <div class="col-md-2">
                    <i class="fas fa-truck fa-5x"></i>
                    <h3>特色服務</h3>
                    特色服務<br>
                    大宗採購方案<br>
                    直配大陸<br>
                </div>
                <div class="col-md-2">
                    <i class="fas fa-users fa-5x"></i>
                    <h3>客戶服務</h3>
                    客戶服務<br>
                    訂單/配送進度查詢<br>
                    取消訂單/退貨<br>
                    更改配送地址<br>
                    追蹤清單<br>
                    12H速達服務<br>
                    折價券說明<br>
                </div>
                <div class="col-md-2">
                    <i class="fas fa-comments-dollar fa-5x"></i>
                    <h3>好康大放送</h3>
                    好康大放送<br>
                    新會員禮包<br>
                    活動得獎名單<br>
                </div>
                <div class="col-md-2">
                    <i class="fas fa-question fa-5x"></i>
                    <h3>FAQ 常見問題</h3>
                    FAQ 常見問題<br>
                    系統使用問題<br>
                    產品問題資詢<br>
                    大宗採購問題<br>
                    聯絡我們<br>
                </div>
            </div>
        </div>
    </section>
    <section id="footer">
        <div class="container-fluid">
            <div id="last-data" class="row text-center">
                <div class="col-md-12">
                    <h6>中彰投分署科技股份有限公司 40767台中市西屯區工業區一路100號 電話：04-23592181 免付費電話：0800-777888</h6>
                    <h6>企業通過ISO/IEC27001認證，食品業者登錄字號：A-127360000-00000-0</h6>
                    <h6>版權所有 copyright © 2017 WDA.com Inc. All Rights Reserved.</h6>
                </div>
            </div>
        </div>

    </section>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <script type="text/javascript" src="./gotop.js"></script>
</body>

</html>
