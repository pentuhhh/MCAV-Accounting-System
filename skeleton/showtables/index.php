<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Display Tables</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
        }
    </style>
</head>
<body>

<?php
// Database connection
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

// Function to display a table
function displayTable($conn, $tableName) {
    $sql = "SELECT * FROM $tableName";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "<h2>$tableName</h2>";
        echo "<table>";
        echo "<tr>";

        // Fetch and display the table headers
        $fields = mysqli_fetch_fields($result);
        foreach ($fields as $field) {
            echo "<th>{$field->name}</th>";
        }
        echo "</tr>";

        // Fetch and display the table rows
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            foreach ($fields as $field) {
                echo "<td>{$row[$field->name]}</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Error displaying $tableName: " . mysqli_error($conn);
    }
}

// List of tables to display
$tables = [
    'Action_logs',
    'customers',
    'employee_info',
    'employee_credentials',
    'orders',
    'payment_plans',
    'payment_receipts',
    'products',
    'customer_info_archive',
    'employee_info_archive',
    'order_archive',
    'payment_plans_archive',
    'payment_receipt_archive'
];

// Display each table
foreach ($tables as $table) {
    displayTable($conn, $table);
}

// Close the database connection
mysqli_close($conn);
?>

</body>
</html>
