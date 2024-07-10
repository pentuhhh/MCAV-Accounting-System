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

                <div class="GLOBAL_SUBHEADER justify-start">
                    <h1>Sticker Options</h1>
                    <input type="number" name="quantity" placeholder="Qty" class="PRODUCT_INPUT_QUANTITY" required>
                    <button class="GLOBAL_BUTTON_BLUE ml-5">Add Item</button>
                </div>

                <div class="COMPONENT_STICKER_CONTAINER pb-10">
                    <div class="COMPONENT_STICKER_CONTAINER_ROW">
                        <button class="COMPONENT_STICKER_CONTAINER_ROW_OPTION GLOBAL_BOX_DIV" name="" value="">
                            <div class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_PRICE">
                                <h1>₱ 0.70</h1>
                            </div>
                            <div class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_TITLE">
                                <h1>1 Inch Circle</h1>
                            </div>
                            <div class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_TYPE">
                                <h1>Sticker</h1>
                            </div>
                        </button>

                        <button class="COMPONENT_STICKER_CONTAINER_ROW_OPTION GLOBAL_BOX_DIV">
                            <div class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_PRICE">
                                <h1>₱ 1.30</h1>
                            </div>
                            <div class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_TITLE">
                                <h1>1.5 Inches Circle</h1>
                            </div>
                            <div class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_TYPE">
                                <h1>Sticker</h1>
                            </div>
                        </button>

                        <button class="COMPONENT_STICKER_CONTAINER_ROW_OPTION GLOBAL_BOX_DIV">
                            <div class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_PRICE">
                                <h1>₱ 2.30</h1>
                            </div>
                            <div class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_TITLE">
                                <h1>2 Inches Circle</h1>
                            </div>
                            <div class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_TYPE">
                                <h1>Sticker</h1>
                            </div>
                        </button>

                        <button class="COMPONENT_STICKER_CONTAINER_ROW_OPTION GLOBAL_BOX_DIV">
                            <div class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_PRICE">
                                <h1>₱ 3.50</h1>
                            </div>
                            <div class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_TITLE">
                                <h1>2.5 Inches Circle</h1>
                            </div>
                            <div class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_TYPE">
                                <h1>Sticker</h1>
                            </div>
                        </button>

                        <button class="COMPONENT_STICKER_CONTAINER_ROW_OPTION GLOBAL_BOX_DIV">
                            <div class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_PRICE">
                                <h1>₱ 5.00</h1>
                            </div>
                            <div class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_TITLE">
                                <h1>3 Inches Circle</h1>
                            </div>
                            <div class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_TYPE">
                                <h1>Sticker</h1>
                            </div>
                        </button>
                    </div>

                    <div class="COMPONENT_STICKER_CONTAINER_ROW">
                        <button class="COMPONENT_STICKER_CONTAINER_ROW_OPTION GLOBAL_BOX_DIV">
                            <div class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_PRICE">
                                <h1>₱ 0.50</h1>
                            </div>
                            <div class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_TITLE">
                                <h1>1 Inch Square</h1>
                            </div>
                            <div class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_TYPE">
                                <h1>Sticker</h1>
                            </div>
                        </button>

                        <button class="COMPONENT_STICKER_CONTAINER_ROW_OPTION GLOBAL_BOX_DIV">
                            <div class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_PRICE">
                                <h1>₱ 1.00</h1>
                            </div>
                            <div class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_TITLE">
                                <h1>1.5 Inches Square</h1>
                            </div>
                            <div class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_TYPE">
                                <h1>Sticker</h1>
                            </div>
                        </button>

                        <button class="COMPONENT_STICKER_CONTAINER_ROW_OPTION GLOBAL_BOX_DIV">
                            <div class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_PRICE">
                                <h1>₱ 1.50</h1>
                            </div>
                            <div class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_TITLE">
                                <h1>2 Inches Square</h1>
                            </div>
                            <div class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_TYPE">
                                <h1>Sticker</h1>
                            </div>
                        </button>

                        <button class="COMPONENT_STICKER_CONTAINER_ROW_OPTION GLOBAL_BOX_DIV">
                            <div class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_PRICE">
                                <h1>₱ 2.20</h1>
                            </div>
                            <div class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_TITLE">
                                <h1>2.5 Inches Square</h1>
                            </div>
                            <div class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_TYPE">
                                <h1>Sticker</h1>
                            </div>
                        </button>

                        <button class="COMPONENT_STICKER_CONTAINER_ROW_OPTION GLOBAL_BOX_DIV">
                            <div class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_PRICE">
                                <h1>₱ 3.20</h1>
                            </div>
                            <div class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_TITLE">
                                <h1>3 Inches Square</h1>
                            </div>
                            <div class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_TYPE">
                                <h1>Sticker</h1>
                            </div>
                        </button>
                    </div>

                    <div class="COMPONENT_STICKER_CONTAINER_ROW">
                        <button class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_NONE GLOBAL_BOX_DIV">
                            <h1>None</h1>
                        </button>

                        <button class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_CENTER GLOBAL_BOX_DIV">
                            <div class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_PRICE">
                                <h1>₱ 50.00</h1>
                            </div>
                            <div>
                                <h1>Manual Cut</h1>
                            </div>
                        </button>

                        <button class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_CENTER GLOBAL_BOX_DIV">
                            <div class="COMPONENT_STICKER_CONTAINER_ROW_OPTION_PRICE">
                                <h1>₱ 80.00</h1>
                            </div>
                            <div>
                                <h1>Dye Cut Machine</h1>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- -- BANNER SECTION -- -->

                <div class="GLOBAL_SUBHEADER justify-start">
                    <h1>Banner Options</h1>
                    <input type="number" name="quantity" placeholder="Qty" class="PRODUCT_INPUT_QUANTITY" required>
                    <button class="GLOBAL_BUTTON_BLUE ml-5">Add Item</button>
                </div>

                <div class="COMPONENT_BANNER_CONTAINER pb-10">
                    <div class="COMPONENT_BANNER_CONTAINER_ROW">
                        <button class="COMPONENT_BANNER_CONTAINER_ROW_OPTION GLOBAL_BOX_DIV">
                            <div class="COMPONENT_BANNER_CONTAINER_ROW_OPTION_PRICE">
                                <h1>₱ 0.70</h1>
                            </div>
                            <div class="COMPONENT_BANNER_CONTAINER_ROW_OPTION_TITLE">
                                <h1>2 x 5 SQ.FT </h1>
                            </div>
                            <div class="COMPONENT_BANNER_CONTAINER_ROW_OPTION_TYPE">
                                <h1>Banner</h1>
                            </div>
                        </button>

                        <button class="COMPONENT_BANNER_CONTAINER_ROW_OPTION GLOBAL_BOX_DIV">
                            <div class="COMPONENT_BANNER_CONTAINER_ROW_OPTION_PRICE">
                                <h1>₱ 1.30</h1>
                            </div>
                            <div class="COMPONENT_BANNER_CONTAINER_ROW_OPTION_TITLE">
                                <h1>2 x 6 SQ.FT</h1>
                            </div>
                            <div class="COMPONENT_BANNER_CONTAINER_ROW_OPTION_TYPE">
                                <h1>Banner</h1>
                            </div>
                        </button>

                        <button class="COMPONENT_BANNER_CONTAINER_ROW_OPTION GLOBAL_BOX_DIV">
                            <div class="COMPONENT_BANNER_CONTAINER_ROW_OPTION_PRICE">
                                <h1>₱ 2.30</h1>
                            </div>
                            <div class="COMPONENT_BANNER_CONTAINER_ROW_OPTION_TITLE">
                                <h1>Roll Up Banner</h1>
                            </div>
                            <div class="COMPONENT_BANNER_CONTAINER_ROW_OPTION_TYPE">
                                <h1>Banner</h1>
                            </div>
                        </button>

                        <div class="COMPONENT_BANNER_CONTAINER_ROW_OPTION">
                        </div>

                        <div class="COMPONENT_BANNER_CONTAINER_ROW_OPTION">
                        </div>


                    </div>
                </div>

                <!-- -- TARPAULIN SECTION -- -->

                <div class="GLOBAL_SUBHEADER justify-start">
                    <h1>Tarpaulin Options</h1>
                    <input type="number" name="quantity" placeholder="Qty" class="PRODUCT_INPUT_QUANTITY" required>
                    <button class="GLOBAL_BUTTON_BLUE ml-5">Add Item</button>
                </div>

                <div class="COMPONENT_TARPAULIN_CONTAINER pb-10">
                    <div class="COMPONENT_TARPAULIN_CONTAINER_ROW">
                        <div class="COMPONENT_TARPAULIN_CONTAINER_ROW_COLUMN w-3/5">
                            <div class="COMPONENT_TARPAULIN_CONTAINER_ROW_COLUMN_INNERROW">
                                <button class="COMPONENT_TARPAULIN_CONTAINER_ROW_OPTION GLOBAL_BOX_DIV">
                                    <div class="COMPONENT_TARPAULIN_CONTAINER_ROW_OPTION_PRICE">
                                        <h1>₱ 11.00</h1>
                                    </div>
                                    <div class="COMPONENT_TARPAULIN_CONTAINER_ROW_OPTION_TITLE">
                                        <h1>8 Oz</h1>
                                    </div>
                                    <div class="COMPONENT_TARPAULIN_CONTAINER_ROW_OPTION_TYPE">
                                        <h1>Tarpaulin</h1>
                                    </div>
                                </button>

                                <button class="COMPONENT_TARPAULIN_CONTAINER_ROW_OPTION GLOBAL_BOX_DIV">
                                    <div class="COMPONENT_TARPAULIN_CONTAINER_ROW_OPTION_PRICE">
                                        <h1>₱ 12.00</h1>
                                    </div>
                                    <div class="COMPONENT_TARPAULIN_CONTAINER_ROW_OPTION_TITLE">
                                        <h1>10 Oz</h1>
                                    </div>
                                    <div class="COMPONENT_TARPAULIN_CONTAINER_ROW_OPTION_TYPE">
                                        <h1>Tarpaulin</h1>
                                    </div>
                                </button>

                                <button class="COMPONENT_TARPAULIN_CONTAINER_ROW_OPTION GLOBAL_BOX_DIV">
                                    <div class="COMPONENT_TARPAULIN_CONTAINER_ROW_OPTION_PRICE">
                                        <h1>₱ 13.00</h1>
                                    </div>
                                    <div class="COMPONENT_TARPAULIN_CONTAINER_ROW_OPTION_TITLE">
                                        <h1>13 Oz</h1>
                                    </div>
                                    <div class="COMPONENT_TARPAULIN_CONTAINER_ROW_OPTION_TYPE">
                                        <h1>Tarpaulin</h1>
                                    </div>
                                </button>
                            </div>

                            <div class="COMPONENT_TARPAULIN_CONTAINER_ROW_COLUMN_INNERROW">
                                <button class="COMPONENT_TARPAULIN_CONTAINER_ROW_OPTION GLOBAL_BOX_DIV">
                                    <div class="COMPONENT_TARPAULIN_CONTAINER_ROW_OPTION_PRICE">
                                        <h1>₱ 16.00</h1>
                                    </div>
                                    <div class="COMPONENT_TARPAULIN_CONTAINER_ROW_OPTION_TITLE">
                                        <h1>15 Oz</h1>
                                    </div>
                                    <div class="COMPONENT_TARPAULIN_CONTAINER_ROW_OPTION_TYPE">
                                        <h1>Tarpaulin</h1>
                                    </div>
                                </button>

                                <button class="COMPONENT_TARPAULIN_CONTAINER_ROW_OPTION GLOBAL_BOX_DIV">
                                    <div class="COMPONENT_TARPAULIN_CONTAINER_ROW_OPTION_PRICE">
                                        <h1>₱ 18.00</h1>
                                    </div>
                                    <div class="COMPONENT_TARPAULIN_CONTAINER_ROW_OPTION_TITLE">
                                        <h1>18 Oz</h1>
                                    </div>
                                    <div class="COMPONENT_TARPAULIN_CONTAINER_ROW_OPTION_TYPE">
                                        <h1>Tarpaulin</h1>
                                    </div>
                                </button>

                                <button class="COMPONENT_TARPAULIN_CONTAINER_ROW_OPTION GLOBAL_BOX_DIV">
                                    <div class="COMPONENT_TARPAULIN_CONTAINER_ROW_OPTION_PRICE">
                                        <h1>₱ 50.00</h1>
                                    </div>
                                    <div class="COMPONENT_TARPAULIN_CONTAINER_ROW_OPTION_TITLE">
                                        <h1>Panaflex</h1>
                                    </div>
                                    <div class="COMPONENT_TARPAULIN_CONTAINER_ROW_OPTION_TYPE">
                                        <h1>Tarpaulin</h1>
                                    </div>
                                </button>
                            </div>
                        </div>

                        <div class="COMPONENT_TARPAULIN_CONTAINER_ROW_COLUMN GLOBAL_BOX_DIV w-2/5">
                            <div class="COMPONENT_TARPAULIN_CONTAINER_ROW_COLUMN_INNERDIV">
                                <div class="COMPONENT_TARPAULIN_CONTAINER_ROW_COLUMN_INNERDIV_TITLE">
                                    <h1>Enter the Size:</h1>
                                </div>
                            </div>
                            <div class="COMPONENT_TARPAULIN_CONTAINER_ROW_COLUMN_INNERDIV">
                                <div class="COMPONENT_TARPAULIN_CONTAINER_ROW_COLUMN_INNERDIV_INNERROW">
                                    <h1>Width:</h1>
                                    <input type="number">
                                </div>
                            </div>

                            <div class="COMPONENT_TARPAULIN_CONTAINER_ROW_COLUMN_INNERDIV_INNERROW">
                                <h1>Height:</h1>
                                <input type="number">
                            </div>
                        </div>

                    </div>
                </div>

                <!-- -- OTHERS SECTION -- -->

                <div class="GLOBAL_SUBHEADER justify-start">
                    <h1>Tarpaulin Options</h1>
                    <input type="number" name="quantity" placeholder="Qty" class="PRODUCT_INPUT_QUANTITY" required>
                    <button class="GLOBAL_BUTTON_BLUE ml-5">Add Item</button>
                </div>

                <div class="COMPONENT_OTHERS_CONTAINER">
                    <div class="COMPONENT_OTHERS_CONTAINER_ROW">
                        <div class="COMPONENT_OTHERS_CONTAINER_ROW_COLUMN w-3/5">
                            <div class="COMPONENT_OTHERS_CONTAINER_ROW_COLUMN_INNERROW">
                                <button class="COMPONENT_OTHERS_CONTAINER_ROW_OPTION GLOBAL_BOX_DIV">
                                    <div class="COMPONENT_OTHERS_CONTAINER_ROW_OPTION_PRICE">
                                        <h1>₱ 270.00</h1>
                                    </div>
                                    <div class="COMPONENT_OTHERS_CONTAINER_ROW_OPTION_TITLE">
                                        <h1>Front Only</h1>
                                    </div>
                                    <div class="COMPONENT_OTHERS_CONTAINER_ROW_OPTION_TYPE">
                                        <h1>Calling Card</h1>
                                    </div>
                                </button>

                                <button class="COMPONENT_OTHERS_CONTAINER_ROW_OPTION GLOBAL_BOX_DIV">
                                    <div class="COMPONENT_OTHERS_CONTAINER_ROW_OPTION_PRICE">
                                        <h1>₱ 370.00</h1>
                                    </div>
                                    <div class="COMPONENT_OTHERS_CONTAINER_ROW_OPTION_TITLE">
                                        <h1>Front & Back</h1>
                                    </div>
                                    <div class="COMPONENT_OTHERS_CONTAINER_ROW_OPTION_TYPE">
                                        <h1>Calling Card</h1>
                                    </div>
                                </button>

                                <button class="COMPONENT_OTHERS_CONTAINER_ROW_OPTION GLOBAL_BOX_DIV">
                                    <div class="COMPONENT_OTHERS_CONTAINER_ROW_OPTION_PRICE">
                                        <h1>₱ 370.00</h1>
                                    </div>
                                    <div class="COMPONENT_OTHERS_CONTAINER_ROW_OPTION_TITLE">
                                        <h1>Min: 5 ID’s</h1>
                                    </div>
                                    <div class="COMPONENT_OTHERS_CONTAINER_ROW_OPTION_TYPE">
                                        <h1>PVC ID</h1>
                                    </div>
                                </button>
                            </div>

                            <div class="COMPONENT_OTHERS_CONTAINER_ROW_COLUMN_INNERROW">
                                <button class="COMPONENT_OTHERS_CONTAINER_ROW_OPTION GLOBAL_BOX_DIV">
                                    <div class="COMPONENT_OTHERS_CONTAINER_ROW_OPTION_PRICE">
                                        <h1>₱ 60.00</h1>
                                    </div>
                                    <div class="COMPONENT_OTHERS_CONTAINER_ROW_OPTION_TITLE">
                                        <h1>Per Sheet</h1>
                                    </div>
                                    <div class="COMPONENT_OTHERS_CONTAINER_ROW_OPTION_TYPE">
                                        <h1>C2S Laser Print</h1>
                                    </div>
                                </button>

                                <button class="COMPONENT_OTHERS_CONTAINER_ROW_OPTION GLOBAL_BOX_DIV">
                                    <div class="COMPONENT_OTHERS_CONTAINER_ROW_OPTION_PRICE">
                                        <h1>₱ 21.00</h1>
                                    </div>
                                    <div class="COMPONENT_OTHERS_CONTAINER_ROW_OPTION_TITLE">
                                        <h1>BillBoards</h1>
                                    </div>
                                    <div class="flex flex-row justify-start text-[9px] text-[#DC186E]">
                                        <h1>Note: Each price is worth per SQ.FT</h1>
                                    </div>
                                </button>

                                <button class="COMPONENT_OTHERS_CONTAINER_ROW_OPTION GLOBAL_BOX_DIV">
                                    <div class="COMPONENT_OTHERS_CONTAINER_ROW_OPTION_PRICE">
                                        <h1>₱ 60.00</h1>
                                    </div>
                                    <div class="COMPONENT_OTHERS_CONTAINER_ROW_OPTION_TITLE">
                                        <h1>1 X 1 (8pcs.) & 2 X 2(4pcs.)</h1>
                                    </div>
                                    <div class="COMPONENT_OTHERS_CONTAINER_ROW_OPTION_TYPE">
                                        <h1>ID Picture</h1>
                                    </div>
                                </button>
                            </div>
                        </div>

                        <div class="COMPONENT_OTHERS_CONTAINER_ROW_COLUMN GLOBAL_BOX_DIV w-2/5">
                            <div class="COMPONENT_OTHERS_CONTAINER_ROW_COLUMN_INNERDIV">
                                <div class="COMPONENT_TARPAULIN_CONTAINER_ROW_COLUMN_INNERDIV_TITLE">
                                    <h1>Enter the Size:</h1>
                                </div>
                            </div>
                            <div class="COMPONENT_OTHERS_CONTAINER_ROW_COLUMN_INNERDIV">
                                <div class="COMPONENT_OTHERS_CONTAINER_ROW_COLUMN_INNERDIV_INNERROW">
                                    <h1>Width:</h1>
                                    <input type="number">
                                </div>
                            </div>

                            <div class="COMPONENT_OTHERS_CONTAINER_ROW_COLUMN_INNERDIV_INNERROW">
                                <h1>Height:</h1>
                                <input type="number">
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
            </form>
        </div>
    </div>
</div>