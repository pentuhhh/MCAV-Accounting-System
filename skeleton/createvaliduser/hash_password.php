<?php
// Database connection
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $employeeID = 1; // Change as per your requirement
        $permissionsID = 1; // Change as per your requirement

        // Generate hashed password using bcrypt
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Define account status (must match enum values in database)
        $accountStatus = 'Activated'; // Change as needed ('Activated' or 'Deactivated')

        // Sanitize inputs
        $username = $conn->real_escape_string($username);
        $accountStatus = $conn->real_escape_string($accountStatus);

        // Ensure hashed password fits the binary(60) format
        $hashed_password = str_pad(bin2hex($hashed_password), 120, '0');

        // Insert hashed password into employee_credentials table
        $sql = "INSERT INTO employee_credentials (PermissionsID, EmployeeID, username, employee_Password, UserLevel, accountStatus)
                VALUES ('$permissionsID', '$employeeID', '$username', X'$hashed_password', '0', '$accountStatus')";

        if ($conn->query($sql) === TRUE) {
            echo "Hashed Password for username '$username' inserted successfully.";
        } else {
            echo "Error inserting hashed password: " . $conn->error;
        }
    } else {
        echo "Username or password not provided.";
    }
}

$conn->close();
?>
