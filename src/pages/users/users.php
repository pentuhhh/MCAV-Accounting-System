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
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['EmployeeWebID'])) {
        $employeeWebID = intval($_POST['EmployeeWebID']);

        // Prepare and execute the delete statement
        $sql = "UPDATE employee_info SET IsRemoved = 1 WHERE EmployeeWebID = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$employeeWebID]);

        echo json_encode(['status' => 'success']);
    }
}
