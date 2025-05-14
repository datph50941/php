<?php
require 'db.php';

// Mỗi đơn hàng gồm: ngày, tên KH, ghi chú, và danh sách sản phẩm (id, quantity)
$orders = [
    [
        '2025-05-10', 'Công ty A', 'Giao trước 20/5', [
            ['product_id' => 1, 'qty' => 2],
            ['product_id' => 2, 'qty' => 5],
        ]
    ],
    [
        '2025-05-11', 'Công ty B', 'Gấp', [
            ['product_id' => 3, 'qty' => 1],
            ['product_id' => 5, 'qty' => 3],
        ]
    ],
    [
        '2025-05-11', 'Công ty C', null, [
            ['product_id' => 1, 'qty' => 1],
            ['product_id' => 4, 'qty' => 2],
        ]
    ]
];

foreach ($orders as $order) {
    [$date, $customer, $note, $items] = $order;
    $stmt = $pdo->prepare("INSERT INTO orders (order_date, customer_name, note) VALUES (?, ?, ?)");
    $stmt->execute([$date, $customer, $note]);
    $orderId = $pdo->lastInsertId();

    foreach ($items as $item) {
        $prod = $pdo->prepare("SELECT unit_price FROM products WHERE id = ?");
        $prod->execute([$item['product_id']]);
        $price = $prod->fetchColumn();

        $insertItem = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price_at_order_time) VALUES (?, ?, ?, ?)");
        $insertItem->execute([$orderId, $item['product_id'], $item['qty'], $price]);
    }
    echo "Tạo đơn hàng ID: $orderId thành công<br>";
}
