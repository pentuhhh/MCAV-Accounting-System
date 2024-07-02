<div class="flex">
    <?php
    include_once __DIR__ . "/../../components/sidebar.php";
    ?>

    <div class="flex flex-col">
        <!-- Header -->
        <div class="flex items-center p-8">
            <i class="material-symbols-rounded text-[42px]">
                receipt_long
            </i>
            <span class="pl-2 text-2xl font-bold">Orders</span>
        </div>
        <!-- End of Header -->

        <!-- Search Bar -->
        <div class="flex px-8 pb-3">
            <div class="column-1">
                <a href="">
                    <i class="material-symbols-rounded text-[18px]">
                        search
                    </i>
                </a>
                <input type="text" placeholder="Search" class="p-2 w-1/2 border border-gray-300 rounded-lg">
            </div>
            <a href="/input/customer">Add order</a>
        </div>
        <!-- End of Search Bar -->

        <!-- Orders Table -->
        <div class="items-center px-8">
            <h1 class="text-2xl font-bold">Recent Orders</h1>
            <div>
                <table>
                    <tr>
                        <th>#</th>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Product Description</th>
                        <th>Qty</th>
                        <th>Order Date</th>
                        <th>Amount</th>
                        <th>Date Released</th>
                        <th>Status</th>
                        <th>Remarks</th>
                        <th><!-- edit column --></th>
                    </tr>
                    <tr>
                        <!-- Insert php here -->
                    </tr>
                </table>
            </div>
        </div>
        <!-- End of Orders Table -->
    </div>
</div>