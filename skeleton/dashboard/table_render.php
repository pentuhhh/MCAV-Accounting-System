<?php
function renderTable($caption, $headers, $data) {
    echo "<table>";
    echo "<caption>$caption</caption>";
    echo "<thead><tr>";
    foreach ($headers as $header) {
        echo "<th>$header</th>";
    }
    echo "</tr></thead>";
    echo "<tbody>";
    foreach ($data as $row) {
        echo "<tr>";
        foreach ($row as $cell) {
            echo "<td>$cell</td>";
        }
        echo "</tr>";
    }
    echo "</tbody></table>";
}

function renderRecentOrdersTable($caption, $result) {
    echo "<table>";
    echo "<caption>$caption</caption>";
    echo "<thead><tr>
            <th>Order ID</th>
            <th>Customer Name</th>
            <th>Order Date</th>
            <th>Amount</th>
            <th>Deadline</th>
            <th>Status</th>
          </tr></thead>";
    echo "<tbody>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['OrderID'] . "</td>";
            echo "<td>" . $row['CustomerName'] . "</td>";
            echo "<td>" . $row['OrderDate'] . "</td>";
            echo "<td>" . $row['Amount'] . "</td>";
            echo "<td>" . $row['Deadline'] . "</td>";
            echo "<td>" . $row['Status'] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No recent orders found.</td></tr>";
    }
    echo "</tbody></table>";
}
?>
