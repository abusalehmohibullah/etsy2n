<?php session_start();

date_default_timezone_set('America/New_York'); // Set timezone to Eastern Standard Time

if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
    header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    exit();
}

include "../connection/connection.php";
include "../helper/utilities.php";
include "../functions/login-management.php";
include "../functions/mail-management.php";
include "../functions/data-management.php";
include "../functions/signup-management.php";

if (!is_authenticate()) {
    $_SESSION['error'] = "Unauthorized Access!";
    redirect('admin-login.php');
}

$table_names = ["logo", "slides", "notices", "products", "product_image", "jackpots", "jackpot_image", "notifications", "notification_image"];
$data = get_data($table_names, "1 OR 2");

// access data for first table
$logo = $data["logo"];

// access data for first table
$slider_data = $data["slides"];

// access data for second table
$notice_text = $data["notices"];


$product_data = $data["products"];

// access data for second table
$product_image = $data["product_image"];


$jackpot_data = $data["jackpots"];

// access data for second table
$jackpot_image = $data["jackpot_image"];


$notification_data = $data["notifications"];

// access data for second table
$notification_image = $data["notification_image"];

$user_list = get_user_list();

// Prepare and execute the query
$query = "SELECT COUNT(id) as withdrawalRequestCount FROM withdrawals WHERE status = 1";
$withdrawalRequest = $connection->query($query);

// Get the row count
if ($withdrawalRequest) {
    $row = $withdrawalRequest->fetch_assoc();
    $withdrawalRequestCount = $row['withdrawalRequestCount'];
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link rel="icon" type="image/x-icon" href="../assets/images/logo/<?php
                                                                        if (isset($logo) && !empty($logo)) {
                                                                            foreach ($logo as $data) {
                                                                                echo $data->favicon_image;
                                                                            }
                                                                        }
                                                                        ?>">



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha3/css/bootstrap.min.css" integrity="sha512-iGjGmwIm1UHNaSuwiNFfB3+HpzT/YLJMiYPKzlQEVpT6FWi5rfpbyrBuTPseScOCWBkRtsrRIbrTzJpQ02IaLA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" integrity="sha512-ZnR2wlLbSbr8/c9AgLg3jQPAattCUImNsae6NHYnS9KrIwRdcY9DxFotXhNAKIKbAXlRnujIqUWoXXwqyFOeIQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta3/css/bootstrap-select.min.css" integrity="sha512-g2SduJKxa4Lbn3GW+Q7rNz+pKP9AWMR++Ta8fgwsZRCUsawjPvF/BxSMkGS61VsR9yinGoEgrHPGPn2mrj8+4w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="../assets/css/style-admin.css">

</head>


<body>

    <!-- main container  -->
    <div class="container-fluid adjust-width py-4 pe-4 h-100 position-relative"> <!-- ends at footer.php  -->


        <!-- row div  -->
        <div class="row h-100">

            <?php
            include "side-nav.php";
            ?>

            <!-- content div  -->
            <div class="col-12 col-md-12 col-lg-9 col-xl-9 col-xxl-10 h-100">


                <!-- top page title bar  -->
                <div class="container-fluid content-box rounded-5 h-100 overflow-auto">
                    <div class="container-fluid content mb-4">


                        <div class="d-flex justify-content-between pt-2">
                            <div class="text-start h2 fw-semibold py-3">
                                <?php echo $page_title ?>
                            </div>
                            <div class="py-3 d-flex align-items-center">
                                <?php echo login_admin_user_name() ?>
                            </div>
                        </div>
                        <?php

                        if ($withdrawalRequestCount > 0) {
                        ?>
                            <div class="alert alert-warning" role="alert">
                                You have <?php echo $withdrawalRequestCount; ?> pending withdrawal requests.
                            </div>
                        <?php
                        }
                        ?>
                        <?php show_message_admin(); ?>