<!DOCTYPE html>
<html>
<head>
    <title>Payment Receipts</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .pagination {
            margin: 20px 0;
            text-align: center;
        }
        .pagination button {
            padding: 10px 20px;
            margin: 0 5px;
        }
    </style>
</head>
<body>

<h2>Payment Receipts</h2>

<table id="receiptsTable">
    <thead>
        <tr>
            <th>Receipt ID</th>
            <th>Order ID</th>
            <th>Payment Method</th>
            <th>Receipt Amount Paid</th>
            <th>Payment Date</th>
        </tr>
    </thead>
    <tbody>
        <!-- Data rows will be inserted here -->
    </tbody>
</table>

<div class="pagination">
    <button onclick="firstPage()">First</button>
    <button onclick="prevPage()">Previous</button>
    <span id="pageButtons"></span>
    <button onclick="nextPage()">Next</button>
    <button onclick="lastPage()">Last</button>
</div>

<script>
    const data = [
        <?php
        $servername = "localhost";
        $username = "MCAVDB";
        $password = "password1010";
        $dbname = "MCAV";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT
                    r.ReceiptID,
                    p.OrderID,
                    p.PaymentMethod,
                    r.ReceiptAmountPaid,
                    r.PaymentDate
                FROM
                    Payment_Receipts r
                INNER JOIN payment_plans p ON r.PlanID = p.PlanID
                WHERE r.IsRemoved = 0
                ORDER BY r.ReceiptID ASC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $rows = [];
            while($row = $result->fetch_assoc()) {
                $rows[] = json_encode($row);
            }
            echo implode(",", $rows);
        }
        $conn->close();
        ?>
    ];

    let currentPage = 1;
    const rowsPerPage = 5;
    const maxPageButtons = 5;

    function displayTable(page) {
        const tableBody = document.getElementById('receiptsTable').getElementsByTagName('tbody')[0];
        tableBody.innerHTML = "";
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const paginatedItems = data.slice(start, end);

        paginatedItems.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.ReceiptID}</td>
                <td>${item.OrderID}</td>
                <td>${item.PaymentMethod}</td>
                <td>${item.ReceiptAmountPaid}</td>
                <td>${item.PaymentDate}</td>
            `;
            tableBody.appendChild(row);
        });
        updatePageButtons();
    }

    function prevPage() {
        if (currentPage > 1) {
            currentPage--;
            displayTable(currentPage);
        }
    }

    function nextPage() {
        if (currentPage * rowsPerPage < data.length) {
            currentPage++;
            displayTable(currentPage);
        }
    }

    function firstPage() {
        currentPage = 1;
        displayTable(currentPage);
    }

    function lastPage() {
        currentPage = Math.ceil(data.length / rowsPerPage);
        displayTable(currentPage);
    }

    function goToPage(page) {
        currentPage = page;
        displayTable(currentPage);
    }

    function updatePageButtons() {
        const pageButtonsContainer = document.getElementById('pageButtons');
        pageButtonsContainer.innerHTML = '';
        const totalPages = Math.ceil(data.length / rowsPerPage);
        let startPage = Math.max(currentPage - Math.floor(maxPageButtons / 2), 1);
        let endPage = Math.min(startPage + maxPageButtons - 1, totalPages);

        if (endPage - startPage < maxPageButtons - 1) {
            startPage = Math.max(endPage - maxPageButtons + 1, 1);
        }

        for (let i = startPage; i <= endPage; i++) {
            const button = document.createElement('button');
            button.textContent = i;
            button.onclick = (function(i) {
                return function() {
                    goToPage(i);
                };
            })(i);
            if (i === currentPage) {
                button.style.fontWeight = 'bold';
            }
            pageButtonsContainer.appendChild(button);
        }
    }

    window.onload = function() {
        displayTable(currentPage);
    };
</script>

</body>
</html>
