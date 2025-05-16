<?php
session_start();
if (!isset($_SESSION['poll_results'])) {
    $_SESSION['poll_results'] = [
        'Giao diện' => 0,
        'Tốc độ' => 0,
        'Dịch vụ khách hàng' => 0
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $option = isset($_POST['option']) ? $_POST['option'] : '';
    if (array_key_exists($option, $_SESSION['poll_results'])) {
        $_SESSION['poll_results'][$option]++;
    }

    $total = array_sum($_SESSION['poll_results']);
    $results = [];
    foreach ($_SESSION['poll_results'] as $key => $value) {
        $results[$key] = $total > 0 ? round(($value / $total) * 100, 2) : 0;
    }

    header('Content-Type: application/json');
    echo json_encode($results);
}
?>