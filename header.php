<?php
include 'conn.php';
// SQL query to get total amount of transactions
$sql = "SELECT SUM(Amount) AS total_amount FROM transactions";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the result as an associative array
    $row = $result->fetch_assoc();

    // Access the total_amount value
    $totalAmount = $row["total_amount"];

} else {
    echo "No transactions found.";
}

// Close the database connection
// $conn->close();
// $getAccountData = mysqli_query($conn, "SELECT * FROM transactions");
// if (mysqli_num_rows($getAccountData) > 0) {
//     $accountData = mysqli_fetch_array($getAccountData);
//     $accountBalance = $accountData['Amount'];
  
//     if ($accountBalance == "" || $accountBalance == null || empty($accountBalance)) {
//         $accountBalance = 0;
//     }else{
//         $accountBalance = $accountData['Amount'];
//     }
// }else{
//     $accountBalance = 0;
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Money Wallet</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="login form">
            <div class="containerholder">
                <h1>Wallet App</h1>

                <div class="account" id="account">
                    <h2>Account Balance</h2>

                     <h3>Ksh <?= number_format($totalAmount, 2);?></h3> <!-- ECHO THE BALANCE IN TWO DECIMAL PLACES -->
                </div>
                <div class="account-panel">
                    <div class="account-name">
                        <h2><span class="loginuser">User Logged in :</span>Edwin</h2>
                    </div>
                    <div class="account-logout">
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
                <?php include 'links.php'; ?>
            </div>
        </div>
    </div>
</body>
</html>
