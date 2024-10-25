<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $initial_balance = $_POST['initial_balance'];

    // إضافة حساب جديد
    $sql = "INSERT INTO accounts (user_id, balance) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("id", $user_id, $initial_balance);
    $stmt->execute();

    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>إضافة حساب جديد</title>
</head>
<body>
    <h1>إضافة حساب جديد</h1>
    <form method="POST" action="">
        <input type="number" name="initial_balance" placeholder="الرصيد الابتدائي" required>
        <button type="submit">إضافة حساب</button>
    </form>
    <a href="dashboard.php">عودة إلى لوحة التحكم</a>
</body>
</html>
