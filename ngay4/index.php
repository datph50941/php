<?php
session_start();

if (!isset($_SESSION['transactions'])) {
    $_SESSION['transactions'] = [];
}

if (!isset($_SESSION['total_income'])) {
    $_SESSION['total_income'] = 0;
}

if (!isset($_SESSION['total_expense'])) {
    $_SESSION['total_expense'] = 0;
}

$warnings = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['transaction_name'] ?? '';
    $amount = $_POST['amount'] ?? '';
    $type = $_POST['type'] ?? '';
    $note = $_POST['note'] ?? '';
    $date = $_POST['date'] ?? '';

    $errors = [];

    if (!preg_match("/^[a-zA-ZÀ-ỹ0-9\s]+$/u", $name)) {
        $errors[] = "Tên giao dịch không được chứa ký tự đặc biệt.";
    }

    if (!preg_match("/^[0-9]+(\.[0-9]{1,2})?$/", $amount) || floatval($amount) <= 0) {
        $errors[] = "Số tiền phải là số dương hợp lệ.";
    }

    if (!preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $date)) {
        $errors[] = "Ngày thực hiện không đúng định dạng dd/mm/yyyy.";
    }

    $sensitive_keywords = ['nợ xấu', 'vay nóng'];
    foreach ($sensitive_keywords as $word) {
        if (stripos($note, $word) !== false) {
            $warnings[] = "Cảnh báo: Ghi chú chứa từ khóa nhạy cảm \"$word\".";
        }
    }

    if (empty($errors)) {
        $transaction = [
            'name' => $name,
            'amount' => floatval($amount),
            'type' => $type,
            'note' => $note,
            'date' => $date
        ];

        $_SESSION['transactions'][] = $transaction;

        // Update totals
        if ($type === 'thu') {
            $_SESSION['total_income'] += $transaction['amount'];
        } else {
            $_SESSION['total_expense'] += $transaction['amount'];
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ứng dụng Giao dịch Tài chính</title>
</head>
<body>
    <h2>Nhập giao dịch tài chính</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label>Tên giao dịch:</label><br>
        <input type="text" name="transaction_name" value="<?= htmlspecialchars($name ?? '') ?>" required><br><br>

        <label>Số tiền:</label><br>
        <input type="text" name="amount" value="<?= htmlspecialchars($amount ?? '') ?>" required><br><br>

        <label>Loại giao dịch:</label><br>
        <input type="radio" name="type" value="thu" <?= (isset($type) && $type == 'thu') ? 'checked' : '' ?> required> Thu
        <input type="radio" name="type" value="chi" <?= (isset($type) && $type == 'chi') ? 'checked' : '' ?>> Chi<br><br>

        <label>Ghi chú:</label><br>
        <textarea name="note"><?= htmlspecialchars($note ?? '') ?></textarea><br><br>

        <label>Ngày thực hiện (dd/mm/yyyy):</label><br>
        <input type="text" name="date" value="<?= htmlspecialchars($date ?? '') ?>" required><br><br>

        <input type="submit" value="Lưu giao dịch">
    </form>

    <?php if (!empty($errors)) : ?>
        <ul style="color:red;">
            <?php foreach ($errors as $error) echo "<li>$error</li>"; ?>
        </ul>
    <?php endif; ?>

    <?php if (!empty($warnings)) : ?>
        <ul style="color:orange;">
            <?php foreach ($warnings as $warn) echo "<li>$warn</li>"; ?>
        </ul>
    <?php endif; ?>

    <?php if (!empty($_SESSION['transactions'])) : ?>
        <h3>Danh sách giao dịch:</h3>
        <table border="1" cellpadding="5">
            <tr>
                <th>Tên</th>
                <th>Số tiền</th>
                <th>Loại</th>
                <th>Ghi chú</th>
                <th>Ngày</th>
            </tr>
            <?php
            foreach ($_SESSION['transactions'] as $item) {
                echo "<tr>";
                foreach ($item as $value) {
                    echo "<td>" . htmlspecialchars($value) . "</td>";
                }
                echo "</tr>";
            }
            ?>
        </table>
        <br>
        <strong>Tổng thu:</strong> <?= number_format($_SESSION['total_income'], 0, ',', '.') ?> VNĐ<br>
        <strong>Tổng chi:</strong> <?= number_format($_SESSION['total_expense'], 0, ',', '.') ?> VNĐ<br>
        <strong>Số dư:</strong> <?= number_format($_SESSION['total_income'] - $_SESSION['total_expense'], 0, ',', '.') ?> VNĐ<br>
    <?php endif; ?>
</body>
</html>
