<?php
include "header.php";
?>
<section>
    <div class="d-flex my-2 light-bg p-2 shadow-sm">
        <div class="d-flex align-items-center p-2 position-relative">

            <div class="img-container me-2 rounded-circle">
                <img src="./assets/images/profile-pictures/<?php echo $profile_picture ?>" alt="" width="70px" height="70px" class="rounded-circle">
            </div>
            <div class="d-flex flex-column justify-content-center name-n-price gap-0">
                <div class="fs-5 fw-semibold"> <?php echo $name; ?></div>
                <div>@<?php echo $user_name; ?></div>
            </div>
            <a href="./profile.php" class="stretched-link"></a>
        </div>


        <div class="ms-auto"> <img src="./assets/images/icons/<?php echo $level_image ?>" alt="" width="100px" height="100px" class=" level-image m-2"></div>
    </div>
</section>



<section>
    <div class="row p-2">

        <?php
        $sql = "SELECT * FROM users WHERE id = $login_id";


        if ($result = $connection->query($sql)) {
            if ($result->num_rows > 0) {
                $balance_data = $result->fetch_object();
                $balance = $balance_data->balance;
                $holding_balance = $balance_data->holding_balance;
                $treasury_balance = $balance_data->treasury_balance;
            } else {
                $balance = 0;
                $holding_balance = 0;
                $treasury_balance = 0;
            }
        } else {
            echo "Error executing SQL query: " . $connection->error;
        }


        // order quantity

        $countQuery = "SELECT COUNT(*) AS order_count FROM orders WHERE ordered_by = $login_id AND DATE(ordered_at) = DATE('$now') AND status = 2";


        if ($countResult = $connection->query($countQuery)) {
            if ($countResult->num_rows > 0) {
                $countRow = $countResult->fetch_assoc();
                $order_count = $countRow['order_count'];
            } else {
                $order_count = 0;
            }
        } else {
            echo "Error executing SQL query: " . $connection->error;
        }


        // total commission

$sql = "SELECT 
          COALESCE((SELECT SUM(commission_amount) FROM orders WHERE ordered_by = $login_id AND status = 2), 0) +
          COALESCE((SELECT SUM(commission_amount) FROM jackpots WHERE target_user = $login_id AND status = 2), 0) AS total_commission";



        if ($result = $connection->query($sql)) {
            $row = $result->fetch_assoc();
            if ($row['total_commission'] === null || $row['total_commission'] === 0) {
                $total_commission = 0;
            } else {
                $total_commission = $row['total_commission'];
            }
        } else {
            echo "Error executing SQL query: " . $connection->error;
        }



        // daily income

$sql = "SELECT COALESCE(
        (SELECT SUM(commission_amount) FROM orders WHERE ordered_by = $login_id AND DATE(ordered_at) = DATE('$now') AND status = 2),
        0) +
        COALESCE(
        (SELECT SUM(commission_amount) FROM jackpots WHERE target_user = $login_id AND DATE(ordered_at) = DATE('$now') AND status = 2),
        0) AS today_commission";

        if ($result = $connection->query($sql)) {
            $row = $result->fetch_assoc();
            if ($row['today_commission'] === null || $row['today_commission'] === 0) {
                $daily_income = 0;
            } else {
                $daily_income = $row['today_commission'];
            }
        } else {
            echo "Error executing SQL query: " . $connection->error;
        }

        ?>



        <div class="col-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 col-xxl-2 p-1">
            <div class="balance-container light-bg balance-text-small d-flex flex-column justify-content-center align-items-center gap-0 rounded-3 w-100 p-1">
                <div><?php echo $language_data['balance'] ?></div>
                <div class="text-success balance-text-medium fw-bold w-100 rounded text-center fs-5 p-1">$ <?php echo number_format($balance, 2) ?></div>
            </div>
        </div>
        <div class="col-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 col-xxl-2 p-1">
            <div class="balance-container light-bg balance-text-small d-flex flex-column justify-content-center align-items-center gap-0 rounded-3 w-100 p-1">
                <div><?php echo $language_data['treasury_balance'] ?></div>
                <div class="text-success balance-text-medium fw-bold w-100 rounded text-center fs-5 p-1">$ <?php echo number_format($treasury_balance, 2) ?></div>
            </div>
        </div>
        <div class="col-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 col-xxl-2 p-1">
            <div class="balance-container light-bg balance-text-small d-flex flex-column justify-content-center align-items-center gap-0 rounded-3 w-100 p-1">
                <div><?php echo $language_data['holding_balance'] ?></div>
                <div class="text-danger balance-text-medium fw-bold w-100 rounded text-center fs-5 p-1">$ <?php echo number_format($holding_balance, 2) ?></div>
            </div>
        </div>
        <div class="col-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 col-xxl-2 p-1">
            <div class="balance-container light-bg balance-text-small d-flex flex-column justify-content-center align-items-center gap-0 rounded-3 w-100 p-1">
                <div><?php echo $language_data['daily_income'] ?></div>
                <div class="text-success balance-text-medium fw-bold w-100 rounded text-center fs-5 p-1">$ <?php echo number_format($daily_income, 2) ?></div>
            </div>
        </div>
        <div class="col-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 col-xxl-2 p-1">
            <div class="balance-container light-bg balance-text-small d-flex flex-column justify-content-center align-items-center gap-0 rounded-3 w-100 p-1">
                <div><?php echo $language_data['total_commission'] ?></div>
                <div class="text-success balance-text-medium fw-bold w-100 rounded text-center fs-5 p-1">$ <?php echo number_format($total_commission, 2) ?></div>
            </div>
        </div>
        <div class="col-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 col-xxl-2 p-1">
            <div class="balance-container light-bg balance-text-small d-flex flex-column justify-content-center align-items-center gap-0 rounded-3 w-100 p-1">
                <div><?php echo $language_data['order_quantity'] ?></div>
                <div class="text-success balance-text-medium fw-bold w-100 rounded text-center fs-5 p-1"><?php echo $order_count ?>/<?php echo $order_limit ?></div>
            </div>
        </div>

    </div>
