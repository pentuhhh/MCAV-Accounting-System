<div class="flex">
    <?php
    include_once __DIR__ . "/../../components/sidebar.php";
    ?>

    <div class="flex flex-col">
        <!-- Header -->
        <div class="flex items-center p-8">
            <i class="material-symbols-rounded text-[42px]">
                Person
            </i>
            <span class="pl-2 text-2xl font-bold">Add New User</span>
        </div>
        <!-- End of Header -->

        <!-- User Information -->
        <div class="items-center px-8">
            <h1 class="text-2xl font-bold">User Information</h1>
            <div class="flex flex-col">
                <form action="" method="post" class="flex">
                    <!-- Column 1 -->
                    <div class="columns-1">
                        <!-- Email -->
                        <div class="flex flex-col">
                            <label for="email">Email</label>
                            <input type="email" name="Email" class="p-2 w-full border border-gray-300 rounded-lg">
                        </div>
                        <!-- First Name -->
                        <div class="flex flex-col">
                            <label for="first-name">First Name</label>
                            <input type="text" name="first-name" class="p-2 w-full border border-gray-300 rounded-lg">
                        </div>
                        <!-- Middle Name -->
                        <div class="flex flex-col">
                            <label for="middle-name">Middle Name</label>
                            <input type="text" name="middle-name" class="p-2 w-full border border-gray-300 rounded-lg">
                        </div>
                        <!-- Last Name -->
                        <div class="flex flex-col">
                            <label for="middle-name">Last Name</label>
                            <input type="text" name="middle-name" class="p-2 w-full border border-gray-300 rounded-lg">
                        </div>
                        <!-- Suffix -->
                        <div class="flex flex-col">
                            <label for="suffix">Suffix</label>
                            <input type="text" name="suffix" class="p-2 w-full border border-gray-300 rounded-lg">
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div class="columns-2">
                        <!-- Contact Number -->
                        <div class="flex flex-col">
                            <label for="contact-number">Contact Number</label>
                            <input type="text" name="contact-number" class="p-2 w-full border border-gray-300 rounded-lg">
                        </div>
                        <!-- Address -->
                        <div class="flex flex-col">
                            <label for="address">Address</label>
                            <input type="text" name="address" class="p-2 w-full border border-gray-300 rounded-lg">
                        </div>
                        <!-- Hire Date -->
                        <div class="flex flex-col">
                            <label for="hire-date">Hire Date</label>
                            <input type="number" id="month" min="1" max="12" size="2" placeholder="Month" class="p-2 w-2/4 border border-gray-300 rounded-lg">
                            <input type="number" id="day" min="1" max="31" size="2" placeholder="Day" class="p-2 w-1/4 border border-gray-300 rounded-lg">
                            <input type="number" id="year" min="1900" max="2100" placeholder="Year" size="4" class="p-2 w-1/4 border border-gray-300 rounded-lg">
                        </div>
                        <!-- Birth Date -->
                        <div class="flex flex-col">
                            <label for="birth-date">Birth Date</label>
                            <input type="number" min="1" max="12" size="2" placeholder="Month" class="p-2 w-2/4 border border-gray-300 rounded-lg">
                            <input type="number" min="1" max="31" size="2" placeholder="Day" class="p-2 w-1/4 border border-gray-300 rounded-lg">
                            <input type="number" min="1900" max="2100" placeholder="Year" size="4" class="p-2 w-1/4 border border-gray-300 rounded-lg">
                        </div>
                        <!-- Gender -->
                        <div class="flex flex-col">
                        <label for="gender">Gender</label>
                        <select name="gender" class="p-2 w-full border border-gray-300 rounded-lg">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    </div>

                    <!-- Column 3 -->
                    <div class="columns-3">

                    </div>
                    <div class="flex flex-col">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="p-2 w-1/2 border border-gray-300 rounded-lg">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="p-2 bg-blue-500 text-white rounded-lg">Add User</button>
                </form>
            </div>
        </div>
        <!-- End of User Information -->
    </div>
</div>