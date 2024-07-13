<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "../utilities/db-connection.php";

// Function to fetch single value
function fetchSingleValue($conn, $query) {
    $result = $conn->query($query);
    if ($result === false) {
        die("Query failed: " . $conn->error);
    }
    $row = $result->fetch_assoc();
    return array_values($row)[0];
}

// Fetch Monthly Sales
$monthlySales = fetchSingleValue($conn, "
    SELECT SUM(ReceiptAmountPaid) AS 'Monthly Sales'
    FROM Payment_Receipts
    WHERE PaymentDate >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
    AND PaymentDate <= CURDATE()
");

// Fetch Total Orders
$totalOrders = fetchSingleValue($conn, "
    SELECT COUNT(OrderID) AS 'Total Orders'
    FROM orders
    WHERE isremoved = 0
");

// Fetch Total Sales
$totalSales = fetchSingleValue($conn, "
    SELECT SUM(ReceiptAmountPaid) AS 'Total Sales'
    FROM Payment_Receipts
    WHERE isremoved = 0
");

// Fetch Recent Orders
$recentOrdersQuery = "
    SELECT
        o.OrderID AS 'Order ID',
        CONCAT(c.CustomerFname, ' ', c.CustomerLname) AS 'Customer Name',
        o.OrderStartDate AS 'Order Date',
        pp.TotalAmount AS 'Amount',
        o.OrderDeadline AS 'Deadline',
        CASE
            WHEN o.OrderStatusCode = 1 THEN 'Pending'
            WHEN o.OrderStatusCode = 2 THEN 'Started'
            WHEN o.OrderStatusCode = 3 THEN 'Completed'
            ELSE 'Unknown'
        END AS 'Status'
    FROM orders o
    INNER JOIN payment_plans pp ON pp.orderID = o.orderID
    INNER JOIN customers c ON o.customerID = c.customerID
    WHERE o.isremoved = 0
    ORDER BY o.OrderStartDate DESC
    LIMIT 5
";



$recentOrders = $conn->query($recentOrdersQuery);
if ($recentOrders === false) {
    die("Query failed: " . $conn->error);
}
if ($recentOrders->num_rows > 0) {
    $rows = [];
    while ($row = $recentOrders->fetch_assoc()) {
        $rows[] = json_encode($row);
    }
    echo implode(",", $rows);
}

?>