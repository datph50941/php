<?php
require 'db.php';

$products = [
    ['Động cơ A1', 1200000, 50],
    ['Cảm biến X9', 850000, 100],
    ['Bảng điều khiển Z3', 2200000, 30],
    ['Máy nén khí K7', 3750000, 20],
    ['Bộ xử lý T5', 1450000, 40]
];

$stmt = $pdo->prepare("INSERT INTO products (product_name, unit_price, stock_quantity) VALUES (?, ?, ?)");

foreach ($products as $p) {
    $stmt->execute($p);
    echo "Đã thêm sản phẩm với ID: " . $pdo->lastInsertId() . "<br>";
}
