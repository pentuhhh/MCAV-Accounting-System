<?php
// Assuming you have a database connection established
$servername = "localhost";
$username = "MCAVDB";
$password = "password1010";
$dbname = "MCAV";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Determine which action to perform based on 'action' parameter
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === "search") {
            // Handle search for an existing customer
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];

            // Search for customer in customers table
            $sql = "SELECT CustomerID FROM customers WHERE CustomerFname='$fname' AND CustomerLname='$lname'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Customer found
                $row = $result->fetch_assoc();
                $customerID = $row["CustomerID"];
                echo json_encode(array("customer_id" => $customerID));
            } else {
                echo json_encode(array("error" => "Customer not found."));
            }
        } elseif ($action === "select_payment_plan") {
            // Handle selection of payment plan
            $customerID = $_POST['customer_id'];
            $payment_method = $_POST['payment_method'];
            $payment_processor = ($_POST['payment_method'] === 'cash') ? 'Cash payment' : $_POST['payment_processor'];
            $due_date = $_POST['due_date'];

            // Insert into payment_plans table
            $sql = "INSERT INTO payment_plans (OrderID, DueDate, PaymentMethod, PaymentProcessor, IsRemoved)
                    VALUES (NULL, '$due_date', '$payment_method', '$payment_processor', false)";
            if ($conn->query($sql) === TRUE) {
                $planID = $conn->insert_id;

                // Get the last inserted OrderID
                $orderID = $conn->insert_id;

                // Prepare JSON response with OrderID and PlanID
                echo json_encode(array("order_id" => $orderID, "plan_id" => $planID));
            } else {
                echo json_encode(array("error" => "Error inserting payment plan: " . $conn->error));
            }
        } elseif ($action === "select_products") {
            // Handle selection of products
            $orderID = $_POST['order_id'];
            $products = $_POST['products'];

            // Insert each selected product into products table
            foreach ($products as $product) {
                $sql = "INSERT INTO products (OrderID, ProductDescription, IsRemoved)
                        VALUES ('$orderID', '$product', false)";
                if ($conn->query($sql) !== TRUE) {
                    echo json_encode(array("error" => "Error inserting product: " . $conn->error));
                    exit();
                }
            }

            echo json_encode(array("success" => "Products inserted successfully."));
        } elseif ($action === "create_order") {
            // Handle creation of order
            $customerID = $_POST['customer_id'];
            $orderStartDate = date("Y-m-d"); // Example for current date
            $orderStatusCode = 1; // Example status code, adjust as needed

            // Insert into orders table
            $sql = "INSERT INTO orders (EmployeeID, CustomerID, OrderStartDate, OrderStatusCode, IsRemoved)
                    VALUES (NULL, '$customerID', '$orderStartDate', '$orderStatusCode', false)";
            if ($conn->query($sql) === TRUE) {
                $orderID = $conn->insert_id;

                // Prepare JSON response with OrderID
                echo json_encode(array("order_id" => $orderID));
            } else {
                echo json_encode(array("error" => "Error inserting order: " . $conn->error));
            }
        }
    }
}

$conn->close();
?>