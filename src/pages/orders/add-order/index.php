<div class="GLOBAL_PAGE">
    <?php
    include_once __DIR__ . "/../../../components/sidebar.php";
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

        <div class="CUSTOMERS_INFO">
            <div class="GLOBAL_SUBHEADER">
                <h1>Customer Information</h1>
                <a onclick="window.history.back(); return false;">
                    <i class="material-symbols-rounded text-[#7F7F7F] text-3xl">
                        arrow_back
                    </i>
                </a>
            </div>

            <form action="" method="post">
                <div class="CUSTOMERS_INPUT GLOBAL_BOX_DIV">

                    <!-- Column 1 -->
                    <div class="CUSTOMERS_INPUT_COLUMN">
                        <!-- First Name -->
                        <div class="CUSTOMERS_INPUT_COLUMN_CONTAINER">
                            <label for="first-name">First Name</label>
                            <input type="text" name="first-name" placeholder="First name" required>
                        </div>
                        <!-- Last Name -->
                        <div class="CUSTOMERS_INPUT_COLUMN_CONTAINER">
                            <label for="last-name">Last Name</label>
                            <input type="text" name="last-name" placeholder="Last name" required>
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div class="CUSTOMERS_INPUT_COLUMN">
                        <!-- Email -->
                        <div class="CUSTOMERS_INPUT_COLUMN_CONTAINER">
                            <label for="email">Email</label>
                            <input type="text" name="contact-number" placeholder="Email" required>
                        </div>
                        <!-- Phone Number -->
                        <div class="CUSTOMERS_INPUT_COLUMN_CONTAINER">
                            <label for="phone-number">Phone Number</label>
                            <input type="text" name="phone-number" placeholder="Phone number" required>
                        </div>
                    </div>
                </div>

                <div class="GLOBAL_SUBHEADER">
                    <h1>Payment Plan</h1>
                </div>

                <div class="flex flex-row gap-10 justify-start GLOBAL_BOX_DIV px-12 py-8 mb-6">

                    <!-- Column 1 -->
                    <div class="CUSTOMERS_INPUT_COLUMN">
                        <!-- Payment Method -->
                        <div class="CUSTOMERS_INPUT_COLUMN_CONTAINER">
                            <label for="payment-method">Payment Method</label>
                            <select name="payment-method" id="payment-method" onchange="enableInput(this)">
                                <option value="cash">Cash</option>
                                <option value="bank-transfer">Digital Wallet</option>
                                <!-- Enter More Options -->
                            </select>
                        </div>
                        <!-- Due Date -->
                        <div class="CUSTOMERS_INPUT_COLUMN_CONTAINER">
                            <label for="due-date">Due Date</label>
                            <div class="flex flex-row gap-2">
                                <input type="number" id="month" min="1" max="12" size="2" placeholder="Month" required>
                                <input type="number" id="day" min="1" max="31" size="2" placeholder="Day" required>
                                <input type="number" id="year" min="1900" max="2100" placeholder="Year" size="4" required>
                            </div>
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div class="CUSTOMERS_INPUT_COLUMN">
                        <!-- Payment Processor -->
                        <label for="processor">Processor</label>
                        <select id="processor" name="processor" disabled>
                            <option value="none">None</option>
                            <option value="gcash">GCash</option>
                            <option value="metrobank">Metrobank</option>
                            <option value="metrobank">BDO</option>
                            <option value="metrobank">Paypal</option>
                            <!-- Enter More Options -->
                        </select>
                    </div>
                </div>
                <div class="flex flex-row justify-end pb-5">
                    <a href="/orders" class="GLOBAL_BUTTON_GRAY mr-4">Cancel</a>
                    <a class="GLOBAL_BUTTON_BLUE" onclick="scrollToSection('input')">Proceed</a>
                </div>

                <div id="input" class="GLOBAL_SUBHEADER">
                    <h1>Product Input</h1>
                </div>

                <div class="GLOBAL_SUBHEADER">
                    <div class="PRODUCTS_INPUT_COLUMN">
                        <?php
                        parse_str($_SERVER['QUERY_STRING'] ?? '', $query);

                        $tab = $query['tab'] ?? 'sticker';

                        $componentsFolder = __DIR__ . "/../../../components/";

                        function isActiveLeft($tabName, $currentTab)
                        {
                            return $tabName === $currentTab ? 'bg-[#00A1E2] hover:bg-[#007BB5] text-white shadow-xl font-semibold' : '';
                        }

                        function isActive($tabName, $currentTab)
                        {
                            return $tabName === $currentTab ? 'bg-[#00A1E2] hover:bg-[#007BB5] text-white shadow-xl font-semibold' : '';
                        }

                        function isActiveRight($tabName, $currentTab)
                        {
                            return $tabName === $currentTab ? 'bg-[#00A1E2] hover:bg-[#007BB5] text-white shadow-xl font-semibold' : '';
                        }
                        ?>

                        <div class="PRODUCTS_INPUT_COLUMN_TABS">
                            <a href="?tab=sticker" class="PRODUCTS_BUTTON_LEFTROUNDED <?= isActiveLeft('sticker', $tab) ?>">Sticker</a>
                            <a href="?tab=banner" class="PRODUCTS_BUTTON <?= isActive('banner', $tab) ?>">Banner</a>
                            <a href="?tab=tarpaulin" class="PRODUCTS_BUTTON <?= isActive('tarpaulin', $tab) ?>">Tarpaulin</a>
                            <a href="?tab=other" class="PRODUCTS_BUTTON_RIGHTROUNDED <?= isActiveRight('other', $tab) ?>">Others</a>
                        </div>

                        <div class="PRODUCTS_INPUT_COLUMN_NUMBER_CONTAINER">
                            <div class="PRODUCTS_INPUT_COLUMN_NUMBER_CONTAINER_BUTTON">
                                <i class="material-symbols-rounded">
                                    remove
                                </i>
                            </div>
                            <div class="PRODUCTS_INPUT_COLUMN_NUMBER_CONTAINER_DISPLAY GLOBAL_BOX_DIV">
                                <p>1</p>
                            </div>
                            <div class="PRODUCTS_INPUT_COLUMN_NUMBER_CONTAINER_BUTTON">
                                <i class="material-symbols-rounded">
                                    add
                                </i>
                            </div>
                            <button class="GLOBAL_BUTTON_BLUE ml-5">Add Item</button>
                        </div>
                    </div>
                </div>

                <?php
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

                <div class="PRODUCTS_INPUT_ITEMS pb-10">
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
            </form>
        </div>
    </div>
</div>