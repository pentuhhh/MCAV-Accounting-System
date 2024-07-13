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
        o.orderID AS 'Order ID',
        CONCAT(c.customerFname, ' ', c.customerLname) AS 'Customer Name',
        o.orderStartDate AS 'Order Date',
        pp.TotalAmount AS 'Amount',
        o.OrderDeadline AS 'Deadline',
        o.OrderStatusCode AS 'Status'
    FROM orders o
    INNER JOIN payment_plans pp ON pp.orderID = o.orderID
    INNER JOIN customers c ON o.customerID = c.customerID
    ORDER BY o.OrderDeadline ASC LIMIT 5
";

$sql = "SELECT      
            o.OrderID,      
            CONCAT(c.CustomerFname, ' ', c.CustomerLname) AS CustomerName,           
            o.OrderStartDate,
            p.totalamount,      
            o.OrderDeadline,      
            CASE
                WHEN o.OrderStatusCode = 1 THEN 'Pending'
                WHEN o.OrderStatusCode = 2 THEN 'Started'
                WHEN o.OrderStatusCode = 3 THEN 'Completed'
                ELSE 'Unknown'
            END AS Status
        FROM      
            orders o     
        INNER JOIN customers c ON o.customerid = c.customerID
        INNER JOIN payment_plans p ON p.orderID = o.orderID
        WHERE o.isremoved = 0 
        ORDER BY o.OrderStartDate DESC;";


$recentOrders = $conn->query($recentOrdersQuery);
if ($recentOrders === false) {
    die("Query failed: " . $conn->error);
}

?>