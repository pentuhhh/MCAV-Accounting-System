<div class="LOGIN_CONTAINER">
    <div class="LOGIN_CONTAINER_LOGINBOX">
        <!---------------------------------------LOGIN-------------------------------------------->

        <div class="text-center mb-6">
            <span class="text-3xl font-bold text-white quantico">Log In</span>
        </div>

        <!-------------------------------------USERNAME------------------------------------------->
        <form class="LOGIN_CONTAINER_LOGINBOX_FORM" action="/login/handler" method="POST">
            <div class="form-group UsernameSec">
                <div class="flex flex-row mb-2">
                    <i class="material-symbols-rounded text-gray-300">person</i>
                    <label for="username" class="block text-gray-300 font-bold  quantico">Username</label>
                </div>
                <input data-error="<?= var_export(isset($_SESSION["error"]["username"])); ?>" type="text" id="username" name="username" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline data-[error='true']:ring data-[error='true']:ring-[#DF166E]" placeholder="Enter username" required>
                <span class="text-[#DF166E] text-sm pt-1"><?= $_SESSION["error"]["username"] ?? ""; ?></span>
            </div>


            <!-------------------------------------PASSWORD------------------------------------------->
            <div class="form-group UsernameSec">
                <div class="items-center flex flex-row mb-2">
                    <i class="material-symbols-rounded text-gray-300">lock</i>
                    <label for="password" class="block text-gray-300 font-bold quantico justify-center"> Password</label>
                </div>
                <input data-error="<?= var_export(isset($_SESSION["error"]["password"])); ?>" type="password" id="password" name="password" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline data-[error='true']:ring data-[error='true']:ring-[#DF166E]"" placeholder=" Enter password" required>
                <span class="text-[#DF166E] text-sm pt-1"><?= $_SESSION["error"]["password"] ?? ""; ?></span>

                <!--------------------------------LOGIN BUTTON AND LOGO------------------------------------>
                <div class="flex flex-col items-center">

                    <button type="submit" class="bg-[#00A1E2] hover:bg-[#007BB5] duration-300 text-white font-bold py-0.5 px-10 mb-6 mt-5 rounded focus:outline-none focus:shadow-outline">
                        Login
                    </button>

                    <img src="/../assets/logo.png" alt="Logo" class="mb-4 w-90 h-18">

                </div>
            </div>
        </form>

    </div>
</div>

<?php
unset($_SESSION["error"]);
