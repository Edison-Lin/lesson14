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
                            <a href="./goods.php?p_id=<?=$data['p_id'];?>"><img src="product_img/<?= $data['img_file'] ?>" class="card-img-top" alt="HOT<?= $data['h_sort'] ?>" title="<?= $data['p_name'] ?>"></a>
                        <?php } ?>
                    </div>