<?php
session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    if ($productId > 0) {
        $_SESSION['cart'][] = $productId;
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'cartCount' => count($_SESSION['cart'])]);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false]);
    }
}
?>