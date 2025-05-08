<?php
session_start();

if (!isset($_SESSION['cart']) || !isset($_SESSION['customer'])) {
    echo "Chưa có sản phẩm trong giỏ!";
    exit;
}

$cart = $_SESSION['cart'];
$customer = $_SESSION['customer'];
$total = 0;

echo "<h2>Thông tin đặt hàng</h2>";
echo "Email: {$customer['email']}<br>";
echo "SĐT: {$customer['phone']}<br>";
echo "Địa chỉ: {$customer['address']}<br><br>";

echo "<table border='1'><tr><th>Tên sách</th><th>SL</th><th>Giá</th><th>Thành tiền</th></tr>";

foreach ($cart as $title => $item) {
    $subtotal = $item['quantity'] * $item['price'];
    $total += $subtotal;
    echo "<tr><td>$title</td><td>{$item['quantity']}</td><td>{$item['price']}</td><td>$subtotal</td></tr>";
}

echo "</table>";
echo "<strong>Tổng thanh toán: " . number_format($total) . "đ</strong><br>";
echo "Thời gian đặt hàng: " . date("Y-m-d H:i:s") . "<br><br>";

$data = [
    "customer_email" => $customer['email'],
    "products" => [],
    "total_amount" => $total,
    "created_at" => date("Y-m-d H:i:s")
];

foreach ($cart as $title => $item) {
    $data['products'][] = [
        "title" => $title,
        "quantity" => $item['quantity'],
        "price" => $item['price']
    ];
}

try {
    file_put_contents("cart_data.json", json_encode($data, JSON_PRETTY_PRINT));
} catch (Exception $e) {
    echo "Không thể ghi file JSON: " . $e->getMessage();
}
?>

<form method="POST" action="clear_cart.php">
    <button type="submit">Xóa giỏ hàng</button>
</form>
