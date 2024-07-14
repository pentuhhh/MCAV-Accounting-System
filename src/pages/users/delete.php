<?php
// delete_user.php
require "../utilities/db-connection.php"; // Adjust the path as needed

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /receipts");
    exit();
}

require_once "../utilities/db-connection.php";

$sql = "UPDATE employee_credentials SET AccountStatus = 'Deactivated' WHERE EmployeeWebID = {$_POST["id"]}";

$result = $conn->query($sql);
$conn->close();

header("Location: /users");
exit();

