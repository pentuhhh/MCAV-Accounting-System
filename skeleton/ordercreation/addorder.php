<?php
// Variables
$customerID = 0;
$customerFname = '';
$customerLname = '';
$customerEmail = '';
$customerPhone = '';

$paymentMethod = '';
$duemonth;
$dueday;
$dueyear;
$paymentprocessor = '';
// Database connection parameters
$servername = "localhost";
$username = "MCAVDB";
$password = "password1010";
$dbname = "MCAV";

$orderid;

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

    //proceed to create order entry

    $orderentryquery = "insert into orders (customerId, OrderstartDate) values ('$customerID', curdate());";
    $conn->query($orderentryquery);

    //retrieve order ID

    $retrieveorderid ="select orderID from orders where customerID = '$customerID';";
    $result = $conn->query($retrieveorderid);
    $row = $result->fetch_assoc();
    $orderid = (int)$row['orderID'];

    //create paymentplan entry

}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html>
    <head>

    <script>
        function enableInput(select) {
            var processorSelect = document.getElementById("processor");
            if (select.value === "bank-transfer") {
                processorSelect.disabled = false;
            } else {
                processorSelect.disabled = true;
            }
        }
    </script>
    </head>
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


            <br><br>
            <label for="payment-method">Payment Method</label>
                            <select name="payment-method" id="payment-method" onchange="enableInput(this)">
                                <option value="cash">Cash</option>
                                <option value="bank-transfer">Digital Wallet</option>
                                <!-- Enter More Options -->
                            </select>

                            <label for="due-date">Due Date</label>
                            <div class="flex flex-row gap-2">
                                <input type="number" id="month" min="1" max="12" size="2" placeholder="Month" required>
                                <input type="number" id="day" min="1" max="31" size="2" placeholder="Day" required>
                                <input type="number" id="year" min="1900" max="2100" placeholder="Year" size="4" required>
                            </div>

                            <label for="processor">Processor</label>
                        <select id="processor" name="processor" disabled>
                            <option value="none">None</option>
                            <option value="gcash">GCash</option>
                            <option value="metrobank">Metrobank</option>
                            <option value="metrobank">BDO</option>
                            <option value="metrobank">Paypal</option>
                            <!-- Enter More Options -->
                        </select>
        </form>

    
    </body>
</html>
