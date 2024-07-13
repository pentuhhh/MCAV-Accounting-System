<?php

// Variables
$customerID = 0;
$customerFname = '';
$customerLname = '';
$customerEmail = '';
$customerPhone = '';

$paymentMethod = '';
$duedate;
$paymentprocessor = '';
$orderid;


//Products and stuff

$productDescription;
$dimensions;
$amount;
$remarks;

// Database connection parameters
require "../utilities/db-connection.php";

// Function to sanitize input to prevent SQL injection
function sanitize_input($conn, $data) {
    return mysqli_real_escape_string($conn, $data);
}

function populateVariables($conn){
    global $customerFname, $customerLname, $customerEmail, $customerPhone;

    if (isset($_POST['CustomerFname'])) {
        $customerFname = sanitize_input($conn, $_POST['first-name']);
    }
    if (isset($_POST['CustomerLname'])) {
        $customerLname = sanitize_input($conn, $_POST['last-name']);
    }
    if (isset($_POST['CustomerEmail'])) {
        $customerEmail = sanitize_input($conn, $_POST['contact-email']);
    }
    if (isset($_POST['CustomerPhone'])) {
        $customerPhone = sanitize_input($conn, $_POST['phone-number']);
    }

    if (isset($_POST['payment-method'])) {
        $paymentMethod = sanitize_input($conn, $_POST['payment-method']);
    }

    if (isset($_POST['processor'])) {
        $paymentprocessor = sanitize_input($conn, $_POST['processor']);
    }

    
}

function userExists($conn){
    global $customerFname, $customerLname, $customerID;

    $fname = sanitize_input($conn, $customerFname);
    $lname = sanitize_input($conn, $customerLname);

    $sql = "SELECT customerID FROM customers WHERE CustomerFname = '$fname' AND CustomerLname = '$lname'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch and assign customerID
        $row = $result->fetch_assoc();
        $customerID = (int)$row['customerID']; // Cast to integer
    } else {
        $customerID = 0; // Set customerID to 0 if no rows found
    }
}

// add products

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'addProduct') {
    $productDescription = $_POST['product-description'];
    $dimensions = $_POST['dimensions'];
    $price = $_POST['price'];
    $amount = $_POST['amount'];
    $remarks = $_POST['remarks'];

    // Validate and sanitize input data
    $productDescription = sanitize_input($conn, $productDescription);
    $dimensions = sanitize_input($conn, $dimensions);
    $price = sanitize_input($conn, $price);
    $amount = sanitize_input($conn, $amount);
    $remarks = sanitize_input($conn, $remarks);

    // Prepare product data as an associative array
    $product = [
        'productDescription' => $productDescription,
        'dimensions' => $dimensions,
        'price' => $price,
        'amount' => $amount,
        'remarks' => $remarks
    ];

    // Check if the product list already exists in the session
    if (!isset($_SESSION['product_list'])) {
        $_SESSION['product_list'] = [];
    }

    // Add the new product to the product list
    $_SESSION['product_list'][] = $product;

    echo "Product added to the list.";
    exit;
}

if (isset($_POST['action']) && $_POST['action'] == 'deleteProduct') {
    $index = $_POST['index'];

    if (isset($_SESSION['product_list'][$index])) {
        array_splice($_SESSION['product_list'], $index, 1);
        echo "Product removed from the list.";
    } else {
        echo "Invalid product index.";
    }
    exit;
}

//  MAIN    

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "main") {
    // Print the entire POST array to see what values are being sent
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';

    // Get values and store them into variables
    populateVariables($conn);

    // Check if user exists
    userExists($conn);
    // If user does not exist, it will add and remember the customer ID
    if ($customerID == 0) {
        $createcustomer = "INSERT INTO Customers (customerfname, customerlname, customeremail, customerphone)
                    VALUES ('$customerFname','$customerLname','$customerEmail','$customerPhone');";
        
        $conn->query($createcustomer);

        $fname = sanitize_input($conn, $customerFname);
        $lname = sanitize_input($conn, $customerLname);

        $sql = "SELECT customerID FROM customers WHERE CustomerFname = '$fname' AND CustomerLname = '$lname'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $customerID = (int)$row['customerID'];

        echo "User does not exist new user added with ID: ". $customerID;
    } else {
        // If user exists then just use that user
        echo "User exists with ID: " . $customerID;
    }

    // Proceed to create order entry
    $orderentryquery = "INSERT INTO orders (customerID, orderStartDate) VALUES ('$customerID', curdate());";
    $conn->query($orderentryquery);

    // Retrieve order ID
    $retrieveorderid = "SELECT orderID from orders where customerID = $customerID order by orderID desc limit 1;";
    $result = $conn->query($retrieveorderid);
    $row = $result->fetch_assoc();
    $orderID = $row['orderID'];

    // Retrieve and sanitize due date
    if (isset($_POST['due-date'])) {
        $duedate = sanitize_input($conn, $_POST['due-date']);
        echo "Due date before sanitization: " . $_POST['due-date'] . "<br>";
        echo "Due date after sanitization: " . $duedate . "<br>";
    } else {
        echo "Due date not set in POST array.";
    }

    // Validate the due date
    if (!empty($duedate)) {
        // Ensure due date is in correct format (YYYY-MM-DD)
        $dateTime = DateTime::createFromFormat('Y-m-d', $duedate);
        if ($dateTime && $dateTime->format('Y-m-d') === $duedate) {
            // Create payment plan entry
            $paymentplanquery = "INSERT INTO payment_plans (orderID, TotalAmount, dueDate, paymentMethod, PaymentProcessor) VALUES 
                ('$orderID', 0, '$duedate', '$paymentMethod', '$paymentprocessor');";
            if ($conn->query($paymentplanquery) === TRUE) {
                echo "Payment plan created successfully.";
            } else {
                echo "Error creating payment plan: " . $conn->error;
            }
        } else {
            echo "Error: Invalid due date format.";
        }
    } else {
        echo "Error: Due date value is not set properly.";
    }

    // Insert products
    foreach ($_SESSION['product_list'] as $product) {
        $productDescription = $product['productDescription'];
        $dimensions = $product['dimensions'];
        $amount = $product['amount'];
        $remarks = $product['remarks'];

        // Insert the data into the database or perform the desired action
        $insertproductquery = "INSERT INTO products (orderID, productDescription, productDimensions, productQuantity, productRemarks) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertproductquery);
        $stmt->bind_param("issis", $orderID, $productDescription, $dimensions, $amount, $remarks);

        if (!$stmt->execute()) {
            echo "Error adding product: " . $stmt->error;
            break;
        }
    }

    // Retrieve price
    $retrievetotal = "SELECT SUM(ProductPrice * ProductQuantity) AS TotalPrice FROM products WHERE OrderID = '$orderID';";
    $result = $conn->query($retrievetotal);
    $row = $result->fetch_assoc();
    $totalamount = (float)$row['TotalPrice'];

    // Update total amount
    $updatetotal = "UPDATE payment_plans SET totalAmount = '$totalamount' WHERE orderID = '$orderID';";
    $conn->query($updatetotal);

    // Update balance to equal total amount
    $updatebalance = "UPDATE payment_plans SET balance = '$totalamount' WHERE orderID = '$orderID';";

    $stmt->close();
    $conn->close();

    // Clear the product list from the session after insertion
    unset($_SESSION['product_list']);
}

// Close connection
$conn->close();
?>