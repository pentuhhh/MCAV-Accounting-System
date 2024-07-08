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

// Query 1: Monthly Sales
$monthlySalesQuery = <<<SQL
                        SELECT SUM(ReceiptAmountPaid) AS MonthlySales
                        FROM Payment_Receipts
                        WHERE PaymentDate >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
                        AND PaymentDate <= CURDATE()
                        SQL;
$monthlySalesResult = $conn->query($monthlySalesQuery);
$monthlySales = $monthlySalesResult->fetch_assoc()['MonthlySales'];

// Query 2: Total Orders
$totalOrdersQuery = <<<SQL
                        SELECT COUNT(OrderID) AS TotalOrders
                        FROM orders
                        WHERE isremoved = 0 
                        SQL;
$totalOrdersResult = $conn->query($totalOrdersQuery);
$totalOrders = $totalOrdersResult->fetch_assoc()['TotalOrders'];

// Query 3: Total Sales
$totalSalesQuery = <<<SQL
                    SELECT SUM(ReceiptAmountPaid) AS TotalSales
                    FROM Payment_Receipts
                    WHERE isremoved = 0
                    SQL;
$totalSalesResult = $conn->query($totalSalesQuery);
$totalSales = $totalSalesResult->fetch_assoc()['TotalSales'];

// Query 4: Recent Orders
$recentOrdersQuery = <<<SQL
                        SELECT o.orderID AS OrderID, CONCAT(c.customerFname, ' ', c.customerLname) AS CustomerName,
                            o.orderStartDate AS OrderDate, pp.TotalAmount AS Amount, o.OrderDeadline AS Deadline,
                            o.OrderStatusCode AS Status
                        FROM orders o
                        INNER JOIN payment_Plans pp ON pp.orderID = o.orderID
                        INNER JOIN customers c ON o.customerID = c.customerID
                        ORDER BY o.OrderDeadline ASC
                        LIMIT 5
                        SQL;
$recentOrdersResult = $conn->query($recentOrdersQuery);
?>