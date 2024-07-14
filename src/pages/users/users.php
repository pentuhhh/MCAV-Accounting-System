<?php
require "../utilities/db-connection.php"; // Adjust path as necessary

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    $sql = "SELECT 
        ec.EmployeeWebID,
        ec.username,
        ei.EmployeeLastname,
        ei.EmployeeFirstname,
        ei.ProfilePicturePath,
        ei.Gender,
        ei.Position,
        ei.HireDate,
        ec.accountStatus
    FROM 
        employee_info ei
    JOIN 
        employee_credentials ec ON ei.EmployeeID = ec.EmployeeID
    WHERE 
        ei.IsRemoved = 0 AND (ec.username LIKE ? OR ei.EmployeeLastname LIKE ?)
    ORDER BY 
        ei.EmployeeLastname ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(["%$search%", "%$search%"]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);


    echo json_encode($data);
}



