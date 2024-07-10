<?php
// Database connection
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "database_name";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$due_date = $_POST['due_date'];
$payment_method = $_POST['payment_method'];
$processor = $_POST['processor'];

if ($payment_method == 'cash') {
    $processor = 'N/A';
}

// Insert customer data into customers table
$sql = "INSERT INTO customers (CustomerFname, CustomerLname, CustomerEmail, CustomerPhone)
VALUES ('$fname', '$lname', '$email', '$phone')";

if ($conn->query($sql) === TRUE) {
    $customer_id = $conn->insert_id; // Get the last inserted ID
    // Redirect to order creation page with customer ID
    header("Location: create_order.php?customer_id=$customer_id&due_date=$due_date&payment_method=$payment_method&processor=$processor");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
