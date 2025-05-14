<?php
require 'db.php';

// Lấy danh sách sản phẩm
$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách sản phẩm - TechFactory</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h1 { color: #2c3e50; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; border: 1px solid #bdc3c7; text-align: left; }
        th { background-color: #3498db; color: white; }
        a.button { background-color: #27ae60; color: white; padding: 8px 12px; text-decoration: none; border-radius: 4px; }
        a.button:hover { background-color: #2ecc71; }
        .action-link { margin-right: 8px; }
    </style>
</head>
<body>

<h1>Danh sách sản phẩm - TechFactory</h1>

<a class="button" href="add_product.php">+ Thêm sản phẩm</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên sản phẩm</th>
            <th>Giá bán (VND)</th>
            <th>Số lượng tồn</th>
            <th>Ngày tạo</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($products) > 0): ?>
            <?php foreach ($products as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= htmlspecialchars($p['product_name']) ?></td>
                    <td><?= number_format($p['unit_price'], 0, ',', '.') ?></td>
                    <td><?= $p['stock_quantity'] ?></td>
                    <td><?= $p['created_at'] ?></td>
                    <td>
                        <a class="action-link" href="edit_product.php?id=<?= $p['id'] ?>">Sửa</a>
                        <a class="action-link" href="delete_product.php?id=<?= $p['id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này không?');">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">Không có sản phẩm nào.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
