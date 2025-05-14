<?php
require '../db.php';
$stmt = $pdo->query("SELECT * FROM products");
foreach ($stmt as $row) {
    echo "{$row['product_name']} - {$row['unit_price']} VNĐ<br>";
}
