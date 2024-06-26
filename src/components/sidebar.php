<?php
$urlPath = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$activePath = [
    "dashboard" => preg_match("/dashboard/i", $urlPath) > 0,
    "users" => preg_match("/users/i", $urlPath) > 0,
    "orders" => preg_match("/orders/i", $urlPath) > 0,
    "receipts" => preg_match("/receipts/i", $urlPath) > 0,
    "new-login" => preg_match("/new-login/i", $urlPath) > 0
];
?>

<!-- Sidebar Component -->
<div class="flex flex-col justify-between w-full max-w-[300px] h-dvh bg-[#0C0E0D]">
    <div>
        <img src="/assets/mcav.jpg" alt="mcav logo" class="w-full mb-8">

        <ul>
            <!-- Dashboard -->
            <li data-active=<?= var_export($activePath["dashboard"]); ?> class="COMPONENT_SIDEBAR_BUTTON before:bg-[#049FDD]">
                <a href="/dashboard">
                    <i class="material-symbols-rounded text-white text-3xl">
                        dashboard
                    </i>
                    <span class="text-lg font-semibold text-white">Dashboard</span>
                </a>
            </li>
            <!-- Users -->
            <li data-active=<?= var_export($activePath["users"]); ?> class="COMPONENT_SIDEBAR_BUTTON">
                <a href="/users">
                    <i class="material-symbols-rounded text-white text-3xl">
                        person
                    </i>
                    <span class="text-lg font-semibold text-white">Users</span>
                </a>
            </li>
            <!-- Orders -->
            <li data-active=<?= var_export($activePath["orders"]); ?> class="COMPONENT_SIDEBAR_BUTTON">
                <a href="/orders">
                    <i class="material-symbols-rounded text-white text-3xl">
                        receipt_long
                    </i>
                    <span class="text-lg font-semibold text-white">Orders</span>
                </a>
            </li>
            <!-- Receipts -->
            <li data-active=<?= var_export($activePath["receipts"]); ?> class="COMPONENT_SIDEBAR_BUTTON">
                <a href="/receipts">
                    <i class="material-symbols-rounded text-white text-3xl">
                        payments
                    </i>
                    <span class="text-lg font-semibold text-white">Receipts</span>
                </a>
            </li>
            <!-- New Login -->
            <li data-active=<?= var_export($activePath["new-login"]); ?> class="COMPONENT_SIDEBAR_BUTTON">
                <a href="/new-login">
                    <i class="material-symbols-rounded text-white text-3xl">
                        add
                    </i>
                    <span class="text-lg font-semibold text-white">New Login</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="COMPONENT_SIDEBAR_LOGOUT_BUTTON mb-6">
        <a href="/log-out">
            <i class="material-symbols-rounded text-white text-3xl">
                Logout
            </i>
            <span class="text-lg font-semibold text-white">Log Out</span>
        </a>
    </div>
</div>