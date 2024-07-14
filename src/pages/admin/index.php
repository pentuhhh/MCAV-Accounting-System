<?php
$username = $_SESSION['username'];
$profilePicture = isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : '';
?>

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
                <span class="">Admin</span>
            </div>
            <div class="GLOBAL_HEADER_USER">
                <div class="GLOBAL_HEADER_COLUMN">
                    <p>Hey, <strong><?php echo htmlspecialchars($username); ?></strong></p>
                    <p>Admin</p>
                </div>
                <img src="<?php echo htmlspecialchars($profilePicture); ?>" alt="Profile Picture">
            </div>
        </div>
    </div>

</div>