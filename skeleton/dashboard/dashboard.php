<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
    INNER JOIN payment_Plans pp ON pp.orderID = o.orderID
    INNER JOIN customers c ON o.customerID = c.customerID
    ORDER BY o.OrderDeadline ASC LIMIT 5
";
$recentOrders = $conn->query($recentOrdersQuery);
if ($recentOrders === false) {
    die("Query failed: " . $conn->error);
}

// HTML Output
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>

<h1>Dashboard</h1>

<h2>Analytics</h2>
<p><strong>Monthly Sales:</strong> $<?php echo number_format($monthlySales, 2); ?></p>

<h2>Total Orders</h2>
<p><strong>Total Orders:</strong> <?php echo $totalOrders; ?></p>

<h2>Total Sales</h2>
<p><strong>Total Sales:</strong> $<?php echo number_format($totalSales, 2); ?></p>

<h2>Recent Orders</h2>
<table>
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
        <?php while ($row = $recentOrders->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['Order ID']; ?></td>
                <td><?php echo $row['Customer Name']; ?></td>
                <td><?php echo $row['Order Date']; ?></td>
                <td>$<?php echo number_format($row['Amount'], 2); ?></td>
                <td><?php echo $row['Deadline']; ?></td>
                <td><?php echo $row['Status']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

</body>
</html>

<?php
$conn->close();
?>
