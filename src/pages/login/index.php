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
                    <label for="username" class="block text-gray-300 font-bold  quantico"> Username</label>
                </div>
                <input type="text" id="username" name="username" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter username" required>
            </div>


            <!-------------------------------------PASSWORD------------------------------------------->
            <div class="form-group UsernameSec">
                <div class="items-center flex flex-row mb-2">
                    <i class="material-symbols-rounded text-gray-300">lock</i>
                    <label for="password" class="block text-gray-300 font-bold quantico justify-center"> Password</label>
                </div>
                <input type="password" id="password" name="password" class="shadow appearance-none border rounded py-2 px-3 mb-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter password" required>


                <!--------------------------------LOGIN BUTTON AND LOGO------------------------------------>
                <div class="flex flex-col items-center">

                    <button type="submit" class="bg-[#00A1E2] hover:bg-[#007BB5] duration-300 text-white font-bold py-0.5 px-10 mb-6 rounded focus:outline-none focus:shadow-outline">
                        Login
                    </button>

                    <img src="/../assets/logo.png" alt="Logo" class="mb-4 w-90 h-18">

                </div>
            </div>
        </form>

    </div>