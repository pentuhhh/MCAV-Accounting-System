<div class="GLOBAL_PAGE flex">
    <?php
    include_once __DIR__ . "/../../components/sidebar.php";

    $username = $_SESSION['username'];
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
                    <p>Admin</p>
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
                    r.ReceiptID,
                    r.PlanID AS OrderID,
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
            const deleteButton = document.createElement('button');
            deleteButton.textContent = 'Delete';
            deleteButton.classList.add('text-[#DF166E]');
            deleteButton.onclick = function() {
                if (confirm('Are you sure you want to delete this row?')) {
                    // Add delete functionality here
                }
            };
            actionCell.appendChild(deleteButton);
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
        filteredData = data.filter(item => {
            return item.ReceiptID.toString().toLowerCase().includes(query) ||
                item.OrderID.toString().toLowerCase().includes(query) ||
                item.PaymentMethod.toLowerCase().includes(query) ||
                item.AmountPaid.toString().toLowerCase().includes(query) ||
                item.PaymentDate.toLowerCase().includes(query) ||
                item.ReferenceNumber.toLowerCase().includes(query);
        });
        displayTable(1);
    }

    document.getElementById('searchInput').addEventListener('input', function() {
        filterData(this.value);
    });

    // Sorting functionality
    document.querySelectorAll('.sortable').forEach(header => {
        header.addEventListener('click', function() {
            const column = this.dataset.column;
            const direction = this.dataset.dir;
            const isNumeric = column === 'AmountPaid' || column === 'ReferenceNumber';

            // Reset sort icons
            document.querySelectorAll('.sort-icon').forEach(icon => {
                icon.innerHTML = '';
            });

            // Set sorting direction
            this.dataset.dir = direction === 'asc' ? 'desc' : 'asc';
            const newDirection = this.dataset.dir;

            // Update sort icon
            const sortIcon = this.querySelector('.sort-icon');
            sortIcon.innerHTML = newDirection === 'asc' ? '&uarr;' : '&darr;';

            // Sort the data
            filteredData.sort((a, b) => {
                const aValue = isNumeric ? parseInt(a[column]) : a[column];
                const bValue = isNumeric ? parseInt(b[column]) : b[column];

                if (newDirection === 'asc') {
                    return aValue - bValue;
                } else {
                    return bValue - aValue;
                }
            });

            // Redisplay table with sorted data
            displayTable(currentPage);
        });
    });

    window.onload = function() {
        displayTable(currentPage);
    };
</script>