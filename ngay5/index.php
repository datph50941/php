<?php
require_once "includes/header.php";
require_once "includes/logger.php";
require_once "includes/upload.php";

$upload_result = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $uploaded_filename = null;

    if (isset($_FILES['proof']) && $_FILES['proof']['error'] !== 4) {
        $upload_result = handle_file_upload($_FILES['proof']);
        if (strpos($upload_result, 'Tải file thành công') !== false) {
            preg_match('/Tải file thành công: (.+)/', $upload_result, $matches);
            $uploaded_filename = $matches[1] ?? null;
        }
    }

    if ($action !== '') {
        write_log($action, $uploaded_filename);
    }
}

?>

<form method="post" enctype="multipart/form-data">
    <label>Nhập mô tả hành động:</label><br>
    <input type="text" name="action" required style="width: 400px;"><br><br>

    <label>Đính kèm file minh chứng (jpg, png, pdf):</label><br>
    <input type="file" name="proof"><br><br>

    <button type="submit">Ghi nhật ký</button>
</form>

<?php if ($upload_result): ?>
    <p class="<?= strpos($upload_result, 'thành công') !== false ? 'success' : 'error' ?>"><?= $upload_result ?></p>
<?php endif; ?>

<br><hr>
<a href="view_log.php">Xem nhật ký theo ngày</a>
</body>
</html>
