<?php
require '../db.php';
$stmt = $pdo->query("SELECT * FROM products WHERE unit_price > 1000000");
foreach ($stmt as $row) {
    echo "{$row['product_name']} - {$row['unit_price']} VNĐ<br>";
}
