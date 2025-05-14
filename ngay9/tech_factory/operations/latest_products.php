<?php
require '../db.php';
$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC LIMIT 5");
foreach ($stmt as $row) {
    echo "{$row['product_name']} - {$row['created_at']}<br>";
}
