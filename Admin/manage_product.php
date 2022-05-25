<?php
require('top.inc.php');

$condition = '';
$condition1 = '';
if($_SESSION['ADMIN_ROLE'] == 1){
    $condition = " and product.added_by = '".$_SESSION['ADMIN_ID']."'";
    $condition1 = " and added_by = '".$_SESSION['ADMIN_ID']."'";
}

$categories_id = '';
$sub_categories_id = '';
$name = '';
$mrp = '';
$price = '';
$qty = '';
$image = '';
$short_desc = '';
$description = '';
$meta_title = '';
$meta_description = '';
$meta_keyword = '';
$status = '';
$best_seller = '';

$msg = '';
$image_required = 'required';
if (isset($_GET['id']) && $_GET['id'] != '') {
    $image_required = '';
    $id = get_safe_value($con, $_GET['id']);
    $res = mysqli_query($con, "select * from product where id = '$id' $condition1");
    $row = mysqli_fetch_assoc($res);
    $categories_id = $row['categories_id'];
    $sub_categories_id = $row['sub_categories_id'];
    $name = $row['name'];
    $mrp = $row['mrp'];
    $price = $row['price'];
    $qty = $row['qty'];
    $short_desc = $row['short_desc'];
    $description = $row['description'];
    $meta_title = $row['meta_title'];
    $meta_description = $row['meta_desc'];
    $meta_keyword = $row['meta_keyword'];
    $best_seller = $row['best_seller'];
}


