<!DOCTYPE html>
<html>

<head>
    <title>Orders Page</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
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

    <h2>Orders Page</h2>

    <table id="ordersTable">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Order Date</th>
                <th>Amount</th>
                <th>Order Deadline</th>
                <th>Order Status</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data rows will be inserted here -->
        </tbody>
    </table>

    <div class="pagination">
        <button onclick="prevPage()">Previous</button>
        <span id="pageButtons"></span>
        <button onclick="nextPage()">Next</button>
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
                    o.OrderID,      
                    CONCAT(c.CustomerFname, ' ', c.CustomerLname) AS CustomerName,           
                    o.OrderStartDate,
                    p.totalamount,      
                    o.OrderDeadline,      
                    CASE
                        WHEN o.OrderStatusCode = 1 THEN 'Pending'
                        WHEN o.OrderStatusCode = 2 THEN 'Started'
                        WHEN o.OrderStatusCode = 3 THEN 'Completed'
                        ELSE 'Unknown'
                    END AS Status
                FROM      
                    orders o     
                INNER JOIN customers c ON o.customerid = c.customerID
                INNER JOIN payment_plans p ON p.orderID = o.orderID      
                WHERE o.isremoved = 0 
                ORDER BY o.orderId ASC;";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $rows = [];
                while ($row = $result->fetch_assoc()) {
                    $rows[] = json_encode($row);
                }
                echo implode(",", $rows);
            }
            $conn->close();
            ?>
        ];

        /*  Pagination Logic */

        let currentPage = 1;
        const rowsPerPage = 5;

        function displayTable(page) {
            const tableBody = document.getElementById('ordersTable').getElementsByTagName('tbody')[0];
            tableBody.innerHTML = "";
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            const paginatedItems = data.slice(start, end);

            paginatedItems.forEach(item => {
                const row = document.createElement('tr');
                Object.keys(item).forEach(key => {
                    const cell = document.createElement('td');
                    if (key === 'OrderID') {
                        const link = document.createElement('a');
                        link.href = `orderdetails.php?orderID=${item[key]}`;
                        link.textContent = item[key];
                        cell.appendChild(link);
                    } else {
                        cell.textContent = item[key];
                    }
                    row.appendChild(cell);
                });
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

        function goToPage(page) {
            currentPage = page;
            displayTable(currentPage);
        }

        function updatePageButtons() {
            const pageButtonsContainer = document.getElementById('pageButtons');
            pageButtonsContainer.innerHTML = '';
            const totalPages = Math.ceil(data.length / rowsPerPage);
            for (let i = 1; i <= totalPages; i++) {
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