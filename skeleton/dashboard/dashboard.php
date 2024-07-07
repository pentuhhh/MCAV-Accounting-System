<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        /* Your CSS styles here */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
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

// Query 1: Monthly Sales
$monthlySalesQuery = "SELECT SUM(ReceiptAmountPaid) AS MonthlySales
                      FROM Payment_Receipts
                      WHERE PaymentDate >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
                      AND PaymentDate <= CURDATE()";
$monthlySalesResult = $conn->query($monthlySalesQuery);
$monthlySales = $monthlySalesResult->fetch_assoc()['MonthlySales'];

// Query 2: Total Orders
$totalOrdersQuery = "SELECT COUNT(OrderID) AS TotalOrders
                     FROM orders
                     WHERE isremoved = 0";
$totalOrdersResult = $conn->query($totalOrdersQuery);
$totalOrders = $totalOrdersResult->fetch_assoc()['TotalOrders'];

// Query 3: Total Sales
$totalSalesQuery = "SELECT SUM(ReceiptAmountPaid) AS TotalSales
                    FROM Payment_Receipts
                    WHERE isremoved = 0";
$totalSalesResult = $conn->query($totalSalesQuery);
$totalSales = $totalSalesResult->fetch_assoc()['TotalSales'];

// Query 4: Recent Orders
$recentOrdersQuery = "SELECT o.orderID AS OrderID, CONCAT(c.customerFname, ' ', c.customerLname) AS CustomerName,
                            o.orderStartDate AS OrderDate, pp.TotalAmount AS Amount, o.OrderDeadline AS Deadline,
                            o.OrderStatusCode AS Status
                     FROM orders o
                     INNER JOIN payment_Plans pp ON pp.orderID = o.orderID
                     INNER JOIN customers c ON o.customerID = c.customerID
                     ORDER BY o.OrderDeadline ASC
                     LIMIT 5";
$recentOrdersResult = $conn->query($recentOrdersQuery);
?>

<h2>Dashboard</h2>

<!-- Monthly Sales -->
<table>
    <caption>Monthly Sales</caption>
    <thead>
        <tr>
            <th>Monthly Sales</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo $monthlySales; ?></td>
        </tr>
    </tbody>
</table>

<!-- Total Orders -->
<table>
    <caption>Total Orders</caption>
    <thead>
        <tr>
            <th>Total Orders</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo $totalOrders; ?></td>
        </tr>
    </tbody>
</table>

<!-- Total Sales -->
<table>
    <caption>Total Sales</caption>
    <thead>
        <tr>
            <th>Total Sales</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo $totalSales; ?></td>
        </tr>
    </tbody>
</table>

<!-- Recent Orders -->
<table>
    <caption>Recent Orders</caption>
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Customer Name</th>
            <th>Order Date</th>
            <th>Amount</th>
            <th>Deadline</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($recentOrdersResult->num_rows > 0) {
            while ($row = $recentOrdersResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['OrderID'] . "</td>";
                echo "<td>" . $row['CustomerName'] . "</td>";
                echo "<td>" . $row['OrderDate'] . "</td>";
                echo "<td>" . $row['Amount'] . "</td>";
                echo "<td>" . $row['Deadline'] . "</td>";
                echo "<td>" . $row['Status'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No recent orders found.</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php
$conn->close();
?>

</body>
</html>
