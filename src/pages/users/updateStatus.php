<?php
// delete_user.php
require "../utilities/db-connection.php"; // Adjust the path as needed

//Block Access

$employeeWebID = $_SESSION['employeeWebID'];

$sql = "select UserLevel from employee_credentials where employeeWebID = $employeeWebID;";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$userlevel = $row['UserLevel'];

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /receipts");
    exit();
}

require_once "../utilities/db-connection.php";
if($userlevel == 1){
    $sql = <<<SQL
        -- UPDATE employee_credentials SET AccountStatus = IF( AccountStatus = 'Deactivated', 'Activated', 'Deactivated') WHERE EmployeeWebID = {$_POST["id"]}
        UPDATE employee_credentials SET AccountStatus = CASE
        WHEN AccountStatus = 'deactivated' THEN 'Activated' 
        WHEN AccountStatus = 'Activated' THEN 'Deactivated' End
        WHERE EmployeeWebID = {$_POST["id"]}
        SQL;

    $result = $conn->query($sql);
    $conn->close();
    header("Location: /users");
} else {
    echo "access denied";
}



exit();

