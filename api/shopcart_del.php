<?php 
$Connection="../Connections/";
require_once($Connection."conn_db.php") ?>
<?php
if (isset($_GET['mode']) && $_GET['mode'] != "") {
    $mode = $_GET['mode'];
    switch ($mode) {
        case 1:
            //使用購物車編號刪除內容
            $SQLstring = sprintf("DELETE FROM cart WHERE cartid=%d AND orderid IS NULL", $_GET['cartid']);
            break;
        case 2:
            //使用IP位置清空購物車
            $SQLstring = sprintf("DELETE FROM cart WHERE ip='%s' AND orderid IS NULL", $_SERVER['REMOTE_ADDR']);
            break;
    }
    $result = $link->query($SQLstring);
}
$deleteGoto = "../cart.php";
header(sprintf("location:%s", $deleteGoto));
?>
