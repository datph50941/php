<?php
require_once "includes/header.php";
?>

<form method="post">
    <label>Chọn ngày để xem nhật ký:</label>
    <input type="date" name="log_date" required>
    <button type="submit">Xem nhật ký</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['log_date'])) {
    $selected_date = $_POST['log_date'];
    $filename = __DIR__ . "/logs/log_$selected_date.txt";

    if (file_exists($filename)) {
        echo "<h3>Nhật ký ngày $selected_date</h3>";
        $file = fopen($filename, "r");
        while (!feof($file)) {
            $line = fgets($file);
            if ($line) {
                $class = (stripos($line, 'thất bại') !== false) ? 'important' : 'log-line';
                echo "<div class='$class'>" . htmlspecialchars($line) . "</div>";
        
                // Nếu dòng có chứa file minh chứng thì hiển thị
                if (preg_match('/File:\s*(.+)/', $line, $match)) {
                    $filename = trim($match[1]);
                    $filepath = "uploads/" . $filename;
                    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                    if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                        echo "<div><img src='$filepath' alt='minh chứng' width='200'></div><br>";
                    } elseif ($ext === 'pdf') {
                        echo "<div><a href='$filepath' target='_blank'>Xem file PDF</a></div><br>";
                    }
                }
            }
        }
        
    }
}
?>

</body>
</html>
