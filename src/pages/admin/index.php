<?php
require "../utilities/db-connection.php";
$username = $_SESSION['username'];

// get userlevel

$sql = "select UserLevel from employee_credentials where username = '$username';";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$userlevel = $row['UserLevel'];

$userlevel2 = $_SESSION['user_level'] == 1 ? 'Admin' : 'User';
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
                    admin_panel_settings
                </i>
                <span class="">Admin</span>
            </div>
            <div class="GLOBAL_HEADER_USER">
                <div class="GLOBAL_HEADER_COLUMN">
                    <p>Hey, <strong><?php echo htmlspecialchars($username); ?></strong></p>
                    <p><?php echo htmlspecialchars($userlevel2) ?></p>
                </div>
                <img src="<?php echo htmlspecialchars($profilePicture); ?>" alt="Profile Picture">
            </div>
        </div>

        <div class="GLOBAL_PAGE_CONTAINER_CONTENT">
            <div class="GLOBAL_SUBHEADER">
                <h1>Admin Access</h1>
                <a onclick="window.history.back(); return false;">
                    <i class="material-symbols-rounded text-[#7F7F7F] text-3xl">
                        arrow_back
                    </i>
                </a>
            </div>
            <div class="flex flex-row justify-between columns-4 gap-5">
                <div class="flex flex-col w-full p-5 GLOBAL_BOX_DIV">
                    <h1 class="font-semibold text-lg pb-5">Login Logs</h1>
                    <a href="admin/login-logs" class="GLOBAL_BUTTON_BLUE text-center">View</a>
                </div>
                <div class="flex flex-col w-full p-5 GLOBAL_BOX_DIV">
                    <h1 class="font-semibold text-lg pb-5">Action Logs</h1>
                    <a href="admin/action-logs" class="GLOBAL_BUTTON_BLUE text-center">View</a>
                </div>
                <div class="flex flex-col w-full p-5 GLOBAL_BOX_DIV">
                    <h1 class="font-semibold text-lg pb-5">File History</h1>
                    <a href="admin/file-history" class="GLOBAL_BUTTON_BLUE text-center">View</a>
                </div>
                <div class="flex flex-col w-full p-5 GLOBAL_BOX_DIV">
                    <h1 class="font-semibold text-lg pb-5">Delete Logs</h1>
                    <a href="admin/delete-logs" class="GLOBAL_BUTTON_BLUE text-center">View</a>
                </div>
            </div>
            <!-- <h1>Login Logs</h1>
            <a href="admin/login-logs" class="GLOBAL_BUTTON_BLUE">View</a><br>
            Action Logs :
            <a href="admin/action-logs" class="GLOBAL_BUTTON_BLUE">View</a><br>

            File History :
            <a href="admin/file-history" class="GLOBAL_BUTTON_BLUE">View</a><br>

            Delete Logs :
            <a href="admin/delete-logs" class="GLOBAL_BUTTON_BLUE">View</a><br> -->
        </div>



    </div>
</div>