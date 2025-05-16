<?php
require_once 'includes/db_connect.php';

$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;

$result = $conn->query("SELECT * FROM products WHERE id = $productId");
if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
    echo "<h3>{$product['name']}</h3>";
    echo "<p>Mô tả: {$product['description']}</p>";
    echo "<p>Giá: {$product['price']} VNĐ</p>";
    echo "<p>Tồn kho: {$product['stock']}</p>";
} else {
    echo "<p>Không tìm thấy sản phẩm.</p>";
}
$conn->close();
?>