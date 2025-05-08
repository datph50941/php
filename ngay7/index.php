<?php
require_once 'AffiliatePartner.php';
require_once 'PremiumAffiliatePartner.php';
require_once 'AffiliateManager.php';

$manager = new AffiliateManager();

// Tạo cộng tác viên thường
$partner1 = new AffiliatePartner("Nguyễn Văn A", "a@gmail.com", 5);   // 5%
$partner2 = new AffiliatePartner("Trần Thị B", "b@gmail.com", 7);   // 7%

// Tạo cộng tác viên cao cấp
$premium = new PremiumAffiliatePartner("Lê Văn C", "c@gmail.com", 6, 50000); // 6% + 50.000đ

// Thêm vào hệ thống
$manager->addPartner($partner1);
$manager->addPartner($partner2);
$manager->addPartner($premium);

// Hiển thị thông tin
echo "<h3>Danh sách cộng tác viên:</h3>";
$manager->listPartners();

// Giả sử mỗi người có đơn hàng 2.000.000
$orderValue = 2000000;
echo "<h3>Hoa hồng từng cộng tác viên:</h3>";
echo "{$partner1->getSummary()} - Hoa hồng: " . number_format($partner1->calculateCommission($orderValue)) . " VNĐ<br>";
echo "{$partner2->getSummary()} - Hoa hồng: " . number_format($partner2->calculateCommission($orderValue)) . " VNĐ<br>";
echo "{$premium->getSummary()} - Hoa hồng: " . number_format($premium->calculateCommission($orderValue)) . " VNĐ<br>";

// Tổng hoa hồng
echo "<h3>Tổng hoa hồng hệ thống phải chi: " . number_format($manager->totalCommission($orderValue)) . " VNĐ</h3>";
