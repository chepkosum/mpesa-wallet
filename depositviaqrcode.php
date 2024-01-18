<?php
$genQRCode = false;
include 'header.php';
if (isset($_POST['generateqrcode'])) {
    include 'accessToken.php';
    $amount = $_POST['amount'];
    $accountNumber = $_POST['accountNumber'];
    $DynamicQRUrl = 'https://sandbox.safaricom.co.ke/mpesa/qrcode/v1/generate';
    $MerchantName = "Chepterit Softwares";
    $BusinessShortCode = "600997";
    $AccountNumber = "Edwin123";
    $payload = array(
        'MerchantName' => $MerchantName,
        'RefNo' => $accountNumber,
        'Amount' => $amount,
        'TrxCode' => 'PB',
        'CPI' => $BusinessShortCode,
        'Size' => '300',
    );
    $data_string = json_encode($payload);
    $headers = array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $access_token,
    );
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $DynamicQRUrl);
    curl_setopt($curl, CURLINFO_HEADER_OUT, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

    $response = curl_exec($curl);
    $resp = json_decode($response);
    $resp->QRCode;
    if (isset($resp->QRCode)) {
        $data = $resp->QRCode;
        $qrImage = "data:image/jpeg;base64, {$resp->QRCode}";
        $genQRCode = true;
    } else {
        echo "<script>window.location.href='depositviaqrcode.php?error=Something Went Wrong'</script>'";
    }
}

if ($genQRCode == true) {
?>
    <form action="#">
        <?php
        echo "<p style='color:green'>Scan the QR Code Below To Complete The Transaction</p>";
        ?>
        <image src="<?= $qrImage; ?>" alt="QR Code">
    </form>
<?php } else { ?>
    <form action="#" method="POST">
        <?php
        if (isset($_GET['success'])) {
            echo "<p style='color:green'>" . $_GET['success'] . "</p>";
        } elseif (isset($_GET['error'])) {
            echo "<p style='color:red'>" . $_GET['error'] . "</p>";
        }
        ?>
        <input type="number" name="amount" placeholder="Amount" required>
        <input type="text" name="accountNumber" placeholder="Account Number" required>
        <input type="submit" class="button" name="generateqrcode" value="GENERATE QR CODE">
    </form>
<?php } ?>