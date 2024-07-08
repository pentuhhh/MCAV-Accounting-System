<?php
function openConnection() {
    $servername = "localhost";
    $username = "MCAVDB";
    $password = "password1010";
    $dbname = "MCAV";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
?>
