<?php
require "../utilities/db-connection.php"; // Adjust path as necessary

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    $sql = "SELECT 
        pr.ReceiptID,
        pr.ReceiptImagePath,
        pr.ReceiptAmountPaid,
        pr.PaymentDate,
        pr.PaymentProcessor,
        pr.PaymentProcessorReferenceNumber,
        pl.PlanID
    FROM 
        Payment_Receipts pr
    JOIN
        payment_Plans pl ON pr.PlanID = pl.PlanID
    WHERE 
        pr.IsRemoved = 0 AND (pl.PlanID LIKE ? OR pr.PaymentProcessor LIKE ?)
    ORDER BY 
        pr.PaymentDate DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(["%$search%", "%$search%"]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['ReceiptID'])) {
        $receiptID = intval($_POST['ReceiptID']);
        

        $employeeWebID = $_SESSION['employeeWebID'];
        
        $sql = "INSERT INTO action_logs (EmployeeWebID, UserAction, affectedentitytype, affectedentity, Logtimestamp)
                VALUES (?, 'Delete', 'Payment_Receipts', ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $employeeWebID, $receiptID);
        $stmt->execute();

        // Prepare and execute the delete statement
        $sql = "UPDATE Payment_Receipts SET IsRemoved = 1 WHERE ReceiptID = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$receiptID]);

        echo json_encode(['status' => 'success']);
    }
}
