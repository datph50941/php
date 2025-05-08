<?php

$employees = [
    ['id' => 101, 'name' => 'Nguyễn Văn A', 'base_salary' => 5000000],
    ['id' => 102, 'name' => 'Trần Thị B', 'base_salary' => 6000000],
    ['id' => 103, 'name' => 'Lê Văn C', 'base_salary' => 5500000],
];

$timesheet = [
    101 => ['2025-03-01', '2025-03-02', '2025-03-04', '2025-03-05'],
    102 => ['2025-03-01', '2025-03-03', '2025-03-04'],
    103 => ['2025-03-02', '2025-03-03', '2025-03-04', '2025-03-05', '2025-03-06'],
];

$adjustments = [
    101 => ['allowance' => 500000, 'deduction' => 200000],
    102 => ['allowance' => 300000, 'deduction' => 100000],
    103 => ['allowance' => 400000, 'deduction' => 150000],
];


foreach ($timesheet as $id => $days) {
    $timesheet[$id] = array_unique($days); // array_unique()
}


$workingDays = array_map('count', $timesheet); // count() + array_map()


function calculateNetSalary($employee, $workingDays, $adjustments, $standardDays = 22): int {
    $id = $employee['id'];
    $base = $employee['base_salary'];
    $actualDays = $workingDays[$id] ?? 0;
    $allowance = $adjustments[$id]['allowance'] ?? 0;
    $deduction = $adjustments[$id]['deduction'] ?? 0;

    $salary = ($base / $standardDays) * $actualDays + $allowance - $deduction;
    return round($salary); 
}


$payroll = array_map(function ($emp) use ($workingDays, $adjustments) {
    $id = $emp['id'];
    $days = $workingDays[$id] ?? 0;
    $base = $emp['base_salary'];
    $allowance = $adjustments[$id]['allowance'] ?? 0;
    $deduction = $adjustments[$id]['deduction'] ?? 0;
    $netSalary = calculateNetSalary($emp, $workingDays, $adjustments);

    return compact('id', 'days', 'base', 'allowance', 'deduction', 'netSalary') + ['name' => $emp['name']];
}, $employees);

echo "<h2>BẢNG LƯƠNG THÁNG 03/2025</h2>";
echo "<table border='1' cellpadding='8' cellspacing='0'>";
echo "<tr>
        <th>Mã NV</th>
        <th>Họ tên</th>
        <th>Ngày công</th>
        <th>Lương cơ bản</th>
        <th>Phụ cấp</th>
        <th>Khấu trừ</th>
        <th>Thực lĩnh</th>
      </tr>";

foreach ($payroll as $row) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['days']}</td>
            <td>" . number_format($row['base']) . "</td>
            <td>" . number_format($row['allowance']) . "</td>
            <td>" . number_format($row['deduction']) . "</td>
            <td>" . number_format($row['netSalary']) . "</td>
          </tr>";
}

echo "</table>";




$total = array_sum(array_map(fn($r) => $r['netSalary'], $payroll));
echo "\nTổng quỹ lương tháng 03/2025: " . number_format($total) . " VND\n";


$sorted = $payroll;
usort($sorted, fn($a, $b) => $b['days'] <=> $a['days']); 

$maxEmp = $sorted[0];
$minEmp = end($sorted);

echo "Nhân viên làm nhiều nhất: {$maxEmp['name']} ({$maxEmp['days']} ngày công)\n";
echo "Nhân viên làm ít nhất: {$minEmp['name']} ({$minEmp['days']} ngày công)\n";


$filtered = array_filter($payroll, fn($r) => $r['days'] >= 4); // array_filter()
echo "Danh sách nhân viên đủ điều kiện xét thưởng:\n";
foreach ($filtered as $r) {
    echo "- {$r['name']} ({$r['days']} ngày công)\n";
}


$checkDate = '2025-03-03';
$checkName = 'Trần Thị B';
$checkId = 101;

$hasWorked = in_array($checkDate, $timesheet[102] ?? []); 
echo "$checkName có đi làm vào ngày $checkDate: " . ($hasWorked ? "Có" : "Không") . "\n";

$hasAdjustment = array_key_exists($checkId, $adjustments); // array_key_exists()
echo "Thông tin phụ cấp của nhân viên $checkId tồn tại: " . ($hasAdjustment ? "Có" : "Không") . "\n";

// 11. Thêm nhân viên mới
$newEmployees = [
    ['id' => 104, 'name' => 'Phạm Thị D', 'base_salary' => 5200000],
];
$employees = array_merge($employees, $newEmployees); // array_merge()

// 12. Thêm ngày công cho nhân viên
array_push($timesheet[101], '2025-03-06'); // thêm cuối
array_unshift($timesheet[101], '2025-03-07'); // thêm đầu
array_pop($timesheet[101]); // xóa cuối
array_shift($timesheet[101]); // xóa đầu
?>
