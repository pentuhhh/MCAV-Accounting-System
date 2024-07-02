<div class="flex w- full">
    <?php
    include_once __DIR__ . "/../../components/sidebar.php";
    ?>

    <div class="flex flex-col">
        <!-- Header -->
        <div class="flex items-center p-8">
            <i class="material-symbols-rounded text-[42px]">
                dashboard
            </i>
            <span class="pl-2 text-2xl font-bold">Dashboard</span>
        </div>
        <!-- End of Header -->
    
        <!-- Analytics -->
        <div class="items-center px-8 pb-4">
            <h1 class="text-2xl font-bold">Analytics</h1>
        </div>
    
        <div class="flex px-8">
            <!-- Monthly Sales -->
            <div class="column-1">
                <h3>Monthly Sales</h3>
            </div>
            <!-- Total Orders -->
            <div class="column-2">
                <h3>Total Orders</h3>
            </div>
            <!-- Total Sales -->
            <div class="column-3">
                <h3>Total Sales</h3>
            </div>
        </div>
        <!-- End of Analytics -->

        <!-- Recent Orders -->
        <div class="items-center px-8">
            <h1 class="text-2xl font-bold">Recent Orders</h1>
            <div>
                <table>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Product Description</th>
                        <th>Qty</th>
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
                <a href="">Show all</a>
            </div>
        </div>
        <!-- End of Recent Orders -->
    </div>
</div>