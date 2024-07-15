<?php
// echo session_id();
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
function sanitize_input($conn, $data)
{
    return mysqli_real_escape_string($conn, $data);
}

function populateVariables($conn)
{
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

    if (isset($_POST['processor'])) {
        $paymentprocessor = sanitize_input($conn, $_POST['processor']);
    }
}

function userExists($conn)
{
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

    // debug: echo "Product added to the list.";
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
    // debug: echo '<pre>';
    // debug: print_r($_POST);
    // debug: echo '</pre>';

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

        // debug: echo "User does not exist new user added with ID: ". $customerID;
    } else {
        // If user exists then just use that user
        // debug: echo "User exists with ID: " . $customerID;
    }

    // Retrieve who is making the order
    $employeeID = $_SESSION['employeeID'];


    // Proceed to create order entry
    $orderentryquery = "INSERT INTO orders (customerID, employeeID, orderStartDate) VALUES ('$customerID', '$employeeID', curdate());";
    $conn->query($orderentryquery);



    // Retrieve order ID
    $retrieveorderid = "SELECT orderID from orders where customerID = $customerID order by orderID desc limit 1;";
    $result = $conn->query($retrieveorderid);
    $row = $result->fetch_assoc();
    $orderID = $row['orderID'];

    // Log Order creation action

    $employeeWebID = $_SESSION['employeeWebID'];
    $sql = "Insert into action_logs (employeeWebID, userAction, affectedEntityType, affectedEntityID, LogTimeStamp) values ('$employeeID', 'Create', 'Orders', '$orderID', now());";
    $conn->query($sql);

    // Retrieve and sanitize due date
    if (isset($_POST['due-date'])) {
        $duedate = sanitize_input($conn, $_POST['due-date']);
        // debug: echo "Due date before sanitization: " . $_POST['due-date'] . "<br>";
        // debug: echo "Due date after sanitization: " . $duedate . "<br>";
    } else {
        // debug: echo "Due date not set in POST array.";
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

                // Retrieve payment plan ID
                $retrieveplanid = "SELECT PlanID from payment_plans where orderID = $orderID order by PlanID desc limit 1;";
                $result = $conn->query($retrieveplanid);
                $row = $result->fetch_assoc();
                $planID = $row['PlanID'];

                // Log payment plan creation action
                $sql = "Insert into action_logs (employeeWebID, userAction, affectedEntityType, affectedEntityID, LogTimeStamp) values ('$employeeID', 'Create', 'Payment_Plan', '$planID', now());";
                $conn->query($sql);
                // debug: echo "Payment plan created successfully.";
            } else {
                // debug: echo "Error creating payment plan: " . $conn->error;
            }
        } else {
            // debug: echo "Error: Invalid due date format.";
        }
    } else {
        // debug: echo "Error: Due date value is not set properly.";
    }

    // Insert products
    foreach ($_SESSION['product_list'] as $product) {
        $productDescription = $product['productDescription'];
        $dimensions = $product['dimensions'];
        $price = $product['price'];
        $amount = $product['amount'];
        $remarks = $product['remarks'];

        // Insert the data into the database
        $insertproductquery = "INSERT INTO products (orderID, productDescription, productDimensions, productPrice, productQuantity, productRemarks) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertproductquery);
        $stmt->bind_param("issdis", $orderID, $productDescription, $dimensions, $price, $amount, $remarks);

        if ($stmt->execute()) {
            // Get the inserted product ID
            $productID = $stmt->insert_id;

            // Log product creation action if employeeWebID is set
            if (isset($_SESSION['employeeWebID'])) {
                $employeeWebID = $_SESSION['employeeWebID'];
                $sql = "INSERT INTO action_logs (employeeWebID, userAction, affectedEntityType, affectedEntityID, LogTimeStamp) VALUES ('$employeeWebID', 'Create', 'Products', '$productID', NOW())";
                if (!$conn->query($sql)) {
                    // Log insertion failed
                    error_log("Error logging product creation: " . $conn->error);
                }
            } else {
                // Handle case where $_SESSION['employeeWebID'] is not set
                error_log("Error: employeeWebID not set in session");
            }
        } else {
            // Log insertion failed
            error_log("Error adding product: " . $stmt->error);
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

    $stmt->close();

    // Clear the product list from the session after insertion
    unset($_SESSION['product_list']);
}

// Close connection
$conn->close();
?>

<div class="GLOBAL_PAGE">
    <?php
    include_once __DIR__ . "/../../../components/sidebar.php";

    $username = $_SESSION['username'];
    $userlevel = $_SESSION['user_level'] == 1 ? 'Admin' : 'User';
    $profilePicture = isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : '';
    ?>

    <div class="GLOBAL_PAGE_CONTAINER">
        <div class="GLOBAL_HEADER">
            <div class="GLOBAL_HEADER_TITLE">
                <i class="material-symbols-rounded text-[42px]">
                    receipt_long
                </i>
                <span class="">Add New Order</span>
            </div>
            <div class="GLOBAL_HEADER_USER">
                <div class="GLOBAL_HEADER_COLUMN">
                    <p>Hey, <strong><?php echo htmlspecialchars($username); ?></strong></p>
                    <p><?php echo htmlspecialchars($userlevel) ?></p>
                </div>
                <img src="../../../<?php echo htmlspecialchars($profilePicture); ?>" alt="Profile Picture">
            </div>
        </div>

        <div class="CUSTOMERS_INFO">
            <div class="GLOBAL_SUBHEADER">
                <h1>Customer Information</h1>
                <a onclick="window.history.back(); return false;">
                    <i class="material-symbols-rounded text-[#7F7F7F] text-3xl">
                        arrow_back
                    </i>
                </a>
            </div>

            <form id="order-form" method="post">
                <div class="CUSTOMERS_INPUT GLOBAL_BOX_DIV">

                    <!-- Column 1 -->
                    <div class="CUSTOMERS_INPUT_COLUMN">
                        <!-- First Name -->
                        <div class="CUSTOMERS_INPUT_COLUMN_CONTAINER">
                            <label for="fname">First Name</label>
                            <input id="fname" type="text" name="CustomerFname" placeholder="First name" required>
                        </div>
                        <!-- Last Name -->
                        <div class="CUSTOMERS_INPUT_COLUMN_CONTAINER">
                            <label for="lname">Last Name</label>
                            <input id="lname" type="text" name="CustomerLname" placeholder="Last name" required>
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div class="CUSTOMERS_INPUT_COLUMN">
                        <!-- Email -->
                        <div class="CUSTOMERS_INPUT_COLUMN_CONTAINER">
                            <label for="email">Email</label>
                            <input id="email" type="email" name="CustomerEmail" placeholder="Email" required>
                        </div>
                        <!-- Phone Number -->
                        <div class="CUSTOMERS_INPUT_COLUMN_CONTAINER">
                            <label for="phone">Phone Number</label>
                            <input id="phone" type="text" name="CustomerPhone" placeholder="Phone number" required>
                        </div>
                    </div>
                </div>

                <div class="GLOBAL_SUBHEADER">
                    <h1>Payment Plan</h1>
                </div>

                <div class="flex flex-row gap-10 justify-start GLOBAL_BOX_DIV px-12 py-8 mb-6">

                    <!-- Column 1 -->
                    <div class="CUSTOMERS_INPUT_COLUMN">
                        <!-- Payment Method -->
                        <div class="CUSTOMERS_INPUT_COLUMN_CONTAINER">
                            <label for="payment-method">Payment Method</label>
                            <select name="payment-method" id="payment-method" onchange="enableInput(this)">
                                <option value="cash">Cash</option>
                                <option value="bank-transfer">Digital Wallet</option>
                                <!-- Enter More Options -->
                            </select>
                        </div>
                        <!-- Due Date -->
                        <div class="CUSTOMERS_INPUT_COLUMN_CONTAINER">
                            <label for="due-date">Due Date</label>
                            <input id="due-date" name="due-date" type="date">
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div class="CUSTOMERS_INPUT_COLUMN">
                        <!-- Payment Processor -->
                        <label for="processor">Processor</label>
                        <select id="processor" name="processor" disabled>
                            <option value="none">None</option>
                            <option value="gcash">GCash</option>
                            <option value="metrobank">Metrobank</option>
                            <option value="BDO">BDO</option>
                            <option value="Paypal">Paypal</option>
                            <!-- Enter More Options -->
                        </select>
                    </div>
                </div>

                <input type="hidden" name="action" value="main">
            </form>

            <form id="productForm">
                <input type="hidden" name="action" value="addProduct">

                <div class="GLOBAL_SUBHEADER justify-start">
                    <h1>Product Options</h1>
                    <input id="amount" type="number" name="amount" min="0" placeholder="Qty" class="PRODUCT_INPUT_QUANTITY" required>
                    <button class="GLOBAL_BUTTON_BLUE ml-5" type="button" onclick="addItemToList()">Add Item</button>
                </div>

                <div class="flex flex-row gap-10 justify-start GLOBAL_BOX_DIV px-12 py-8 mb-6">
                    <!-- Column 1 -->
                    <div class="CUSTOMERS_INPUT_COLUMN">
                        <!-- Product Description -->
                        <div class="CUSTOMERS_INPUT_COLUMN_CONTAINER">
                            <div class="CUSTOMERS_INPUT_COLUMN_CONTAINER">
                                <label for="product-description">Product Description</label>
                                <input id="product-description" type="text" name="product-description" placeholder="Product Description" required>
                            </div>
                        </div>
                        <!-- Dimensions -->
                        <div class="CUSTOMERS_INPUT_COLUMN_CONTAINER">
                            <label for="dimensions">Dimensions</label>
                            <input id="dimensions" type="text" name="dimensions" placeholder="Dimensions" required>
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div class="CUSTOMERS_INPUT_COLUMN">
                        <!-- Amount -->
                        <div class="CUSTOMERS_INPUT_COLUMN_CONTAINER">
                            <div class="CUSTOMERS_INPUT_COLUMN_CONTAINER">
                                <label for="price">Price</label>
                                <input id="price" step="0.01" type="number" name="price" placeholder="Price" required>
                            </div>
                        </div>
                        <!-- Remarks -->
                        <div class="CUSTOMERS_INPUT_COLUMN_CONTAINER">
                            <div class="CUSTOMERS_INPUT_COLUMN_CONTAINER">
                                <label for="remarks">Remarks</label>
                                <input id="remarks" type="text" name="remarks" placeholder="Remarks" required>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="PRODUCTS_INPUT_NOTE">
                <p>Note: Each item is priced per piece</p>
            </div>

            <div class="GLOBAL_SUBHEADER">
                <h1>Total Items</h1>
            </div>

            <div class="PRODUCTS_INPUT_ITEMS pb-10">
                <div class="GLOBAL_TABLE GLOBAL_BOX_DIV">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Description</th>
                                <th>Dimensions</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $totalSum = 0;

                            if (isset($_SESSION['product_list']) && !empty($_SESSION['product_list'])) {
                                foreach ($_SESSION['product_list'] as $index => $product) {
                                    $amount = (float) $product['amount'];
                                    $price = (float) $product['price'];
                                    $totalPrice = $amount * $price;
                                    $totalSum += $totalPrice; // Add to the total sum

                                    echo "<tr id='product-row-$index'>";
                                    echo "<td>$index</td>";
                                    echo "<td>" . htmlspecialchars($product['productDescription']) . "</td>";
                                    echo "<td>" . htmlspecialchars($product['dimensions']) . "</td>";
                                    echo "<td>" . htmlspecialchars($product['amount']) . "</td>";
                                    echo "<td>" . htmlspecialchars($product['price']) . "</td>";
                                    echo "<td>" . htmlspecialchars($product['remarks']) . "</td>";
                                    echo "<td><button class='text-[#DF166E]' type='button' onclick='deleteItem($index)'>Delete</button></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7'>No products added.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="PRODUCTS_INPUT_ITEMS_TOTAL GLOBAL_BOX_DIV">
                    <div class="PRODUCTS_INPUT_ITEMS_TOTAL_TITLE">
                        <h1>Total Charge</h1>
                        <h1>Php <?php echo htmlspecialchars($totalSum); ?></h1>
                    </div>
                    <div class="PRODUCTS_INPUT_ITEMS_TOTAL_BUTTONS">
                        <a href="/orders" class="GLOBAL_BUTTON_RED">Cancel</a>
                        <button class="GLOBAL_BUTTON_BLUE ml-2" type="button" onclick="submitForm();">Add Order</button>

                        <script>
                            function submitForm() {
                                if (confirm('Confirm order?')) {
                                    document.getElementById('order-form').submit();
                                }
                            }

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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>