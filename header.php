<?php
session_start();

// error_reporting(E_ALL);
// ini_set('display_errors', '1');

// Set timezone to Eastern Standard Time
date_default_timezone_set('America/New_York');

// redirect the website to HTTPS
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
    header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    exit();
}

// include all files
include "./connection/connection.php"; // database connection
include "./functions/mail-management.php"; // handles signup and email sending
include "./helper/utilities.php"; // contains helpful functions
include "./functions/login-management.php"; // handles login procedure
include "./functions/signup-management.php"; // handles signup procedure
include "./functions/data-management.php"; // manages all data CRUD operations
include "./functions/load-more.php"; // helps load large amounts of data when needed

// takes the URL and determines the current page
$category_explode = explode("/", $_SERVER['REQUEST_URI']);
$page_name = $category_explode[count($category_explode) - 1];

// keeps the user logged in using cookies
if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
    if ($_COOKIE['userType'] === "users") {
        $_SESSION["is_authenticate_user"] = true;
    }
}

if (isset($_SESSION['login_id'])) {
    // Retrieve the user's status from the database
    $userStatus = getUserStatus($_SESSION['login_id']);
    // Check if the user's status is not equal to 1
    if (is_authenticate_user()) {
        if ($userStatus !== 1) {
            header("Location: logout.php");
            exit();
        }
    }
}

if (!is_authenticate_user()) {
    // Check if the repeat-user cookie is already set
    if (isset($_COOKIE['repeat-user'])) {
        $repeatUser = $_COOKIE['repeat-user'];

        // Check if the current request is a GET request
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $getRequestUrl = $_SERVER['REQUEST_URI'];

            // Check if the 'invited_by' parameter is set in the query string
            if (isset($_GET['invited_by'])) {
                if (!isset($_GET['repeat-user'])) {
                    $getRequestUrl .= '&repeat-user=' . urlencode($repeatUser);
                }
            } else {
                // Check if there is already a query string in the URL
                if (strpos($getRequestUrl, '?') !== false) {
                    if (!isset($_GET['repeat-user'])) {
                        $getRequestUrl .= '&repeat-user=' . urlencode($repeatUser);
                    }
                } else {
                    if (!isset($_GET['repeat-user'])) {
                        $getRequestUrl .= '?repeat-user=' . urlencode($repeatUser);
                    }
                }
            }

            if (!isset($_GET['repeat-user'])) {
                // Redirect to the GET request URL
                header('Location: ' . $getRequestUrl);
                exit();
            }
        }
    } else {
        // Set the repeat-user cookie
        setcookie('repeat-user', 'yes', time() + (86400 * 30), '/'); // Cookie lasts for 30 days
    }

    // Restrict user from accessing other pages except the following ones
    if ($page_name !== "index.php" && $page_name !== "index.php?invited-by=" . $_GET['invited-by'] && $page_name !== "index.php?repeat-user=yes" && $page_name !== "index.php?invited-by=" . $_GET['invited-by'] . "&repeat-user=yes") {
        redirect('index.php');
    }
}

// Retrieve the necessary data using the data-management.php file
$table_names = ["users", "logo", "slides", "notices", "products", "product_image", "jackpots", "jackpot_image"];
$data = get_data($table_names, "1 OR 2");

// Access data for the "users" table
$users = $data["users"];

$logo = $data["logo"];

// Access data for the "slides" table
$slider_data = $data["slides"];

// Access data for the "notices" table
$notice_text = $data["notices"];

// Access data for the "products" table
global $product_data;
$product_data = $data["products"];

// Access data for the "product_image" table
$product_image = $data["product_image"];

// Access data for the "jackpots" table
global $jackpot_data;
$jackpot_data = $data["jackpots"];

// Access data for the "jackpot_image" table
$jackpot_image = $data["jackpot_image"];

// store users login id in a variable for future use
    $login_id = "";
if (isset($_SESSION['login_id'])) {
    
    $login_id = $_SESSION['login_id'];


    $sql = "SELECT * FROM users WHERE id = $login_id";
    
    $result = mysqli_query($connection, $sql);
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
    
        // Retrieve the user's information
        $name = $row['name'];
        $user_name = $row['user_name'];
        $email = $row['email'];
        $phone = $row['phone'];
        $level = $row['level'];
        $balance = $row['balance'];
        $profile_picture = $row['profile_picture'];
    
    
    
        if ($level == 1) {
            $commission = "0.5";
            $level_image = "silver.png";
            $order_limit = 60;
        } elseif ($level == 2) {
            $commission = "0.6";
            $level_image = "gold.png";
            $order_limit = 80;
        } elseif ($level == 3) {
            $commission = "0.7";
            $level_image = "platinum.png";
            $order_limit = 100;
        } elseif ($level == 4) {
            $commission = "0.8";
            $level_image = "diamond.png";
            $order_limit = 120;
        } elseif ($level == 5) {
            $commission = "0.9";
            $level_image = "crown.png";
            $order_limit = 130;
        }
    } else {
        // Handle the case when the query fails
        echo "Error: " . mysqli_error($connection);
    }

}
// Loop through the users and find the level and related data for the current user

$now = date('Y-m-d H:i:s');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Income</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/images/logo/<?php
                                                                        if (isset($logo) && !empty($logo)) {
                                                                            foreach ($logo as $data) {
                                                                                echo $data->favicon_image;
                                                                            }
                                                                        }
                                                                        ?>">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha3/css/bootstrap.min.css" integrity="sha512-iGjGmwIm1UHNaSuwiNFfB3+HpzT/YLJMiYPKzlQEVpT6FWi5rfpbyrBuTPseScOCWBkRtsrRIbrTzJpQ02IaLA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Slick Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Slick Carousel Theme CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap Icons CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" integrity="sha512-ZnR2wlLbSbr8/c9AgLg3jQPAattCUImNsae6NHYnS9KrIwRdcY9DxFotXhNAKIKbAXlRnujIqUWoXXwqyFOeIQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Remix Icon CSS -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="./assets/css/style.css">

</head>

<body>
    <div class="container mb-4 position-relative">

        <!--include navbar (top-bottom both)-->
        <?php
        include "navbars.php";
        ?>

        <!--creates a blank space on top-->
        <div class="bottom-div"></div>