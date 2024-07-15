<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../utilities/db-connection.php";

// echo "Starting logout process...<br>";

session_start();
// echo "Session started. Session ID: " . session_id() . "<br>";

// if (isset($_SESSION['username'])) {
//     echo "User was logged in as: " . $_SESSION['username'] . "<br>";
// } else {
//     echo "No user was logged in.<br>";
// }

// Log action
$employeeWebID = $_SESSION['employeeWebID'];
$sql = "insert into action_logs (EmployeeWebID, UserAction, Logtimestamp)
values ('$employeeWebID', 'Logout', now());";
$conn->query($sql);



session_destroy();
session_destroy();
// echo "Session destroyed.<br>";

// echo "Redirecting to login page in 5 seconds...";
header("Location: /login");
exit();
?>