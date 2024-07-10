<?php
session_start();
require '../../../utilities/db_connection.php'; // Adjust path as needed

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = ? AND employee_Password = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $_SESSION['username'] = $username;
            header("Location: ../../../public/index.php?page=dashboard");
            exit();
        } else {
            echo "Invalid username or password.";
        }
        $stmt->close();
    }
}
?>