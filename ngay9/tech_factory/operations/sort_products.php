<?php
require '../db.php';
$stmt = $pdo->query("SELECT * FROM products ORDER BY unit_price DESC");
foreach ($stmt as $row) {
    echo "{$row['product_name']} - {$row['unit_price']}<br>";
}
