<?php
$users = [
    1 => ['name' => 'Alice', 'referrer_id' => null],
    2 => ['name' => 'Bob', 'referrer_id' => 1],
    3 => ['name' => 'Charlie', 'referrer_id' => 2],
    4 => ['name' => 'David', 'referrer_id' => 3],
    5 => ['name' => 'Eva', 'referrer_id' => 1],
];

$orders = [
    ['order_id' => 101, 'user_id' => 4, 'amount' => 200.0],
    ['order_id' => 102, 'user_id' => 3, 'amount' => 150.0],
    ['order_id' => 103, 'user_id' => 5, 'amount' => 300.0],
];

$commissionRates = [
    1 => 0.10,
    2 => 0.05,
    3 => 0.02,
];


function getReferrers(int $userId, array $users, int $maxLevel = 3): array {//
    $referrers = [];
    $currentId = $userId;
    $level = 1;

    while ($level <= $maxLevel && isset($users[$currentId]['referrer_id'])) {
        $refId = $users[$currentId]['referrer_id'];
        if ($refId === null) break;
        $referrers[$level] = $refId;
        $currentId = $refId;
        $level++;
    }

    return $referrers; 
}


function calculateCommissionAmount(float $amount, float $rate = 0.1): float {//
    return $amount * $rate;
}


$commissionLog = [];


function logCommission(int $userId, array $order, int $level, float $commission): void {//
    global $commissionLog;
    static $logCount = 0;
    $logCount++;

    $commissionLog[] = [
        'log_id'     => $logCount,
        'receiver'   => $userId,
        'from_order' => $order['order_id'],
        'buyer'      => $order['user_id'],
        'level'      => $level,
        'amount'     => round($commission, 2),
    ];
}


function calculateCommission(array $orders, array $users, array $rates): array {//
    $results = [];

    foreach ($orders as $order) {
        $buyerId = $order['user_id'];
        $amount = $order['amount'];

        $referrers = getReferrers($buyerId, $users);

        foreach ($referrers as $level => $refUserId) {
            $rate = $rates[$level] ?? 0;
            $commission = calculateCommissionAmount($amount, $rate);

           
            if (!isset($results[$refUserId])) $results[$refUserId] = 0;
            $results[$refUserId] += $commission;


            logCommission($refUserId, $order, $level, $commission);
        }
    }

    return $results;
}


$totalCommission = calculateCommission($orders, $users, $commissionRates);


echo "=== BÁO CÁO TỔNG HOA HỒNG ===\n";
foreach ($totalCommission as $userId => $amount) {
    echo "- " . $users[$userId]['name'] . " nhận được: $" . number_format($amount, 2) . "\n";
}

echo "\n=== CHI TIẾT HOA HỒNG ===\n";
array_map(function ($log) use ($users) {
    echo "- " . $users[$log['receiver']]['name'] .
         " nhận hoa hồng từ đơn #" . $log['from_order'] .
         " do " . $users[$log['buyer']]['name'] .
         " mua (Cấp " . $log['level'] . "): $" .
         number_format($log['amount'], 2) . "\n";
}, $commissionLog);
function printUserOrders(int $userId, array ...$orders): void {//
    echo "\n[Đơn hàng của người dùng ID $userId]:\n";
    foreach ($orders as $order) {
        if ($order['user_id'] === $userId) {
            echo "- Đơn #" . $order['order_id'] . ": $" . $order['amount'] . "\n";
        }
    }
}

printUserOrders(4, ...$orders); 
