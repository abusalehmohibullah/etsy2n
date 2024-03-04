<?php
// takes url and see which page it is 
$category_explode = explode("/", $_SERVER['REQUEST_URI']);
$page_name = $category_explode[count($category_explode) - 1];


?>




<!-- side nav div  -->
<div class="col-12 col-md-12 col-lg-3 col-xl-3 col-xxl-2 set-height">
    <!-- side nav  -->
    <nav class="navbar navbar-expand-lg py-0 set-height">

        <div class="top-bar d-flex w-100 p-2">
            <a class="navbar-brand" href="#">
                <img src="../assets/images/logo/<?php
                                                if (isset($logo) && !empty($logo)) {
                                                    foreach ($logo as $data) {
                                                        echo $data->logo_image;
                                                    }
                                                }
                                                ?>" alt="Bootstrap" height="30">
            </a>
            <div class="ms-auto toggler-container">
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <span class="navbar-toggler-icon menu-button"></span>
                </button>
            </div>
        </div>

        <div class="container set-height">
            <div class="offcanvas offcanvas-start h-100 w-100 " tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><img src="../assets/images/logo/<?php
                                                                                                            if (isset($logo) && !empty($logo)) {
                                                                                                                foreach ($logo as $data) {
                                                                                                                    echo $data->logo_image;
                                                                                                                }
                                                                                                            }
                                                                                                            ?>" alt="Bootstrap" height="24"> </h5>
                    <button type="button" class="btn-close m-1" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body side-nav rounded-5 h-100 d-flex justify-content-center">


                    <ul class="navbar-nav flex-column justify-content-around align-items-center h-100">
                        <div class="top-bar-mini h3 pt-3"><img src="../assets/images/logo/<?php
                                                                                            if (isset($logo) && !empty($logo)) {
                                                                                                foreach ($logo as $data) {
                                                                                                    echo $data->logo_image;
                                                                                                }
                                                                                            }
                                                                                            ?>" alt="Bootstrap" height="30"></div>
                        <li class="nav-item admin-nav-btn rounded-4 w-100 text-center p-2">
                            <a class="nav-link d-flex align-items-center gap-1 <?php if ($page_name == "index.php" || $page_name == "") {
                                                                                    echo "active";
                                                                                    $page_title = "Dashboard";
                                                                                } ?> >" aria-current="page" href="index.php"><i class="bi bi-house"></i>

                                Dashboard
                                <?php

                                if ($withdrawalRequestCount > 0) {
                                ?>
                                    <span class="badge text-bg-danger px-2 py-1">
                                        <?php
                                        echo $withdrawalRequestCount;
                                        ?>
                                    </span>
                                <?php
                                }
                                ?>
                            </a>
                        </li>
                        <li class="nav-item admin-nav-btn rounded-4 w-100 text-center p-2">
                            <a class="nav-link  <?php if ($page_name == "create-order.php") {
                                                    echo "active";
                                                    $page_title = "Create Order";
                                                } ?> >" aria-current="page" href="create-order.php"><i class="bi bi-plus-lg"></i> Create Order</a>
                        </li>
                        <li class="nav-item admin-nav-btn rounded-4 w-100 text-center p-2">
                            <a class="nav-link <?php if ($page_name == "slider.php") {
                                                    echo "active";
                                                    $page_title = "Create Slides";
                                                } ?> >" href="slider.php"><i class="bi bi-chevron-double-right"></i> Slider</a>
                        </li>
                        <li class="nav-item admin-nav-btn rounded-4 w-100 text-center p-2">
                            <a class="nav-link <?php if ($page_name == "notification.php") {
                                                    echo "active";
                                                    $page_title = "Send Notifications";
                                                } ?> >" href="notification.php"><i class="bi bi-bell"></i> Notifications</a>
                        </li>
                        <li class="nav-item admin-nav-btn rounded-4 w-100 text-center p-2">
                            <a class="nav-link <?php if ($page_name == "popup.php") {
                                                    echo "active";
                                                    $page_title = "Send Popup";
                                                } ?> >" href="popup.php"><i class="bi bi-chat-square"></i> Popup</a>
                        </li>
                        <li class="nav-item admin-nav-btn rounded-4 w-100 text-center p-2">
                            <a class="nav-link <?php if ($page_name == "users.php") {
                                                    echo "active";
                                                    $page_title = "Manage Users";
                                                } elseif ($page_name == "jackpot.php") {
                                                    echo "active";
                                                    $page_title = "Jackpot";
                                                } ?> >" href="users.php"><i class="bi bi-people"></i> Users</a>
                        </li>
                        <li class="nav-item admin-nav-btn rounded-4 w-100 text-center p-2">
                            <a class="nav-link <?php if ($page_name == "manage-emails.php") {
                                                    echo "active";
                                                    $page_title = "Manage Emails";
                                                } ?> >" href="manage-emails.php"><i class="bi bi-envelope"></i> Emails</a>
                        </li>
                        <li class="nav-item admin-nav-btn rounded-4 w-100 text-center p-2">
                            <a class="nav-link <?php if ($page_name == "settings.php" || $page_name == "change-logo.php" || $page_name == "change-email.php" || $page_name == "change-password.php" || $page_name == "manage-language.php" || $page_name == "manage-admins.php") {
                                                    echo "active";
                                                    $page_title = "Settings";
                                                } ?> >" href="settings.php"><i class="bi bi-gear"></i> Settings</a>
                        </li>
                        <li class="nav-item admin-nav-btn rounded-4 w-100 text-center p-2">
                            <a class="nav-link text-danger" href="admin-logout.php"><i class="bi bi-box-arrow-right"></i> Log Out</a>
                        </li>

                    </ul>

                </div>
            </div>
        </div>
    </nav>
</div>