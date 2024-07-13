<div class="GLOBAL_PAGE">
    <?php include_once __DIR__ . "/../../../components/sidebar.php"; ?>

    <div class="GLOBAL_PAGE_CONTAINER">
        <div class="GLOBAL_HEADER">
            <div class="GLOBAL_HEADER_TITLE">
                <i class="material-symbols-rounded text-[42px]">
                    receipt_long
                </i>
                <span>Order Details</span>
            </div>
            <div class="GLOBAL_HEADER_USER">
                <div class="GLOBAL_HEADER_COLUMN">
                    <p>Hey, <strong>Radon</strong></p>
                    <p>Admin</p>
                </div>
                <img src="/assets/JumanjiRon.png" alt="">
            </div>
        </div>

        <?php
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

        // Get orderID from query string
        if (isset($_GET['orderID'])) {
            $orderID = $_GET['orderID'];

            // Fetch and display customer information
            $customerQuery = "SELECT CONCAT(CustomerFname, ' ', CustomerLname) AS CustomerName, CustomerEmail, CustomerPhone
                                FROM customers
                                WHERE customerID IN (SELECT customerID FROM orders WHERE orderID = $orderID)";
            $customerResult = $conn->query($customerQuery);

            if ($customerResult->num_rows > 0) {
                $customerRow = $customerResult->fetch_assoc();
                $customerName = $customerRow['CustomerName'];
                $customerEmail = $customerRow['CustomerEmail'];
                $customerPhone = $customerRow['CustomerPhone'];
            }

            // Fetch and display order information
            $orderQuery = "SELECT OrderStartDate, OrderDeadline, 
                                      CASE
                                          WHEN OrderStatusCode = 1 THEN 'Pending'
                                          WHEN OrderStatusCode = 2 THEN 'Started'
                                          WHEN OrderStatusCode = 3 THEN 'Completed'
                                          ELSE 'Unknown'
                                      END AS Status
                               FROM orders
                               WHERE orderID = $orderID";
            $orderResult = $conn->query($orderQuery);

            if ($orderResult->num_rows > 0) {
                $orderRow = $orderResult->fetch_assoc();
                $orderStartDate = $orderRow['OrderStartDate'];
                $orderDeadline = $orderRow['OrderDeadline'];
                $orderStatus = $orderRow['Status'];
            }

            // Fetch and display ordered products
            $productsQuery = "SELECT ProductID, ProductDescription, ProductDimensions, ProductQuantity, ProductPrice
                                  FROM products
                                  WHERE orderID = $orderID AND isremoved = 0";
            $productsResult = $conn->query($productsQuery);
            $products = [];
            if ($productsResult->num_rows > 0) {
                while ($productRow = $productsResult->fetch_assoc()) {
                    $products[] = $productRow;
                }
            }

            // Fetch and display payment plan information
            $paymentQuery = "SELECT PaymentMethod, DueDate, 
                                        CASE
                                            WHEN PaymentStatus = 0 THEN 'Pending'
                                            WHEN PaymentStatus = 1 THEN 'Paid'
                                            ELSE 'Unknown'
                                        END AS PaymentStatus, TotalAmount, AmountPaid, Balance
                                 FROM payment_plans
                                 WHERE orderID = $orderID AND isremoved = 0";
            $paymentResult = $conn->query($paymentQuery);
            $paymentPlan = [];
            if ($paymentResult->num_rows > 0) {
                $paymentPlan = $paymentResult->fetch_assoc();
            }

            // Fetch and display related receipts
            $receiptQuery = "SELECT ReceiptID, ReceiptAmountPaid, PaymentDate
                                 FROM Payment_Receipts
                                 WHERE planID IN (SELECT planID FROM payment_plans WHERE orderID = $orderID AND isremoved = 0) AND isremoved = 0";
            $receiptResult = $conn->query($receiptQuery);
            $receipts = [];
            if ($receiptResult->num_rows > 0) {
                while ($receiptRow = $receiptResult->fetch_assoc()) {
                    $receipts[] = $receiptRow;
                }
            }
        } else {
            echo "<p>No orderID specified.</p>";
        }

        $conn->close();
        ?>

        <div class="DETAILS_CONTAINER">
            <div class="GLOBAL_SUBHEADER">
                <div class="DETAILS_ORDERID">
                    <h1>
                        <?php
                        if (isset($orderID)) {
                            echo "Order #$orderID";
                        } else {
                            echo "Order Details";
                        }
                        ?>
                    </h1>
                </div>
                <a onclick="window.history.back()">
                    <i class="material-symbols-rounded text-[#7F7F7F] text-3xl">
                        arrow_back
                    </i>
                </a>
            </div>
                <!-- EDIT INFO -->
            <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'edit') {
                    // Display the edit form
                    $customerID = htmlspecialchars($_POST['customerID']);
                    echo <<<HTML
                    <div class="POPUP_CONTAINER">
                        <div class="POPUP_CONTAINER_BOX GLOBAL_BOX_DIV flex flex-col gap-4 w-full">
                        <a href="/orders/details?orderID={$orderID}" class="absolute top-2 right-4 text-2xl text-gray-500 cursor-pointer">&times;</a>
                            <h1 class = "text-lg font-bold">Edit Customer Information</h1>
                            <form method="post" class = "flex flex-col gap-4">
                                <input type="hidden" name="action" value="save">
                                <input type="hidden" name="customerID" value="{$customerID}">
                                <input type="text" name="editCustomerName" value="{$customerName}" placeholder="Customer Name">
                                <input type="email" name="editCustomerEmail" value="{$customerEmail}" placeholder="Customer Email">
                                <input type="tel" name="editCustomerPhone" value="{$customerPhone}" placeholder="Customer Phone">
                                <!-- Add other fields as needed -->
                                <button type="submit" class="GLOBAL_BUTTON_BLUE flex-grow-0 w-min">Save</button>
                            </form>
                        </div>
                    </div> 
                    HTML; 
        
                }
            ?>

                <!-- END EDIT INFO -->

                <!-- Render Table -->
            <div class="DETAILS_CONTAINER_ROW columns-2">
                <div class="DETAILS_CONTAINER_ROW_LEFT">
                    <div class="GLOBAL_SUBHEADER_TITLE">
                        <h1>Customer Information</h1>
                    </div>
                      <div class="DETAILS_CONTAINER_ROW_TABLE GLOBAL_BOX_DIV">
                        <table>
                            <tr>
                                <td>Customer Name</td>
                                <td><?=htmlspecialchars($customerName); ?></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td><?=htmlspecialchars($customerEmail); ?></td>
                            </tr>
                            <tr>
                                <td>Contact Number</td>
                                <td><?=htmlspecialchars($customerPhone); ?></td>
                            </tr>
                        </table>
                        <div class="DETAILS_CONTAINER_ROW_BUTTON">
                            <form method="post">
                                <input type="hidden" name="action" value="edit">
                                <input type="hidden" name="customerID" value="<?=htmlspecialchars($customerID); ?>">
                                <button type="submit" class="GLOBAL_BUTTON_BLUE">Edit Info</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- End Render Table -->

                <!-- Save Info TODO: BACKEND DEVELOPER-->
                <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'save') {
                        // Retrieve POST data
                        $customerID = htmlspecialchars($_POST['customerID']);
                        $editedName = htmlspecialchars($_POST['editCustomerName']);
                        $editedEmail = htmlspecialchars($_POST['editCustomerEmail']);
                        $editedPhone = htmlspecialchars($_POST['editCustomerPhone']);
                        
                        // Update the customer information in the database
                        updateCustomerInfo($customerID, $editedName, $editedEmail, $editedPhone);
                        
                        // Optionally, redirect or show a success message
                        header("Location: " . $_SERVER['PHP_SELF']);
                        exit;
                    }

                    function updateCustomerInfo($id, $name, $email, $phone) {
                        try {
                            // Replace with your actual database connection details
                            $pdo = new PDO('mysql:host=your_host;dbname=your_db', 'your_user', 'your_password');
                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            
                            $sql = "UPDATE customers SET name = ?, email = ?, phone = ? WHERE id = ?";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([$name, $email, $phone, $id]);
                            
                            echo "Customer information updated successfully.";
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }
                    }
                ?>

                <!-- END Save Info -->

                <div class="DETAILS_CONTAINER_ROW_RIGHT">
                    <div class="GLOBAL_SUBHEADER_TITLE">
                        <h1>Order Information</h1>
                    </div>
                    <div class="DETAILS_CONTAINER_ROW_TABLE GLOBAL_BOX_DIV">
                        <table>
                            <tr>
                                <td>Order Date</td>
                                <td><?php echo $orderStartDate ?? ''; ?></td>
                            </tr>
                            <tr>
                                <td>Deadline</td>
                                <td><?php echo $orderDeadline ?? ''; ?></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td><?php echo $orderStatus ?? ''; ?></td>
                            </tr>
                        </table>
                        <div class="DETAILS_CONTAINER_ROW_BUTTON">
                            <button class="GLOBAL_BUTTON_RED">Cancel Order</button>
                            <button class="GLOBAL_BUTTON_GREEN">Complete</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="DETAILS_CONTAINER_ROW">
                <div class="DETAILS_CONTAINER_ROW_COLUMN">
                    <div class="DETAILS_CONTAINER_SUBHEADER mb-5">
                        <h1>Ordered Products</h1>
                        <button class="GLOBAL_BUTTON_BLUE ml-5">Add Item</button>
                    </div>
                    <div class="GLOBAL_TABLE GLOBAL_BOX_DIV mb-5">
                        <table>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Product</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Total</th>
                                <th>Action</th>
                            </tr>
                            <?php foreach ($products as $product) : ?>
                                <tr>
                                    <td class="text-center font-normal"><?php echo $product['ProductID']; ?></td>
                                    <td class="text-center font-normal"><?php echo $product['ProductDescription']; ?></td>
                                    <td class="text-center font-normal"><?php echo $product['ProductQuantity']; ?></td>
                                    <td class="text-center font-normal"><?php echo $product['ProductPrice']; ?></td>
                                    <td class="text-center font-normal"><?php echo $product['ProductQuantity'] * $product['ProductPrice']; ?></td>
                                    <td class="flex flex-row justify-center">
                                        <button class="text-[#DF166E]" onclick="return confirm('Are you sure you want to delete row?');">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>

                    </div>
                </div>
            </div>

            <div class="DETAILS_CONTAINER_ROW columns-2 pt-3">
                <div class="DETAILS_CONTAINER_ROW_LEFT">
                    <div class="GLOBAL_SUBHEADER_TITLE">
                        <h1>Payment Plan</h1>
                    </div>
                    <div class="DETAILS_CONTAINER_ROW_TABLE GLOBAL_BOX_DIV">
                        <table>
                            <tr>
                                <td>Payment Method</td>
                                <td><?php echo $paymentPlan['PaymentMethod'] ?? ''; ?></td>
                            </tr>
                            <tr>
                                <td>Due Date</td>
                                <td><?php echo $paymentPlan['DueDate'] ?? ''; ?></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td><?php echo $paymentPlan['PaymentStatus'] ?? ''; ?></td>
                            </tr>
                            <tr>
                                <td>Total Amount</td>
                                <td><?php echo $paymentPlan['TotalAmount'] ?? ''; ?></td>
                            </tr>
                            <tr>
                                <td>Amount Paid</td>
                                <td><?php echo $paymentPlan['AmountPaid'] ?? ''; ?></td>
                            </tr>
                            <tr>
                                <td>Balance</td>
                                <td><?php echo $paymentPlan['Balance'] ?? ''; ?></td>
                            </tr>
                        </table>
                        <div class="DETAILS_CONTAINER_ROW_BUTTON">
                            <button class="GLOBAL_BUTTON_BLUE">Edit Payment Plan</button>
                        </div>
                    </div>
                </div>
                <div class="DETAILS_CONTAINER_ROW_RIGHT">
                    <div class="GLOBAL_SUBHEADER_TITLE mb-5">
                        <h1>Receipts</h1>
                    </div>
                    <div class="GLOBAL_TABLE GLOBAL_BOX_DIV">
                        <table>
                            <tr>
                                <th>#</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                            <?php foreach ($receipts as $receipt) : ?>
                                <tr>
                                    <td><?php echo $receipt['ReceiptID']; ?></td>
                                    <td><?php echo $receipt['ReceiptAmountPaid']; ?></td>
                                    <td><?php echo $receipt['PaymentDate']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>