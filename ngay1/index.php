<?php

const COMMISSION_RATE = 0.2; 
const VAT_RATE = 0.1;        

$campaign_name = "Spring Sale 2025";
$order_count = (int) "150";           
$product_price = (float) 99.99;
$product_type = "Thời trang";
$campaign_status = true;              


$order_list = [
    "ID001" => 99.99,
    "ID002" => 49.99,
    "ID003" => 199.99,
    "ID004" => 89.50,
    "ID005" => 109.99
];


$total_revenue_from_list = 0;


$keys = array_keys($order_list);
for ($i = 0; $i < count($order_list); $i++) {
    $total_revenue_from_list += $order_list[$keys[$i]];
}


$revenue = $product_price * $order_count;


$commission_cost = $revenue * COMMISSION_RATE;


$vat = $revenue * VAT_RATE;


$profit = $revenue - $commission_cost - $vat;


echo "Tên chiến dịch: $campaign_name\n";
echo "Trạng thái: " . ($campaign_status ? "Đã kết thúc" : "Đang chạy") . "\n";


echo "Tổng doanh thu: $" . number_format($revenue, 2) . "\n";
echo "Chi phí hoa hồng (20%): $" . number_format($commission_cost, 2) . "\n";
echo "Thuế VAT (10%): $" . number_format($vat, 2) . "\n";
echo "Lợi nhuận: $" . number_format($profit, 2) . "\n";


if ($profit > 0) {
    echo "Đánh giá: Chiến dịch thành công\n";
} elseif ($profit == 0) {
    echo "Đánh giá: Chiến dịch hòa vốn\n";
} else {
    echo "Đánh giá: Chiến dịch thất bại\n";
}


switch ($product_type) {
    case "Thời trang":
        echo "Thông báo: Sản phẩm Thời trang có doanh thu ổn định.\n";
        break;
    case "Điện tử":
        echo "Thông báo: Sản phẩm Điện tử cần chiến lược giá cạnh tranh.\n";
        break;
    case "Gia dụng":
        echo "Thông báo: Sản phẩm Gia dụng có nhu cầu ổn định quanh năm.\n";
        break;
    default:
        echo "Thông báo: Loại sản phẩm không xác định.\n";
        break;
}


echo "\n--- Danh sách đơn hàng ---\n";
foreach ($order_list as $id => $value) {//
    echo "Đơn hàng $id: $" . number_format($value, 2) . "\n";
}


echo "\n--- Mảng đơn hàng ---\n";
print_r($order_list);


echo "\nThông tin debug:\n";
echo "File đang chạy: " . __FILE__ . "\n";
echo "Dòng hiện tại: " . __LINE__ . "\n";


echo "\nChiến dịch $campaign_name đã " . ($campaign_status ? "kết thúc" : "chưa kết thúc") .
    " với lợi nhuận: $" . number_format($profit, 2) . " USD.\n";
?>
