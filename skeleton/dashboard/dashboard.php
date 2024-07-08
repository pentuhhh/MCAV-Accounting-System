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

<h2>Dashboard</h2>

<?php
require 'db_connection.php';
require 'queries.php';
require 'table_render.php';

$conn = openConnection();

// Fetch data
$monthlySales = fetchMonthlySales($conn);
$totalOrders = fetchTotalOrders($conn);
$totalSales = fetchTotalSales($conn);
$recentOrders = fetchRecentOrders($conn);

// Render tables
renderTable("Monthly Sales", ["Monthly Sales"], [[$monthlySales]]);
renderTable("Total Orders", ["Total Orders"], [[$totalOrders]]);
renderTable("Total Sales", ["Total Sales"], [[$totalSales]]);
renderRecentOrdersTable("Recent Orders", $recentOrders);

$conn->close();
?>

</body>
</html>
