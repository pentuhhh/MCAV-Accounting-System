<?php
require "../utilities/db-connection.php"; 
$username = $_SESSION['username'];

// get userlevel

$sql = "select UserLevel from employee_credentials where username = '$username';";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$userlevel = $row['UserLevel'];

$profilePicture = isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : '';

?>

<div class="GLOBAL_PAGE">
    <?php
    include_once __DIR__ . "/../../components/sidebar.php";
    ?>

    <div class="GLOBAL_PAGE_CONTAINER">
        <div class="GLOBAL_HEADER">
            <div class="GLOBAL_HEADER_TITLE">
                <i class="material-symbols-rounded text-[42px]">
                    Person
                </i>
                <span class="">Admin</span>
            </div>
            <div class="GLOBAL_HEADER_USER">
                <div class="GLOBAL_HEADER_COLUMN">
                    <p>Hey, <strong><?php echo htmlspecialchars($username); ?></strong></p>
                    <p><?php echo htmlspecialchars($userlevel) ?></p>
                </div>
                <img src="<?php echo htmlspecialchars($profilePicture); ?>" alt="Profile Picture">
            </div>
        </div>


    Login Logs : <a href="admin/login-logs">View</a><br>
    Action Logs : <a href="admin/action-logs">View</a><br>

    File History : <a href="admin/file-history">View</a><br>

    Delete Logs : <a href="admin/delete-logs">View</a><br>


    </div>
</div>