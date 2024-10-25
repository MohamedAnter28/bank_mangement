<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST['amount'];
    $account_id = $_POST['account_id'];

    // تحقق من الرصيد قبل السحب
    $sql = "SELECT balance FROM accounts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $account_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $account = $result->fetch_assoc();

    if ($account['balance'] >= $amount) {
        // تحديث الرصيد
        $sql = "UPDATE accounts SET balance = balance - ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("di", $amount, $account_id);
        $stmt->execute();

        // تسجيل المعاملة
        $sql = "INSERT INTO transactions (account_id, amount, transaction_type) VALUES (?, ?, 'withdraw')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("id", $account_id, $amount);
        $stmt->execute();

        header("Location: dashboard.php");
        exit();
    } else {
        echo "لا يوجد رصيد كافٍ في الحساب.";
    }
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM accounts WHERE user_id='$user_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>سحب</title>
</head>
<body>
    <h1>سحب الأموال</h1>
    <form method="POST" action="">
        <select name="account_id" required>
            <option value="">اختر الحساب</option>
            <?php while ($account = $result->fetch_assoc()) { ?>
                <option value="<?php echo $account['id']; ?>"><?php echo $account['id']; ?></option>
            <?php } ?>
        </select>
        <input type="number" name="amount" placeholder="المبلغ" required>
        <button type="submit">سحب</button>
    </form>
    <a href="dashboard.php">عودة إلى لوحة التحكم</a>
</body>
</html>
