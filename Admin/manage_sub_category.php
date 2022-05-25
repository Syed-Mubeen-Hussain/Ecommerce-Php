<?php
require('top.inc.php');
$categories = '';
$msg = '';
$sub_categories = '';
isAdmin();
if(isset($_GET['id']) && $_GET['id'] != ''){
    $id = get_safe_value($con,$_GET['id']);
    $res = mysqli_query($con,"select * from sub_categories where id = '$id'");
    $row = mysqli_fetch_assoc($res);
    $categories = $row['categories_id'];
    $sub_categories = $row['sub_categories'];
}


if(isset($_POST['submit'])){
    $categories_id = get_safe_value($con,$_POST['categories_id']);
    $sub_categories = get_safe_value($con,$_POST['sub_categories']);
    $res = mysqli_query($con,"select * from sub_categories where categories_id = '$categories' and sub_categories = '$sub_categories'");
    $check = mysqli_num_rows($res);
    if($check > 0){
        if(isset($_GET['id']) && $_GET['id'] != ''){
            $getData = mysqli_fetch_assoc($res);
            if($id == $getData['id']){
            }else{
                $msg = "Sub Category already exist";    
            }
        }else{
            $msg = "Sub Category already exist";
        }
    }

    if($msg == ''){
        if(isset($_GET['id']) && $_GET['id'] != ''){
            mysqli_query($con,"update sub_categories set categories_id = '$categories_id',sub_categories = '$sub_categories' where id = '$id'");
        }else{
            mysqli_query($con,"insert into sub_categories(categories_id,sub_categories,status) values('$categories_id','$sub_categories','1')");
        }
        header('location:sub_categories.php');
        die();
    }
}
?>

<div class="content pb-0">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><strong>Categories</strong><small> Form</small></div>
                  <form method="post">
                  <div class="card-body card-block">
                        <div class="form-group">
                            <label for="company" class=" form-control-label">Categories</label>
                            <select name="categories_id" required class="form-control">
                                <option value="">Select Category</option>
                                <?php
                                    $res = mysqli_query($con,"select * from categories where status = 1");
                                    while($row=mysqli_fetch_assoc($res)){
                                        if($row['id'] == $categories){
                                            echo "<option value=".$row['id']." selected>".$row['categories']."</option>";
                                        }else{
                                            echo "<option value=".$row['id'].">".$row['categories']."</option>";
                                        }
                                        
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class=" form-control-label">Sub Categories</label>
                            <input type="text" required value="<?php echo $sub_categories?>" name="sub_categories" placeholder="Enter sub categories" class="form-control">
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