<?php
function write_log($action_desc, $filename = null) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $date = date('Y-m-d');
    $time = date('H:i:s');
    $log_dir = __DIR__ . '/../logs/';
    if (!file_exists($log_dir)) {
        mkdir($log_dir, 0777, true);
    }

    $log_file = $log_dir . "log_$date.txt";
    $line = "[$time] - IP: $ip - Hành động: $action_desc";
    if ($filename) {
        $line .= " - File: $filename";
    }
    $line .= PHP_EOL;

    file_put_contents($log_file, $line, FILE_APPEND);
}