</section>




<!-- buttons  -->
<section>
    <div class="d-flex justify-content-around four-btns my-3 mx-5">

        <div class="deposit-btn d-flex flex-column justify-content-center align-items-center position-relative">
            <div class="icon-div light-bg btn shadow-sm">
                <img src="./assets/images/icons/deposit.png" alt="" width="30px" height="30px">
            </div>
            <div class="tab-name"><?php echo $language_data['deposit'] ?></div>
            <a href="./deposit.php" class="stretched-link"></a>
        </div>

        <div class="withdraw-btn d-flex flex-column justify-content-center align-items-center position-relative">
            <div class="icon-div light-bg btn shadow-sm">
                <img src="./assets/images/icons/withdraw.png" alt="" width="30px" height="30px">
            </div>
            <div class="tab-name"><?php echo $language_data['withdraw'] ?></div>
            <a href="./withdraw.php" class="stretched-link"></a>
        </div>

        <div class="invite-btn d-flex flex-column justify-content-center align-items-center position-relative">
            <div class="icon-div light-bg btn shadow-sm">
                <img src="./assets/images/icons/invite.png" alt="" width="30px" height="30px">
            </div>
            <div class="tab-name"><?php echo $language_data['invite'] ?></div>
            <a href="./invite.php" class="stretched-link"></a>
        </div>

        <div class="treasury-btn d-flex flex-column justify-content-center align-items-center position-relative">
            <div class="icon-div light-bg btn shadow-sm">
                <img src="./assets/images/icons/treasury.png" alt="" width="30px" height="30px">
            </div>
            <div class="tab-name"><?php echo $language_data['treasury'] ?></div>
            <a href="./treasury.php" class="stretched-link"></a>
        </div>

    </div>
</section>




<div class="container-fluid light-bg my-2 p-2 rounded shadow-sm">
    <div class="h5 fw-semibold mt-2 mb-3">Transaction History</div>
    <div class="balance-history bg-white px-2" id="transaction-history">
        <?php

        // Set the parameters for the initial load
        $_GET['type'] = 'transactions'; // Example table name
        $_GET['table'] = 'transactions'; // Example table name
        $_GET['conditions'] = 'created_by'; // Example additional conditions
        $_GET['condition_value'] = $login_id; // Example additional conditions
        $_GET['order_conditions'] = 'created_at'; // Example additional conditions

        // Include the initial_load.php file
        include "./functions/initial-load.php";
        ?>


    </div>
</div>



<div class="light-bg rounded p-3 d-flex flex-column gap-3 shadow-sm">
    <a class="nav-link" aria-current="page" href="./profile.php"><?php echo $language_data['profile'] ?></a>
    <a class="nav-link" aria-current="page" href="./change-password.php"><?php echo $language_data['modify_login_password'] ?></a>
    <a class="nav-link" aria-current="page" href="./withdrawal-accounts.php"><?php echo $language_data['withdrawal_accounts'] ?></a>
</div>

<div class="bg-danger rounded px-3 py-2 fs-5 d-flex shadow-sm mt-2 position-relative">
    <div class="text-white fw-bold"><i class="ri-logout-box-r-line fw-bolder"></i> </i><?php echo $language_data['logout'] ?></div>
    <a href="./logout.php" class="stretched-link"></a>
</div>




<?php
include "footer.php";
?>