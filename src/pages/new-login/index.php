<div class="GLOBAL_PAGE">
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
                    <p>Hey, <strong class="text-black">Radon</strong></p>
                    <p>Admin</p>
                </div>
                <img src="/assets/JumanjiRon.png" alt="">
            </div>
        </div>

        <div class="NEWLOGIN_INFO">
            <div class="GLOBAL_SUBHEADER">
                <h1>User Information</h1>
            </div>
            <form action="/new-login/new-login" method="post">
                <div class="NEWLOGIN_INPUT GLOBAL_BOX_DIV">

                    <!-- Column 1 -->
                    <div class="NEWLOGIN_INPUT_COLUMN">
                        <!-- Email -->
                        <div class="NEWLOGIN_INPUT_COLUMN_CONTAINER">
                            <label for="email">Email</label>
                            <input id="email" type="email" name="email" placeholder="Email" required>
                        </div>
                        <!-- First Name -->
                        <div class="NEWLOGIN_INPUT_COLUMN_CONTAINER">
                            <label for="first-name">First Name</label>
                            <input id="first-name" type="text" name="first-name" placeholder="First name" required>
                        </div>
                        <!-- Middle Name -->
                        <div class="NEWLOGIN_INPUT_COLUMN_CONTAINER">
                            <label for="middle-name">Middle Name</label>
                            <input id="middle-name" type="text" name="middle-name" placeholder="Middle name" required>
                        </div>
                        <!-- Last Name -->
                        <div class="NEWLOGIN_INPUT_COLUMN_CONTAINER">
                            <label for="middle-name">Last Name</label>
                            <input id="middle-name" type="text" name="last-name" placeholder="Last name" required>
                        </div>
                        <!-- Suffix -->
                        <div class="NEWLOGIN_INPUT_COLUMN_CONTAINER">
                            <label for="suffix">Suffix</label>
                            <input id="suffix" type="text" name="suffix" placeholder="Suffix">
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div class="NEWLOGIN_INPUT_COLUMN">
                        <!-- Contact Number -->
                        <div class="NEWLOGIN_INPUT_COLUMN_CONTAINER">
                            <label for="contact-number">Contact Number</label>
                            <input id="contact-number" type="text" name="contact-number" placeholder="Contact number" required>
                        </div>
                        <!-- Address -->
                        <div class="NEWLOGIN_INPUT_COLUMN_CONTAINER">
                            <label for="address">Address</label>
                            <input id="address" type="text" name="address" placeholder="Address" required>
                        </div>
                        <!-- Hire Date -->
                        <div class="NEWLOGIN_INPUT_COLUMN_CONTAINER">
                            <label for="hire-date">Hire Date</label>
                            <input id="hire-date" type="date" name="hire-date">
                        </div>
                        <!-- Birth Date -->
                        <div class="NEWLOGIN_INPUT_COLUMN_CONTAINER">
                            <label for="birth-date">Birth Date</label>
                            <input id="birth-date" type="date" name="birth-date">
                        </div>
                        <!-- Gender -->
                        <div class="NEWLOGIN_INPUT_COLUMN_CONTAINER w-1/2">
                            <label for="gender">Gender</label>
                            <select id="gender" name="gender" required>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>
                    <!-- Column 3 -->
                    <div class="NEWLOGIN_INPUT_COLUMN">
                        <div class="NEWLOGIN_INPUT_COLUMN_CONTAINER">
                            <label for="fileInput">Upload a file</label>
                            <input id="fileInput" name="profilePicture" type="file" accept="image/*" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <p class="mt-2 text-xs text-gray-500">Only .jpg, .png, files allowed</p>
                        </div>
                        <div class="NEWLOGIN_INPUT_COLUMN_CONTAINER">
                            <label id="password">Password</label>
                            <input id="password" type="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="NEWLOGIN_INPUT_COLUMN_CONTAINER">
                            <label class="pb-2">Permission</label>
                            <label for="user" class="NEWLOGIN_INPUT_COLUMN_CONTAINER_RADIO pb-2">
                                <input type="radio" id="user" name="permission" class="form-radio h-4 w-4 text-blue-600">
                                <span>User</span>
                            </label>
                            <label for="admin" class="NEWLOGIN_INPUT_COLUMN_CONTAINER_RADIO pb-2">
                                <input type="radio" id="admin" name="permission" class="form-radio h-4 w-4 text-blue-600">
                                <span>Administrator</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="NEWLOGIN_INFO_BUTTONS">
                    <button type="submit" id="submit" class="GLOBAL_BUTTON_BLUE">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>