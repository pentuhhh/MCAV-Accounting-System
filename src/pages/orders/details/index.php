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
                <span>Order Details</span>
            </div>
            <div class="GLOBAL_HEADER_USER">
                <div class="GLOBAL_HEADER_COLUMN">
                    <p>Hey, <strong>Radon</strong></p>
                    <p>Admin</p>
                </div>
                <img src="/assets/JumanjiRon.png" alt="">
            </div>
        </div>
        
        <div class="DETAILS_CONTAINER">
            <div class="GLOBAL_SUBHEADER">
                <div class="DETAILS_ORDERID">
                    <h1>ODR22105032</h1>
                </div>
                <a onclick="window.history.back()">
                    <i class="material-symbols-rounded text-[#7F7F7F] text-3xl">
                        arrow_back
                    </i>
                </a>
            </div>

            <div class="DETAILS_CONTAINER_ROW columns-2">
                <div class="DETAILS_CONTAINER_ROW_LEFT">
                    <div class="GLOBAL_SUBHEADER_TITLE">
                        <h1>Customer Information</h1>
                    </div>
                    <div class="DETAILS_CONTAINER_ROW_TABLE GLOBAL_BOX_DIV">
                        <table>
                            <tr>
                                <td>Customer Name</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Contact Number</td>
                                <td></td>
                            </tr>
                        </table>
                        <div class="DETAILS_CONTAINER_ROW_BUTTON">
                            <button class="GLOBAL_BUTTON_BLUE">Edit Info</button>
                        </div>
                    </div>
                </div>
                <div class="DETAILS_CONTAINER_ROW_RIGHT">
                    <div class="GLOBAL_SUBHEADER_TITLE">
                        <h1>Order Information</h1>
                    </div>
                    <div class="DETAILS_CONTAINER_ROW_TABLE GLOBAL_BOX_DIV">
                        <table>
                            <tr>
                                <td>Order Date</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Deadline</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td></td>
                            </tr>
                        </table>
                        <div class="DETAILS_CONTAINER_ROW_BUTTON">
                            <button class="GLOBAL_BUTTON_RED">Cancel Order</button>
                            <button class="GLOBAL_BUTTON_GREEN">Complete</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="DETAILS_CONTAINER_ROW">
                <div class="DETAILS_CONTAINER_ROW_COLUMN">
                    <div class="DETAILS_CONTAINER_SUBHEADER">
                        <h1>Ordered Products</h1>
                        <button class="GLOBAL_BUTTON_BLUE ml-5">Add Item</button>
                    </div>
                    <div class="DETAILS_CONTAINER_ROW_TABLE GLOBAL_BOX_DIV">
                        <table>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                            <tr></tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="DETAILS_CONTAINER_ROW columns-2 pt-3">
                <div class="DETAILS_CONTAINER_ROW_LEFT">
                    <div class="GLOBAL_SUBHEADER_TITLE">
                        <h1>Payment Plan</h1>
                    </div>
                    <div class="DETAILS_CONTAINER_ROW_TABLE GLOBAL_BOX_DIV">
                        <table>
                            <tr>
                                <td>Payment Method</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Due Date</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Total Amount</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Total Paid</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Balance</td>
                                <td></td>
                            </tr>
                        </table>
                        <div class="DETAILS_CONTAINER_ROW_BUTTON">
                            <button class="GLOBAL_BUTTON_BLUE">Edit Info</button>
                        </div>
                    </div>
                </div>
                <div class="DETAILS_CONTAINER_ROW_RIGHT">
                    <div class="GLOBAL_SUBHEADER_TITLE">
                        <h1>Order Information</h1>
                    </div>
                    <div class="DETAILS_CONTAINER_ROW_TABLE GLOBAL_BOX_DIV">
                        <table>
                            <tr>
                                <th>Receipt ID</th>
                                <th>Amount Paid</th>
                                <th>Date Paid</th>
                            </tr>
                            <tr></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>