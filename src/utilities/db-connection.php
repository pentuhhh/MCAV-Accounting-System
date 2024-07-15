<?php
$servername = "localhost";
$dbusername = "MCAVDB";
$dbpassword = "password1010";
$dbname = "MCAV";

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>