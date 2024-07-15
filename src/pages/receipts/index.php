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
                <i class="material-symbols-rounded text-4xl">payments</i>
                <span class="ml-3 text-2xl font-semibold">Receipts Management</span>
                <a href="/receipts/add-receipt/" class="GLOBAL_BUTTON_BLUE ml-5">Add receipt</a>
            </div>
            <div class="GLOBAL_HEADER_USER">
                <div class="GLOBAL_HEADER_COLUMN">
                    <p>Hey, <strong><?php echo htmlspecialchars($username); ?></strong></p>
                    <p><?php echo htmlspecialchars($userlevel) ?></p>
                </div>
                <img src="<?php echo htmlspecialchars($profilePicture); ?>" alt="Profile Picture">
            </div>
        </div>

        <div class="GLOBAL_ANALYTICS">
            <div class="GLOBAL_ANALYTICS_ROW">
                <div class="GLOBAL_ANALYTICS_CARD GLOBAL_BOX_DIV">
                    <div class="GLOBAL_ANALYTICS_CARD_TEXT">
                        <h1 class="GLOBAL_ANALYTICS_CARD_TITLE">Last Month's Income</h1>
                        <h1 class="GLOBAL_ANALYTICS_CARD_VALUE">
                            <?php
                            require_once "../utilities/db-connection.php";

                            $sql = <<<SQL
                                    SELECT SUM(ReceiptAmountPaid) AS total_income
                                    FROM Payment_Receipts
                                    WHERE
                                        PaymentDate BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
                                        AND CURDATE()
                                        AND IsRemoved = 0;
                                    SQL;
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();

                            echo "Php " . number_format(($row['total_income'] ?? 0), 2);
                            $conn->close();
                            ?>
                        </h1>
                    </div>
                    <div class="GLOBAL-ANALYTICS_CARD_ICON">
                        <!-- Icon for Last Month's Income -->
                    </div>
                </div>
                <div class="GLOBAL_ANALYTICS_CARD GLOBAL_BOX_DIV">
                    <div class="GLOBAL_ANALYTICS_CARD_TEXT">
                        <h1 class="GLOBAL_ANALYTICS_CARD_TITLE">This Month's Income</h1>
                        <h1 class="GLOBAL_ANALYTICS_CARD_VALUE">
                            <?php
                            require "../utilities/db-connection.php";

                            $sql = "SELECT SUM(ReceiptAmountPaid) AS total_income
                                    FROM Payment_Receipts
                                    WHERE YEAR(PaymentDate) = YEAR(CURDATE())
                                      AND MONTH(PaymentDate) = MONTH(CURDATE())
                                      AND IsRemoved = 0;";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            echo "Php " . number_format(($row['total_income'] ?? 0), 2);
                            $conn->close();
                            ?>
                        </h1>
                    </div>
                    <div class="GLOBAL-ANALYTICS_CARD_ICON">
                        <!-- Icon for This Month's Income -->
                    </div>
                </div>
                <div class="GLOBAL_ANALYTICS_CARD GLOBAL_BOX_DIV">
                    <div class="GLOBAL_ANALYTICS_CARD_TEXT">
                        <h1 class="GLOBAL_ANALYTICS_CARD_TITLE">Total Sales</h1>
                        <h1 class="GLOBAL_ANALYTICS_CARD_VALUE">
                            <?php
                            require "../utilities/db-connection.php";

                            $sql = "SELECT SUM(ReceiptAmountPaid) AS total_sales
                                    FROM Payment_Receipts
                                    WHERE IsRemoved = 0;";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            echo "Php " . number_format($row['total_sales'], 2);
                            $conn->close();
                            ?>
                        </h1>
                    </div>
                    <div class="GLOBAL-ANALYTICS_CARD_ICON">
                        <!-- Icon for Total Sales -->
                    </div>
                </div>
            </div>
        </div>

        <div class="ORDERS_SEARCH">
            <div class="columns-1">
                <a href="" class="ORDER_SEARCH_BUTTON">
                    <i class="material-symbols-rounded">search</i>
                </a>
                <input type="text" placeholder="Search" id="searchInput">
            </div>
        </div>

        <div class="ORDERS_CONTENT">
            <div class="GLOBAL_TABLE">
                <table>
                    <thead>
                        <tr>
                            <th class="sortable" data-column="ReceiptID" data-dir="">#</th>
                            <th class="sortable" data-column="OrderID" data-dir="">Plan ID</th>
                            <th class="sortable" data-column="PaymentMethod" data-dir="">Payment Processor</th>
                            <th class="sortable" data-column="AmountPaid" data-dir="">Amount Paid </th>
                            <th class="sortable" data-column="PaymentDate" data-dir="">Payment Date </th>
                            <th class="sortable" data-column="ReferenceNumber" data-dir="">Reference Number</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="receiptsTable">
                        <!-- Data rows will be inserted here -->
                    </tbody>
                </table>
            </div>
            <div class="pagination mt-4 text-end">
                <button onclick="prevPage()" class="">&lt; Prev</button>
                <span id="pageButtons"></span>
                <button onclick="nextPage()" class="">Next &gt;</button>
            </div>
        </div>
    </div>
</div>

<script>
    const data = [
        <?php
        require "../utilities/db-connection.php";

        $sql = "SELECT      
                    r.ReceiptID,
                    r.PlanID,
                    r.PaymentProcessor AS PaymentMethod,
                    r.ReceiptAmountPaid AS AmountPaid,
                    r.PaymentDate,
                    r.PaymentProcessorReferenceNumber AS ReferenceNumber
                FROM      
                    Payment_Receipts r
                WHERE r.IsRemoved = 0
                ORDER BY r.ReceiptID DESC;";
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
    const rowsPerPage = 8;
    let filteredData = data;

    function displayTable(page) {
        const tableBody = document.getElementById('receiptsTable');
        tableBody.innerHTML = "";

        if (filteredData.length === 0) {
            tableBody.innerHTML = "<tr><td colspan='7' class='text-center'>Receipt doesn't exist</td></tr>";
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
                cell.textContent = item[key];
                row.appendChild(cell);
            });

            const actionCell = document.createElement('td');
            const form = document.createElement('form');
            const deleteButton = document.createElement('button');

            form.action = "/receipts/delete";
            form.method = "POST";

            deleteButton.onclick = function() {
                if (confirm('Are you sure you want to delete this receipt?')) {
                    form.submit();
                }
            };
            deleteButton.type = 'submit';
            deleteButton.name = "id";
            deleteButton.value = item.ReceiptID;
            deleteButton.textContent = 'Delete';
            deleteButton.classList.add('text-[#DF166E]');

            form.appendChild(deleteButton);

            actionCell.appendChild(form);
            row.appendChild(actionCell);
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
            (Object.values(item).some((value) =>
                value.toLowerCase().includes(query)
            ))
        );
        displayTable(1);
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