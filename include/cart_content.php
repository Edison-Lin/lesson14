    <?php
    $SQLstring = "SELECT * FROM cart,product,product_img WHERE ip='" . $_SERVER['REMOTE_ADDR'] . "' AND orderid is NULL AND cart.p_id=product_img.p_id AND product.p_id=product_img.p_id AND product_img.sort=1 ORDER BY cartid DESC ;";

    $cart_rs = $link->query($SQLstring);
    $ptotal = 0; //定義累加變數初始值=0
    ?>
    <h3>電商藥粧：購物車</h3>
    <?php if ($cart_rs->rowCount() != 0) { 
        // $_SESSION['cart-check']=true;//如果有購物
        ?>
        <a href="./index.php" name="btn01" class="btn btn-primary">繼續購物</a>
        <button type="button" id="btn01" name="btn01" class="btn btn-info" onclick="window.history.go(-1);">回到上一頁</button>
        <button type="button" id="btn03" name="btn03" class="btn btn-success" onclick="btn_confirmlink('確定清空購物車','./api/shopcart_del.php?mode=2');">清空購物車</button>
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
                                <h4 class="color_e600a0 pt-1">$<?= $cart_data['p_price'];?></h4>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="number" id="qty[]" name="qty[]" class="form-control" value="<?= $cart_data['qty']; ?>" min="1" max="20" required style="min-width: 60px;" cartid="<?php echo $cart_data['cartid']; ?>">
                                </div>
                            </td>

                            <td>
                                <h4 class="color_e600a0 pt-1">$<?= $cart_data['p_price'] * $cart_data['qty']; ?></h4>
                            </td>
                            <td><button type="button" id="btn[]" name="btn[]" class="btn btn-danger" onclick="btn_confirmlink('確定刪除本資料?','./api/shopcart_del.php?mode=1&cartid=<?= $cart_data['cartid']; ?>')">取消</button></td>
                        </tr>
                    <?php $ptotal += $cart_data['p_price'] * $cart_data['qty'];
                    } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7">總計：<?= $ptotal; ?></td>
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