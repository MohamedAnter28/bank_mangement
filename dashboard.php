<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// استرجاع معلومات الحسابات
$sql = "SELECT * FROM accounts WHERE user_id='$user_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>لوحة التحكم</title>
</head>
<body>
    <h1>مرحبًا بك في لوحة التحكم</h1>
    <h2>حساباتك</h2>
    <table>
        <tr>
            <th>رقم الحساب</th>
            <th>الرصيد</th>
        </tr>
        <?php while ($account = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $account['id']; ?></td>
                <td><?php echo $account['balance']; ?> ج.م</td>
            </tr>
        <?php } ?>
    </table>
    
    <h3>إجراءات الحساب</h3>
    <a href="add_account.php">إضافة حساب جديد</a>
    <a href="deposit.php">إيداع</a>
    <a href="withdraw.php">سحب</a>
    <a href="transactions.php">عرض المعاملات</a>
    <a href="logout.php">تسجيل الخروج</a>
</body>
</html>
