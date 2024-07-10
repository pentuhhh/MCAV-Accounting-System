<?php
// Variables
$customerID = 0;
$customerFname = '';
$customerLname = '';
$customerEmail = '';
$customerPhone = '';

// Database connection parameters
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "search") {
    // Get values and store them into variables
    populateVariables($conn);

    // Check if user exists
    userExists($conn);


    // If user does not exist, it will add and remember the customer ID
    if ($customerID == 0) {
        $createcustomer = "insert into Customers (customerfname, customerlname, customeremail, customerphone)
                    values ('$customerFname','$customerLname','$customerEmail','$customerPhone');";
        
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
    
    
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html>
    <body>
        <form method="post">
            Create Order<br>
            <label for="fname">First Name:</label>
            <input type="text" id="fname" name="CustomerFname" required><br><br>
            
            <label for="lname">Last Name:</label>
            <input type="text" id="lname" name="CustomerLname" required><br><br>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="CustomerEmail" required><br><br>
            
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="CustomerPhone" required><br><br>
            
            <input type="hidden" name="action" value="search">
            <input type="submit" value="Submit">
        </form>

    
    </body>
</html>
