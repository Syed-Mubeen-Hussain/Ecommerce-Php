<?php
require('top.php');
if(!isset($_SESSION['USER_ID'])){
    ?>
    <script>
        window.location.href = 'index.php';
    </script>
    <?php
}
$uid = $_SESSION['USER_ID'];

if(isset($_GET['id'])){
    $wid = $_GET['id'];
    mysqli_query($con,"delete from wishlist where id = '$wid' and user_id = '$uid'");
}

$res = mysqli_query($con,"select product.name,product.image,product.price,product.mrp,wishlist.id from product,wishlist where wishlist.product_id = product.id and wishlist.user_id = '$uid'");
?>
  <!-- Start Bradcaump area -->
  <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/4.jpg) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner">
                                <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="index.html">Home</a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <span class="breadcrumb-item active">Wishlist</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        <!-- cart-main-area start -->
        <div class="cart-main-area ptb--100 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <form action="#">               
                            <div class="table-content table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="product-thumbnail">products</th>
                                            <th class="product-name">name of products</th>
                                            <th class="product-remove">Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                         if(mysqli_num_rows($res)){
                                        while($row=mysqli_fetch_assoc($res)){
                                        ?>
                                        <tr>
                                            <td class="product-thumbnail"><a href="#"><img src="<?php echo PRODUCT_IMAGE_SITE_PATH . $row['image'] ?>" /></a></td>
                                            <td class="product-name"><a href="#"><?php echo $row['name']?></a>
                                                <ul  class="pro__prize">
                                                    <li class="old__prize"><?php echo $row['mrp']?></li>
                                                    <li><?php echo $row['price']?></li>
                                                </ul>
                                            </td>
                                            <br>
                                            <td class="product-remove"><a href="wishlist.php?wishlist_id=<?php echo $row['id']?>" ><i class="icon-trash icons"></i></a></td>
                                        </tr>
                                        <?php } } else{
                                            echo "<tr>
                                                <td colspan='6'>No wishlist products</td>
                                            </tr>";
                                        }?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="buttons-cart--inner">
                                        <div class="buttons-cart">
                                            <a href="<?php echo SITE_PATH?>">Continue Shopping</a>
                                        </div>
                                        <div class="buttons-cart checkout--btn">
                                            <a href="<?php echo SITE_PATH?>checkout.php">checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
<?php require('footer.php') ?>