<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT a.id AS account_id, t.amount, t.transaction_type, t.transaction_date 
        FROM transactions t 
        JOIN accounts a ON t.account_id = a.id 
        WHERE a.user_id = '$user_id' 
        ORDER BY t.transaction_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>عرض المعاملات</title>
</head>
<body>
    <h1>المعاملات السابقة</h1>
    <table>
        <tr>
            <th>رقم الحساب</th>
            <th>المبلغ</th>
            <th>نوع المعاملة</th>
            <th>تاريخ المعاملة</th>
        </tr>
        <?php while ($transaction = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $transaction['account_id']; ?></td>
                <td><?php echo $transaction['amount']; ?> ج.م</td>
                <td><?php echo $transaction['transaction_type']; ?></td>
                <td><?php echo $transaction['transaction_date']; ?></td>
            </tr>
        <?php } ?>
    </table>
    <a href="dashboard.php">عودة إلى لوحة التحكم</a>
</body>
</html>
