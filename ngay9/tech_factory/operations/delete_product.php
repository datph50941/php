<?php
require '../db.php';
$id = 3; // ví dụ ID cần xóa
$stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
$stmt->execute([$id]);
echo "Đã xóa sản phẩm ID $id";
