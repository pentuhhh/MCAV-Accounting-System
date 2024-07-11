<?php
require "../utilities/db-connection.php";

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Data for employee_info
    $email = $_POST['email'];
    $first_name = $_POST['first-name'];
    $last_name = $_POST['last-name'];
    $suffix = $_POST['suffix'] ?? ''; // Optional field
    $contact_number = $_POST['contact-number'];
    $address = $_POST['address'];
    $hire_date = $_POST['hire-date'];
    $birth_date = $_POST['birth-date'];
    $gender = $_POST['gender']; // Now 'M' or 'F'
    $position = $_POST['position']; // Capture position from the form
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $permission = $_POST['permission'] == 'admin' ? 1 : 0;

    // File upload handling
    $profile_picture_path = ''; // Default value
    if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] == 0) {
        $file = $_FILES['profilePicture'];

        // Get file info
        $fileName = basename($file['name']);
        $fileTmpName = $file['tmp_name'];
        $fileType = $file['type'];

        // Define the allowed file types
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

        // Check if the file type is allowed
        if (in_array($fileType, $allowedTypes)) {
            // Define the target directory
            $targetDir = __DIR__ . '/../../public/assets/';

            // Ensure the target directory exists
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            // Define the target file path
            $targetFile = $targetDir . $fileName;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($fileTmpName, $targetFile)) {
                $profile_picture_path = 'assets/' . $fileName; // relative path for storing in the database
            } else {
                die("Error: There was a problem uploading your file.");
            }
        } else {
            die("Error: Invalid file type.");
        }
    }
    // else {
    //     die("Error: " . $_FILES['profilePicture']['error']);
    // }

    // Insert into employee_info
    $sql_info = "INSERT INTO employee_info (
                    ProfilePicturePath, EmployeeFirstname, EmployeeLastname, EmployeeHireDate, Gender, Position, WebUserLevel, IsRemoved
                ) VALUES (
                    '$profile_picture_path', '$first_name', '$last_name', '$hire_date', '$gender', '$position', '$permission', '0'
                )";

    if ($conn->query($sql_info) === TRUE) {
        $employee_id = $conn->insert_id;

        // Insert into employee_credentials
        $sql_credentials = "INSERT INTO employee_credentials (
                                PermissionsID, EmployeeID, username, employee_Password, UserLevel, accountStatus
                            ) VALUES (
                                '1', '$employee_id', '$email', '$hashed_password', '$permission', 'Activated'
                            )";

        if ($conn->query($sql_credentials) === TRUE) {
            echo "Registration successful";
        } else {
            echo "Error: " . $sql_credentials . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $sql_info . "<br>" . $conn->error;
    }
}

$conn->close();

?>