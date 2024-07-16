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
                    <h1>File History</h1>
                    <a onclick="window.history.back(); return false;">
                        <i class="material-symbols-rounded text-[#7F7F7F] text-3xl">
                            arrow_back
                        </i>
                    </a>
                </div>
                <?php
                // Display the customer_info_archive table
                $sql = "SELECT customerArchiveID, CustomerID, CustomerFname, CustomerLname, CustomerEmail, CustomerPhone, ArchiveTimestamp 
                            FROM customer_info_archive";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo '<table class="action-logs-table">';
                    echo '<tr>';
                    echo '<th>Customer Archive ID</th>';
                    echo '<th>Customer ID</th>';
                    echo '<th>Customer First Name</th>';
                    echo '<th>Customer Last Name</th>';
                    echo '<th>Customer Email</th>';
                    echo '<th>Customer Phone</th>';
                    echo '<th>Archive Timestamp</th>';
                    echo '</tr>';

                    // Fetch and display each row of the results
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['customerArchiveID']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['CustomerID']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['CustomerFname']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['CustomerLname']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['CustomerEmail']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['CustomerPhone']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['ArchiveTimestamp']) . '</td>';
                        echo '</tr>';
                    }

                    echo '</table>';
                } else {
                    // echo 'No results found.';
                }
                ?>

                <div class="ORDERS_SEARCH">
                    <form id="searchid" method="post" action="">
                        <div class="columns-1">
                            <button type="submit" class="ORDER_SEARCH_BUTTON">
                                <i class="material-symbols-rounded">
                                    search
                                </i>
                            </button>
                            <input type="num" name="employeeid" id="employeeid" placeholder="EmployeeID">
                        </div>
                    </form>
                </div>

                <!-- <br><br>Search by user (input EmployeeID): -->
                <!-- <div class="GLOBAL_TABLE">
                    <form id="searchid" method="post" action="">
                        <input type="number" name="employeeid" id="employeeid" placeholder="EmployeeID">
                        <input type="submit" class="GLOBAL_BUTTON_BLUE">
                    </form>
                </div> -->

                <div class="GLOBAL_TABLE">

                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['employeeid'])) {
                        $inputemployeeid = $_POST['employeeid'];

                        // Display the customer_info_archive table for that user
                        $sql = "SELECT customerArchiveID, CustomerID, CustomerFname, CustomerLname, CustomerEmail, CustomerPhone, ArchiveTimestamp 
                                    FROM customer_info_archive 
                                    WHERE CustomerID = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $inputemployeeid);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            echo '<table class="action-logs-table">';
                            echo '<tr>';
                            echo '<th>Customer Archive ID</th>';
                            echo '<th>Customer ID</th>';
                            echo '<th>Customer First Name</th>';
                            echo '<th>Customer Last Name</th>';
                            echo '<th>Customer Email</th>';
                            echo '<th>Customer Phone</th>';
                            echo '<th>Archive Timestamp</th>';
                            echo '</tr>';

                            // Fetch and display each row of the results
                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($row['customerArchiveID']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['CustomerID']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['CustomerFname']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['CustomerLname']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['CustomerEmail']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['CustomerPhone']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['ArchiveTimestamp']) . '</td>';
                                echo '</tr>';
                            }

                            echo '</table>';
                        } else {
                            // echo 'No results found for the specified CustomerID.';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- <style>
        .action-logs-table {
            width: 100%;
            border-collapse: collapse;
        }

        .action-logs-table,
        .action-logs-table th,
        .action-logs-table td {
            border: 1px solid black;
        }

        .action-logs-table th,
        .action-logs-table td {
            padding: 8px;
            text-align: left;
        }

        .action-logs-table th {
            background-color: #f2f2f2;
        }
    </style> -->

<?php
} else {
    echo 'Access Denied';
}

$conn->close();
?>