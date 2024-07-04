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
            <div>
                <div class="GLOBAL_HEADER_COLUMN">
                    <p class="text-sm text-[#7F7F7F]">Hey, <strong class="text-black">Radon</strong></p>
                    <p class="text-sm text-[#7F7F7F]">Admin</p>
                </div>
            </div>
        </div>

        <div class="DASHBOARD_ANALYTICS">
            <div class="DASHBOARD_ANALYTICS_HEADER">
                <h1 class="DASHBOARD_ANALYTICS_HEADER_TITLE">Analytics</h1> 
                <a href="">
                    <i class="material-symbols-rounded text-[#7F7F7F] text-3xl">
                        arrow_back
                    </i>
                </a>
            </div>
            <div class="DASHBOARD_ANALYTICS_ROW">
                <div class="DASHBOARD_ANALYTICS_CARD GLOBAL_BOX_DIV">
                    <h1 class="DASHBOARD_ANALYTICS_CARD_TITLE">Monthly Sales</h1>
                    <h1 class="DASHBOARD_ANALYTICS_CARD_VALUE">Php 65,521</h1>
                </div>
                <div class="DASHBOARD_ANALYTICS_CARD GLOBAL_BOX_DIV">
                    <h1 class="DASHBOARD_ANALYTICS_CARD_TITLE">Total Orders</h1>
                    <h1 class="DASHBOARD_ANALYTICS_CARD_VALUE">1,002</h1>
                </div>
                <div class="DASHBOARD_ANALYTICS_CARD GLOBAL_BOX_DIV">
                    <h1 class="DASHBOARD_ANALYTICS_CARD_TITLE">Total Sales</h1>
                    <h1 class="DASHBOARD_ANALYTICS_CARD_VALUE">Php 105,156</h1>
                </div>
            </div>
        </div>
    
        <div class="DASHBOARD_RECENT">
            <h1 class="DASHBOARD_RECENT_HEADER">Recent Orders</h1>
            <div class="GLOBAL_TABLE">
                <table>
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Order Date</th>
                        <th>Amount</th>
                        <th>Date Released</th>
                        <th>Status</th>
                        <th>Remarks</th>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                </table>
            </div>
            <a href="">Show all</a>
        </div>
    </div>
</div>