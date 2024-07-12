<?php

// Function to sanitize input to prevent SQL injection
function sanitize_input($conn, $data) {
    return mysqli_real_escape_string($conn, $data);
}

function populateVariables($conn){
    global $customerFname, $customerLname, $customerEmail, $customerPhone;

    if (isset($_POST['CustomerFname'])) {
        $customerFname = sanitize_input($conn, $_POST['CustomerFname']);
    }
    if (isset($_POST['CustomerLname'])) {
        $customerLname = sanitize_input($conn, $_POST['CustomerLname']);
    }
    if (isset($_POST['CustomerEmail'])) {
        $customerEmail = sanitize_input($conn, $_POST['CustomerEmail']);
    }
    if (isset($_POST['CustomerPhone'])) {
        $customerPhone = sanitize_input($conn, $_POST['CustomerPhone']);
    }

    if (isset($_POST['payment-method'])) {
        $paymentMethod = sanitize_input($conn, $_POST['payment-method']);
    }

    // Process due date fields
    if (isset($_POST['month']) && isset($_POST['day']) && isset($_POST['year'])) {
        $duemonth = sanitize_input($conn, $_POST['month']);
        $dueday = sanitize_input($conn, $_POST['day']);
        $dueyear = sanitize_input($conn, $_POST['year']);
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

?>
