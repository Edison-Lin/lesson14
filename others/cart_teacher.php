<?php (!isset($_SESSION)) ? session_start() : ""; ?>
<!-- 這是將資料庫，連線程式載入 -->
<?php require_once('Connections/conn_db.php'); ?>
<!-- 如果SESSION沒有啟動，則啟動SESSION功能，這是跨網頁變數存取 -->
<!-- 載複共用PHP函數 -->
<?php require_once("php_lib.php"); ?>
<!doctype html>
<html lang="zh-TW">

<head>
    <!-- 引入網頁標頭 -->
    <?php require_once("headfile.php"); ?>
    <style type="text/css">
        /* 輸入有錯誤時，顯示紅框 */
        table input:invalid {
            border: solid red 3px;
        }
    </style>
</head>

<body>
    <section id="header">
        <!-- 引入導覽列 -->
        <?php require_once("navbar.php"); ?>
    </section>
    <section id="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2">
                    <!-- 引入sidebar分類導覽 -->
                    <?php require_once("sidebar.php"); ?>
                    <!-- 引入熱銷商品 -->
                    <?php require_once("hot.php"); ?>
                </div>
                <div class="col-md-10">
                    <!-- 購物車內容模組 -->
                    <?php // require_once("cart_content.php"); 
                    ?>
                    <?php
                    //建立購物車資料查詢
                    $SQLstring = "SELECT * FROM cart,product,product_img WHERE ip='" . $_SERVER['REMOTE_ADDR'] . "' AND orderid IS NULL AND cart.p_id=product_img.p_id AND cart.p_id=product.p_id AND product_img.sort=1 ORDER BY cartid DESC";
                    $cart_rs = $link->query($SQLstring);
                    $ptotal = 0; //設定購物車金額累加的變數，初始=0;
                    ?>
                    <h3>電商藥粧：購物車</h3>
                    <?php if ($cart_rs->rowCount() != 0) { ?>
                        <a href="index.php" name="btn01" id="btn01" class="btn btn-primary">繼續購物</a>
                        <button type="button" name="btn02" id="btn02" class="btn btn-info" onclick="window.history.go(-1)">回到上一頁</button>
                        <button type="button" name="btn03" id="btn03" class="btn btn-success" onclick="btn_confirmLink('確定清空購物車','shopcart_del.php?mode=2');">清空購物車</button>
                        <a href="checkout.php" name="btn04" id="btn04" class="btn btn-warning">前往結帳</a>
                        <div class="table-responsive-md">
                            <table class="table table-hover mt-3">
                                <thead>
                                    <tr class="table-warning">
                                        <td width="10%">產品編號</td>
                                        <td width="10%">圖片</td>
                                        <td width="25%">名稱</td>
                                        <td width="15%">價格</td>
                                        <td width="10%">數量</td>
                                        <td width="15%">小計</td>
                                        <td width="15%">下次再買</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($cart_data = $cart_rs->fetch()) { ?>
                                        <tr>
                                            <td><?php echo $cart_data['p_id']; ?></td>
                                            <td><img src="product_img/<?php echo $cart_data['img_file']; ?>" alt="<?php echo $cart_data['p_name']; ?>" class="img-fluid"></td>
                                            <td><?php echo $cart_data['p_name']; ?></td>
                                            <td>
                                                <h4 class="color_e600a0 pt-1">$<?php echo $cart_data['p_price']; ?></h4>
                                            </td>
                                            <td style="min-width:100px;">
                                                <div class="input-group">
                                                    <input type="number" class="form-control" id="qty[]" name="qty[]" value="<?php echo $cart_data['qty']; ?>" min="1" max="49" cartid="<?php echo $cart_data['cartid']; ?>" required>
                                                </div>
                                            </td>
                                            <td>
                                                <h4 class="color_e600a0 pt-1">$<?php echo $cart_data['p_price'] * $cart_data['qty']; ?></h4>
                                            </td>
                                            <td><button type="button" id="btn[]" name="btn[]" class="btn btn-danger" onclick="btn_confirmLink('是否確定刪除本資料','shopcart_del.php?mode=1&cartid=<?php echo $cart_data['cartid']; ?>');">取消</button></td>
                                        </tr>
                                    <?php $ptotal += $cart_data['p_price'] * $cart_data['qty'];
                                    } ?>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7">累計：<?php echo $ptotal; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">運費：100</td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" class="color_red">總計：<?php echo $ptotal + 100; ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    <?php } else { ?>
                        <div class="alert alert-warning" role="alert">
                            抱歉！目前購物車沒有相關產品。
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <hr>
    <section id="scontent">
        <!-- 引入服務說明資料     -->
        <?php require_once("scontent.php"); ?>
    </section>
    <section id="footer">
        <!-- 引入聯絡資訊     -->
        <?php require_once("footer.php"); ?>
    </section>
    <!-- 引入javascript檔     -->
    <?php require_once("jsfile.php"); ?>
    <script type="text/javascript">
        //跳出確認訊息對話框
        function btn_confirmLink(message, url) {
            if (message == "" || url == "") {
                return false;
            }
            if (confirm(message)) {
                window.location = url;
            }
            return false;
        }
        //將變更的數量寫入後台資料庫
        $("input").change(function() {
            var qty = $(this).val();
            const cartid = $(this).attr("cartid");
            if (qty <= 0 || qty >= 20) {
                alert("更改數量需大於0，低於20以下!");
                return false;
            }
            //利用jquery $.ajax函數呼叫後台的addcart.php
            $.ajax({
                url: './change_qtyold.php',
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
</body>

</html>
<?php

?>