<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

const BASE_PATH = __DIR__ . "/../..";

$urlPath = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

session_start();

//DESTIN FIXED IT

// echo "Session started. Session ID: " . session_id() . "<br>";

// Function to check if user is logged in
function isLoggedIn()
{
    return isset($_SESSION['username']);
}

// Function to redirect to login page
function redirectToLogin()
{
    // echo "Redirecting to login page...<br>";
    header("Location: /login");
    exit();
}

// Check if the user is trying to access the login page
$isLoginPage = preg_match("/login/i", $urlPath) > 0;

// echo "Current URL path: " . $urlPath . "<br>";
// echo "Is login page: " . ($isLoginPage ? "Yes" : "No") . "<br>";
// echo "Is logged in: " . (isLoggedIn() ? "Yes" : "No") . "<br>";

// If not logged in and not trying to access the login page, redirect to login
if (!isLoggedIn() && !$isLoginPage) {
    redirectToLogin();
}

$pagePath = BASE_PATH . "/src/pages$urlPath";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCAV</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:wght,FILL@300,1" />
    <link type="text/css" rel="stylesheet" href="/output.css" />
    <script src="/script.js" defer></script>
</head>

<body class="font-poppins">
    <?php
    // Include the requested page if it exists
    if (file_exists($pagePath . "/index.php")) {
        include_once $pagePath . "/index.php";
    } elseif (file_exists($pagePath . ".php")) {
        include_once $pagePath . ".php";
    } else {
        // Show a 404 error if the page is not found
        http_response_code(404);
        echo "404 Not Found";
    }
    ?>

    <div id="popupModal" class="POPUP_CONTAINER hidden">
        <!-- Modal content -->
        <div class="POPUP_CONTAINER_BOX GLOBAL_BOX_DIV">
            <span class="closeButton absolute top-2 right-4 text-2xl text-gray-500 cursor-pointer">&times;</span>
            <div class="GLOBAL_SUBHEADER_TITLE flex flex-row justify-between">
                <h1>Alvin De Leon</h1>
                <button class="GLOBAL_BUTTON_BLUE">Edit</button>
            </div>
            <h1 class="text-[#00A1E2] font-semibold text-lg pb-5">EM0001</h1>
            <table>
                <tr>
                    <td>Employee Name</td>
                    <td>Alvin De Leon</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>alvin253@gmail.com</td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td>Email</td>
                </tr>
                <tr>
                    <td>Phone Number</td>
                    <td>09662537382</td>
                </tr>
                <tr>
                    <td>Birthdate</td>
                    <td>02-14-1976</td>
                </tr>
                <tr>
                    <td>Hiredate</td>
                    <td>02-15-2012</td>
                </tr>
                <tr>
                    <td>Position</td>
                    <td>User</td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td>**********</td>
                </tr>
            </table>
        </div>
    </div>

    <div id="popupModalReceipt" class="POPUP_CONTAINER hidden">
        <!-- Modal content -->
        <div class="POPUP_CONTAINER_BOX GLOBAL_BOX_DIV">
            <span class="closeButtonReceipt absolute top-2 right-4 text-2xl text-gray-500 cursor-pointer">&times;</span>
            <div class="flex flex-row justify-between">
                <div class="GLOBAL_HEADER_TITLE">
                    <i class="material-symbols-rounded text-[40px]">
                        payments
                    </i>
                    <h1 class="text-2xl font-bold ml-2">RCT000001</h1>
                </div>
                <button class="GLOBAL_BUTTON_BLUE ml-5">Edit</button>
            </div>
            <h1 class="font-semibold text-lg mb-4">Details</h1>
            <table class="pb-5">
                <tr>
                    <td>Order ID</td>
                    <td>ODR00001</td>
                </tr>
                <tr>
                    <td>Amount Paid</td>
                    <td>P 20.30</td>
                </tr>
                <tr>
                    <td>Payment Date</td>
                    <td>24-02-24</td>
                </tr>
                <tr>
                    <td>Pay Method</td>
                    <td>Cash</td>
                </tr>
            </table>
            <h1 class="text-right font-semibold text-lg mt-5">
                Total Amount:
                <span>P 72.20</span>
            </h1>
            <h1 class="text-right font-semibold text-lg">
                Payment Amount Left:
                <span>P 52.30</span>
            </h1>
        </div>
    </div>
</body>

</html>