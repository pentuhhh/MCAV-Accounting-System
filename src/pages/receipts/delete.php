<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /receipts");
    exit();
}

require_once "../utilities/db-connection.php";

$sql = "UPDATE Payment_Receipts SET IsRemoved = 1 WHERE ReceiptID = {$_POST["id"]}";

$result = $conn->query($sql);
$conn->close();

header("Location: /receipts");
exit();
