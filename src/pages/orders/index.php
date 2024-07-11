<div class="GLOBAL_PAGE flex">
    <?php include_once __DIR__ . "/../../components/sidebar.php"; ?>

    <div class="GLOBAL_PAGE_CONTAINER">
        <div class="GLOBAL_HEADER flex items-center justify-between">
            <div class="GLOBAL_HEADER_TITLE flex items-center">
                <i class="material-symbols-rounded text-4xl">
                    receipt_long
                </i>
                <span class="ml-3 text-2xl font-semibold">Order Management</span>
                <a href="/orders/add-order2" class="GLOBAL_BUTTON_BLUE ml-5">Add order</a>
            </div>
            <div class="GLOBAL_HEADER_USER flex items-center">
                <div class="GLOBAL_HEADER_COLUMN text-right mr-4">
                    <p>Hey, <strong>Radon</strong></p>
                    <p>Admin</p>
                </div>
                <img src="/assets/JumanjiRon.png" alt="" class="w-10 h-10 rounded-full">
            </div>
        </div>

        <div class="ORDERS_SEARCH">
            <div class="columns-1">
                <a href="" class="ORDER_SEARCH_BUTTON">
                    <i class="material-symbols-rounded">
                        search
                    </i>
                </a>
                <input type="text" placeholder="Search">
            </div>
        </div>

        <div class="ORDERS_CONTENT">
            <div class="GLOBAL_TABLE">
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Order Date</th>
                            <th>Amount</th>
                            <th>Order Deadline</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="ordersTable">
                        <!-- Data rows will be inserted here -->
                    </tbody>
                </table>
            </div>
            <div class="pagination mt-4 text-end">
                <button onclick="prevPage()" class="">< Prev</button>
                <span id="pageButtons"></span>
                <button onclick="nextPage()" class="">Next ></button>
            </div>
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
            while ($row = $result->fetch_assoc()) {
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
                // cell.classList.add('border', 'p-2');
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
                button.classList.add('px-4', 'py-2', 'font-bold', 'text-white', 'duration-200', 'bg-[#00A1E2]', 'hover:bg-[#007BB5]', 'rounded-md', 'mx-1');
            } else {
                button.classList.add('px-4', 'py-2', 'bg-white', 'hover:bg-[#dddddd]', 'duration-200', 'rounded-md', 'mx-1');
            }
            pageButtonsContainer.appendChild(button);
        }
    }

    window.onload = function() {
        displayTable(currentPage);
    };
</script>