<?php
require 'db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID sản phẩm không hợp lệ!");
}

// Lấy thông tin sản phẩm theo ID
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    die("Không tìm thấy sản phẩm!");
}

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
            $stmt = $pdo->prepare("UPDATE products SET product_name = ?, unit_price = ?, stock_quantity = ? WHERE id = ?");
            $stmt->execute([$name, $price, $stock, $id]);
            $success = "Cập nhật sản phẩm thành công!";
            // Làm mới dữ liệu sản phẩm sau cập nhật
            $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->execute([$id]);
            $product = $stmt->fetch();
        } catch (PDOException $e) {
            $errors[] = "Lỗi cập nhật: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa sản phẩm - TechFactory</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        input[type="text"], input[type="number"] {
            width: 300px; padding: 8px; margin: 5px 0;
        }
        .form-group { margin-bottom: 10px; }
        .btn { background: #2980b9; color: #fff; padding: 8px 16px; border: none; border-radius: 4px; }
        .btn:hover { background: #3498db; }
        .error { color: red; margin-top: 10px; }
        .success { color: green; margin-top: 10px; }
        a { display: inline-block; margin-top: 20px; }
    </style>
</head>
<body>

<h2>Sửa sản phẩm</h2>

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
        <input type="text" name="product_name" value="<?= htmlspecialchars($product['product_name']) ?>" required>
    </div>

    <div class="form-group">
        <label>Giá bán (VND):</label><br>
        <input type="number" name="unit_price" step="0.01" value="<?= $product['unit_price'] ?>" required>
    </div>

    <div class="form-group">
        <label>Số lượng tồn:</label><br>
        <input type="number" name="stock_quantity" value="<?= $product['stock_quantity'] ?>" required>
    </div>

    <button class="btn" type="submit">Cập nhật sản phẩm</button>
</form>

<a href="index.php">← Quay về danh sách sản phẩm</a>

</body>
</html>
