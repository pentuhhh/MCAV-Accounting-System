<?php
require __DIR__ . '/../../utilities/db-connection.php';
require('dashboard.php');
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
                    <p>Hey, <strong class="text-black">Radon</strong></p>
                    <p>Admin</p>
                </div>
                <img src="/assets/JumanjiRon.png" alt="">
            </div>
        </div>

        <div class="GLOBAL_ANALYTICS">
            <div class="GLOBAL_SUBHEADER">
                <h1>Analytics</h1>
            </div>
            <div class="GLOBAL_ANALYTICS_ROW">
                <div class="GLOBAL_ANALYTICS_CARD GLOBAL_BOX_DIV">
                    <div class="GLOBAL_ANALYTICS_CARD_TEXT">
                        <h1 class="GLOBAL_ANALYTICS_CARD_TITLE">Monthly Sales</h1>
                        <h1 class="GLOBAL_ANALYTICS_CARD_VALUE">Php 65,521</h1>
                    </div>
                    <div class="GLOBAL_ANALYTICS_CARD_ICON">
                        <i class="material-symbols-rounded">
                            monitoring
                        </i>
                    </div>
                </div>
                <div class="GLOBAL_ANALYTICS_CARD GLOBAL_BOX_DIV">
                    <div class="GLOBAL_ANALYTICS_CARD_TEXT">
                        <h1 class="GLOBAL_ANALYTICS_CARD_TITLE">Total Orders</h1>
                        <h1 class="GLOBAL_ANALYTICS_CARD_VALUE">1,002</h1>
                    </div>
                    <div class="GLOBAL_ANALYTICS_CARD_ICON">
                        <i class="material-symbols-rounded">
                            orders
                        </i>
                    </div>
                </div>
                <div class="GLOBAL_ANALYTICS_CARD GLOBAL_BOX_DIV">
                    <div class="GLOBAL_ANALYTICS_CARD_TEXT">
                        <h1 class="GLOBAL_ANALYTICS_CARD_TITLE">Total Sales</h1>
                        <h1 class="GLOBAL_ANALYTICS_CARD_VALUE">Php 105,156</h1>
                    </div>
                    <div class="GLOBAL_ANALYTICS_CARD_ICON">
                        <i class="material-symbols-rounded">
                            local_atm
                        </i>
                    </div>
                </div>
            </div>
        </div>

        <div class="DASHBOARD_RECENT">
            <div class="GLOBAL_SUBHEADER">
                <h1>Recent Orders</h1>
            </div>
            <div class="GLOBAL_TABLE">
                <table>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Order Date</th>
                        <th>Amount</th>
                        <th>Deadline</th>
                        <th>Status</th>
                    </tr>
                    <?php
                    if ($recentOrdersResult->num_rows > 0) {
                        while ($row = $recentOrdersResult->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['OrderID'] . "</td>";
                            echo "<td>" . $row['CustomerName'] . "</td>";
                            echo "<td>" . $row['OrderDate'] . "</td>";
                            echo "<td>" . $row['Amount'] . "</td>";
                            echo "<td>" . $row['Deadline'] . "</td>";
                            echo "<td>" . $row['Status'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No recent orders found.</td></tr>";
                    }
                    ?>
                </table>
            </div>
            <a href="" class="DASHBOARD_RECENT_SHOW_A">Show all</a>
        </div>
    </div>
</div>

<?php
$conn->close();
?>