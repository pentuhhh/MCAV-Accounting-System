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
                    <p class="text-sm text-[#7F7F7F]">Hey, <strong class="text-black">Radon</strong></p>
                    <p class="text-sm text-[#7F7F7F]">Admin</p>
                </div>
                <img src="/assets/JumanjiRon.png" alt="">
            </div>
        </div>

        <div class="px-10 flex-grow">
            <div class="flex flex-row pb-5 items-center justify-between">
                <h1 class="text-2xl font-bold">Customer Information</h1> 
				<a onclick="window.history.back(); return false;" class="flex items-center outline-none">
                    <i class="material-symbols-rounded text-[#7F7F7F] text-3xl">
                        arrow_back
                    </i>
                </a>
            </div>

            <form action="" method="post">
                <div class="flex flex-row gap-10 justify-start GLOBAL_BOX_DIV px-12 py-8 mb-6">

                    <!-- Column 1 -->
                    <div class="columns-1 flex flex-col w-[400px]">
                        <!-- First Name -->
                        <div class="flex flex-col pb-3">
                            <label for="first-name">First Name</label>
                            <input type="text" name="first-name" placeholder="First name" required>
                        </div>
                        <!-- Last Name -->
                        <div class="flex flex-col pb-3">
                            <label for="last-name">Last Name</label>
                            <input type="text" name="last-name" placeholder="Last name" required>
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div class="columns-2 flex flex-col w-[400px]">
                        <!-- Email -->
                        <div class="flex flex-col pb-3">
                            <label for="email">Email</label>
                            <input type="text" name="contact-number" placeholder="Email" required>
                        </div>
                        <!-- Phone Number -->
                        <div class="flex flex-col pb-3">
                            <label for="phone-number">Phone Number</label>
                            <input type="text" name="phone-number" placeholder="Phone number" required>
                        </div>
					</div>
                </div>

				<div class="flex flex-row pb-5 items-center justify-between">
					<h1 class="text-2xl font-bold">Payment Plan</h1> 
				</div>

                <div class="flex flex-row gap-10 justify-start GLOBAL_BOX_DIV px-12 py-8 mb-6">

                    <!-- Column 1 -->
                    <div class="columns-1 flex flex-col w-[400px]">
						<!-- Payment Method -->
                        <div class="flex flex-col pb-3">
                            <label for="payment-method">Payment Method</label>
                            <select name="payment-method" id="payment-method" onchange="enableInput(this)">
                                <option value="cash">Cash</option>
                                <option value="bank-transfer">Bank Transfer</option>
								<!-- Enter More Options -->
                            </select>
                        </div>
						<!-- Due Date -->
						<div class="flex flex-col pb-3">
                            <label for="due-date">Due Date</label>
                            <div class="flex flex-row gap-2">
                                <input type="number" id="month" min="1" max="12" size="2" placeholder="Month" required>
                                <input type="number" id="day" min="1" max="31" size="2" placeholder="Day" required>
                                <input type="number" id="year" min="1900" max="2100" placeholder="Year" size="4" required>
                            </div>
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div class="columns-2 flex flex-col w-[400px]">
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
                <div class="flex flex-row justify-end">
                    <a href="/orders" class="GLOBAL_BUTTON_GRAY mr-4">Cancel</a>
                    <a href="/orders/add-new/products" class="GLOBAL_BUTTON_BLUE">Proceed</a>
                </div>
			</form>
        </div>
    </div>
</div>