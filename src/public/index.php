<?php

const BASE_PATH = __DIR__ . "/../..";

$urlPath = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

session_start();

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
</body>

</html>