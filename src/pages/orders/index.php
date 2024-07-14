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
