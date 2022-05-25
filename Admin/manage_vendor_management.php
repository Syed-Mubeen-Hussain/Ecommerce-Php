<?php
require('top.inc.php');
$username = '';
$password = '';
$email = '';
$mobile = '';

$msg = '';
isAdmin();
if (isset($_GET['id']) && $_GET['id'] != '') {
    $id = get_safe_value($con, $_GET['id']);
    $res = mysqli_query($con, "select * from admin_user where id = '$id'");
    $row = mysqli_fetch_assoc($res);
    $username = $row['username'];
    $email = $row['email'];
    $mobile = $row['mobile'];
    $password = $row['password'];
}


if (isset($_POST['submit'])) {
    $username = get_safe_value($con, $_POST['username']);
    $email = get_safe_value($con, $_POST['email']);
    $mobile = get_safe_value($con, $_POST['mobile']);
    $password = get_safe_value($con, $_POST['password']);
    
    $res = mysqli_query($con, "select * from admin_user where username = '$username'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        if (isset($_GET['id']) && $_GET['id'] != '') {
            $getData = mysqli_fetch_assoc($res);
            if ($id == $getData['id']) {
            } else {
                $msg = "Username already exist";
            }
        } else {
            $msg = "Username already exist";
        }
    }

    if ($msg == '') {
        if (isset($_GET['id']) && $_GET['id'] != '') {
                $update_sql = "update admin_user set coupon_code = '$coupon_code',coupon_value = '$coupon_value',coupon_type = '$coupon_type',cart_min_value = '$cart_min_value' where id = '$id'";
            mysqli_query($con, $update_sql);
        } else {
            mysqli_query($con, "insert into 
            coupon_master(coupon_code,coupon_value,coupon_type,cart_min_value,status) values('$coupon_code','$coupon_value','$coupon_type','$cart_min_value',1)");
        }
        header('location:coupon_master.php');
        die();
    }
}
?>
<div class="content pb-0">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><strong>Coupon</strong><small> Form</small></div>
                    <form method="post" enctype="multipart/form-data">
                        <div class="card-body card-block">
                            <div class="form-group">
                                <label for="company" class=" form-control-label">Coupon Code</label>
                                <input type="text" required value="<?php echo $coupon_code ?>" name="coupon_code" placeholder="Enter coupon code" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="company" class=" form-control-label">Coupon Value</label>
                                <input type="text" required value="<?php echo $coupon_value ?>" name="coupon_value" placeholder="Enter coupon value" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="company" class=" form-control-label">Coupon Type</label>
                                <select class="form-control" name="coupon_type" required>
                                    <option value="">Select</option>
                                    <?php
                                    if ($coupon_type == "Percentage") {
                                        echo '<option value="Percentage" selected>Percentage</option>
                                                <option value="Rupee">Rupee</option>';
                                    } else if ($coupon_type == "Rupee") {
                                        echo '<option value="Percentage">Percentage</option>
                                        <option value="Rupee"  selected>Rupee</option>';
                                    } else {
                                        echo '<option value="Percentage">Percentage</option>
                                                <option value="Rupee">Rupee</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="company" class=" form-control-label">Cart Min Value</label>
                                <input type="text" required value="<?php echo $cart_min_value ?>" name="cart_min_value" placeholder="Enter cart min value" class="form-control">
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

<?php
require('footer.inc.php');
?>
