<div class="flex bg-[#F6F6F9]">
    <?php
    include_once __DIR__ . "/../../components/sidebar.php";
    ?>

    <div class="flex flex-col w-full">
        <div class="GLOBAL_HEADER">
            <div class="GLOBAL_HEADER_TITLE">
                <i class="material-symbols-rounded text-[42px]">
                    Person
                </i>
                <span class="">Add New User</span>
            </div>
            <div class="GLOBAL_HEADER_COLUMN">
                <div class="flex flex-col text-right">
                    <p class="font-sm text-[#7F7F7F]">Hey, <strong class="text-black">Radon</strong></p>
                    <p class="font-sm text-[#7F7F7F]">Admin</p>
                </div>
            </div>
        </div>

        <!-- User Information -->
        <div class="px-10 flex-grow">
            <div class="flex flex-row pb-5 items-center justify-between">
                <h1 class="text-2xl font-bold">User Information</h1> 
                <a href="" class="flex items-center outline-none">
                    <i class="material-symbols-rounded text-[#7F7F7F] text-3xl">
                        arrow_back
                    </i>
                </a>
            </div>
            <form action="" method="post">
                <div class="flex flex-row gap-4 justify-between GLOBAL_BOX_DIV px-12 py-8 mb-6">

                    <!-- Column 1 -->
                    <div class="columns-1 flex flex-col flex-grow">
                        <!-- Email -->
                        <div class="flex flex-col pb-3">
                            <label for="email">Email</label>
                            <input type="email" name="Email" class="p-2 w-full border border-gray-300 rounded-lg">
                        </div>
                        <!-- First Name -->
                        <div class="flex flex-col pb-3">
                            <label for="first-name">First Name</label>
                            <input type="text" name="first-name" class="p-2 w-full border border-gray-300 rounded-lg">
                        </div>
                        <!-- Middle Name -->
                        <div class="flex flex-col pb-3">
                            <label for="middle-name">Middle Name</label>
                            <input type="text" name="middle-name" class="p-2 w-full border border-gray-300 rounded-lg">
                        </div>
                        <!-- Last Name -->
                        <div class="flex flex-col pb-3">
                            <label for="middle-name">Last Name</label>
                            <input type="text" name="middle-name" class="p-2 w-full border border-gray-300 rounded-lg">
                        </div>
                        <!-- Suffix -->
                        <div class="flex flex-col pb-3">
                            <label for="suffix">Suffix</label>
                            <input type="text" name="suffix" class="p-2 w-full border border-gray-300 rounded-lg">
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div class="columns-2 flex flex-col flex-grow">
                        <!-- Contact Number -->
                        <div class="flex flex-col pb-3">
                            <label for="contact-number">Contact Number</label>
                            <input type="text" name="contact-number" class="p-2 w-full border border-gray-300 rounded-lg">
                        </div>
                        <!-- Address -->
                        <div class="flex flex-col pb-3">
                            <label for="address">Address</label>
                            <input type="text" name="address" class="p-2 w-full border border-gray-300 rounded-lg">
                        </div>
                        <!-- Hire Date -->
                        <div class="flex flex-col pb-3">
                            <label for="hire-date">Hire Date</label>
                            <div class="flex flex-row gap-2">
                                <input type="number" id="month" min="1" max="12" size="2" placeholder="Month" class="p-2 w-1/3 border border-gray-300 rounded-lg">
                                <input type="number" id="day" min="1" max="31" size="2" placeholder="Day" class="p-2 w-1/3 border border-gray-300 rounded-lg">
                                <input type="number" id="year" min="1900" max="2100" placeholder="Year" size="4" class="p-2 w-1/3 border border-gray-300 rounded-lg">
                            </div>
                        </div>
                        <!-- Birth Date -->
                        <div class="flex flex-col pb-3">
                            <label for="birth-date">Birth Date</label>
                            <div class="flex flex-row gap-2">
                                <input type="number" min="1" max="12" size="2" placeholder="Month" class="p-2 w-1/3 border border-gray-300 rounded-lg">
                                <input type="number" min="1" max="31" size="2" placeholder="Day" class="p-2 w-1/3 border border-gray-300 rounded-lg">
                                <input type="number" min="1900" max="2100" placeholder="Year" size="4" class="p-2 w-1/3 border border-gray-300 rounded-lg">
                            </div>
                        </div>
                        <!-- Gender -->
                        <div class="flex flex-col pb-3">
                            <label for="gender">Gender</label>
                            <select name="gender" class="p-2 w-1/2 border border-gray-300 rounded-lg">
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
                <!-- Button Row -->
                <div class="flex flex-row justify-end">
                    <button type="submit" class="GLOBAL_BUTTON_GRAY mr-4">Cancel</button>
                    <button type="submit" class="GLOBAL_BUTTON_BLUE">Create User</button>
                </div>
            </form>
        </div>
        <!-- End of User Information -->
    </div>
</div>