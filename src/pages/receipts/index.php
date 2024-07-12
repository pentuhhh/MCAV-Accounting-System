<div class="GLOBAL_PAGE">
    <?php
    include_once __DIR__ . "/../../components/sidebar.php";
    ?>

    <div class="GLOBAL_PAGE_CONTAINER">
        <div class="GLOBAL_HEADER">
            <div class="GLOBAL_HEADER_TITLE">
                <i class="material-symbols-rounded text-[42px]">
                    payments
                </i>
                <span>Receipts</span>
                <a href="/receipts/add-receipt/" class="GLOBAL_BUTTON_BLUE ml-7">Add receipt</a>
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
            <div class="GLOBAL_ANALYTICS_ROW">
                <div class="GLOBAL_ANALYTICS_CARD GLOBAL_BOX_DIV">
                    <div class="GLOBAL_ANALYTICS_CARD_TEXT">
                        <h1 class="GLOBAL_ANALYTICS_CARD_TITLE">Last Month's Income</h1>
                        </h1>
                        <h1 class="GLOBAL_ANALYTICS_CARD_VALUE">Php 65,521+</h1>
                    </div>
                    <div class="GLOBAL-ANALYTICS_CARD_ICON">

                    </div>
                </div>
                <div class="GLOBAL_ANALYTICS_CARD GLOBAL_BOX_DIV">
                    <div class="GLOBAL_ANALYTICS_CARD_TEXT">
                        <h1 class="GLOBAL_ANALYTICS_CARD_TITLE">This Month's Income</h1>
                        <h1 class="GLOBAL_ANALYTICS_CARD_VALUE">Php 48,200+</h1>
                    </div>
                    <div class="GLOBAL-ANALYTICS_CARD_ICON">

                    </div>
                </div>
                <div class="GLOBAL_ANALYTICS_CARD GLOBAL_BOX_DIV">
                    <div class="GLOBAL_ANALYTICS_CARD_TEXT">
                        <h1 class="GLOBAL_ANALYTICS_CARD_TITLE">Total Sales</h1>
                        <h1 class="GLOBAL_ANALYTICS_CARD_VALUE">Php 48,156+</h1>
                    </div>
                    <div class="GLOBAL-ANALYTICS_CARD_ICON">

                    </div>
                </div>
            </div>
        </div>

        <div class="ORDERS_SEARCH">
            <div class="columns-1">
                <a href="" class="ORDER_SEARCH_BUTTON">
                    <i class="material-symbols-rounded">
                        search
                    </i>
                </a>
                <input type="text" placeholder="Search">
            </div>
        </div>

        <div class="ORDERS_CONTENT">
            <div class="GLOBAL_TABLE">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Receipt</th>
                            <th>Order</th>
                            <th>Payment Method</th>
                            <th>Amount Paid</th>
                            <th>Payment Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><a href="" onclick="openModalReceipt(), event.preventDefault()" class="GLOBAL_TABLE_ID">123123</a></td>
                            <td>123123</td>
                            <td>Cash</td>
                            <td>Php 1,000.00</td>
                            <td>2021-10-10</td>
                            <td class="flex flex-row justify-center">
                                <button class="text-[#DF166E]" onclick="return confirm('Are you sure you want to delete row?');">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>