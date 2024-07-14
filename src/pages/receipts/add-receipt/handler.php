<?php
// Variables
$orderid = 0;
$paymentdate = '';
$amount = 0;
$referencenumber = 0;
$planid = 0;
$total_amount = 0.0;
// this doesnt work for me, change accordingly require "../../utilities/db-connection.php";

require "../utilities/db-connection.php";

// Function to sanitize input to prevent SQL injection
function sanitize_input($conn, $data) {
    return mysqli_real_escape_string($conn, $data);
}

function populateVariables($conn){
    global $orderid, $paymentdate, $amount, $referencenumber;

    if (isset($_POST['order-id'])) {
        $orderid = sanitize_input($conn, $_POST['order-id']);
    }
    if (isset($_POST['payment-date'])) {
        $paymentdate = sanitize_input($conn, $_POST['payment-date']);
    }
    if (isset($_POST['amount'])) {
        $amount = sanitize_input($conn, $_POST['amount']);
    }
    if (isset($_POST['reference-number'])) {
        $referencenumber = sanitize_input($conn, $_POST['reference-number']);
        $referencenumber = (float)$referencenumber; // Explicitly cast to float
    }
}

function orderExists($conn){
    global $orderid, $planid;

    $sql = "SELECT PlanID FROM payment_plans WHERE OrderID = '$orderid' AND IsRemoved = 0;";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $planid = (int)$row['PlanID'];
    } else {
        $planid = 0;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Debugging: Print out POST data for inspection
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';

    populateVariables($conn);
    orderExists($conn);

    if ($planid == 0) {
        echo "<script type='text/javascript'>alert('Order does not exist');</script>";
        exit();
    } else {
        // Add receipt entry
        $sql = "INSERT INTO payment_receipts (PlanID, PaymentDate, ReceiptAmountPaid, PaymentProcessorReferenceNumber) 
                VALUES ('$planid', '$paymentdate', '$amount', '$referencenumber');";
        echo "Executing query: $sql\n"; // Debugging
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Update payment plan balance

        $sql = "update payment_plans set balance = balance - $amount where PlanID = $planid";
        echo "Executing query: $sql\n"; // Debugging
        if ($conn->query($sql) === TRUE) {
            echo "Balance updated successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Update total amount paid
        $sql = "update payment_plans set AmountPaid = AmountPaid + $amount where PlanID = $planid";
        echo "Executing query: $sql\n"; // Debugging
        if ($conn->query($sql) === TRUE) {
            echo "Amount paid updated successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;

        //update status if balance is 0
        $sql = "update payment_plans set PaymentStatus = 3 where PlanID = $planid and balance = 0";
        echo "Executing query: $sql\n"; // Debugging
        if ($conn->query($sql) === TRUE) {
            echo "Status updated successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        }
        header ("Location: /receipts");
        exit();
    }
}

$conn->close();
?>