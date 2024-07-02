<!-- TODO: Create a login page. Assigned to Vin Michael Sagarino -->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Quantico&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .background-logo {
      background-image: url('BackgroundLogo.png');
      background-size: cover;
      background-position: center;
    }
    .custom-width {
      width: 75%;
    }
    .quantico{
        font-family: Quantico;
    }
    .poppins{
        font-family: Poppins;
    }
    .form-container {
      display: grid;
      grid-template-columns: 1fr;
      grid-gap: 1rem;
      align-items: center;
      justify-items: center;
    }
    .form-group {
      display: grid;
      grid-template-columns: 1fr;
      width: 75%;
    }
    .form-group label, .form-group input {
      width: 100%;
      text-align: left;
    }
    .form-group input {
      text-align: left;
    }
  </style>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen background-logo">
  <div class="bg-[#0C0E0D] shadow-md rounded-lg p-8 w-full max-w-lg">
    <div class="text-center mb-6">
      <span class="text-3xl font-bold text-white quantico">Log In</span>
    </div>
    <form class="form-container">
      <div class="form-group UsernameSec">
        <label for="username" class="block text-gray-300 font-bold mb-2 quantico">Username</label>
        <input type="text" id="username" name="username" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter your username">
      </div>
      <div class="form-group PasswordSec">
        <label for="password" class="block text-gray-300 font-bold mb-2 quantico">Password</label>
        <input type="password" id="password" name="password" class="shadow appearance-none border rounded py-2 px-3 mb-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter your password">
      </div>
      <div class="flex flex-col items-center">
        <button type="submit" class="bg-[#00A1E2] hover:bg-blue-700 text-white font-bold py-0.5 px-10 mb-6 rounded focus:outline-none focus:shadow-outline poppins">
          Login
        </button>
        <img src="logo.png" alt="Logo" class="mb-4 w-90 h-18">
      </div>
    </form>
  </div>
</body>
</html>
