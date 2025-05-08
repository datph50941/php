<?php
session_start();

try {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_VALIDATE_REGEXP, [
        "options" => ["regexp" => "/^[0-9]{10,11}$/"]
    ]);
    $address = htmlspecialchars(trim($_POST['address']));
    $books = $_POST['books'];

    // Kiểm tra xem có sách nào được chọn không
    $hasSelectedBook = false;
    foreach ($books as $info) {
        if (isset($info['checked'])) {
            $hasSelectedBook = true;
            break;
        }
    }

    if (!$email || !$phone || !$address || !$hasSelectedBook) {
        throw new Exception("Dữ liệu không hợp lệ");
    }

    setcookie('customer_email', $email, time() + (86400 * 7)); // lưu 7 ngày

    foreach ($books as $title => $info) {
        if (isset($info['checked'])) {
            $cleanTitle = htmlspecialchars($title); // thay vì FILTER_SANITIZE_STRING đã deprecated
            $quantity = (int) $info['quantity'];
            $price = (int) $info['price'];

            if (!isset($_SESSION['cart'][$cleanTitle])) {
                $_SESSION['cart'][$cleanTitle] = ['quantity' => $quantity, 'price' => $price];
            } else {
                $_SESSION['cart'][$cleanTitle]['quantity'] += $quantity;
            }
        }
    }

    $_SESSION['customer'] = ['email' => $email, 'phone' => $phone, 'address' => $address];

    header("Location: view_cart.php");
} catch (Exception $e) {
    file_put_contents("log.txt", date("Y-m-d H:i:s") . " - Lỗi: " . $e->getMessage() . "\n", FILE_APPEND);
    echo "Đã có lỗi xảy ra: " . $e->getMessage();
}
