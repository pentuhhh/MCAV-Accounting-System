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
                    person
                </i>
                <span class="ml-3 text-2xl font-semibold">Users</span>
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
                            <th onclick="sortTable('EmployeeWebID')">#</th>
                            <th>Profile Picture</th>
                            <th onclick="sortTable('username')">Username</th>
                            <th onclick="sortTable('EmployeeLastname')">Last Name</th>
                            <th onclick="sortTable('EmployeeFirstname')">First Name</th>
                            <th onclick="sortTable('HireDate')">Hire Date</th>
                            <th onclick="sortTable('Gender')">Gender</th>
                            <th onclick="sortTable('Position')">Position</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="usersTable">
                        <!-- Table rows will be inserted here by JavaScript -->
                    </tbody>
                </table>
            </div>
            <div class="pagination mt-4 text-end">
                <button onclick="prevPage()">Prev</button>
                <span id="pageButtons"></span>
                <button onclick="nextPage()">Next</button>
            </div>
        </div>
    </div>
</div>

<script>
    const data = <?php
                    require "../utilities/db-connection.php"; // Adjust the path as needed

                    // Fetch user data from the database
                    $sql = "SELECT 
    ec.EmployeeWebID,
    ec.username,
    ei.EmployeeLastname,
    ei.EmployeeFirstname,
    ei.ProfilePicturePath,
    ei.Gender,
    ei.Position,
    ei.EmployeeHireDate AS HireDate,
    ec.accountStatus
    FROM 
        employee_info ei
    JOIN 
        employee_credentials ec ON ei.EmployeeID = ec.EmployeeID
    WHERE 
        ei.IsRemoved = 0";

                    $result = $conn->query($sql);

                    $users = [];

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Modify gender display
                            $row['Gender'] = ($row['Gender'] == 'M') ? 'Male' : 'Female';

                            // Modify account status display
                            $row['accountStatus'] = ($row['accountStatus'] == 'Activated') ?
                                '<span class="status-active">Activated</span>' :
                                '<span class="status-deactivated">Deactivated</span>';

                            $users[] = $row;
                        }
                    }

                    $defaultImagePath = "/assets/defaultProfilePicture.jpg";

                    // Set the default image path if ProfilePicturePath is null or empty
                    foreach ($users as &$row) {
                        if ($row['ProfilePicturePath'] === "") {
                            $row['ProfilePicturePath'] = $defaultImagePath;
                        }
                    }

                    $conn->close();

                    // Output as JSON
                    echo json_encode($users);
                    ?>;

    let currentPage = 1;
    const rowsPerPage = 8;
    let filteredData = data;
    let sortDirection = true;

    function displayTable(page) {
        const tableBody = document.getElementById('usersTable');
        tableBody.innerHTML = "";

        if (filteredData.length === 0) {
            tableBody.innerHTML = "<tr><td colspan='10' class='text-center'>User doesn't exist</td></tr>";
            document.getElementById('pageButtons').innerHTML = '';
            return;
        }

        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const paginatedItems = filteredData.slice(start, end);

        paginatedItems.forEach((item, index) => {
            const row = document.createElement('tr');
            const rowIndex = start + index + 1;
            row.innerHTML = `
                <td>${rowIndex}</td>
                <td class="flex flex-row justify-center"><img src="${item.ProfilePicturePath}" alt="Profile Picture" class="w-10 h-10 rounded-full"></td>
                <td>${item.username}</td>
                <td>${item.EmployeeLastname}</td>
                <td>${item.EmployeeFirstname}</td>
                <td>${item.HireDate}</td>
                <td>${item.Gender}</td>
                <td>${item.Position}</td>
                <td>${item.accountStatus}</td>
                <td>
                    <button class='text-[#DF166E]' onclick='return confirm("Are you sure you want to delete this user?");'>Delete</button>
                </td>
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
            return item.username.toLowerCase().includes(query) ||
                item.EmployeeLastname.toLowerCase().includes(query) ||
                item.EmployeeFirstname.toLowerCase().includes(query) ||
                item.HireDate.toLowerCase().includes(query) ||
                item.Gender.toLowerCase().includes(query) ||
                item.Position.toLowerCase().includes(query);
        });
        currentPage = 1;
        displayTable(currentPage);
    }

    function sortTable(column) {
        sortDirection = !sortDirection;
        filteredData.sort((a, b) => {
            const aValue = a[column] ? a[column].toString().toLowerCase() : '';
            const bValue = b[column] ? b[column].toString().toLowerCase() : '';
            if (aValue < bValue) {
                return sortDirection ? -1 : 1;
            }
            if (aValue > bValue) {
                return sortDirection ? 1 : -1;
            }
            return 0;
        });
        displayTable(currentPage);
    }

    document.getElementById('searchInput').addEventListener('input', function() {
        filterData(this.value);
    });

    window.onload = function() {
        displayTable(currentPage);
    };
</script>