<?php
require_once 'includes/db_connect.php';

$productId = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

$result = $conn->query("SELECT * FROM reviews WHERE product_id = $productId");
$reviews = [];
while ($row = $result->fetch_assoc()) {
    $reviews[] = [
        'user' => $row['user_name'],
        'comment' => $row['comment'],
        'rating' => $row['rating']
    ];
}
$conn->close();

header('Content-Type: application/json');
echo json_encode($reviews);
?>