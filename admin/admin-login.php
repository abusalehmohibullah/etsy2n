<?php session_start();
// date_default_timezone_set('Asia/Dhaka');
include "../connection/connection.php";
include "../helper/utilities.php";
include "../functions/login-management.php";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style-admin.css">



</head>

<body>

    <div class="main-container container-fluid p-5 h-100">
        <div class="deep-bg row d-flex justify-content-center align-items-center rounded-5 h-100 p-4">
            <div class="col-xs-11 col-sm-10 col-md-7 col-lg-6 col-xl-5 col-xxl-4 bg-white sub-container rounded-5 py-4 px-5">
                <h2 class="text-center mb-2">Admin</h2>
                <?php show_message_admin(); ?>
                <form action="index.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter email" name="user_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" required>
                    </div>
                    <div class="d-flex mb-3 form-check w-100">
                        <input class="form-check-input pe-2" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label ps-2" for="remember"> Keep me logged in</label>

                        <!--<div class="ms-auto">-->
                        <!--    <a href="#">Forgot password?</a>-->
                        <!--</div>-->
                    </div>
                    <input type="hidden" name="table" value="admins">
                    <input type="submit" class="btn btn-success w-100 my-2" name="login" value="Login">

                </form>
            </div>
        </div>
    </div>

</body>

</html>