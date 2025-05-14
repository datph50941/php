<?php
require '../db.php';
$stmt = $pdo->prepare("UPDATE products SET unit_price = ?, stock_quantity = ? WHERE id = ?");
$stmt->execute([1950000, 60, 2]);
echo "Đã cập nhật sản phẩm ID 2";
