<?php
session_start();

$books = [
    ["title" => "Clean Code", "price" => 150000],
    ["title" => "Design Patterns", "price" => 200000],
    ["title" => "Refactoring", "price" => 180000],
];

$customer_email = isset($_COOKIE['customer_email']) ? $_COOKIE['customer_email'] : '';
?>

<h2>Chọn sách</h2>
<form method="POST" action="add_to_cart.php">
    <label>Email:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($customer_email) ?>" required><br>

    <label>SĐT:</label>
    <input type="text" name="phone" required><br>

    <label>Địa chỉ:</label>
    <input type="text" name="address" required><br><br>

    <h3>Danh sách sách:</h3>
    <?php foreach ($books as $book): ?>
        <input type="checkbox" name="books[<?= $book['title'] ?>][checked]" value="1">
        <?= $book['title'] ?> - <?= number_format($book['price']) ?>đ
        SL: <input type="number" name="books[<?= $book['title'] ?>][quantity]" min="1" value="1">
        <input type="hidden" name="books[<?= $book['title'] ?>][price]" value="<?= $book['price'] ?>"><br>
    <?php endforeach; ?>

    <button type="submit">Thêm vào giỏ</button>
</form>
