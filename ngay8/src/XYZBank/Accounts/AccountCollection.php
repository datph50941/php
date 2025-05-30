<?php

namespace XYZBank\Accounts;

/**
 * Iterable collection of accounts
 */
class AccountCollection implements \IteratorAggregate {
    private array $accounts = [];

    public function addAccount(BankAccount $account): void {
        $this->accounts[] = $account;
    }

    public function getIterator(): \Iterator {
        return new \ArrayIterator($this->accounts);
    }

    public function getHighBalanceAccounts(float $threshold = 10000000): array {
        return array_filter($this->accounts, fn($account) => $account->getBalance() >= $threshold);
    }
}