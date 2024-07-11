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
                            <input id="first-name" type="text" name="first-name" placeholder="First name" required>
                        </div>
                        <!-- Last Name -->
                        <div class="CUSTOMERS_INPUT_COLUMN_CONTAINER">
                            <label for="last-name">Last Name</label>
                            <input id="last-name" type="text" name="last-name" placeholder="Last name" required>
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div class="CUSTOMERS_INPUT_COLUMN">
                        <!-- Email -->
                        <div class="CUSTOMERS_INPUT_COLUMN_CONTAINER">
                            <label for="email">Email</label>
                            <input id="email" type="text" name="contact-number" placeholder="Email" required>
                        </div>
                        <!-- Phone Number -->
                        <div class="CUSTOMERS_INPUT_COLUMN_CONTAINER">
                            <label for="phone-number">Phone Number</label>
                            <input id="phone-number" type="text" name="phone-number" placeholder="Phone number" required>
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
                            <input id="due-date" name="due-date" type="date">
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
                            <option value="BDO">BDO</option>
                            <option value="Paypal">Paypal</option>
                            <!-- Enter More Options -->
                        </select>
                    </div>
                </div>

                <div class="GLOBAL_SUBHEADER justify-start">
                    <h1>Product Options</h1>
                    <input type="number" name="quantity" placeholder="Qty" class="PRODUCT_INPUT_QUANTITY" required>
                    <button class="GLOBAL_BUTTON_BLUE ml-5">Add Item</button>
                </div>

                <div class="flex flex-row gap-10 justify-start GLOBAL_BOX_DIV px-12 py-8 mb-6">

                    <!-- Column 1 -->
                    <div class="CUSTOMERS_INPUT_COLUMN">
                        <!-- Product Description -->
                        <div class="CUSTOMERS_INPUT_COLUMN_CONTAINER">
                            <div class="CUSTOMERS_INPUT_COLUMN_CONTAINER">
                                <label for="product-description">Product Description</label>
                                <input id="product-description" type="text" name="product-description" placeholder="Product Description" required>
                            </div>
                        </div>
                        <!-- Dimensions -->
                        <div class="CUSTOMERS_INPUT_COLUMN_CONTAINER">
                            <label for="dimensions">Dimensions</label>
                            <input id="dimensions" type="text" name="dimensions" placeholder="Dimensions" required>
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div class="CUSTOMERS_INPUT_COLUMN">
                        <!-- Amount -->
                        <div class="CUSTOMERS_INPUT_COLUMN_CONTAINER">
                            <div class="CUSTOMERS_INPUT_COLUMN_CONTAINER">
                                <label for="amount">Amount</label>
                                <input id="amount" type="number" name="amount" placeholder="Amount" required>
                            </div>
                        </div>
                        <!-- Remarks -->
                        <div class="CUSTOMERS_INPUT_COLUMN_CONTAINER">
                            <div class="CUSTOMERS_INPUT_COLUMN_CONTAINER">
                                <label for="remarks">Remarks</label>
                                <input id="remarks" type="text" name="remarks" placeholder="Remarks" required>
                            </div>
                        </div>
                    </div>
                </div>
                
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
            </div>

        </form>
    </div>
</div>