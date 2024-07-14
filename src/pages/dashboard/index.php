<?php
require "dashboard.php";

$username = $_SESSION['username'];
$profilePicture = isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : '';
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
                    <p>Hey, <strong><?php echo htmlspecialchars($username); ?></strong></p>
                    <p>Admin</p>
                </div>
                <img src="<?php echo htmlspecialchars($profilePicture); ?>" alt="Profile Picture">
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
                    <tbody id="recentOrders">
                        <?php while ($row = $resultRecentOrders->fetch_assoc()) { ?>
                            <tr>
                                <td>
                                    <a href="/orders/details/?orderID=<?php echo $row['Order ID']; ?>">
                                        <?php echo $row['Order ID']; ?>
                                    </a>
                                </td>
                                <td><?php echo htmlspecialchars($row['Customer Name']); ?></td>
                                <td><?php echo htmlspecialchars($row['Order Date']); ?></td>
                                <td><?php echo number_format($row['Amount'], 2); ?></td>
                                <td><?php echo htmlspecialchars($row['Deadline']); ?></td>
                                <td><?php
                                    if ($row['Status'] == 'Completed') {
                                        echo '<span class="status-completed">Completed</span>';
                                    } else if ($row['Status'] == 'Pending') {
                                        echo '<span class="status-pending">Pending</span>';
                                    } else if ($row['Status'] == 'Started') {
                                        echo '<span class="status-started">Started</span>';
                                    } else {
                                        echo '<span class="status-unknown">Unknown</span>';
                                    }
                                    ?></td>
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