<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /receipts");
    exit();
}

require_once "../utilities/db-connection.php";

// get planID from receipt

$sql = "select PlanID from payment_receipts where ReceiptID = {$_POST["id"]}";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$planID = $row["PlanID"];

// get OrderID

$sql = "select OrderID from payment_plans where PlanID = $planID";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$globOrderID = $row["OrderID"];

// Update total amount
$sql = "update payment_plans set totalamount = (select sum(productPrice * productQuantity) from products where orderid = '$globOrderID' and isRemoved = 0) where orderid = '$globOrderID';";
$conn->query($sql);

// Update balance
$sql = "update payment_plans set balance = totalamount - amountpaid where orderid = '$globOrderID' and IsRemoved = 0;";
$conn->query($sql);


// Update new receipt;

$sql = "UPDATE Payment_Receipts SET IsRemoved = 1 WHERE ReceiptID = {$_POST["id"]}";


$result = $conn->query($sql);
$conn->close();

header("Location: /receipts");
exit();
