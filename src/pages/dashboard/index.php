<?php
require "dashboard.php";
?>
<div class="GLOBAL_PAGE">
    <?php
    include_once __DIR__ . "/../../components/sidebar.php";
    ?>

    <div class="GLOBAL_PAGE_CONTAINER">
        <div class="GLOBAL_HEADER">
            <div class="GLOBAL_HEADER_TITLE">
                <i class="material-symbols-rounded text-[42px]">
                    dashboard
                </i>
                <span>Dashboard</span>
            </div>
            <div class="GLOBAL_HEADER_USER">
                <div class="GLOBAL_HEADER_COLUMN">
                    <p class="text-sm text-[#7F7F7F]">Hey, <strong class="text-black">Radon</strong></p>
                    <p class="text-sm text-[#7F7F7F]">Admin</p>
                </div>
                <img src="/assets/JumanjiRon.png" alt="">
            </div>
        </div>

        <div class="GLOBAL_ANALYTICS">
            <div class="GLOBAL_SUBHEADER">
                <h1 class="GLOBAL_SUBHEADER_TITLE">Analytics</h1>
            </div>
            <div class="GLOBAL_ANALYTICS_ROW">
                <div class="GLOBAL_ANALYTICS_CARD GLOBAL_BOX_DIV">
                    <div class="GLOBAL_ANALYTICS_CARD_TEXT">
                        <h1 class="GLOBAL_ANALYTICS_CARD_TITLE">Monthly Sales</h1>
                        <h1 class="GLOBAL_ANALYTICS_CARD_VALUE">P <?php echo number_format($monthlySales, 2); ?></h1>
                    </div>
                    <i class="material-symbols-rounded text-8xl">
                        monitoring
                    </i>
                </div>
                <div class="GLOBAL_ANALYTICS_CARD GLOBAL_BOX_DIV">
                    <div class="GLOBAL_ANALYTICS_CARD_TEXT">
                        <h1 class="GLOBAL_ANALYTICS_CARD_TITLE">Total Orders</h1>
                        <h1 class="GLOBAL_ANALYTICS_CARD_VALUE"><?php echo $totalOrders; ?></h1>
                    </div>
                    <i class="material-symbols-rounded text-8xl">
                        orders
                    </i>
                </div>
                <div class="GLOBAL_ANALYTICS_CARD GLOBAL_BOX_DIV">
                    <div class="GLOBAL_ANALYTICS_CARD_TEXT">
                        <h1 class="GLOBAL_ANALYTICS_CARD_TITLE">Total Sales</h1>
                        <h1 class="GLOBAL_ANALYTICS_CARD_VALUE">P <?php echo number_format($totalSales, 2); ?></h1>
                    </div>
                    <i class="material-symbols-rounded text-8xl">
                        local_atm
                    </i>
                </div>
            </div>
        </div>

        <div class="DASHBOARD_RECENT">
            <div class="GLOBAL_SUBHEADER">
                <h1 class="GLOBAL_SUBHEADER_TITLE">Recent Orders</h1>
            </div>
            <div class="GLOBAL_TABLE">
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Order Date</th>
                            <th>Amount</th>
                            <th>Deadline</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $recentOrders->fetch_assoc()) { ?>
                            <tr>
                                <td>
                                    <a href = "/orders/details/?orderID=<?php echo $row['Order ID']; ?>">
                                        <?php echo $row['Order ID']; ?>
                                    </a>
                                </td>
                                <td><?php echo $row['Customer Name']; ?></td>
                                <td><?php echo $row['Order Date']; ?></td>
                                <td>$<?php echo number_format($row['Amount'], 2); ?></td>
                                <td><?php echo $row['Deadline']; ?></td>
                                <td><?php echo $row['Status']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <a href="/orders" class="DASHBOARD_RECENT_SHOW_A">Show all</a>
        </div>
    </div>
</div>

<?php
$conn->close();
?>

<script>
    
    function displayTable() {
        const tableBody = document.getElementById('ordersTable');
        tableBody.innerHTML = "";

        data.forEach(item => {
            const row = document.createElement('tr');

            Object.keys(item).forEach(key => {
                const cell = document.createElement('td');
                cell.textContent = item[key];

                if (key === 'Status') {
                    // Add class based on status
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
    }

    // Simulate loading of data (you would replace this with actual data retrieval logic)
    window.onload = function() {
        displayTable();
    };
</script>
