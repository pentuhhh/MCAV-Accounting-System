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
                    <h1>Login Logs</h1>
                    <a onclick="window.history.back(); return false;">
                        <i class="material-symbols-rounded text-[#7F7F7F] text-3xl">
                            arrow_back
                        </i>
                    </a>
                </div>

                <div class="GLOBAL_TABLE mb-8">
                    <?php
                    // Display the action logs table
                    $sql = "SELECT c.employeeid, CONCAT(e.employeeFirstname, ' ', e.employeeLastname) AS 'User Name', logtimestamp 
                        FROM action_logs a 
                        INNER JOIN employee_credentials c ON a.employeewebid = c.employeewebid 
                        INNER JOIN employee_info e ON e.Employeeid = c.employeeid 
                        WHERE useraction = 'login' OR useraction = 'logout'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo '<table border="1">';
                        echo '<tr>';
                        echo '<th>Employee ID</th>';
                        echo '<th>Employee Name</th>';
                        echo '<th>Log Timestamp</th>';
                        echo '</tr>';

                        // Fetch and display each row of the results
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row['employeeid']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['User Name']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['logtimestamp']) . '</td>';
                            echo '</tr>';
                        }

                        echo '</table>';
                    } else {
                        echo 'No results found.';
                    }
                    ?>
                </div>

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

                <!-- <br><br>Search by user (input EmployeeID):
                <div class="GLOBAL_TABLE">
                    <form id="searchid" method="post" action="">
                        <input type="number" name="employeeid" id="employeeid" placeholder="EmployeeID">
                        <input type="submit" class="GLOBAL_BUTTON_BLUE">
                    </form>
                </div> -->

                <div class="GLOBAL_TABLE mb-8">
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['employeeid'])) {
                        $inputemployeeid = $_POST['employeeid'];

                        // Display the action logs table for that user
                        $sql = "SELECT c.employeeid, CONCAT(e.employeeFirstname, ' ', e.employeeLastname) AS 'User Name', logtimestamp 
                                FROM action_logs a 
                                INNER JOIN employee_credentials c ON a.employeewebid = c.employeewebid 
                                INNER JOIN employee_info e ON e.Employeeid = c.employeeid 
                                WHERE (useraction = 'login' OR useraction = 'logout') AND c.employeeid = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $inputemployeeid);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            echo '<table border="1">';
                            echo '<tr>';
                            echo '<th>Employee Name</th>';
                            echo '<th>Log Timestamp</th>';
                            echo '</tr>';

                            // Fetch and display each row of the results
                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($row['User Name']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['logtimestamp']) . '</td>';
                                echo '</tr>';
                            }

                            echo '</table>';
                        } else {
                            echo 'No results found for the specified EmployeeID.';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    <?php
} else {
    echo 'Access Denied';
}

$conn->close();
    ?>