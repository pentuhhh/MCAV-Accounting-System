<?php
session_start();
require_once "../utilities/db-connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!isset($conn) || $conn->connect_error) {
        die("Database connection failed: " . ($conn->connect_error ?? "Connection variable not set"));
    }

    // Prepare and execute query to fetch user credentials
    $query = "SELECT * FROM employee_credentials WHERE username = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row['employee_Password'])) {
                // Fetch additional user info
                $employeeWebID = $row['EmployeeWebID'];
                $employeeID = $row['EmployeeID'];
                $infoQuery = "SELECT ProfilePicturePath FROM employee_info WHERE EmployeeID = ?";
                $infoStmt = $conn->prepare($infoQuery);

                if ($infoStmt) {
                    $infoStmt->bind_param('i', $employeeID);
                    $infoStmt->execute();
                    $infoResult = $infoStmt->get_result();

                    if ($infoResult->num_rows > 0) {
                        $infoRow = $infoResult->fetch_assoc();
                        $_SESSION['profile_picture'] = $infoRow['ProfilePicturePath'];
                    }

                    $infoStmt->close();
                }

                // Successful login
                $_SESSION['username'] = $username;
                $_SESSION['employeeID'] = $employeeID;
                $_SESSION['user_level'] = $row['UserLevel'];
                $_SESSION['account_status'] = $row['accountStatus'];

                header("Location: /dashboard");
                exit();
            } else {
                $_SESSION['error']['password'] = "Invalid password.";
                header("Location: /login");
                exit();
            }
        } else {
            $_SESSION['error']['username'] = "Invalid username.";
            header("Location: /login");
            exit();
        }

        $stmt->close();
    } else {
        echo "Query preparation failed: " . $conn->error;
    }
} else {
    echo "Invalid request method.";
}
