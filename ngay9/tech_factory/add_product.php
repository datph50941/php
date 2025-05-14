<?php
require 'db.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['product_name'] ?? '');
    $price = $_POST['unit_price'] ?? 0;
    $stock = $_POST['stock_quantity'] ?? 0;

    if ($name === '') {
        $errors[] = "Tên sản phẩm không được để trống.";
    }

    if (!is_numeric($price) || $price <= 0) {
        $errors[] = "Giá sản phẩm phải là số và lớn hơn 0.";
    }

    if (!is_numeric($stock) || $stock < 0) {
        $errors[] = "Số lượng tồn phải là số không âm.";
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO products (product_name, unit_price, stock_quantity, created_at)
                VALUES (:name, :price, :stock, NOW())
            ");
            $stmt->execute([
                ':name' => $name,
                ':price' => $price,
                ':stock' => $stock
            ]);

            $success = "✅ Thêm sản phẩm thành công (ID: " . $pdo->lastInsertId() . ")";
        } catch (PDOException $e) {
            $errors[] = "Lỗi khi thêm sản phẩm: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm sản phẩm - TechFactory</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        input[type="text"], input[type="number"] {
            width: 300px; padding: 8px; margin: 5px 0;
        }
        .form-group { margin-bottom: 10px; }
        .btn { background: #27ae60; color: #fff; padding: 8px 16px; border: none; border-radius: 4px; }
        .btn:hover { background: #2ecc71; }
        .error { color: red; margin-top: 10px; }
        .success { color: green; margin-top: 10px; }
        a { display: inline-block; margin-top: 20px; }
    </style>
</head>
<body>

<h2>➕ Thêm sản phẩm mới</h2>

<?php if ($success): ?>
    <p class="success"><?= $success ?></p>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <div class="error">
        <ul>
            <?php foreach ($errors as $e): ?>
                <li><?= $e ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post">
    <div class="form-group">
        <label>Tên sản phẩm:</label><br>
        <input type="text" name="product_name" required>
    </div>

    <div class="form-group">
        <label>Giá bán (VND):</label><br>
        <input type="number" name="unit_price" step="0.01" required>
    </div>

    <div class="form-group">
        <label>Số lượng tồn:</label><br>
        <input type="number" name="stock_quantity" required>
    </div>

    <button class="btn" type="submit">Lưu sản phẩm</button>
</form>

<a href="index.php">← Quay về danh sách sản phẩm</a>

</body>
</html>
