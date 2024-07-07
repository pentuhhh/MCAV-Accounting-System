<!DOCTYPE html>
<html>
<head>
    <title>Order Details</title>
    <style>
        /* Your CSS styles here */
    </style>
</head>
<body>

<?php
$servername = "localhost";
$username = "MCAVDB";
$password = "password1010";
$dbname = "MCAV";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get orderID from query string
if (isset($_GET['orderID'])) {
    $orderID = $_GET['orderID'];
    
    // Query to retrieve customer information
    $customerQuery = "SELECT CONCAT(CustomerFname, ' ', CustomerLname) AS CustomerName, CustomerEmail, CustomerPhone
                     FROM customers
                     WHERE customerID IN (SELECT customerID FROM orders WHERE orderID = $orderID)";
    $customerResult = $conn->query($customerQuery);
    
    if ($customerResult->num_rows > 0) {
        $customerRow = $customerResult->fetch_assoc();
        $customerName = $customerRow['CustomerName'];
        $customerEmail = $customerRow['CustomerEmail'];
        $customerPhone = $customerRow['CustomerPhone'];
        
        // Display customer information
        echo "<h2>Customer Information</h2>";
        echo "<p><strong>Name:</strong> $customerName</p>";
        echo "<p><strong>Email:</strong> $customerEmail</p>";
        echo "<p><strong>Phone Number:</strong> $customerPhone</p>";
    }
    
    // Query to retrieve order information
    $orderQuery = "SELECT OrderStartDate, OrderDeadline, OrderStatusCode AS Status
                   FROM orders
                   WHERE orderID = $orderID";
    $orderResult = $conn->query($orderQuery);
    
    if ($orderResult->num_rows > 0) {
        $orderRow = $orderResult->fetch_assoc();
        $orderStartDate = $orderRow['OrderStartDate'];
        $orderDeadline = $orderRow['OrderDeadline'];
        $orderStatus = $orderRow['Status'];
        
        // Display order information
        echo "<h2>Order Information</h2>";
        echo "<p><strong>Order Date:</strong> $orderStartDate</p>";
        echo "<p><strong>Deadline:</strong> $orderDeadline</p>";
        echo "<p><strong>Status:</strong> $orderStatus</p>";
    }
    
    // Query to retrieve ordered products
    $productsQuery = "SELECT ProductID, ProductDescription, ProductDimensions, ProductQuantity, ProductPrice, ProductStatusCode
                      FROM products
                      WHERE orderID = $orderID AND isremoved = 0";
    $productsResult = $conn->query($productsQuery);
    
    if ($productsResult->num_rows > 0) {
        // Display ordered products
        echo "<h2>Ordered Products</h2>";
        echo "<table>";
        echo "<tr><th>Product ID</th><th>Description</th><th>Dimensions</th><th>Quantity</th><th>Price</th><th>Status</th></tr>";
        while ($productRow = $productsResult->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $productRow['ProductID'] . "</td>";
            echo "<td>" . $productRow['ProductDescription'] . "</td>";
            echo "<td>" . $productRow['ProductDimensions'] . "</td>";
            echo "<td>" . $productRow['ProductQuantity'] . "</td>";
            echo "<td>" . $productRow['ProductPrice'] . "</td>";
            echo "<td>" . $productRow['ProductStatusCode'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    // Query to retrieve payment plan information
    $paymentQuery = "SELECT PaymentMethod, DueDate, PaymentStatus, TotalAmount, AmountPaid, Balance
                     FROM payment_plans
                     WHERE orderID = $orderID AND isremoved = 0";
    $paymentResult = $conn->query($paymentQuery);
    
    if ($paymentResult->num_rows > 0) {
        // Display payment plan information
        echo "<h2>Payment Plan</h2>";
        echo "<table>";
        echo "<tr><th>Method</th><th>Due Date</th><th>Status</th><th>Total Amount</th><th>Amount Paid</th><th>Balance</th></tr>";
        while ($paymentRow = $paymentResult->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $paymentRow['PaymentMethod'] . "</td>";
            echo "<td>" . $paymentRow['DueDate'] . "</td>";
            echo "<td>" . $paymentRow['PaymentStatus'] . "</td>";
            echo "<td>" . $paymentRow['TotalAmount'] . "</td>";
            echo "<td>" . $paymentRow['AmountPaid'] . "</td>";
            echo "<td>" . $paymentRow['Balance'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    // Query to retrieve related receipts
    $receiptQuery = "SELECT ReceiptID, ReceiptAmountPaid, PaymentDate
                     FROM Payment_Receipts
                     WHERE planID IN (SELECT planID FROM payment_plans WHERE orderID = $orderID AND isremoved = 0) AND isremoved = 0";
    $receiptResult = $conn->query($receiptQuery);
    
    if ($receiptResult->num_rows > 0) {
        // Display related receipts
        echo "<h2>Related Receipts</h2>";
        echo "<table>";
        echo "<tr><th>Receipt ID</th><th>Amount Paid</th><th>Payment Date</th></tr>";
        while ($receiptRow = $receiptResult->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $receiptRow['ReceiptID'] . "</td>";
            echo "<td>" . $receiptRow['ReceiptAmountPaid'] . "</td>";
            echo "<td>" . $receiptRow['PaymentDate'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
} else {
    echo "<p>No orderID specified.</p>";
}

$conn->close();
?>

</body>
</html>
