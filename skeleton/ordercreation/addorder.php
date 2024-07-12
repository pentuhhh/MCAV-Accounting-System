<?php

session_start();
echo session_id();
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
$orderid;


//Products and stuff

$productDescription;
$dimensions;
$amount;
$remarks;

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

//

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

    $orderentryquery = "insert into orders (customerID, orderStartDate) values ('$customerID', curdate());";
    $conn->query($orderentryquery);


    //retrieve order ID

    $retrieveorderid = "select orderID from orders where customerID = '$customerID';";
    $result = $conn->query($retrieveorderid);
    $row = $result->fetch_assoc();
    $orderid = (int)$row['orderID'];

    // convert due date to mysql format

    $duedate = $dueyear . '-' . str_pad($duemonth, 2, '0', STR_PAD_LEFT) . '-' . str_pad($dueday, 2, '0', STR_PAD_LEFT);

    //create paymentplan entry

    $paymentplanquery = "insert into payment_plans (orderID, TotalAmount, dueDate, paymentMethod, PaymentProcessor, ) values 
        ('$orderid', 0, '$duedate', '$paymentMethod', '$paymentprocessor');";

    // insert products

    foreach ($_SESSION['product_list'] as $product) {
        $productDescription = $product['productDescription'];
        $dimensions = $product['dimensions'];
        $amount = $product['amount'];
        $remarks = $product['remarks'];

        // Insert the data into the database or perform the desired action
        $insertproductquery = "INSERT INTO products (orderID, productDescription, productDimensions, productQuantity, productPrice, productRemarks) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertproductquery);
        $stmt->bind_param("ssis", $orderID ,$productDescription, $dimensions, $amount, $remarks);

        if (!$stmt->execute()) {
            echo "Error adding product: " . $stmt->error;
            break;
        }
    }

    // retrive price

    // $retrievetotal = "SELECT SUM(ProductPrice * ProductQuantity) AS TotalPrice FROM products WHERE OrderID = '$orderID';";
    // $result = $conn->query($retrievetotal);
    // $row = $result->fetch_assoc();
    // $totalamount = (float)$row['TotalPrice'];

    // update totalamount

    $updatetotal = "update payment_plans set totalAmount = '$totalamount' where orderID = '$orderID';";
    $conn->query($updatetotal);


    $stmt->close();
    $conn->close();


    // Clear the product list from the session after insertion
    unset($_SESSION['product_list']);
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
                <br>
                <input type="hidden" name="action" value="main">
                <input type="submit" value="Submit">
        </form>

        <form id="productForm">

            <input type="hidden" name="action" value="addProduct">

            <label for="product-description">Product Description:</label>
            <input id="product-description" type="text" name="product-description" placeholder="Product Description" required><br>

            <label for="dimensions">Dimensions:</label>
            <input id="dimensions" type="text" name="dimensions" placeholder="Dimensions" required><br>

            <label for="amount">Amount:</label>
            <input id="amount" type="number" name="amount" placeholder="Amount" required><br>

            <label for="amount">Price:</label>
            <input id="price" step="0.01" type="number" name="price" placeholder="price" required><br>

            <label for="remarks">Remarks:</label>
            <input id="remarks" type="text" name="remarks" placeholder="Remarks" required><br>

            <button type="button" onclick="addItemToList()">Add Item</button>
        </form>
        
        <h2>Product List</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>Product Description</th>
                        <th>Dimensions</th>
                        <th>Amount</th>
                        <th>Price</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $totalSum = 0;

                    if (isset($_SESSION['product_list']) && !empty($_SESSION['product_list'])) {
                        foreach ($_SESSION['product_list'] as $index => $product) {

                            $totalPrice = $product['amount'] * $product['price'];
                            $totalSum += $totalPrice; // Add to the total sum

                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($product['productDescription']) . "</td>";
                            echo "<td>" . htmlspecialchars($product['dimensions']) . "</td>";
                            echo "<td>" . htmlspecialchars($product['price']) . "</td>";
                            echo "<td>" . htmlspecialchars($product['amount']) . "</td>";
                            echo "<td>" . htmlspecialchars($product['remarks']) . "</td>";
                            echo "<td><button type='button' onclick='deleteItem($index)'>Delete</button></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No products added.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <h3>Total Sum: <?php echo htmlspecialchars($totalSum); ?></h3>

        <script>
            function addItemToList() {
                var formData = new FormData(document.getElementById("productForm"));

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "", true);

                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // handle the response from the server
                        alert(xhr.responseText);
                        location.reload();
                    }
                };

                xhr.send(formData);
            }

            function deleteItem(index) {
                var formData = new FormData();
                formData.append('action', 'deleteProduct');
                formData.append('index', index);

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "", true);

                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // handle the response from the server
                        alert(xhr.responseText);
                        // Refresh the page to display the updated product list
                        location.reload();
                    }
                };

                xhr.send(formData);
            }
            
            
        </script>

    
    </body>
</html>
