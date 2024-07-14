<div class="GLOBAL_PAGE">
    <?php
    include_once __DIR__ . "/../../../components/sidebar.php";

    $username = $_SESSION['username'];
    $profilePicture = isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : '';
    ?>

    <div class="GLOBAL_PAGE_CONTAINER">
        <div class="GLOBAL_HEADER">
            <div class="GLOBAL_HEADER_TITLE">
                <i class="material-symbols-rounded text-[42px]">
                    Person
                </i>
                <span class="">User Details</span>
            </div>
            <div class="GLOBAL_HEADER_USER">
                <div class="GLOBAL_HEADER_COLUMN">
                    <p>Hey, <strong><?php echo htmlspecialchars($username); ?></strong></p>
                    <p>Admin</p>
                </div>
                <img src="../<?php echo htmlspecialchars($profilePicture); ?>" alt="Profile Picture">
            </div>
        </div>

        <div class="NEWLOGIN_INFO">
            <div class="GLOBAL_SUBHEADER">
                <h1>User Information</h1>
                <a onclick="window.history.back()">
                    <i class="material-symbols-rounded text-[#7F7F7F] text-3xl">
                        arrow_back
                    </i>
                </a>
            </div>
            <form action="/new-login/new-login" method="post" enctype="multipart/form-data">
                <div class="NEWLOGIN_INPUT GLOBAL_BOX_DIV">

                    <!-- Column 1 -->
                    <div class="NEWLOGIN_INPUT_COLUMN">
                        <!-- username -->
                        <div class="NEWLOGIN_INPUT_COLUMN_CONTAINER">
                            <label for="username">Username</label>
                            <input id="username" type="text" name="username" placeholder="Username" required>
                        </div>
                        <!-- First Name -->
                        <div class="NEWLOGIN_INPUT_COLUMN_CONTAINER">
                            <label for="first-name">First Name</label>
                            <input id="first-name" type="text" name="first-name" placeholder="First name" required>
                        </div>
                        <!-- Last Name -->
                        <div class="NEWLOGIN_INPUT_COLUMN_CONTAINER">
                            <label for="middle-name">Last Name</label>
                            <input id="middle-name" type="text" name="last-name" placeholder="Last name" required>
                        </div>

                        <!-- Position -->
                        <div class="NEWLOGIN_INPUT_COLUMN_CONTAINER">
                            <label for="position">Position</label>
                            <input id="position" type="text" name="position" placeholder="Position" required>
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
                    </div>
                    <!-- Column 3 -->
                    <div class="NEWLOGIN_INPUT_COLUMN">
                        <!-- Gender -->
                        <div class="NEWLOGIN_INPUT_COLUMN_CONTAINER">
                            <label for="gender">Gender</label>
                            <select id="gender" name="gender" required>
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                            </select>
                        </div>
                        <!-- Password -->
                        <div class="NEWLOGIN_INPUT_COLUMN_CONTAINER">
                            <label id="password">Password</label>
                            <input id="password" type="password" name="password" placeholder="Password" required>
                        </div>
                        <!-- Permission -->
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
                    <button type="submit" id="submit" class="GLOBAL_BUTTON_BLUE">Edit User</button>
                </div>
            </form>
        </div>
    </div>
</div>