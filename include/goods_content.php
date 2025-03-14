<div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-3">
                                <?php //取得產品圖片檔名資料 
                                $SQLstring = sprintf("SELECT * FROM product_img WHERE product_img.p_id=%d ORDER BY sort", $_GET['p_id']);
                                $img_rs = $link->query($SQLstring);
                                $imgList = $img_rs->fetch();
                                ?>
                                <img id="showGoods" name="showGoods" src="./product_img/<?= $imgList['img_file']; ?>" alt="<?= $data['p_name']; ?>" title="<?= $data['p_name']; ?>" class="img-fluid">

                                <div class="row mt-2">
                                    <?php do { ?>
                                        <div class="col-md-4">
                                            <a href="./product_img/<?= $imgList['img_file']; ?>" rel="group" class="fancybox" title="<?= $data['p_name']; ?>">
                                                <img src="./product_img/<?= $imgList['img_file']; ?>" alt="<?= $data['p_name']; ?>" title="<?= $data['p_name']; ?>" class="img-fluid">
                                            </a>
                                        </div>
                                    <?php } while ($imgList = $img_rs->fetch()) ?>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $data['p_name']; ?></h5>
                                    <p class="card-text"><?php echo $data['p_intro']; ?></p>
                                    <h4 class="color_e600a0">$<?php echo $data['p_price']; ?></h4>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text color-success" id="inputGroup-sizing-lg">數量</span>
                                                <input type="number" id="qty" name="qty" value="1" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <button id="button01" name="button01" type="button" class="btn btn-success btn-lg color-success" onclick="addcart(<?= $data['p_id']; ?>)">加入購物車</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo $data['p_content']; ?>