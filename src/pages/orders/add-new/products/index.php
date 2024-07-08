<div class="GLOBAL_PAGE">
	<?php
    include_once __DIR__ . "/../../../../components/sidebar.php";
    ?>

	<div class="GLOBAL_PAGE_CONTAINER">
        <div class="GLOBAL_HEADER">
            <div class="GLOBAL_HEADER_TITLE">
                <i class="material-symbols-rounded text-[42px]">
                    receipt_long
                </i>
                <span class="">Add New Order</span>
            </div>
            <div class="GLOBAL_HEADER_USER">
                <div class="GLOBAL_HEADER_COLUMN">
                    <p>Hey, <strong class="text-black">Radon</strong></p>
                    <p>Admin</p>
                </div>
                <img src="/assets/JumanjiRon.png" alt="">
            </div>
        </div>

        <div class="PRODUCTS_INPUT">
            <div class="GLOBAL_SUBHEADER">
                <div class="tabs">
                    <button class="tab" data-target="sticker">Sticker</button>
                    <button class="tab" data-target="banner">Banner</button>
                    <button class="tab" data-target="tarpaulin">Tarpaulin</button>
                    <button class="tab" data-target="other">Others</button>
                </div>

                <a onclick="window.history.back()">
                    <i class="material-symbols-rounded text-[#7F7F7F] text-3xl">
                        arrow_back
                    </i>
                </a>
            </div>

            <?php
            parse_str($_SERVER['QUERY_STRING'] ?? '' , $query);

            $tab = $query['tab'] ?? 'sticker';

            $componentsFolder = __DIR__ . "/../../../../components/";

            if (file_exists($componentsFolder . $tab . '.php')) {
                include_once $componentsFolder . $tab . '.php';
            } elseif (file_exists($componentsFolder . $tab . 'index.php')) {
                include_once $componentsFolder . $tab . 'index.php';
            } else {
                include_once $componentsFolder . 'sticker.php';
            }
            ?>

            <div class="PRODUCTS_INPUT_NOTE">
                <p>Note: Each item is priced per piece</p>
            </div>

            <div class="GLOBAL_SUBHEADER">
                <h1>Total Items</h1>
            </div>

            <div class="PRODUCTS_INPUT_ITEMS">
                <div class="PRODUCTS_INPUT_ITEMS_TABLE GLOBAL_BOX_DIV">
                    <table>
                        <tr>
                            <th>#</th>
                            <th>Description</th>
                            <th>Dimensions</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th></th>
                        </tr>
                        <tr>

                        </tr>
                    </table>
                </div>

                <div class="PRODUCTS_INPUT_ITEMS_TOTAL GLOBAL_BOX_DIV">
                    <div class="PRODUCTS_INPUT_ITEMS_TOTAL_TITLE">
                        <h1>Total Charge</h1>
                        <h1>Php 72.30</h1>
                    </div>
                    <div class="PRODUCTS_INPUT_ITEMS_TOTAL_BUTTONS">
                        <a href="/orders" class="GLOBAL_BUTTON_RED">Cancel</a>
                        <a href="/orders/details" class="GLOBAL_BUTTON_BLUE ml-2" onclick="">Add Order</a>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>