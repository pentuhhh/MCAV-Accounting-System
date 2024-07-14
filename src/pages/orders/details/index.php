<div class="GLOBAL_PAGE">
    <?php
    include_once __DIR__ . "/../../../components/sidebar.php";

    $username = $_SESSION['username'];
    $profilePicture = isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : '';
    ?>

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
                    <p>Hey, <strong><?php echo htmlspecialchars($username); ?></strong></p>
                    <p>Admin</p>
                </div>
                <img src="../../../<?php echo htmlspecialchars($profilePicture); ?>" alt="Profile Picture">
            </div>
        </div>

        <?php
        require "../utilities/db-connection.php";

        // Get orderID from query string
        if (isset($_GET['orderID'])) {
            $orderID = $_GET['orderID'];

            // Fetch and display customer information
            $customerQuery = "SELECT CONCAT(CustomerFname, ' ', CustomerLname) AS CustomerName, CustomerEmail, CustomerPhone
                                FROM customers
                                WHERE customerID IN (SELECT customerID FROM orders WHERE orderID = $orderID)";
            $customerResult = $conn->query($customerQuery);

            //get customer ID
            global $globOrderID;
            $globOrderID = $orderID;
            global $globCustomerID;

            $getCustomerID = "SELECT customerID FROM orders WHERE orderID = $orderID";
            $customerIDResult = $conn->query($getCustomerID);
            if ($customerIDResult->num_rows > 0) {
                $customerIDRow = $customerIDResult->fetch_assoc();
                $globCustomerID = $customerIDRow['customerID'];
            }

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
                                          WHEN OrderStatusCode = 4 THEN 'Cancelled'
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
            $productsQuery = "SELECT ProductID, ProductDescription, ProductDimensions, ProductQuantity, ProductPrice, ProductRemarks
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

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_POST['action'] == 'cancel-order') {
                $sql = "UPDATE orders SET OrderStatusCode = 4 WHERE OrderID = $orderID";
                if ($conn->query($sql) === FALSE) {
                    echo "Error canceling order: " . $conn->error;
                }
            } elseif ($_POST['action'] == 'complete-order') {
                $sql = "UPDATE orders SET OrderStatusCode = 3 WHERE OrderID = $orderID";
                if ($conn->query($sql) === FALSE) {
                    echo "Error completing order: " . $conn->error;
                }
            } elseif ($_POST['action'] == 'inprogress-order') {
                $sql = "UPDATE orders SET OrderStatusCode = 2 WHERE OrderID = $orderID";
                if ($conn->query($sql) === FALSE) {
                    echo "Error marking order as in progress: " . $conn->error;
                }
            }
        }

        if($_SERVER)
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
            <!-- EDIT Customer INFO -->
            <?php
            require "../utilities/db-connection.php";
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'edit') {
                // Display the edit form
                $customerID = htmlspecialchars($_POST['customerID']);

                // breakdown customer name
                
                $sql = "SELECT CustomerFname, CustomerLname FROM customers WHERE CustomerID = $globCustomerID";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                $customerFname = $row['CustomerFname'];
                $customerLname = $row['CustomerLname'];

                echo <<<HTML
                    <div class="POPUP_CONTAINER">
                        <div class="POPUP_CONTAINER_BOX GLOBAL_BOX_DIV flex flex-col gap-4 w-full">
                        <a href="/orders/details?orderID={$orderID}" class="absolute top-2 right-4 text-2xl text-gray-500 cursor-pointer">&times;</a>
                            <h1 class = "text-lg font-bold">Edit Customer Information</h1>
                            <form method="post" class = "flex flex-col gap-4">
                                <input type="hidden" name="action" value="save-customer">
                                <input type="hidden" name="customerID" value="{$customerID}">
                                <input type="text" name="editCustomerFName" value="{$customerFname}" placeholder="Customer First Name">
                                <input type="text" name="editCustomerLName" value="{$customerLname}" placeholder="Customer Last Name">
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

            <!-- END EDIT Customer INFO -->

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
                                <td><?= htmlspecialchars($customerName); ?></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td><?= htmlspecialchars($customerEmail); ?></td>
                            </tr>
                            <tr>
                                <td>Contact Number</td>
                                <td><?= htmlspecialchars($customerPhone); ?></td>
                            </tr>
                        </table>
                        <div class="DETAILS_CONTAINER_ROW_BUTTON">
                            <form method="post">
                                <input type="hidden" name="action" value="edit">
                                <input type="hidden" name="customerID" value="<?= htmlspecialchars($customerID); ?>">
                                <button type="submit" class="GLOBAL_BUTTON_BLUE">Edit Info</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- End Render Table -->

                <!-- Save Info TODO: BACKEND DEVELOPER-->
                <?php

                require "../utilities/db-connection.php";
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'save-customer') {
                        // Retrieve POST data
                        $editedFName = htmlspecialchars($_POST['editCustomerFName']);
                        $editedLName = htmlspecialchars($_POST['editCustomerLName']);
                        $editedEmail = htmlspecialchars($_POST['editCustomerEmail']);
                        $editedPhone = htmlspecialchars($_POST['editCustomerPhone']);

                        // Update the customer information in the database
                        $sql = "UPDATE customers SET CustomerFname = '$editedFName', CustomerLname = '$editedLName', CustomerEmail = '$editedEmail', CustomerPhone = '$editedPhone' WHERE CustomerID = '$globCustomerID'";
                        $conn->query($sql);
                        
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
                        <form method="post">
                            <button type="submit" class="GLOBAL_BUTTON_RED" name="action" value="cancel-order" onclick="return confirm('Are you sure you want to cancel the order?')">Cancel Order </button>
                            <input type="hidden" name="orderID" value="<?php echo htmlspecialchars($_GET['orderID']); ?>">
                        </form>
                        <form method="post">
                            <button type="submit" class="GLOBAL_BUTTON_GREEN" name="action" value="inprogress-order" onclick="return confirm('Are you sure you want to mark the order as Pending?')">Pending </button>
                            <input type="hidden" name="orderID" value="<?php echo htmlspecialchars($_GET['orderID']); ?>">
                        </form>
                        <form method="post">
                            <button type="submit" class="GLOBAL_BUTTON_GREEN" name="action" value="complete-order" onclick="return confirm('Are you sure you want to mark complete the order?')">Complete Order </button>
                            <input type="hidden" name="orderID" value="<?php echo htmlspecialchars($_GET['orderID']); ?>">
                        </form>
                        
                        </div>
                    </div>
                </div>
            </div>

            <div class="DETAILS_CONTAINER_ROW">
                <div class="DETAILS_CONTAINER_ROW_COLUMN">
                    <div class="DETAILS_CONTAINER_SUBHEADER mb-5">
                        <h1>Ordered Products</h1>
                    </div>
                    <div class="GLOBAL_TABLE GLOBAL_BOX_DIV mb-5">
                        <table>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Product Description</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Unit Price</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Remarks</th>
                            </tr>
                            <?php foreach ($products as $product) : ?>
                                <tr>
                                    <td class="text-center font-normal"><?php echo $product['ProductID']; ?></td>
                                    <td class="text-center font-normal"><?php echo $product['ProductDescription']; ?></td>
                                    <td class="text-center font-normal"><?php echo $product['ProductQuantity']; ?></td>
                                    <td class="text-center font-normal"><?php echo $product['ProductPrice']; ?></td>
                                    <td class="text-center font-normal"><?php echo $product['ProductQuantity'] * $product['ProductPrice']; ?></td>
                                    <td class="text-center font-normal"><?php echo $product['ProductRemarks']; ?></td>
    
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


                    <!-- EDIT PAYMENT PLAN -->
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'editPaymentPlan') {
                        // Display the edit form for payment plan
                        $paymentPlanID = htmlspecialchars($_POST['paymentPlanID']);
                        echo <<<HTML
                        <div class="POPUP_CONTAINER">
                            <div class="POPUP_CONTAINER_BOX GLOBAL_BOX_DIV flex flex-col gap-4 w-full">
                                <a href="/orders/details?orderID={$orderID}" class="absolute top-2 right-4 text-2xl text-gray-500 cursor-pointer">&times;</a>
                                <h1 class="text-lg font-bold">Edit Payment Plan</h1>
                                <form method="post" class="flex flex-col gap-4">
                                    <input type="hidden" name="action" value="savePaymentPlan">
                                    <input type="hidden" name="paymentPlanID" value="{$paymentPlanID}">
                                    <input type="text" name="editPaymentMethod" value="{$paymentPlan['PaymentMethod']}" placeholder="Payment Method">
                                    <input type="date" name="editDueDate" value="{$paymentPlan['DueDate']}" placeholder="Due Date">
                                    <!-- Add other fields as needed -->
                                    <button type="submit" class="GLOBAL_BUTTON_BLUE flex-grow-0 w-min">Save</button>
                                </form>
                            </div>
                        </div> 
                        HTML;

                        
                    }
                    ?>
                    <!-- END EDIT PAYMENT PLAN -->

                    <!-- Render Payment Plan Table -->
                    <div class="DETAILS_CONTAINER_ROW_TABLE GLOBAL_BOX_DIV">
                        <table>
                            <tr>
                                <td>Payment Method</td>
                                <td><?php echo htmlspecialchars($paymentPlan['PaymentMethod'] ?? ''); ?></td>
                            </tr>
                            <tr>
                                <td>Due Date</td>
                                <td><?php echo htmlspecialchars($paymentPlan['DueDate'] ?? ''); ?></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td><?php echo htmlspecialchars($paymentPlan['PaymentStatus'] ?? ''); ?></td>
                            </tr>
                            <tr>
                                <td>Total Amount</td>
                                <td><?php echo htmlspecialchars($paymentPlan['TotalAmount'] ?? ''); ?></td>
                            </tr>
                            <tr>
                                <td>Amount Paid</td>
                                <td><?php echo htmlspecialchars($paymentPlan['AmountPaid'] ?? ''); ?></td>
                            </tr>
                            <tr>
                                <td>Balance</td>
                                <td><?php echo htmlspecialchars($paymentPlan['Balance'] ?? ''); ?></td>
                            </tr>
                        </table>
                        <div class="DETAILS_CONTAINER_ROW_BUTTON">
                            <form method="post">
                                <input type="hidden" name="action" value="editPaymentPlan">
                                <input type="hidden" name="paymentPlanID" value="<?= htmlspecialchars($paymentPlanID); ?>">
                                <button type="submit" class="GLOBAL_BUTTON_BLUE">Edit Payment Plan</button>
                            </form>
                        </div>
                    </div>
                    <!-- END Render Payment Plan Table -->

                    <!-- Save Payment Plan Info: BACKEND DEVELOPER: NIKOLAI -->
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'savePaymentPlan') {

                        // require "../utilities/db-connection.php";

                        // Retrieve POST data

                        //retrieve plan ID by orderID

                        $sql = "select * from payment_plans where orderID = '$globOrderID';";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        $paymentPlanID = $row['PlanID'];
                        $editedPaymentMethod = htmlspecialchars($_POST['editPaymentMethod']);
                        $editedDueDate = htmlspecialchars($_POST['editDueDate']);
                      
                        
                        $sql = "UPDATE payment_plans SET PaymentMethod = '$editedPaymentMethod', DueDate = '$editedDueDate' WHERE PlanID = '$paymentPlanID'";
                        $conn->query($sql);
                    }

                    ?>
                    <!-- END Save Payment Plan Info -->

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