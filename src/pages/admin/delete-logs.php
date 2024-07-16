<?php
require "../utilities/db-connection.php";

if (!isset($_SESSION['username'])) {
    echo 'Access Denied';
    exit();
}

$username = $_SESSION['username'];

// Get user level
$sql = "SELECT UserLevel FROM employee_credentials WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo 'Access Denied';
    exit();
}

$row = $result->fetch_assoc();
$userlevel = $row['UserLevel'];

$userlevel2 = $_SESSION['user_level'] == 1 ? 'Admin' : 'User';
$profilePicture = isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : '';

if ($userlevel == 1) {
?>
    <div class="GLOBAL_PAGE">
        <?php include_once __DIR__ . "/../../components/sidebar.php"; ?>

        <div class="GLOBAL_PAGE_CONTAINER">

            <div class="GLOBAL_HEADER">
                <div class="GLOBAL_HEADER_TITLE">
                    <i class="material-symbols-rounded text-[42px]">admin_panel_settings</i>
                    <span class="">Admin</span>
                </div>
                <div class="GLOBAL_HEADER_USER">
                    <div class="GLOBAL_HEADER_COLUMN">
                        <p>Hey, <strong><?php echo htmlspecialchars($username); ?></strong></p>
                        <p><?php echo htmlspecialchars($userlevel2); ?></p>
                    </div>
                    <img src="../<?php echo htmlspecialchars($profilePicture); ?>" alt="Profile Picture">
                </div>
            </div>

            <div class="GLOBAL_PAGE_CONTAINER_CONTENT">
                <div class="GLOBAL_SUBHEADER">
                    <h1>Removed Products</h1>
                    <a onclick="window.history.back(); return false;">
                        <i class="material-symbols-rounded text-[#7F7F7F] text-3xl">
                            arrow_back
                        </i>
                    </a>
                </div>

                <form method="post" action="">
                    <input type="hidden" name="action" value="restore">
                    <div class="flex flex-row items-center justify-start gap-5 mb-5">
                        <button type="submit" value="Restore" class="GLOBAL_BUTTON_BLUE">Restore</button>
                        <input type="number" name="productID" placeholder="Product ID">
                    </div>
                </form>


                <div class="GLOBAL_TABLE mb-8">
                    <div>
                        <?php

                        if (isset($_POST['action']) && $_POST['action'] == 'restore') {
                            $productID = $_POST['productID'];

                            $sql = "UPDATE products SET IsRemoved = 0 WHERE productID = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $productID);
                            $stmt->execute();
                        }
                        ?>
                    </div>

                    <?php
                    // SQL query to select removed products
                    $sql = "SELECT * FROM products WHERE IsRemoved = 1";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo '<table border="1">';
                        echo '<tr>';
                        echo '<th>Product ID</th>';
                        echo '<th>Order ID</th>';
                        echo '<th>Description</th>';
                        echo '<th>File Path</th>';
                        echo '<th>Dimensions</th>';
                        echo '<th>Quantity</th>';
                        echo '<th>Status Code</th>';
                        echo '<th>Price</th>';
                        echo '<th>Remarks</th>';
                        echo '</tr>';

                        // Fetch and display each row of the results
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row['productID']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['OrderID']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['productDescription']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['productFilePath']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['productDimensions']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['ProductQuantity']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['ProductStatusCode']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['ProductPrice']) . '</td>';
                            echo '<td>' . (isset($row['productRemarks']) ? htmlspecialchars($row['productRemarks']) : '') . '</td>';
                            echo '</tr>';
                        }

                        echo '</table>';
                    } else {
                        echo 'No removed products found.';
                    }
                    ?>
                </div>

                <div class="GLOBAL_SUBHEADER">
                    <h1>Removed Receipts</h1>
                </div>

                <form method="post" action="">
                    <input type="hidden" name="action" value="restorereceipt">
                    <div class="flex flex-row items-center justify-start gap-5 mb-5">
                        <button type="submit" value="Restorereceipt" class="GLOBAL_BUTTON_BLUE">Restore</button>
                        <input type="number" name="receiptID" placeholder="Receipt ID">
                    </div>
                </form>

                <!-- <form method="post">
                    <input type="hidden" name="action" value="restorereceipt">
                    <input type="number" name="receiptID" placeholder="Receipt ID">
                    <input type="submit" value="Restorereceipt">
                </form> -->

                <div>
                    <?php

                    if (isset($_POST['action']) && $_POST['action'] == 'restorereceipt') {
                        $receiptID = $_POST['receiptID'];

                        $sql = "UPDATE payment_receipts SET IsRemoved = 0 WHERE receiptID = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $receiptID);
                        $stmt->execute();
                    }
                    ?>
                </div>

                <div class="GLOBAL_TABLE mb-5">
                    <?php
                    // SQL query to select payment receipts
                    $sql_receipts = "SELECT * FROM payment_receipts WHERE IsRemoved = 1";
                    $result_receipts = $conn->query($sql_receipts);

                    if ($result_receipts->num_rows > 0) {
                        echo '<table border="1">';
                        echo '<tr>';
                        echo '<th>Receipt ID</th>';
                        echo '<th>Plan ID</th>';
                        echo '<th>Receipt Image Path</th>';
                        echo '<th>Has Picture</th>';
                        echo '<th>Amount Paid</th>';
                        echo '<th>Payment Date</th>';
                        echo '<th>Payment Processor</th>';
                        echo '<th>Processor Ref Number</th>';
                        echo '<th>Is Removed</th>';
                        echo '</tr>';

                        // Fetch and display each row of the results
                        while ($row_receipt = $result_receipts->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row_receipt['ReceiptID']) . '</td>';
                            echo '<td>' . htmlspecialchars($row_receipt['PlanID']) . '</td>';
                            echo '<td>' . htmlspecialchars($row_receipt['ReceiptImagePath']) . '</td>';
                            echo '<td>' . htmlspecialchars($row_receipt['HasPicture']) . '</td>';
                            echo '<td>' . htmlspecialchars($row_receipt['ReceiptAmountPaid']) . '</td>';
                            echo '<td>' . htmlspecialchars($row_receipt['PaymentDate']) . '</td>';
                            echo '<td>' . htmlspecialchars($row_receipt['PaymentProcessor']) . '</td>';
                            echo '<td>' . htmlspecialchars($row_receipt['PaymentProcessorReferenceNumber']) . '</td>';
                            echo '<td>' . htmlspecialchars($row_receipt['IsRemoved']) . '</td>';
                            echo '</tr>';
                        }

                        echo '</table>';
                    } else {
                        echo 'No payment receipts found.';
                    }
                    ?>
                </div>
            </div>


            <!-- <form method="post">
                <input type="hidden" name="action" value="restore">
                <input type="number" name="productID" placeholder="Product ID">
                <input type="submit" value="Restore">
            </form> -->

            <!-- Additional content or forms can go here -->

        </div>

    </div>
<?php
} else {
    echo 'Access Denied';
}

$conn->close();
?>