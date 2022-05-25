<?php
require('top.inc.php');
isAdmin();
if (isset($_GET['type']) && $_GET['type'] != '') {
    $type = get_safe_value($con, $_GET['type']);
    if ($type == "status") {
        $operation = get_safe_value($con, $_GET['operation']);
        $id = get_safe_value($con, $_GET['id']);
        if ($operation == "active") {
            $status = '1';
        } else {
            $status = '0';
        }
        $update_sql = "update coupon_master set status = '$status' where id = '$id'";
        $run = mysqli_query($con, $update_sql);
        if ($run) {
            echo "<script>window.location.href='coupon_master.php'</script>";
        }
    }

    if ($type == "delete") {
        $id = get_safe_value($con, $_GET['id']);
        $delete_sql = "delete from coupon_master where id = '$id'";
        $run = mysqli_query($con, $delete_sql);
        if ($run) {
            echo "<script>window.location.href='coupon_master.php'</script>";
        }
    }
}

$sql = "select * from coupon_master order by id desc";
$res = mysqli_query($con, $sql);
?>
<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Coupon Master</h4>
                        <h4 class="box-link"><a href="manage_coupon_master.php">Add Coupon</a></h4>
                    </div>
                    <div class="card-body">
                        <div class="table-stats order-table ov-h">
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th class="serial">#</th>
                                        <th>ID</th>
                                        <th>Coupon Code</th>
                                        <th>Coupon Value</th>
                                        <th>Coupon Type</th>
                                        <th>Min Value</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($res)) { ?>
                                        <tr>
                                            <td class="serial"><?php echo $i++ ?></td>
                                            <td><?php echo $row['id'] ?></td>
                                            <td><?php echo $row['coupon_code'] ?></td>
                                            <td><?php echo $row['coupon_value'] ?></td>
                                            <td><?php echo $row['coupon_type'] ?></td>
                                            <td><?php echo $row['cart_min_value'] ?></td>
                                            <td>
                                                <?php
                                                if ($row['status'] == 1) {
                                                    echo "<span class='badge badge-complete'><a href='?type=status&operation=deactive&id=$row[id]'>Active</a></span>&nbsp;";
                                                } else {
                                                    echo "<span class='badge badge-pending'><a href='?type=status&operation=active&id=$row[id]'>Deactive</a></span>&nbsp;";
                                                }
                                                echo "<span class='badge badge-edit'><a href='manage_coupon_master.php?id=$row[id]'>Edit</a></span>&nbsp;";

                                                echo "<span class='badge badge-delete'><a href='?type=delete&id=$row[id]'>Delete</a></span>";
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require('footer.inc.php');
?>