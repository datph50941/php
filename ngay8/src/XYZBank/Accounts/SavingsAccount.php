<?php

namespace XYZBank\Accounts;

/**
 * Savings account implementation
 */
class SavingsAccount extends BankAccount implements InterestBearing {
    use TransactionLogger;

    const INTEREST_RATE = 0.05; // 5%/năm
    const MINIMUM_BALANCE = 1000000; // 1.000.000 VNĐ

    public function deposit(float $amount): void {
        if ($amount <= 0) {
            throw new \InvalidArgumentException("Số tiền gửi phải lớn hơn 0");
        }
        $this->balance += $amount;
        $this->logTransaction("Gửi tiền", $amount, $this->balance);
    }

    public function withdraw(float $amount): void {
        if ($amount <= 0) {
            throw new \InvalidArgumentException("Số tiền rút phải lớn hơn 0");
        }
        if ($this->balance - $amount < self::MINIMUM_BALANCE) {
            throw new \RuntimeException("Số dư sau rút phải lớn hơn hoặc bằng 1.000.000 VNĐ");
        }
        $this->balance -= $amount;
        $this->logTransaction("Rút tiền", $amount, $this->balance);
    }

    public function getAccountType(): string {
        return "Tiết kiệm";
    }

    public function calculateAnnualInterest(): float {
        return $this->balance * self::INTEREST_RATE;
    }
}