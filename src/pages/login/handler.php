<?php
require_once "../utilities/db-connection.php";

// echo "Session started. Session ID: " . session_id() . "<br>";

// if (isset($_SESSION['username'])) {
//     echo "User is already logged in as: " . $_SESSION['username'] . "<br>";
//     echo "Redirecting to dashboard in 5 seconds...";
//     header("Refresh: 5; URL=/dashboard");
//     exit();
// }

// Get credentials from POST data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if $conn is defined and connected
    if (!isset($conn) || $conn->connect_error) {
        die("Database connection failed: " . ($conn->connect_error ?? "Connection variable not set"));
    }

    // Prepare and execute query
    $query = "SELECT * FROM employee_credentials WHERE username = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Verify password (assuming the password is hashed)
            if (password_verify($password, $row['employee_Password'])) {
                // Successful login
                $_SESSION['username'] = $username;
                $_SESSION['user_level'] = $row['UserLevel'];
                $_SESSION['account_status'] = $row['accountStatus'];
                // echo "Login successful.";
                // Redirect to a logged-in page or dashboard
                header("Location: /dashboard");
                exit();
            } else {
                $_SESSION['error']['password'] = "Invalid password.";
                header("Location: /login");
                exit();
            }
        } else {
            $_SESSION['error']['username'] = "Invalid email.";
            header("Location: /login");
            exit();
        }

        $stmt->close();
    } else {
        echo "Query preparation failed: " . $conn->error;
    }

    // Don't close the connection here if it's needed elsewhere in the script
    // $conn->close();
} else {
    echo "Invalid request method.";
}
