<?php

if (isset($_GET["language"])) {
    $language = $_GET["language"];
    setcookie('language', $language, time() + (86400 * 30), "/"); // set cookie to expire in 30 days
} elseif (isset($_COOKIE['language'])) {
    $language = $_COOKIE['language'];
} else {
    $language = "English";
}


$sql = "SELECT * FROM languages WHERE language_name = '$language' AND status = 2";
$connection->set_charset('utf8');
$result = $connection->query($sql);
$language_data = $result->fetch_assoc(); // get the row as an associative array

$_SESSION['language-data'] = $language_data;

// Check if the user's status is not equal to 1
$notification_count = 0;
if (is_authenticate_user()) {
    $query = "SELECT COUNT(*) FROM notifications WHERE (FIND_IN_SET($login_id, target_user) > 0 AND FIND_IN_SET($login_id, read_by) = 0) AND status = 1";
    $count_result = mysqli_query($connection, $query);
    $notification_count = mysqli_fetch_array($count_result)[0];
}


?>

<nav class="navbar top-nav bg-white fixed-top shadow-sm">
    <div class="container d-flex">
        <a class="navbar-brand" href="./index.php">
            <img src="./assets/images/logo/<?php
                                            if (isset($logo) && !empty($logo)) {
                                                foreach ($logo as $data) {
                                                    echo $data->logo_image;
                                                }
                                            }
                                            ?>" alt="Bootstrap" height="30">
        </a>
        <div class="ms-auto d-flex justify-content-center gap-3">
            <div class="d-flex justify-content-center align-items-center gap-2">
                <div class="fs-4 bg-white rounded d-flex justify-content-center align-items-center shadow-sm">
                    <button class="btn btn-outline-none fs-5 language-btn" data-bs-toggle="modal" data-bs-target="#languageModal">
                        <i class="ri-global-line fs-5 language-btn"></i> <?php echo $language ?></button>
                </div>




                <a class="btn px-2 py-0" href="notification.php">

                    <span class="position-relative pt-2">
                        <i class="bi bi-bell fs-2"></i>
                        <?php     // check if the count is greater than zero
                        if ($notification_count > 0) { ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?php if ($notification_count > 99) {
                                    echo "99+";
                                } else {
                                    echo $notification_count;
                                } ?>
                            </span>

                        <?php } ?>
                    </span>
                </a>




            </div>



            <button class="navbar-toggler button-white shadow-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="offcanvas offcanvas-end more" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header top-nav py-2">
                <button type="button" class="navbar-toggler" data-bs-dismiss="offcanvas" aria-label="Close">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><?php echo $language_data['more'] ?></h5>

            </div>
            <div class="offcanvas-body deep-bg d-flex flex-column justify-content-between">
                <div>
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link text-white" aria-current="page" href="./company-profile.php"><?php echo $language_data['company_profile'] ?></a>
                            <a class="nav-link text-white" aria-current="page" href="./agency-cooperation.php"><?php echo $language_data['agency'] ?></a>
                            <a class="nav-link text-white" aria-current="page" href="./rules-and-terms.php"><?php echo $language_data['rules'] ?></a>
                            <a class="nav-link text-white" aria-current="page" href="./privacy-policy.php"><?php echo $language_data['privacy'] ?></a>
                            <a class="nav-link text-white" aria-current="page" href="./about-us.php"><?php echo $language_data['about'] ?></a>
                        </li>

                    </ul>

                </div>
                <div class="bg-danger rounded px-3 py-2 fs-5 d-flex shadow-sm mt-2 position-relative">
                    <div class="text-white fw-bold"><i class="ri-logout-box-r-line fw-bolder"></i> </i><?php echo $language_data['logout'] ?></div>
                    <a href="./logout.php" class="stretched-link"></a>
                </div>
            </div>
        </div>
    </div>
</nav>

<nav class="navbar bottom-nav deep-bg fixed-bottom py-1">
    <div class="container">
        <ul class="navbar-nav d-flex flex-row justify-content-around align-items-end w-100">

            <li class="nav-item text-center p-0 bottom-tabs">
                <a class="nav-link p-0 
                        <?php if ($page_name == "index.php") {
                            echo "fw-semibold border border-2 border-top-0 border-start-0 border-end-0";
                        } ?>
                        " href="index.php">
                    <img src="./assets/images/icons/home.png" alt="" width="30px" height="30px">
                    <div class="tab-name text-white"><?php echo $language_data['home'] ?></div>
                </a>
            </li>
            <li class="nav-item text-center p-0 bottom-tabs">
                <a class="nav-link p-0
                        <?php if ($page_name == "all-order.php" || $page_name == "pending-order.php" || $page_name == "completed-order.php") {
                            echo "fw-semibold border border-2 border-top-0 border-start-0 border-end-0";
                        } ?>
                        " href="all-order.php">
                    <img src="./assets/images/icons/order.png" alt="" width="30px" height="30px">
                    <div class="tab-name text-white"><?php echo $language_data['orders'] ?></div>
                </a>
            </li>
            <li class="nav-item text-center p-0 bottom-tabs">

                <a class="nav-link stretched-link position-relative p-0
                        <?php if ($page_name == "grabbing.php") {
                            echo "fw-semibold border border-2 border-top-0 border-start-0 border-end-0";
                        } ?>
                    " href="grabbing.php">

                    <div class="position-absolute grabbing-btn bottom-100 start-50 translate-middle-x shadow">
                        <img src="./assets/images/icons/grabbing.png" alt="" width="30px" height="30px">
                    </div>
                    <div class="tab-name text-white"><?php echo $language_data['grabbing'] ?></div>
                </a>
            </li>

            <li class="nav-item text-center p-0 bottom-tabs">
                <a class="nav-link p-0" href="https://direct.lc.chat/15657222/" target="_blank">
                    <img src="./assets/images/icons/services.png" alt="" width="30px" height="30px">
                    <div class="tab-name text-white"><?php echo $language_data['services'] ?></div>
                </a>
            </li>



            <li class="nav-item text-center p-0 bottom-tabs">
                <a class="nav-link p-0
                        <?php if ($page_name == "me.php") {
                            echo "fw-semibold border border-2 border-top-0 border-start-0 border-end-0";
                        } ?>
                    " href="me.php">
                    <img src="./assets/images/icons/me.png" alt="" width="30px" height="30px">
                    <div class="tab-name text-white"><?php echo $language_data['me'] ?></div>
                </a>
            </li>

        </ul>
    </div>
</nav>


<!-- Modal -->
<div class="modal fade" id="languageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content light-bg">

            <button type="button" class="btn-close position-absolute m-2 top-0 end-0 z-3" data-bs-dismiss="modal" aria-label="Close"></button>

            <div class="modal-body">
                <div class="d-flex flex-column gap-2 justify-content-center align-items-center">
                    <?php

                    $sql = "SELECT language_name FROM languages WHERE status = 2";
                    $connection->set_charset('utf8');
                    $result = $connection->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) { ?>

                            <div>
                                <button class="btn btn-outline-none" onclick="changeLanguage('<?php echo $row["language_name"] ?>', window.location.href)"><?php echo $row["language_name"] ?></button>
                            </div>

                    <?php          }
                    } ?>

                </div>

            </div>

        </div>
    </div>
</div>