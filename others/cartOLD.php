<?php
(!isset($_SESSION)) ? session_start() : "";
// if(!isset($_SESSION))session_start(); 
// 如果SESSION沒有啟動，則啟動SESSION功能，這是跨網頁變數存取
?>
<!-- 這是將資料庫，連接程式載入 -->
<?php require('Connections/conn_db.php') ?>
<!-- 載入共用php函式庫 -->
<?php $phpFileDir = "./s01_php/"; ?>
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
                    <?php
                    $SQLstring = "SELECT * FROM cart,product,product_img WHERE ip='" . $_SERVER['REMOTE_ADDR'] . "' AND orderid is NULL AND cart.p_id=product_img.p_id AND product.p_id=product_img.p_id AND product_img.sort=1 ORDER BY cartid DESC";
                    $cart_rs = $link->query($SQLstring);
                    $ptotal = 0; //定義累加變數初始值=0
                    ?>
                    <h3>電商藥粧：購物車</h3>
                    <?php if ($cart_rs->rowCount() != 0) { ?>
                        <a href="./index.php" name="btn01" class="btn btn-primary">繼續購物</a>
                        <button type="button" id="btn01" name="btn01" class="btn btn-info" onclick="window.history.go(-1);">回到上一頁</button>
                        <button type="button" id="btn03" name="btn03" class="btn btn-success" onclick="btn_confirmlink('確定清空購物車','shopcart_del.php?mode=2');">清空購物車</button>
                        <a href="checkout.php" id="btn04" name="btn04" class="btn btn-warning">前往結帳</a>
                        <div class="table-responsive-md">
                            <table class="table table-hover mt-3">
                                <thead>
                                    <td width="10%">產品編號</td>
                                    <td width="10%">圖片</td>
                                    <td width="25%">名稱</td>
                                    <td width="15%">價格</td>
                                    <td width="10%">數量</td>
                                    <td width="15%">小計</td>
                                    <td width="15%">下次再買</td>
                                </thead>
                                <tbody>
                                    <?php while ($cart_data = $cart_rs->fetch()) { ?>
                                        <tr>
                                            <td><?= $cart_data['p_id']; ?></td>
                                            <td><img src="./product_img/<?= $cart_data['img_file']; ?>" alt="<?= $cart_data['p_name']; ?>" class="img-fluid">
                                            </td>
                                            <td> <?= $cart_data['p_name']; ?></td>
                                            <td>
                                                <h4 class="color_e600a0 pt-1"><?= $cart_data['p_price']; ?></h4>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="number" id="qty[]" name="qty[]" class="form-control" value="<?= $cart_data['qty']; ?>" min="1" max="20" required style="min-width: 60px;" cartid="<?php echo $cart_data['cartid']; ?>">
                                                </div>
                                            </td>
                                            <td>
                                                <h4 class="color_e600a0 pt-1">$<?= $cart_data['p_price'] * $cart_data['qty']; ?></h4>
                                            </td>
                                            <td><button type="button" id="btn[]" name="btn[]" class="btn btn-danger" onclick="btn_confirmlink('確定刪除本資料?','shopcart_del.php?mode=1&cartid=<?= $cart_data['cartid']; ?>')">取消</button></td>
                                        </tr>
                                    <?php $ptotal += $cart_data['p_price'] * $cart_data['qty'];
                                    } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7">累計：<?= $ptotal; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">運費：100</td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" class="color_red">總計：<?= $ptotal + 100; ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <?php } else { ?>
                        <div class="alert alert-warning" role="alert">
                            抱歉，目前購物車沒有相關產品
                        </div>
                        <?php } ?>
                        <!-- 引入購物車內容模組 -->
                        <?php //require_once($phpFileDir . "cart_content.php"); 
                        ?>
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
<?php require_once($phpFileDir . "jsfile.php") ?>
<script>
$("input").change(function(){
var qty =$(this).val();
const cartid=$(this).attr("cartid");
    if (qty <= 0 || qty >= 20) {
        alert("更改數量需大於0，低於20以下!");
        return false;
    }    
    //利用jquery $.ajax函數呼叫後台的addcart.php
    $.ajax({
        url: './change_qty.php',
        type: 'post',
        dataType: 'json',
        data: {
            cartid: cartid,
            qty: qty,   
        },
        success: function(data) {
            if (data.c == true) {
                alert(data.m);
                console
                window.location.reload();
            } else {
                alert(data.m);
            }
        },
        error: function(data) {
            alert('系統目前無法連接到後台資料庫。');
        }
    });
});
</script>
