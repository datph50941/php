<?php
class AffiliatePartner {
    protected string $name;
    protected string $email;
    protected float $commissionRate;
    protected bool $isActive;

    const PLATFORM_NAME = "VietLink Affiliate";

    public function __construct($name, $email, $commissionRate, $isActive = true) {
        $this->name = $name;
        $this->email = $email;
        $this->commissionRate = $commissionRate;
        $this->isActive = $isActive;
    }

    public function __destruct() {
        echo "Đã hủy cộng tác viên: {$this->name}<br>";
    }

    public function calculateCommission($orderValue): float {
        return ($this->commissionRate / 100) * $orderValue;
    }

    public function getSummary(): string {
        return "Tên: {$this->name}, Email: {$this->email}, Hoa hồng: {$this->commissionRate}%, Trạng thái: " 
            . ($this->isActive ? "Đang hoạt động" : "Ngưng hoạt động") . ", Nền tảng: " . self::PLATFORM_NAME;
    }
}
