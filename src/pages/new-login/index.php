<div class="flex bg-[#F6F6F9]">
    <?php
    include_once __DIR__ . "/../../components/sidebar.php";
    ?>

    <div class="GLOBAL_PAGE_CONTAINER">
        <div class="GLOBAL_HEADER">
            <div class="GLOBAL_HEADER_TITLE">
                <i class="material-symbols-rounded text-[42px]">
                    Person
                </i>
                <span class="">Add New User</span>
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
                <h1 class="text-2xl font-bold">User Information</h1> 
            </div>
            <form action="" method="post">
                <div class="flex flex-row gap-4 justify-between GLOBAL_BOX_DIV px-12 py-8 mb-6">

                    <!-- Column 1 -->
                    <div class="columns-1 flex flex-col flex-grow">
                        <!-- Email -->
                        <div class="flex flex-col pb-3">
                            <label for="email">Email</label>
                            <input type="email" name="Email" placeholder="Email" required>
                        </div>
                        <!-- First Name -->
                        <div class="flex flex-col pb-3">
                            <label for="first-name">First Name</label>
                            <input type="text" name="first-name" placeholder="First name" required>
                        </div>
                        <!-- Middle Name -->
                        <div class="flex flex-col pb-3">
                            <label for="middle-name">Middle Name</label>
                            <input type="text" name="middle-name" placeholder="Middle name" required>
                        </div>
                        <!-- Last Name -->
                        <div class="flex flex-col pb-3">
                            <label for="middle-name">Last Name</label>
                            <input type="text" name="middle-name" placeholder="Last name" required>
                        </div>
                        <!-- Suffix -->
                        <div class="flex flex-col pb-3">
                            <label for="suffix">Suffix</label>
                            <input type="text" name="suffix" placeholder="Suffix">
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div class="columns-2 flex flex-col flex-grow">
                        <!-- Contact Number -->
                        <div class="flex flex-col pb-3">
                            <label for="contact-number">Contact Number</label>
                            <input type="text" name="contact-number" placeholder="Contact number" required>
                        </div>
                        <!-- Address -->
                        <div class="flex flex-col pb-3">
                            <label for="address">Address</label>
                            <input type="text" name="address" placeholder="Address" required>
                        </div>
                        <!-- Hire Date -->
                        <div class="flex flex-col pb-3">
                            <label for="hire-date">Hire Date</label>
                            <div class="flex flex-row gap-2">
                                <input type="number" id="month" min="1" max="12" size="2" placeholder="Month" required>
                                <input type="number" id="day" min="1" max="31" size="2" placeholder="Day" required>
                                <input type="number" id="year" min="1900" max="2100" placeholder="Year" size="4" required>
                            </div>
                        </div>
                        <!-- Birth Date -->
                        <div class="flex flex-col pb-3">
                            <label for="birth-date">Birth Date</label>
                            <div class="flex flex-row gap-2">
                                <input type="number" min="1" max="12" size="2" placeholder="Month" required>
                                <input type="number" min="1" max="31" size="2" placeholder="Day" required>
                                <input type="number" min="1900" max="2100" placeholder="Year" size="4" required>
                            </div>
                        </div>
                        <!-- Gender -->
                        <div class="flex flex-col pb-3">
                            <label for="gender">Gender</label>
                            <select name="gender" required>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>
                    <!-- Column 3 -->
                    <div class="columns-3 flex flex-col flex-grow gap-2">
                        <div class="flex justify-center items-center">

                        </div>
                    </div>
                </div>
                <div class="flex flex-row justify-end">
                    <button type="submit" class="GLOBAL_BUTTON_GRAY mr-4">Cancel</button>
                    <button type="submit" class="GLOBAL_BUTTON_BLUE">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>