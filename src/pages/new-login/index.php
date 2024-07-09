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
            <form action="" method="post">
                <div class="NEWLOGIN_INPUT GLOBAL_BOX_DIV">

                    <!-- Column 1 -->
                    <div class="NEWLOGIN_INPUT_COLUMN">
                        <!-- Email -->
                        <div class="NEWLOGIN_INPUT_COLUMN_CONTAINER">
                            <label for="email">Email</label>
                            <input type="email" name="Email" placeholder="Email" required>
                        </div>
                        <!-- First Name -->
                        <div class="NEWLOGIN_INPUT_COLUMN_CONTAINER">
                            <label for="first-name">First Name</label>
                            <input type="text" name="first-name" placeholder="First name" required>
                        </div>
                        <!-- Middle Name -->
                        <div class="NEWLOGIN_INPUT_COLUMN_CONTAINER">
                            <label for="middle-name">Middle Name</label>
                            <input type="text" name="middle-name" placeholder="Middle name" required>
                        </div>
                        <!-- Last Name -->
                        <div class="NEWLOGIN_INPUT_COLUMN_CONTAINER">
                            <label for="middle-name">Last Name</label>
                            <input type="text" name="middle-name" placeholder="Last name" required>
                        </div>
                        <!-- Suffix -->
                        <div class="NEWLOGIN_INPUT_COLUMN_CONTAINER">
                            <label for="suffix">Suffix</label>
                            <input type="text" name="suffix" placeholder="Suffix">
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div class="NEWLOGIN_INPUT_COLUMN">
                        <!-- Contact Number -->
                        <div class="NEWLOGIN_INPUT_COLUMN_CONTAINER">
                            <label for="contact-number">Contact Number</label>
                            <input type="text" name="contact-number" placeholder="Contact number" required>
                        </div>
                        <!-- Address -->
                        <div class="NEWLOGIN_INPUT_COLUMN_CONTAINER">
                            <label for="address">Address</label>
                            <input type="text" name="address" placeholder="Address" required>
                        </div>
                        <!-- Hire Date -->
                        <div class="NEWLOGIN_INPUT_COLUMN_CONTAINER">
                            <label for="hire-date">Hire Date</label>
                            <div class="flex flex-row gap-2">
                                <input type="number" id="month" min="1" max="12" size="2" placeholder="Month" required>
                                <input type="number" id="day" min="1" max="31" size="2" placeholder="Day" required>
                                <input type="number" id="year" min="1900" max="2100" placeholder="Year" size="4" required>
                            </div>
                        </div>
                        <!-- Birth Date -->
                        <div class="NEWLOGIN_INPUT_COLUMN_CONTAINER">
                            <label for="birth-date">Birth Date</label>
                            <div class="flex flex-row gap-2">
                                <input type="number" min="1" max="12" size="2" placeholder="Month" required>
                                <input type="number" min="1" max="31" size="2" placeholder="Day" required>
                                <input type="number" min="1900" max="2100" placeholder="Year" size="4" required>
                            </div>
                        </div>
                        <!-- Gender -->
                        <div class="NEWLOGIN_INPUT_COLUMN_CONTAINER w-1/2">
                            <label for="gender">Gender</label>
                            <select name="gender" required>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>
                    <!-- Column 3 -->
                    <div class="NEWLOGIN_INPUT_COLUMN">
                        <div class="NEWLOGIN_INPUT_COLUMN_CONTAINER">
                            
                        </div>
                    </div>
                </div>
                <div class="NEWLOGIN_INFO_BUTTONS">
                    <button type="submit" class="GLOBAL_BUTTON_GRAY mr-4">Cancel</button>
                    <button type="submit" class="GLOBAL_BUTTON_BLUE">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>