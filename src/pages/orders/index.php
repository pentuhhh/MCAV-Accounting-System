<div class="GLOBAL_PAGE flex">
    <?php
    include_once __DIR__ . "/../../components/sidebar.php";

    $username = $_SESSION['username'];
    $userlevel = $_SESSION['user_level'] == 1 ? 'Admin' : 'User';
    $profilePicture = isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : '';
    ?>

    <div class="GLOBAL_PAGE_CONTAINER">
        <div class="GLOBAL_HEADER flex items-center justify-between">
            <div class="GLOBAL_HEADER_TITLE flex items-center">
                <i class="material-symbols-rounded text-4xl">
                    receipt_long
                </i>
                <span class="ml-3 text-2xl font-semibold">Order Management</span>
                <a href="/orders/add-order2" class="GLOBAL_BUTTON_BLUE ml-5">Add order</a>
            </div>
            <div class="GLOBAL_HEADER_USER">
                <div class="GLOBAL_HEADER_COLUMN">
                    <p>Hey, <strong><?php echo htmlspecialchars($username); ?></strong></p>
                    <p><?php echo htmlspecialchars($userlevel) ?></p>
                </div>
                <img src="<?php echo htmlspecialchars($profilePicture); ?>" alt="Profile Picture">
            </div>
        </div>

        <div class="ORDERS_SEARCH">
            <div class="columns-1">
                <a href="" class="ORDER_SEARCH_BUTTON">
                    <i class="material-symbols-rounded">
                        search
                    </i>
                </a>
                <input type="text" placeholder="Search" id="searchInput">
            </div>
        </div>

        <div class="ORDERS_CONTENT">
            <div class="GLOBAL_TABLE">
                <table>
                    <thead>
                        <tr>
                            <th class="sortable" data-column="OrderID" data-dir="">Order ID <span class="sort-icon"></span></th>
                            <th class="sortable" data-column="CustomerName" data-dir="">Customer <span class="sort-icon"></span></th>
                            <th class="sortable" data-column="OrderStartDate" data-dir="">Order Date <span class="sort-icon"></span></th>
                            <th class="sortable" data-column="totalamount" data-dir="">Amount <span class="sort-icon"></span></th>
                            <th class="sortable" data-column="OrderDeadline" data-dir="">Order Deadline <span class="sort-icon"></span></th>
                            <th class="sortable" data-column="Status" data-dir="">Status <span class="sort-icon"></span></th>
                        </tr>
                    </thead>
                    <tbody id="ordersTable">
                        <!-- Data rows will be inserted here -->
                    </tbody>
                </table>
            </div>
            <div class="pagination mt-4 text-end">
                <button onclick="prevPage()" class="">
                    < Prev</button>
                        <span id="pageButtons"></span>
                        <button onclick="nextPage()" class="">Next ></button>
            </div>
        </div>
    </div>
</div>

<script>
    const data = [
        <?php
        require "../utilities/db-connection.php";

        $sql = "SELECT      
                    o.OrderID,      
                    CONCAT(c.CustomerFname, ' ', c.CustomerLname) AS CustomerName,           
                    o.OrderStartDate,
                    p.totalamount,      
                    o.OrderDeadline,      
                    CASE
                        WHEN o.OrderStatusCode = 0 THEN 'New'
                        WHEN o.OrderStatusCode = 1 THEN 'Pending'
                        WHEN o.OrderStatusCode = 2 THEN 'Started'
                        WHEN o.OrderStatusCode = 3 THEN 'Completed'
                        WHEN o.OrderStatusCode = 4 THEN 'Cancelled'
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
    const rowsPerPage = 13;
    let filteredData = data;

    function displayTable(page) {
        const tableBody = document.getElementById('ordersTable');
        tableBody.innerHTML = "";

        if (filteredData.length === 0) {
            tableBody.innerHTML = "<tr><td colspan='6' class='text-center'>Order doesn't exist</td></tr>";
            document.getElementById('pageButtons').innerHTML = '';
            return;
        }

        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const paginatedItems = filteredData.slice(start, end);

        paginatedItems.forEach(item => {
            const row = document.createElement('tr');
            Object.keys(item).forEach(key => {
                const cell = document.createElement('td');
                if (key === 'OrderID') {
                    const link = document.createElement('a');
                    link.href = `orders/details/?orderID=${item[key]}`;
                    link.textContent = item[key];
                    link.classList.add('order-id-link');
                    cell.appendChild(link);
                } else {
                    cell.textContent = item[key];
                }

                if (key === 'Status') {
                    switch (item[key]) {
                        case 'Pending':
                            cell.classList.add('status-pending');
                            break;
                        case 'Started':
                            cell.classList.add('status-started');
                            break;
                        case 'Completed':
                            cell.classList.add('status-completed');
                            break;
                        default:
                            cell.classList.add('status-unknown');
                            break;
                    }
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
        if (currentPage * rowsPerPage < filteredData.length) {
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
        const totalPages = Math.ceil(filteredData.length / rowsPerPage);
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

    function filterData(query) {
        query = query.toLowerCase();
        filteredData = data.filter(item =>
            (Object.values(item).some((value) => {
                if (isNaN(value)) {
                    return value.toLowerCase().includes(query)
                } else {
                    return toString(value).toLowerCase().includes(query)
                }
            }))
        );
        displayTable(1);
    }

    function searchOrders() {
        const query = document.getElementById('searchInput').value;
        filterData(query);
    }

    document.getElementById('searchInput').addEventListener('input', function() {
        filterData(this.value);
    });

    // Sorting functionality
    const sortableColumns = document.querySelectorAll('.sortable');

    sortableColumns.forEach(column => {
        column.addEventListener('click', () => {
            const currentDirection = column.getAttribute('data-dir');
            const nextDirection = currentDirection === 'asc' ? 'desc' : 'asc';
            const columnName = column.getAttribute('data-column');

            // Update data array based on sorting
            filteredData.sort((a, b) => {
                if (!isNaN(a[columnName])) {
                    if (nextDirection === 'asc') {
                        return a[columnName] - b[columnName];
                    } else {
                        return b[columnName] - a[columnName];
                    }
                }

                if (nextDirection === 'asc') {
                    return a[columnName] > b[columnName] ? 1 : -1;
                } else {
                    return b[columnName] > a[columnName] ? 1 : -1;
                }
            });

            // Set the new sorting direction
            column.setAttribute('data-dir', nextDirection);

            // Reset other column directions
            sortableColumns.forEach(col => {
                if (col !== column) {
                    col.setAttribute('data-dir', '');
                }
            });

            // Refresh table display
            displayTable(currentPage);
        });
    });

    window.onload = function() {
        displayTable(currentPage);
    };
</script>