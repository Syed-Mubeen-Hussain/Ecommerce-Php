<?php
include('vendor/autoload.php');
require('connection.inc.php');
require('functions.inc.php');

if (!isset($_SESSION['ADMIN_LOGIN'])) {
    if (!isset($_SESSION['USER_ID'])) {
        die();
    }
}


$order_id = get_safe_value($con, $_GET['id']);
$coupon_details = mysqli_fetch_assoc(mysqli_query($con, "select coupon_value from `order` where id = '$order_id'"));
$coupon_value = $coupon_details['coupon_value'];

$css = file_get_contents('css/bootstrap.min.css');
$css .= file_get_contents('style.css');

$html = '<div class="wishlist-table table-responsive">
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
    <tbody>';

$totalPrice = 0;

if (isset($_SESSION['ADMIN_LOGIN'])) {
    $res = mysqli_query($con, "select distinct(order_detail.id), order_detail.*,product.name,product.image from order_detail,product,`order` where order_id = '$order_id' and product.id = order_detail.product_id");
} else {
    $uid = $_SESSION['USER_ID'];
    $res = mysqli_query($con, "select distinct(order_detail.id), order_detail.*,product.name,product.image from order_detail,product,`order` where order_id = '$order_id' and `order`.user_id = '$uid' and product.id = order_detail.product_id");
}

if (mysqli_num_rows($res) == 0) {
    die();
}
while ($row = mysqli_fetch_assoc($res)) {
    $totalPrice = $totalPrice + ($row['qty'] * $row['price']);
    $pp = $row['qty'] * $row['price'];
    $html .= '
        <tr>
            <td class="product-name">' . $row['name'] . '</td>
            <td class="product-name">
                <img src="' . PRODUCT_IMAGE_SITE_PATH . $row['image'] . '">
            </td>
            <td class="product-name">' . $row['qty'] . '</td>
            <td class="product-name">' . $row['price'] . '</td>
            <td class="product-name">' . $pp . '</td>
        </tr>';
}

if ($coupon_value > 0) {
    $totalPrice = $totalPrice - $coupon_value;
    $html .= '<tr>
    <td colspan="3"></td>
    <td>Coupon Value</td>
    <td>' . $coupon_value . '</td>
</tr>
<tr>
    <td colspan="3"></td>
    <td>Total Price</td>
    <td>' .  $totalPrice . '</td>
</tr>';
} else {
    $html .= '<tr>
    <td colspan="3"></td>
    <td>Total Price</td>
    <td>' . $totalPrice . '</td>
</tr>';
}

$html .= '</tbody>
</table>
</div>';

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($css, 1);
$mpdf->WriteHTML($html, 2);
$file = time() . '.pdf';
$mpdf->Output($file, 'D');
