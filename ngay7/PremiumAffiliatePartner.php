<?php
require_once 'AffiliatePartner.php';

class PremiumAffiliatePartner extends AffiliatePartner {
    private float $bonusPerOrder;

    public function __construct($name, $email, $commissionRate, $bonusPerOrder, $isActive = true) {
        parent::__construct($name, $email, $commissionRate, $isActive);
        $this->bonusPerOrder = $bonusPerOrder;
    }

    public function calculateCommission($orderValue): float {
        return parent::calculateCommission($orderValue) + $this->bonusPerOrder;
    }

    public function getSummary(): string {
        return parent::getSummary() . ", Thưởng đơn hàng: " . number_format($this->bonusPerOrder) . " VNĐ";
    }
}
