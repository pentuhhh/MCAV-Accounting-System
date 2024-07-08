<?php
function fetchMonthlySales($conn) {
    $query = "SELECT SUM(ReceiptAmountPaid) AS MonthlySales
              FROM Payment_Receipts
              WHERE PaymentDate >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
              AND PaymentDate <= CURDATE()";
    $result = $conn->query($query);
    return $result->fetch_assoc()['MonthlySales'];
}

function fetchTotalOrders($conn) {
    $query = "SELECT COUNT(OrderID) AS TotalOrders
              FROM orders
              WHERE isremoved = 0";
    $result = $conn->query($query);
    return $result->fetch_assoc()['TotalOrders'];
}

function fetchTotalSales($conn) {
    $query = "SELECT SUM(ReceiptAmountPaid) AS TotalSales
              FROM Payment_Receipts
              WHERE isremoved = 0";
    $result = $conn->query($query);
    return $result->fetch_assoc()['TotalSales'];
}

function fetchRecentOrders($conn) {
    $query = "SELECT o.orderID AS OrderID, CONCAT(c.customerFname, ' ', c.customerLname) AS CustomerName,
                     o.orderStartDate AS OrderDate, pp.TotalAmount AS Amount, o.OrderDeadline AS Deadline,
                     o.OrderStatusCode AS Status
              FROM orders o
              INNER JOIN payment_Plans pp ON pp.orderID = o.orderID
              INNER JOIN customers c ON o.customerID = c.customerID
              ORDER BY o.OrderDeadline ASC
              LIMIT 5";
    return $conn->query($query);
}
?>
