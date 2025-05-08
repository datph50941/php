<?php
function handle_file_upload($file) {
    $allowed_types = ['image/jpeg', 'image/png', 'application/pdf'];
    $max_size = 2 * 1024 * 1024; // 2MB

    if ($file['error'] === UPLOAD_ERR_OK) {
        if ($file['size'] > $max_size) {
            return "File vượt quá dung lượng cho phép (2MB).";
        }
        if (!in_array($file['type'], $allowed_types)) {
            return "Định dạng file không hợp lệ. Chỉ cho phép JPG, PNG, PDF.";
        }

        $timestamp = time();
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $new_name = "upload_" . $timestamp . "." . $ext;
        $upload_dir = __DIR__ . '/../uploads/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $dest = $upload_dir . $new_name;
        move_uploaded_file($file['tmp_name'], $dest);

        return "Tải file thành công: $new_name";
    } else {
        return "Lỗi khi tải file.";
    }
}
?>
