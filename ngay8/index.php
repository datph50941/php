<?php



// Include thủ công các file
require_once 'src/XYZBank/Accounts/BankAccount.php';
require_once 'src/XYZBank/Accounts/InterestBearing.php';
require_once 'src/XYZBank/Accounts/TransactionLogger.php';
require_once 'src/XYZBank/Accounts/SavingsAccount.php';
require_once 'src/XYZBank/Accounts/CheckingAccount.php';
require_once 'src/XYZBank/Accounts/Bank.php';
require_once 'src/XYZBank/Accounts/AccountCollection.php';

use XYZBank\Accounts\AccountCollection;
use XYZBank\Accounts\SavingsAccount;
use XYZBank\Accounts\CheckingAccount;
use XYZBank\Accounts\Bank;

// Phần còn lại của code giữ nguyên

    $collection = new AccountCollection();

    // Tạo tài khoản tiết kiệm
    $savings = new SavingsAccount("10201122", "Nguyễn Thị A", 20000000);
    $collection->addAccount($savings);

    // Tạo tài khoản thanh toán
    $checking1 = new CheckingAccount("20301123", "Lê Văn B", 8000000);
    $checking2 = new CheckingAccount("20401124", "Trần Minh C", 12000000);
    $collection->addAccount($checking1);
    $collection->addAccount($checking2);

    // Thực hiện giao dịch
    $checking1->deposit(5000000);
    $checking2->withdraw(2000000);

    // Hiển thị thông tin tài khoản
    foreach ($collection as $account) {
        echo sprintf(
            "Tài khoản: %s | %s | Loại: %s | Số dư: %s VNĐ\n",
            $account->getAccountNumber(),
            $account->getOwnerName(),
            $account->getAccountType(),
            number_format($account->getBalance(), 0, ',', '.')
        );
    }

    // Hiển thị lãi suất tài khoản tiết kiệm
    $interest = $savings->calculateAnnualInterest();
    echo "Lãi suất hàng năm cho {$savings->getOwnerName()}: " .
         number_format($interest, ) . " VNĐ\n";

    // Hiển thị thông tin ngân hàng
    echo "Tổng số tài khoản đã tạo: " . Bank::getTotalAccounts() . "\n";
    echo "Tên ngân hàng: " . Bank::getBankName() . "\n";


// Chạy kiểm thử
