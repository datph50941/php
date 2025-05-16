<?php
$category = isset($_GET['category']) ? $_GET['category'] : '';
$xml = simplexml_load_file('data/brands.xml');
$options = '<option value="">Chọn thương hiệu</option>';

foreach ($xml->brand as $brand) {
    if ($category === '' || (string)$brand->category === $category) {
        $options .= "<option value='{$brand->name}'>{$brand->name}</option>";
    }
}

echo $options;
?>