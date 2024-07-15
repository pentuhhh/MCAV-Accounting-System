<?php
require "../utilities/db-connection.php"; // Adjust the path as needed

if (isset($_GET['EmployeeWebID'])) {
    $EmployeeWebID = $_GET['EmployeeWebID'];

    $sql = "SELECT 
                    ec.EmployeeWebID,
                    ec.username,
                    ei.EmployeeLastname,
                    ei.EmployeeFirstname,
                    ei.ProfilePicturePath,
                    ei.Gender,
                    ei.Position,
                    ei.EmployeeHireDate AS HireDate,
                    ec.accountStatus
                FROM 
                    employee_info ei
                JOIN 
                    employee_credentials ec ON ei.EmployeeID = ec.EmployeeID
                WHERE 
                    ec.EmployeeWebID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $EmployeeWebID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Modify gender display
        $user['Gender'] = ($user['Gender'] == 'M') ? 'Male' : 'Female';

        // Modify account status display
        $user['accountStatus'] = ($user['accountStatus'] == 'Activated') ? 'Activated' : 'Deactivated';

        $defaultImagePath = "/assets/defaultProfilePicture.jpg";
        if ($user['ProfilePicturePath'] === "") {
            $user['ProfilePicturePath'] = $defaultImagePath;
        }
    } else {
        echo "<p>User not found.</p>";
        exit;
    }
} else {
    echo "<p>No user ID provided.</p>";
    exit;
}

$username = $_SESSION['username'];
$profilePicture = isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : '';
?>

<script>
    function reloadPage() {
        // Reload the page
        window.location.href = window.location.href.split('?')[0];
    }
</script>

