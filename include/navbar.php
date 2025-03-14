<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
        <!-- 頁首LOGO-連結 -->
        <a class="navbar-brand" href="index.php">
            <img src="./images/logo.jpg" class="img-fluid rounded-circle" alt="電商藥粧">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <?php
        $SQLstring = "SELECT * FROM cart WHERE orderid is NULL AND ip='" . $_SERVER['REMOTE_ADDR'] . "'";
        $cart_rs = $link->query($SQLstring);
        ?>
        <!-- 標頭選單 -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">

                <?php if (false /* 關閉<產品資訊>選項 */) { ?>
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
                                    <a class="dropdown-item dropdown-toggle" href="drugstore.php?classid=<?php echo $pyclass01_Rows['classid']; ?>&level=1"><i class="fas <?php echo $pyclass01_Rows['fonticon']; ?> fa-fw"></i><?php echo $pyclass01_Rows['cname']; ?></a>
                                    <?php
                                    $SQLstring = sprintf("SELECT * FROM pyclass WHERE level=2 AND uplink=%d ORDER BY sort", $pyclass01_Rows['classid']);
                                    $pyclass02 = $link->query($SQLstring);
                                    ?>
                                    <ul class="dropdown-menu">
                                        <?php
                                        while ($pyclass02_Rows = $pyclass02->fetch()) {
                                        ?>
                                            <li><a class="dropdown-item" href="drugstore.php?classid=<?php echo $pyclass02_Rows['classid']; ?>"><em class="fas <?= $pyclass02_Rows['fonticon']; ?> fa-fw"></em><?= $pyclass02_Rows['cname'] ?></a></li>
                                        <?php } ?>

                                    </ul>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
                <?php if (!isset($_SESSION['login'])) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./register.php">會員註冊</a>
                    </li>
                    <?php if (isset($_SESSION['login'])) { ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link" onclick="btn_confirmlink('是否確認登出?','./logout.php?sPath=<?= basename($_SERVER['PHP_SELF']); ?>' )">會員登出</a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="./login.php?sPath=<?= basename($_SERVER['PHP_SELF']); ?>">會員登入</a>
                        </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#">會員中心</a>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link" href="#">最新活動</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="orderlist.php">查訂單</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">折價券</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./cart.php">購物車<span class="badge text-bg-success"><?php echo ($cart_rs) ? $cart_rs->rowCount() : ''; ?></span></a>
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

            
                <?php if (isset($_SESSION['login'])) { ?>
                    <ul class="navbar-nav ms-auto me-4">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                                <img src="./uploads/<?php echo ($_SESSION['imgname'] != '') ? $_SESSION['imgname'] : 'avatar.svg'; ?>" width="50" height="50" class="rounded-circle">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="orderlist.php">訂單查閱</a></li>
                                <li><a class="dropdown-item" href="profile.php">個人資料</a></li>
                                <li><a class="dropdown-item" href="#" 
                                onclick="btn_confirmlink('請確認是否要登出?','./logout.php' )">登出</a></li>
                            </ul>
                        </li>
                    </ul>
                <?php } ?>
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
                    <li><a class="dropdown-item" href="drugstore.php?classid=<?php echo $pyclass02_Rows['classid']; ?>"><em class="fas <?= $pyclass02_Rows['fonticon'] ?> fa-fw"></em><?= $pyclass02_Rows['cname'] ?></a></li>
                <?php } ?>
            </ul>
        </li>
<?php }
}
?>