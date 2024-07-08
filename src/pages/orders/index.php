
<div class="GLOBAL_PAGE flex">
    <?php include_once __DIR__ . "/../../components/sidebar.php"; ?>

    <div class="GLOBAL_PAGE_CONTAINER flex-1 p-6">
        <div class="GLOBAL_HEADER flex items-center justify-between mb-6">
            <div class="GLOBAL_HEADER_TITLE flex items-center">
                <i class="material-symbols-rounded text-4xl">
                    receipt_long
                </i>
                <span class="ml-3 text-2xl font-semibold">Order Management</span>
                <a href="/orders/add-new/customers" class="ml-7 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add order</a>
            </div>
            <div class="GLOBAL_HEADER_USER flex items-center">
                <div class="GLOBAL_HEADER_COLUMN text-right mr-4">
                    <p>Hey, <strong>Radon</strong></p>
                    <p>Admin</p>
                </div>
                <img src="/assets/JumanjiRon.png" alt="" class="w-10 h-10 rounded-full">
            </div>
        </div>

        <div class="ORDERS_SEARCH mb-6">
            <div class="relative">
                <input type="text" placeholder="Search" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring">
                <a href="#" class="absolute right-2 top-2 text-gray-500 hover:text-gray-700">
                    <i class="material-symbols-rounded">
                        search
                    </i>
                </a>
            </div>
        </div>

        <div class="ORDERS_CONTENT bg-white shadow rounded-lg p-6">
            <div class="GLOBAL_TABLE overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border p-2">Order ID</th>
                            <th class="border p-2">Customer</th>
                            <th class="border p-2">Order Date</th>
                            <th class="border p-2">Amount</th>
                            <th class="border p-2">Order Deadline</th>
                            <th class="border p-2">Status</th>
                            
                        </tr>
                    </thead>
                    <tbody id="ordersTable">
                        <!-- Data rows will be inserted here -->
                    </tbody>
                </table>
            </div>
        </div>

        <div class="pagination mt-4 text-center">
            <button onclick="prevPage()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded">Previous</button>
            <span id="pageButtons"></span>
            <button onclick="nextPage()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded">Next</button>
        </div>
    </div>
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
                ORDER BY o.orderId DESC;";
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

    function displayTable(page) {
        const tableBody = document.getElementById('ordersTable');
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
                cell.classList.add('border', 'p-2');
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
                button.classList.add('font-bold');
            }
            button.classList.add('px-4', 'py-2', 'bg-gray-200', 'hover:bg-gray-300', 'rounded', 'mx-1');
            pageButtonsContainer.appendChild(button);
        }
    }

    window.onload = function() {
        displayTable(currentPage);
    };
</script>
