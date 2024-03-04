<?php
session_start();
// takes url and see which page it is 
$category_explode = explode("/", $_SERVER['REQUEST_URI']);
$page_name = $category_explode[count($category_explode) - 1];

?>

<div class="row m-0 p-0">

    <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 justify-content-end users-top-bar rounded m-0 px-3 py-2">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-4 px-1">
            <form method="post" action="" id="user-list-form" class=" d-flex gap-2">
                <input type="hidden" name="selected-id">
                <select class="form-control w-100 " id="user-list" name="user-list" data-live-search="true">
                    <option value="<?php echo $user_details['id'] ?>">
                        <?php
                        $user_details =  $_SESSION['user_details'];
                        if (isset($user_details) && !empty($user_details)) {

                        ?>
                            <?php echo $user_details['name'] ?> (@<?php echo $user_details['user_name'] ?>)

                        <?php

                        } else {

                            echo 'Search or Scroll and Select User';
                        }

                        ?>

                    </option>

                    <?php
                    if (isset($user_list) && !empty($user_list)) {

                        foreach ($user_list as $data) {
                    ?>

                            <option value="<?php echo $data->id ?>"><?php echo $data->name ?> (@<?php echo $data->user_name ?>)</option>

                    <?php
                        }
                    }
                    ?>
                </select>
                <button class="btn btn-success fw-bold"><i class="bi bi-arrow-clockwise fw-bold"></i></button>
            </form>

        </div>

    </div>


    <div class="accordion p-0 my-1" id="accordionExample">
        <div class="accordion-item  position-relative">

            <button class="accordion-button d-flex position-relative ps-2 pe-3 py-2 bg-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <div class="align-self-center m-0 p-0 text-dark fw-semibold"><span class="icon"><i class="fas fa-plus"></i></span> Create new user</div>
            </button>

            <div id="collapseOne" class="collapse" aria-labelledby="headingOne">
                <div class="accordion-body row gx-1 py-0 px-2">

                    <div class="container-fluid px-2 py-1">
                        <form action="" method="POST">

                            <div class="row">
                                <div class="form-floating col-12 col-sm-12 col-md-12 col-lg-6 col-xl-4 col-xxl-4 p-1">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="Will generate later" readonly>
                                    <label for="home" class="ms-1">User Name</label>
                                </div>
                                <div class="form-floating col-12 col-sm-12 col-md-12 col-lg-6 col-xl-5 col-xxl-4 p-1">
                                    <input type="text" class="form-control" id="password" name="password" placeholder="Password" required minlength="6">
                                    <label for="home" class="ms-1">Password (Required)</label>
                                </div>
                                <div class="form-floating col-12 col-sm-12 col-md-12 col-lg-6 col-xl-3 col-xxl-4 p-1">
                                    <input type="text" class="form-control" id="invitation_code" name="invitation_code" placeholder="Invitaion Code">
                                    <label for="home" class="ms-1">Invitaion Code</label>
                                </div>

                                <div class="d-flex justify-content-end my-1">
                                    <button class="btn btn-success" type="submit" name="add-admin" value="user">Create</button>

                                </div>

                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-flex flex-column justify-content-start px-3 py-1">

        <?php
        $user_details =  $_SESSION['user_details'];

        if (isset($user_details) && !empty($user_details)) {
        ?>

            <?php

            $attempt_time = time() - 1800;
            $user_name = $user_details['user_name'];

            $sql = "SELECT id FROM login_log WHERE user_name = '$user_name' AND attempt_time > $attempt_time";
            $result = $connection->query($sql);
            $attempt_counter = $result->num_rows;
            if ($result->num_rows > 4) {
            ?>

                <form action="" method="post">
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center w-100 p-2">
                        <div>

                            <strong>
                                User Account Locked!
                            </strong>
                        </div>

                        <input type="hidden" name="user_name" value="<?php echo $user_details['user_name'] ?>">
                        <button class="btn btn-success ms-auto bi bi-unlock" type="submit" name="deleteLog" value="1"></button>

                    </div>
                </form>

            <?php }
            if ($user_details['status'] == 3) { ?>
                <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center w-100 p-2">


                    <strong>
                        User is restricted!
                    </strong>
                </div>
            <?php } ?>

            <div class="user-profile-image-container rounded-circle border border-2 my-2">
                <img src="../assets/images/profile-pictures/<?php echo $user_details['profile_picture'] ?>" alt="Profile Image" class="rounded-circle">
            </div>

            <div class="user-name text-center fw-semibold">
                <?php echo $user_details['name'] ?>
            </div>

            <div class="user-id text-center">@
                <?php echo $user_details['user_name'] ?>
            </div>

            <div class="user-id text-center">

                <?php
                $user_level = $user_details['level'];

                if ($user_level == 1) {
                    $level_name = "Silver";
                } else if ($user_level == 2) {
                    $level_name = "Gold";
                } else if ($user_level == 3) {
                    $level_name = "Platinum";
                } else if ($user_level == 4) {
                    $level_name = "Diamond";
                } else if ($user_level == 5) {
                    $level_name = "Crown";
                }

                ?>

                Level: <?php echo $level_name ?>
            </div>
        <?php


        }

        ?>
        <nav class="navbar d-flex flex-column">
            <div class="user-info bg-white rounded text-center btn p-0 my-2 w-100 <?php if ($page_name == "users.php") {
                                                                                        echo "active";
                                                                                    } ?>">
                <a class="nav-link w-100 py-3" href="users.php">Info</a>
            </div>
            <div class="jackpot bg-white rounded text-center btn p-0 my-2 w-100 <?php if ($page_name == "jackpot.php") {
                                                                                    echo "active";
                                                                                } ?>">
                <a class="nav-link w-100 py-3" href="jackpot.php">Jackpot</a>
            </div>

        </nav>

        <?php
        if ($page_name == "users.php") {

            if (isset($user_details) && !empty($user_details)) {
        ?>
                <div class="d-flex mb-2 justify-content-center align-items-center">

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">

                        <div class="row gy-4">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 text-center fw-bold fs-5">
                                Manage Balance
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mt-1">
                                <form action="" method="POST">
                                    <div class="input-group border border-success rounded">
                                        <span class="input-group-text fs-4 fw-bold text-success">$</span>
                                        <div class="form-floating">

                                            <input type="hidden" name="id" value="<?php echo $user_details['id'] ?>">
                                            <input type="hidden" name="adjust-balance" value="1">
                                            <input type="hidden" name="adjust_column" value="balance">
                                            <input type="hidden" name="table_name" value="users">
                                            <input type="hidden" name="current_balance" value="<?php echo $user_details['balance'] ?>">
                                            <input type="hidden" name="adjust_type" value="deposit">

                                            <input type="number" class="form-control form-control-lg pb-0" id="floatingInputGroup2" placeholder="Username" name="adjust_value" required>
                                            <label for="floatingInputGroup2">Deposit</label>

                                        </div>

                                        <button type="submit" class="common-submit input-group-text btn btn-lg btn-outline-success border-0" name="adjust-balance" value="1"><i class="bi bi-check2"></i></button>
                                    </div>
                                </form>
                            </div>


                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mt-3">
                                <form action="" method="POST">
                                    <div class="input-group border border-danger rounded">
                                        <span class="input-group-text fs-4 fw-bold text-danger">$</span>
                                        <div class="form-floating">

                                            <input type="hidden" name="id" value="<?php echo $user_details['id'] ?>">
                                            <input type="hidden" name="adjust-balance" value="2">
                                            <input type="hidden" name="adjust_column" value="balance">
                                            <input type="hidden" name="adjust_column_2" value="holding_balance">
                                            <input type="hidden" name="table_name" value="users">
                                            <input type="hidden" name="current_balance" value="<?php echo $user_details['balance'] ?>">
                                            <input type="hidden" name="current_hold" value="<?php echo $user_details['holding_balance'] ?>">
                                            <input type="hidden" name="adjust_type" value="hold">


                                            <input type="number" class="form-control form-control-lg pb-0" id="floatingInputGroup2" placeholder="Username" name="adjust_value" required>
                                            <label for="floatingInputGroup2">Hold</label>
                                        </div>
                                        <button class="common-submit input-group-text btn btn-lg btn-outline-danger border-0" name="adjust-balance" value="2"><i class="bi bi-check2"></i></button>

                                    </div>
                                </form>
                            </div>


                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mt-3">
                                <form action="" method="POST">
                                    <div class="input-group border border-success rounded">
                                        <span class="input-group-text fs-4 fw-bold text-success">$</span>
                                        <div class="form-floating">

                                            <input type="hidden" name="id" value="<?php echo $user_details['id'] ?>">
                                            <input type="hidden" name="adjust-balance" value="2">
                                            <input type="hidden" name="adjust_column" value="balance">
                                            <input type="hidden" name="adjust_column_2" value="holding_balance">
                                            <input type="hidden" name="table_name" value="users">
                                            <input type="hidden" name="current_balance" value="<?php echo $user_details['balance'] ?>">
                                            <input type="hidden" name="current_hold" value="<?php echo $user_details['holding_balance'] ?>">
                                            <input type="hidden" name="adjust_type" value="release">
                                            <input type="number" class="form-control form-control-lg pb-0" id="floatingInputGroup2" placeholder="Username" name="adjust_value" required>
                                            <label for="floatingInputGroup2">Release</label>
                                        </div>
                                        <button class="common-submit input-group-text btn btn-lg btn-outline-success border-0" name="adjust-balance" value="2"><i class="bi bi-check2"></i></button>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        <?php }
        } ?>
    </div>