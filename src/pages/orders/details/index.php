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
                <span>Order Details</span>
            </div>
            <div class="GLOBAL_HEADER_USER">
                <div class="GLOBAL_HEADER_COLUMN">
                    <p>Hey, <strong><?php echo htmlspecialchars($username); ?></strong></p>
                    <p><?php echo htmlspecialchars($userlevel) ?></p>
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
                                          WHEN OrderStatusCode = 1 THEN 'Started'
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
            $paymentQuery = "SELECT PaymentMethod, DueDate, PaymentStatus, 
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

        if ($_SERVER)
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
                            <form method="post" class = "flex flex-col gap-4" onsubmit="reloadpage()">
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
                            <form method="post" onsubmit="reloadpage()">
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

                    // Create archive 

                    $sql = "INSERT INTO customer_info_archive (CustomerID, CustomerFname, CustomerLname, CustomerEmail, CustomerPhone, ArchiveTimestamp)
                            SELECT CustomerID, CustomerFname, CustomerLname, CustomerEmail, CustomerPhone, NOW()
                            FROM customers
                            WHERE CustomerID = '$globCustomerID'";

                    $conn->query($sql);


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
                            <h1 class="font-semibold">Update Status: </h1>
                            <form method="post" onsubmit="reloadpage()">
                                <button type="submit" class="GLOBAL_BUTTON_RED ml-2" name="action" value="cancel-order" onclick="return confirm('Are you sure you want to cancel the order?')">Cancel</button>
                                <input type="hidden" name="orderID" value="<?php echo htmlspecialchars($_GET['orderID']); ?>">
                            </form>
                            <form method="post" onsubmit="reloadpage()">
                                <button type="submit" class="GLOBAL_BUTTON_ORANGE ml-2" name="action" value="inprogress-order" onclick="return confirm('Are you sure you want to mark the order as Started?')">Started</button>
                                <input type="hidden" name="orderID" value="<?php echo htmlspecialchars($_GET['orderID']); ?>">
                            </form>
                            <form method="post" onsubmit="reloadpage()">
                                <button type="submit" class="GLOBAL_BUTTON_GREEN" name="action" value="complete-order" onclick="return confirm('Are you sure you want to mark complete the order?')">Complete</button>
                                <input type="hidden" name="orderID" value="<?php echo htmlspecialchars($_GET['orderID']); ?>">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- EDIT ordered Product INFO -->
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'editProductInfo') {
                // Display the edit form for product
                $productID = htmlspecialchars($_POST['productID']);
                $productDescription = htmlspecialchars($_POST['productDescription']);
                $productQuantity = htmlspecialchars($_POST['productQuantity']);
                $productPrice = htmlspecialchars($_POST['productPrice']);
                echo <<<HTML
                        <div class="POPUP_CONTAINER">
                            <div class="POPUP_CONTAINER_BOX GLOBAL_BOX_DIV flex flex-col gap-4 w-full">
                                <a href="/orders/details?orderID={$orderID}" class="absolute top-2 right-4 text-2xl text-gray-500 cursor-pointer">&times;</a>
                                <h1 class="text-lg font-bold">Edit Product Information</h1>
                                <form method="post" class="flex flex-col gap-4" onsubmit="reloadpage()">
                                    <input type="hidden" name="action" value="saveProductInfo">
                                    <input type="hidden" name="productID" value="{$productID}">
                                    <input type="text" name="editProductDescription" value="{$productDescription}" placeholder="Product Description">
                                    <input type="number" name="editProductQuantity" value="{$productQuantity}" placeholder="Product Quantity">
                                    <input type="number" step="0.01" name="editProductPrice" value="{$productPrice}" placeholder="Product Price">
                                    <button type="submit" class="GLOBAL_BUTTON_BLUE flex-grow-0 w-min">Save</button>
                                </form>
                            </div>
                        </div> 
                    HTML;
            }
            ?>
            <!-- EDIT ordered Product INFO -->

            <!-- ADD ordered Product INFO -->
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'addProductInfo') {
                // Display the add form for product
                echo <<<HTML
                        <div class="POPUP_CONTAINER">
                            <div class="POPUP_CONTAINER_BOX GLOBAL_BOX_DIV flex flex-col gap-4 w-full">
                                <a href="/orders/details?orderID={$orderID}" class="absolute top-2 right-4 text-2xl text-gray-500 cursor-pointer">&times;</a>
                                <h1 class="text-lg font-bold">Add Product Information</h1>
                                <form method="post" class="flex flex-col gap-4" onsubmit="reloadpage()">
                                    <input type="hidden" name="action" value="saveNewProduct">
                                    <input type="text" name="newProductDescription" placeholder="Product Description">
                                    <input type="text" name="newProductDimensions" placeholder="Product Dimensions">
                                    <input type="number" name="newProductQuantity" placeholder="Product Quantity">
                                    <input type="number" step="0.01" name="newProductPrice" placeholder="Product Price">
                                    <textarea name="newProductRemarks" placeholder="Remarks"></textarea>
                                    <button type="submit" class="GLOBAL_BUTTON_BLUE w-32">Add Item</button>
                                </form>
                            </div>
                        </div> 
                    HTML;
            }
            ?>
            <!-- end ADD ordered Product INFO -->

            <!-- Render Ordered Products Table -->
            <div class="DETAILS_CONTAINER_ROW">
                <div class="DETAILS_CONTAINER_ROW_COLUMN">
                    <div class="DETAILS_CONTAINER_SUBHEADER mb-5">
                        <h1>Ordered Products</h1>
                        <form method="post" onsubmit="reloadpage()">
                            <input type="hidden" name="action" value="addProductInfo">
                            <button type="submit" class="GLOBAL_BUTTON_BLUE ml-5">Add Item</button>
                        </form>
                    </div>
                    <div class="GLOBAL_TABLE GLOBAL_BOX_DIV mb-5">
                        <table>
                            <tr>
                                <th>#</th>
                                <th>Product Description</th>
                                <th>Product Quantity</th>
                                <th>Product Price</th>
                                <th>Total Price</th>
                                <th>Actions</th>
                            </tr>
                            <?php foreach ($products as $index => $product) : ?>
                                <tr>
                                    <td class="text-center font-normal"><?= htmlspecialchars($index + 1); ?></td>
                                    <td class="text-center font-normal"><?= htmlspecialchars($product['ProductDescription']); ?></td>
                                    <td class="text-center font-normal"><?= htmlspecialchars($product['ProductQuantity']); ?></td>
                                    <td class="text-center font-normal"><?= htmlspecialchars($product['ProductPrice']); ?></td>
                                    <td class="text-center font-normal"><?= htmlspecialchars($product['ProductQuantity'] * $product['ProductPrice']); ?></td>
                                    <td class="flex flex-row justify-center">
                                        <form method="post" onsubmit="reloadpage()">
                                            <input type="hidden" name="action" value='removeProductByIndex'>
                                            <input type="hidden" name="productID" value="<?= htmlspecialchars($product['ProductID']); ?>">
                                            <button type="submit" class="text-[#DF166E]" onclick="return confirm('Are you sure you want to delete this row?');">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <?php

                            ob_start();
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if ($_POST['action'] === 'removeProductByIndex') {
                                    $productID = htmlspecialchars($_POST['productID']);
                                    $sql = "UPDATE products SET isremoved = 1 WHERE ProductID = ?";



                                    if ($stmt = $conn->prepare($sql)) {
                                        $stmt->bind_param("i", $productID);
                                        $stmt->execute();
                                        $stmt->close();
                                    } else {
                                        // Handle errors with prepare operation here
                                        echo "Error preparing the statement: " . $conn->error;
                                    }

                                    // Log action
                                    $employeeWebID = $_SESSION['employeeWebID'];
                                    $sql = "insert into action_logs (EmployeeWebID, UserAction, AffectedEntityType, AffectedEntityID, LogTimestamp)
                                    values ('$employeeWebID', 'Remove', 'Products', '$productID', now());";
                                    $conn->query($sql);
                                }
                            }

                            // update payment_plans
                            $sql = "update payment_plans set totalamount = (select sum(productPrice * productQuantity) from products where orderid = '$globOrderID' and isRemoved = 0) where orderid = '$globOrderID';";
                            $conn->query($sql);

                            //update balance
                            $sql = "update payment_plans set balance = totalamount - amountpaid where orderid = '$globOrderID' and IsRemoved = 0;";
                            $conn->query($sql);

                            // Redirect to the same page to clear the form
                            ob_end_flush();

                            ?>

                        </table>
                    </div>
                </div>
            </div>
            <!-- Render Ordered Products Table -->

            <!-- Save New Product Info -->
            <?php

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'saveNewProduct') {
                // Retrieve POST data
                $newProductDescription = htmlspecialchars($_POST['newProductDescription']);
                $newProductQuantity = htmlspecialchars($_POST['newProductQuantity']);
                $newProductPrice = htmlspecialchars($_POST['newProductPrice']);
                $newProductRemarks = htmlspecialchars($_POST['newProductRemarks']);

                $sql = "insert into products (OrderID, ProductDescription, ProductQuantity, ProductPrice, ProductRemarks) values 
                ('$globOrderID', '$newProductDescription', '$newProductQuantity', '$newProductPrice', '$newProductRemarks')";
                $conn->query($sql);

                // Update total amount
                $sql = "update payment_plans set totalamount = (select sum(productPrice * productQuantity) from products where orderid = '$globOrderID' and isRemoved = 0) where orderid = '$globOrderID';";
                $conn->query($sql);

                // Update balance
                $sql = "update payment_plans set balance = totalamount - amountpaid where orderid = '$globOrderID' and IsRemoved = 0;";
                $conn->query($sql);
            }
            ?>
            <!-- End Save New Product Info -->

            <div class="DETAILS_CONTAINER_ROW columns-2 pt-3">
                <div class="DETAILS_CONTAINER_ROW_LEFT">
                    <div class="GLOBAL_SUBHEADER_TITLE">
                        <h1>Payment Plan</h1>
                    </div>


                    <!-- EDIT PAYMENT PLAN -->
                    <?php
                    $realPlanID = 0;
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'editPaymentPlan') {
                        // Display the edit form for payment plan
                        $paymentPlanID = htmlspecialchars($_POST['paymentPlanID']);
                        $realPlanId = (int)$paymentPlanID;
                        echo <<<HTML
                        <div class="POPUP_CONTAINER">
                            <div class="POPUP_CONTAINER_BOX GLOBAL_BOX_DIV flex flex-col gap-4 w-full">
                                <a href="/orders/details?orderID={$orderID}" class="absolute top-2 right-4 text-2xl text-gray-500 cursor-pointer">&times;</a>
                                <h1 class="text-lg font-bold">Edit Payment Plan</h1>
                                <form method="post" class="flex flex-col gap-4" onsubmit="reloadpage()">
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

                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'refresh') {
                        // Sanitize input
                        $globOrderID = $conn->real_escape_string($globOrderID);

                        //Update amount paid
                        $sql = "UPDATE payment_plans 
                                SET amountpaid = (SELECT SUM(ReceiptAmountPaid) 
                                                  FROM payment_receipts 
                                                  WHERE planID = '$realPlanID' AND isRemoved = 0) 
                                WHERE orderid = '$globOrderID' AND IsRemoved = 0;";
                        $conn->query($sql);

                        // Update total amount in payment_plans
                        $sql = "UPDATE payment_plans 
                                SET totalamount = (SELECT SUM(productPrice * productQuantity) 
                                                   FROM products 
                                                   WHERE orderid = '$globOrderID' AND isRemoved = 0) 
                                WHERE orderid = '$globOrderID';";
                        $conn->query($sql);

                        // Update balance
                        $sql = "UPDATE payment_plans 
                                SET balance = totalamount - amountpaid 
                                WHERE orderid = '$globOrderID' AND IsRemoved = 0;";
                        $conn->query($sql);
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
                                <td>P <?php echo htmlspecialchars($paymentPlan['TotalAmount'] ?? ''); ?></td>
                            </tr>
                            <tr>
                                <td>Amount Paid</td>
                                <td>P <?php echo htmlspecialchars($paymentPlan['AmountPaid'] ?? ''); ?></td>
                            </tr>
                            <tr>
                                <td>Balance</td>
                                <td>P <?php echo htmlspecialchars($paymentPlan['Balance'] ?? ''); ?></td>
                            </tr>
                        </table>
                        <div class="DETAILS_CONTAINER_ROW_BUTTON">
                            <form method="post" onsubmit="reloadpage()">
                                <input type="hidden" name="action" value="editPaymentPlan">
                                <input type="hidden" name="paymentPlanID" value="<?= htmlspecialchars($paymentPlanID); ?>">
                                <button type="submit" class="GLOBAL_BUTTON_BLUE">Edit Payment Plan</button>
                            </form>
                            <form method="post">
                                <input type="hidden" name="action" value="refresh">
                                <input type="hidden" name="paymentPlanID" value="<?= htmlspecialchars($paymentPlanID); ?>">
                                <button type="submit" class="GLOBAL_BUTTON_BLUE ml-2">Refresh</button>
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