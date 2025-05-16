<?php
require_once 'includes/db_connect.php';

$query = isset($_GET['q']) ? $_GET['q'] : '';

$safeQuery = $conn->real_escape_string($query);
$result = $conn->query("SELECT name, price FROM products WHERE name LIKE '%$safeQuery%'");
$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = [
        'name' => $row['name'],
        'price' => $row['price']
    ];
}
$conn->close();

header('Content-Type: application/json');
echo json_encode($products);
?>