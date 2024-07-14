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
        $user['accountStatus'] = ($user['accountStatus'] == 'Activated') ?
            '<span class="status-active">Activated</span>' :
            '<span class="status-deactivated">Deactivated</span>';

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

$EmployeeWebID = $_GET['EmployeeWebID'];

?>

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
                    Person
                </i>
                <span class="">User Details</span>
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
                    <h1>
                        <?php
                        if (isset($EmployeeWebID)) {
                            echo "User #$EmployeeWebID";
                        } else {
                            echo "User Details";
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

            <div class="DETAILS_CONTAINER_ROW columns-1">
                <div class="DETAILS_CONTAINER_ROW_LEFT">
                    <div class="GLOBAL_SUBHEADER_TITLE">
                        <h1>Customer Information</h1>
                    </div>
                    <div class="DETAILS_CONTAINER_ROW_TABLE GLOBAL_BOX_DIV">
                        <table>
                            <tr>
                                <td>Username</td>
                                <td><?= htmlspecialchars($user['username']); ?></td>
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
            </div>


        </div>
    </div>

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
            $user['accountStatus'] = ($user['accountStatus'] == 'Activated') ?
                '<span class="status-active">Activated</span>' :
                '<span class="status-deactivated">Deactivated</span>';

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
    ?>

    <!-- <div class="GLOBAL_PAGE">
    <?php
    include_once __DIR__ . "/../../../components/sidebar.php";

    $username = $_SESSION['username'];
    $profilePicture = isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : '';
    ?>
    <div class="GLOBAL_PAGE_CONTAINER">
        <div class="GLOBAL_HEADER flex items-center justify-between">
            <div class="GLOBAL_HEADER_TITLE flex items-center">
                <i class="material-symbols-rounded text-4xl">
                    person
                </i>
                <span class="ml-3 text-2xl font-semibold">User Details</span>
            </div>
            <div class="GLOBAL_HEADER_USER">
                <div class="GLOBAL_HEADER_COLUMN">
                    <p>Hey, <strong><?php echo htmlspecialchars($username); ?></strong></p>
                    <p>Admin</p>
                </div>
                <img src="../../../<?php echo htmlspecialchars($profilePicture); ?>" alt="Profile Picture">
            </div>
        </div>

        <div class="user-details-container">
            <h1>User Details</h1>
            <div class="user-details">
                <img src="../../../<?php echo htmlspecialchars($user['ProfilePicturePath']); ?>" alt="Profile Picture" class="profile-picture">
                <p><strong>ID:</strong> <?php echo htmlspecialchars($user['EmployeeWebID']); ?></p>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                <p><strong>Last Name:</strong> <?php echo htmlspecialchars($user['EmployeeLastname']); ?></p>
                <p><strong>First Name:</strong> <?php echo htmlspecialchars($user['EmployeeFirstname']); ?></p>
                <p><strong>Hire Date:</strong> <?php echo htmlspecialchars($user['HireDate']); ?></p>
                <p><strong>Gender:</strong> <?php echo htmlspecialchars($user['Gender']); ?></p>
                <p><strong>Position:</strong> <?php echo htmlspecialchars($user['Position']); ?></p>
                <p><strong>Status:</strong> <?php echo $user['accountStatus']; ?></p>
            </div>
        </div>
    </div>


    <style>
        .user-details-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .user-details {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .profile-picture {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .user-details p {
            margin: 5px 0;
        }

        .status-active {
            color: green;
            font-weight: bold;
        }

        .status-deactivated {
            color: red;
            font-weight: bold;
        }
    </style>


</div> -->