if (isset($_POST['submit'])) {
    $categories_id = get_safe_value($con, $_POST['categories_id']);
    $sub_categories_id = get_safe_value($con, $_POST['sub_categories_id']);
    $name = get_safe_value($con, $_POST['name']);
    $mrp = get_safe_value($con, $_POST['mrp']);
    $price = get_safe_value($con, $_POST['price']);
    $qty = get_safe_value($con, $_POST['qty']);
    $short_desc = get_safe_value($con, $_POST['short_desc']);
    $description = get_safe_value($con, $_POST['description']);
    $meta_title = get_safe_value($con, $_POST['meta_title']);
    $meta_description = get_safe_value($con, $_POST['meta_desc']);
    $meta_keyword = get_safe_value($con, $_POST['meta_keyword']);
    $best_seller = get_safe_value($con, $_POST['best_seller']);

    $res = mysqli_query($con, "select * from product where name = '$name'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        if (isset($_GET['id']) && $_GET['id'] != '') {
            $getData = mysqli_fetch_assoc($res);
            if ($id == $getData['id']) {
            } else {
                $msg = "Product already exist";
            }
        } else {
            $msg = "Product already exist";
        }
    }

    if ($_FILES['image']['type'] != '' && strtolower($_FILES['image']['type'] != 'image/png') && strtolower($_FILES['image']['type'] != 'image/jpg') && strtolower($_FILES['image']['type'] != 'image/jpeg')) {
        $msg = "Please select only png,jpg and jpeg image formate";
    }

    if ($msg == '') {
        if (isset($_GET['id']) && $_GET['id'] != '') {
            if ($_FILES['image']['name'] != '') {
                $image = rand(111111111, 999999999) . '_' . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], PRODUCT_IMAGE_SERVER_PATH . $image);
                $update_sql = "update product set categories_id = '$categories_id',name = '$name',mrp = '$mrp',price = '$price',qty = '$qty',short_desc = '$short_desc',description = '$description',meta_title = '$meta_title',meta_desc = '$meta_description',meta_keyword = '$meta_keyword',image = '$image',best_seller = '$best_seller',sub_categories_id = '$sub_categories_id' where id = '$id' $condition1";
            } else {
                $update_sql = "update product set categories_id = '$categories_id',name = '$name',mrp = '$mrp',price = '$price',qty = '$qty',short_desc = '$short_desc',description = '$description',meta_title = '$meta_title',meta_desc = '$meta_description',meta_keyword = '$meta_keyword',best_seller = '$best_seller',sub_categories_id = '$sub_categories_id' where id = '$id' $condition1";
            }
            mysqli_query($con, $update_sql);
        } else {
            $image = rand(111111111, 999999999) . '_' . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], PRODUCT_IMAGE_SERVER_PATH . $image);
            mysqli_query($con, "insert into 
            product(categories_id,name,mrp,price,qty,short_desc,description,meta_title,meta_desc,meta_keyword,status,image,best_seller,sub_categories_id,added_by) values('$categories_id','$name','$mrp','$price','$qty','$short_desc','$description','$meta_title','$meta_description','$meta_keyword','1','$image','$best_seller','$sub_categories_id','".$_SESSION['ADMIN_ID']."')");
        }
        header('location:product.php');
        die();
    }
}
?>
<div class="content pb-0">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><strong>Product</strong><small> Form</small></div>
                    <form method="post" enctype="multipart/form-data">
                        <div class="card-body card-block">
                            <div class="form-group">
                                <label for="company" class=" form-control-label">Category</label>
                                <select class="form-control" name="categories_id" id="categories_id" onchange="get_sub_cat('')" required>
                                    <option>Select Category</option>
                                    <?php
                                    $res = mysqli_query($con, "select id,categories from categories order by categories asc");
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        if ($row['id'] == $categories_id) {
                                            echo "<option selected value='" . $row['id'] . "'>" . $row['categories'] . "</option>";
                                        } else {
                                            echo "<option value='" . $row['id'] . "'>" . $row['categories'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="company" class=" form-control-label">Sub Category</label>
                                <select class="form-control" id="sub_categories_id" name="sub_categories_id" required>
                                    <option value="">Select sub category</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="company" class=" form-control-label">Product Name</label>
                                <input type="text" required value="<?php echo $name ?>" name="name" placeholder="Enter product name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="company" class=" form-control-label">Best Seller</label>
                                <select class="form-control" name="best_seller" required>
                                    <option value="">Select</option>
                                    <?php
                                    if ($best_seller == 1) {
                                        echo '<option value="1" selected>Yes</option>
                                                <option value="0">No</option>';
                                    } else if ($best_seller == 0) {
                                        echo '<option value="1">Yes</option>
                                        <option value="0"  selected>No</option>';
                                    } else {
                                        echo '<option value="1">Yes</option>
                                                <option value="0">No</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="company" class=" form-control-label">MRP</label>
                                <input type="text" required value="<?php echo $mrp ?>" name="mrp" placeholder="Enter product mrp" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="company" class=" form-control-label">Price</label>
                                <input type="text" required value="<?php echo $price ?>" name="price" placeholder="Enter product price" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="company" class=" form-control-label">Qty</label>
                                <input type="text" required value="<?php echo $qty ?>" name="qty" placeholder="Enter product qty" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="company" class=" form-control-label">Image</label>
                                <input type="file" name="image" class="form-control" <?php echo $image_required ?>>
                            </div>
                            <div class="form-group">
                                <label for="company" class=" form-control-label">Short Description</label>
                                <textarea required name="short_desc" placeholder="Enter short desc" class="form-control"><?php echo $short_desc ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="company" class=" form-control-label">Description</label>
                                <textarea required name="description" placeholder="Enter description" class="form-control"><?php echo $description ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="company" class=" form-control-label">Meta Title</label>
                                <input type="text" value="<?php echo $meta_title ?>" name="meta_title" placeholder="Enter meta title" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="company" class=" form-control-label">Meta Description</label>
                                <input type="text" value="<?php echo $meta_description ?>" name="meta_desc" placeholder="Enter meta description" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="company" class=" form-control-label">Meta Keyword</label>
                                <input type="text" value="<?php echo $meta_keyword ?>" name="meta_keyword" placeholder="Enter meta keyword" class="form-control">
                            </div>
                            <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-info btn-block">
                                <span id="payment-button-amount">Submit</span>
                            </button>
                            <span style="color:red; "><?php echo $msg ?></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function get_sub_cat(sub_cat_id) {
        var categories_id = jQuery("#categories_id").val();
        jQuery.ajax({
            url: 'get_sub_cat.php',
            type: 'post',
            data: 'categories_id=' + categories_id + '&sub_cat_id=' + sub_cat_id,
            success: function(result) {
                jQuery("#sub_categories_id").html(result);
            }
        });
    }
</script>

<?php
require('footer.inc.php');
?>

<script>
<?php
if (isset($_GET['id'])) {
?>
    get_sub_cat('<?php echo $sub_categories_id ?>');
<?php
}
?>
</script>