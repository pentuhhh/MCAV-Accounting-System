<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "../utilities/db-connection.php";

// Fetch Monthly Sales
$monthlySalesQuery = "
    SELECT COALESCE(SUM(ReceiptAmountPaid), 0) AS 'Monthly Sales'
    FROM Payment_Receipts
    WHERE PaymentDate >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
    AND PaymentDate <= CURDATE()
";

$resultMonthlySales = $conn->query($monthlySalesQuery);
if ($resultMonthlySales === false) {
    die("Monthly Sales query failed: " . $conn->error);
}

$rowMonthlySales = $resultMonthlySales->fetch_assoc();
$monthlySales = isset($rowMonthlySales['Monthly Sales']) ? $rowMonthlySales['Monthly Sales'] : 0;

// Fetch Total Orders
$totalOrdersQuery = "
    SELECT COUNT(OrderID) AS 'Total Orders'
    FROM orders
    WHERE isremoved = 0
";

$resultTotalOrders = $conn->query($totalOrdersQuery);
if ($resultTotalOrders === false) {
    die("Total Orders query failed: " . $conn->error);
}

$rowTotalOrders = $resultTotalOrders->fetch_assoc();
$totalOrders = isset($rowTotalOrders['Total Orders']) ? $rowTotalOrders['Total Orders'] : 0;

// Fetch Total Sales
$totalSalesQuery = "
    SELECT COALESCE(SUM(ReceiptAmountPaid), 0) AS 'Total Sales'
    FROM Payment_Receipts
    WHERE isremoved = 0
";

$resultTotalSales = $conn->query($totalSalesQuery);
if ($resultTotalSales === false) {
    die("Total Sales query failed: " . $conn->error);
}

$rowTotalSales = $resultTotalSales->fetch_assoc();
$totalSales = isset($rowTotalSales['Total Sales']) ? $rowTotalSales['Total Sales'] : 0;

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

$resultRecentOrders = $conn->query($recentOrdersQuery);
if ($resultRecentOrders === false) {
    die("Recent Orders query failed: " . $conn->error);
}

// Output or use the fetched data as needed
?>