<div class="GLOBAL_PAGE">
    <?php include_once __DIR__ . "/../../../components/sidebar.php"; ?>

    <div class="GLOBAL_PAGE_CONTAINER">
        <div class="GLOBAL_HEADER">
            <div class="GLOBAL_HEADER_TITLE">
                <i class="material-symbols-rounded text-[42px]">
                    person
                </i>
                <span>User Details</span>
            </div>
            <div class="GLOBAL_HEADER_USER">
                <div class="GLOBAL_HEADER_COLUMN">
                    <p>Hey, <strong><?php echo htmlspecialchars($username); ?></strong></p>
                    <p>Admin</p>
                </div>
                <img src="../../<?php echo htmlspecialchars($profilePicture); ?>" alt="Profile Picture">
            </div>
        </div>

        <div class="DETAILS_CONTAINER">
            <div class="GLOBAL_SUBHEADER">
                <div class="DETAILS_ORDERID">
                    <h1>User #<?php echo htmlspecialchars($EmployeeWebID); ?></h1>
                </div>
                <a onclick="window.history.back()">
                    <i class="material-symbols-rounded text-[#7F7F7F] text-3xl">
                        arrow_back
                    </i>
                </a>
            </div>

            <div class="DETAILS_CONTAINER_ROW_GROW">
                <div class="DETAILS_CONTAINER_ROW_LEFT">
                    <div class="GLOBAL_SUBHEADER_TITLE">
                        <h1>User Information</h1>
                    </div>
                    <div class="DETAILS_CONTAINER_ROW_TABLE GLOBAL_BOX_DIV w-full">
                        <table>
                            <tr>
                                <td>Username</td>
                                <td><?= htmlspecialchars($user['username']); ?></td>
                            </tr>
                            <tr>
                                <td>Last Name</td>
                                <td><?= htmlspecialchars($user['EmployeeLastname']); ?></td>
                            </tr>
                            <tr>
                                <td>First Name</td>
                                <td><?= htmlspecialchars($user['EmployeeFirstname']) ?></td>
                            </tr>
                            <tr>
                                <td>Hire Date</td>
                                <td><?= htmlspecialchars($user['HireDate']) ?></td>
                            </tr>
                            <tr>
                                <td>Gender</td>
                                <td><?= htmlspecialchars($user['Gender']) ?></td>
                            </tr>
                            <tr>
                                <td>Position</td>
                                <td><?= htmlspecialchars($user['Position']) ?></td>
                            </tr>
                            <tr>
                                <td>Account Status</td>
                                <td><?= htmlspecialchars($user['accountStatus']) ?></td>
                            </tr>
                        </table>
                        <div class="DETAILS_CONTAINER_ROW_BUTTON">
                            <form method="post" onsubmit="reloadPage()">
                                <input type="hidden" name="action" value="editUser">
                                <input type="hidden" name="EmployeeWebID" value="<?= htmlspecialchars($EmployeeWebID); ?>">
                                <button type="submit" class="GLOBAL_BUTTON_BLUE">Edit Info</button>
                            </form>
                            <form method="post" onsubmit="reloadPage()">
                                <input type="hidden" name="action" value="removeUser">
                                <input type="hidden" name="EmployeeWebID" value="<?= htmlspecialchars($EmployeeWebID); ?>">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit User Form -->
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'editUser') {
                // Display the edit form for user
                $EmployeeWebID = htmlspecialchars($_POST['EmployeeWebID']);
                $sql = "SELECT 
                            ec.username,
                            ei.EmployeeLastname,
                            ei.EmployeeFirstname,
                            ei.Gender,
                            ei.Position,
                            ec.accountStatus
                        FROM 
                            employee_info ei
                        JOIN 
                            employee_credentials ec ON ei.EmployeeID = ec.EmployeeID
                        WHERE 
                            ec.EmployeeWebID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $EmployeeWebID);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $userRow = $result->fetch_assoc();
                    $username = htmlspecialchars($userRow['username']);
                    $lastName = htmlspecialchars($userRow['EmployeeLastname']);
                    $firstName = htmlspecialchars($userRow['EmployeeFirstname']);
                    $gender = htmlspecialchars($userRow['Gender']);
                    $position = htmlspecialchars($userRow['Position']);
                    $accountStatus = htmlspecialchars($userRow['accountStatus']);
                }
                echo <<<HTML
                    <div class="POPUP_CONTAINER">
                        <div class="POPUP_CONTAINER_BOX GLOBAL_BOX_DIV flex flex-col gap-4 w-full">
                            <a href="/users/details/?EmployeeWebID={$EmployeeWebID}" class="absolute top-2 right-4 text-2xl text-gray-500 cursor-pointer">&times;</a>
                            <h1 class="text-lg font-bold">Edit User Information</h1>
                            <form method="post" class="flex flex-col gap-4" onsubmit="reloadPage()">
                                <input type="hidden" name="action" value="saveUser">
                                <input type="hidden" name="EmployeeWebID" value="{$EmployeeWebID}">
                                <input type="text" name="editUsername" value="{$username}" placeholder="Username">
                                <input type="text" name="editLastName" value="{$lastName}" placeholder="Last Name">
                                <input type="text" name="editFirstName" value="{$firstName}" placeholder="First Name">
                                <select name="editGender">
                                    <option value="M" <?= $gender == 'M' ? 'selected' : ''?>Male</option>
                                    <option value="F" <?= $gender == 'F' ? 'selected' : ''?>Female</option>
                                </select>
                                <input type="text" name="editPosition" value="{$position}" placeholder="Position">
                                <select name="editAccountStatus">
                                    <option value="Activated" <?= $accountStatus == 'Activated' ? 'selected' : ''?>Activated</option>
                                    <option value="Deactivated" <?= $accountStatus == 'Deactivated' ? 'selected' : ''?>Deactivated</option>
                                </select>
                                <button type="submit" class="GLOBAL_BUTTON_BLUE flex-grow-0 w-min">Save</button>
                            </form>
                        </div>
                    </div>
                HTML;
            }
            ?>

            <!-- Save User Info -->
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'saveUser') {
                // Retrieve POST data
                $EmployeeWebID = htmlspecialchars($_POST['EmployeeWebID']);
                $editedUsername = htmlspecialchars($_POST['editUsername']);
                $editedLastName = htmlspecialchars($_POST['editLastName']);
                $editedFirstName = htmlspecialchars($_POST['editFirstName']);
                $editedGender = htmlspecialchars($_POST['editGender']);
                $editedPosition = htmlspecialchars($_POST['editPosition']);
                $editedAccountStatus = htmlspecialchars($_POST['editAccountStatus']);

                // Update the user information in the database
                $sql = "UPDATE 
                            employee_info ei
                        JOIN 
                            employee_credentials ec ON ei.EmployeeID = ec.EmployeeID
                        SET 
                            ec.username = ?, 
                            ei.EmployeeLastname = ?, 
                            ei.EmployeeFirstname = ?, 
                            ei.Gender = ?, 
                            ei.Position = ?, 
                            ec.accountStatus = ?
                        WHERE 
                            ec.EmployeeWebID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param(
                    "ssssssi",
                    $editedUsername,
                    $editedLastName,
                    $editedFirstName,
                    $editedGender,
                    $editedPosition,
                    $editedAccountStatus,
                    $EmployeeWebID
                );
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    echo "<p>User information updated successfully.</p>";
                } else {
                    echo "<p>Failed to update user information.</p>";
                }

                $stmt->close();
                $conn->close();
            }
            ?>
        </div>
    </div>
</div>
