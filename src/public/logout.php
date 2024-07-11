<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Starting logout process...<br>";

session_start();
echo "Session started. Session ID: " . session_id() . "<br>";

if (isset($_SESSION['username'])) {
    echo "User was logged in as: " . $_SESSION['username'] . "<br>";
} else {
    echo "No user was logged in.<br>";
}

session_destroy();
echo "Session destroyed.<br>";

echo "Redirecting to login page in 5 seconds...";
header("Refresh: 5; URL=/login");
exit();
?>