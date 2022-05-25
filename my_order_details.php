<?php
require('top.php');
$order_id = get_safe_value($con, $_GET['id']);

$coupon_details = mysqli_fetch_assoc(mysqli_query($con,"select coupon_value from `order` where id = '$order_id'"));
$coupon_value = $coupon_details['coupon_value'];

?>
<div class="body__overlay"></div>
<!-- Start Bradcaump area -->
<div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/4.jpg) no-repeat scroll center center / cover ;">
    <div class="ht__bradcaump__wrap">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="bradcaump__inner">
                        <nav class="bradcaump-inner">
                            <a class="breadcrumb-item" href="index.php">Home</a>
                            <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                            <span class="breadcrumb-item active">Order Details</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Bradcaump area -->
<div class="wishlist-area ptb--100 bg__white">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="wishlist-content">
                    <form action="#">
                        <div class="wishlist-table table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="product-thumbnail">Product Name</th>
                                        <th class="product-thumbnail">Product Image</th>
                                        <th class="product-thumbnail">Qty</th>
                                        <th class="product-thumbnail">Price</th>
                                        <th class="product-thumbnail">Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $totalPrice = 0;
                                    $uid = $_SESSION['USER_ID'];
                                    $res = mysqli_query($con, "select distinct(order_detail.id), order_detail.*,product.name,product.image from order_detail,product,`order` where order_id = '$order_id' and `order`.user_id = '$uid' and product.id = order_detail.product_id");
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        $totalPrice = $totalPrice + ($row['qty'] * $row['price']);
                                    ?>
                                        <tr>
                                            <td class="product-name"><?php echo $row['name'] ?></td>
                                            <td class="product-name">
                                                <img src="<?php echo PRODUCT_IMAGE_SITE_PATH . $row['image'] ?>" />
                                            </td>
                                            <td class="product-name"><?php echo $row['qty'] ?></td>
                                            <td class="product-name"><?php echo $row['price'] ?></td>
                                            <td class="product-name"><?php echo $row['qty'] * $row['price'] ?></td>
                                        </tr>
                                    <?php }
                                    if($coupon_value>0){
                                     ?>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td>Coupon Value</td>
                                        <td><?php echo $coupon_value ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td>Total Price</td>
                                        <td><?php echo $totalPrice - $coupon_value ?></td>
                                    </tr>
                                    <?php }else{ ?>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td>Total Price</td>
                                        <td><?php echo $totalPrice ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require('footer.php'); ?>