<?php
include "header.php";
?>

<div class="py-3">
    <div class="fs-3 fw-bold">Withdraw</div>
</div>

<?php echo show_message() ?>
<div class="bg-light p-2 my-2 rounded">
    <?php

    $balance = "";
    $treasury_balance = "";
    if (isset($users) && !empty($users)) {
        foreach ($users as $data) {
            if ($data->id == login_id()) {
                $balance = $data->balance;

    ?>
                <div class="d-flex position-relative">
                    <div class="img-container me-2 rounded-circle">
                        <img src="./assets/images/profile-pictures/<?php echo $data->profile_picture ?>" alt="" width="70px" height="70px" class="rounded-circle">

                    </div>
                    <div class="d-flex flex-column justify-content-center name-n-price gap-0">
                        <div class="fs-5 fw-semibold"> <?php echo login_name(); ?></div>
                        <div>@<?php echo login_user_name(); ?></div>
                    </div>
                    <a href="./profile.php" class="stretched-link"></a>
                </div>
    <?php
            }
        }
    } ?>

</div>
<div class="light-bg rounded p-3">


    <?php

    $sql = "SELECT first_name, last_name, address, bank_name, currency, bank_address FROM users WHERE id = $login_id";
    $result = mysqli_query($connection, $sql);


    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Access the values from the row
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $address = $row['address'];
        $bank_name = $row['bank_name'];
        $currency = $row['currency'];
        $bank_address = $row['bank_address'];


        // Check if the row has non-zero values
        $hasNonZeroValues = false;
        foreach ($row as $value) {
            if ($value !== '' && $value !== 0) {
                $hasNonZeroValues = true;
                break;
            }
        }

        if ($hasNonZeroValues) {
            // Row has non-zero values
            // Your code here
    ?>
            <div class="d-flex justify-content-center align-items-center my-2">
                <?php

                $pending = "1";
                $sql = "SELECT * FROM withdrawals WHERE withdraw_by = $login_id AND status = 1";

                $result = mysqli_query($connection, $sql);
                if ($result) {
                    $row = mysqli_fetch_assoc($result); // Fetch a single row

                    if ($row) {

                        $pending = 2;
                ?>
                        <div>
                            <div class="h5 fw-semibold text-center">Pending Request</div>

                            <table class="table text-center w-100">
                                <thead class="table-success">
                                    <tr>
                                        <th>Withdraw Amount</th>
                                        <th>Requested At</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider table-light">
                                    <tr>
                                        <td><?php echo $row['amount'] ?></td>
                                        <td><?php echo $row['created_at'] ?></td>
                                    </tr>
                                </tbody>



                            </table>



                        </div>
                <?php
                    }
                }
                ?>
            </div>
            <div class="d-flex justify-content-center align-items-center my-2">
                <form action="" method="POST" class="needs-validation" novalidate>
                    <div class="d-flex flex-column gap-2">

                        <div class="h5 fw-semibold text-center">Withdraw your fund</div>

                        <div class="fw-bold mb-0" id="msg-box" role="alert">

                        </div>
                        <div class="input-group ">
                            <span class="input-group-text fs-3 text-success"><i class="bi bi-cash-coin"></i></span>
                            <div class="form-floating">

                                <input class="form-control form-control-lg text-success fw-bold" type="text" id="available-balance" value="<?php echo $balance; ?>" aria-label="readonly input example" readonly required>

                                <label for="available-balance">Available Balance</label>
                            </div>
                        </div>


                        <div class="input-group">
                            <span class="input-group-text fs-3 fw-bold text-success"><i class="bi bi-currency-dollar fw-bold"></i></span>
                            <div class="form-floating">
                                <input type="number" class="form-control form-control-lg text-danger fw-bold" id="withdrawal-amount" placeholder="Dipositing Amount" name="amount" required autocomplete="off">
                                <label for="withdrawal-amount">Withdrawal Amount</label>
                            </div>
                            <div class="invalid-feedback">
                                Enter an amount!
                            </div>
                        </div>

                        <input type="hidden" name="id" value="<?php echo $login_id ?>">
                        <input type="hidden" name="current_balance" value="<?php echo $balance ?>">
                        <input type="hidden" id="withdraw-status" value="<?php echo $pending ?>">

                        <div class="input-group">
                            <span class="input-group-text fs-3"><i class="bi bi-bank"></i></span>
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="account" required>
                                    <option selected value="">Choose an Account</option>

                                    <?php


                                    $sql = "SELECT region FROM users WHERE id = $login_id";
                                    $result = mysqli_query($connection, $sql);


                                    if ($result && mysqli_num_rows($result) > 0) {
                                        $row = mysqli_fetch_assoc($result);

                                        // Check if the row has non-zero values
                                        $hasNonZeroValues = false;
                                        foreach ($row as $value) {
                                            if ($value !== '' && $value !== 0) {
                                                $hasNonZeroValues = true;
                                                break;
                                            }
                                        }

                                        if ($hasNonZeroValues) {
                                            // Row has non-zero values
                                            // Your code here
                                    ?>

                                            <option value="1">Bank Account</option>

                                    <?php

                                        }
                                    }

                                    ?>

                                    <?php

                                    $sql = "SELECT erc20 FROM users WHERE id = $login_id";
                                    $result = mysqli_query($connection, $sql);


                                    if ($result && mysqli_num_rows($result) > 0) {
                                        $row = mysqli_fetch_assoc($result);

                                        // Check if the row has non-zero values
                                        $hasNonZeroValues = false;
                                        foreach ($row as $value) {
                                            if ($value !== '' && $value !== 0) {
                                                $hasNonZeroValues = true;
                                                break;
                                            }
                                        }

                                        if ($hasNonZeroValues) {
                                            // Row has non-zero values
                                            // Your code here
                                    ?>

                                            <option value="2">USDT Account (ERC20)</option>



                                    <?php

                                        }
                                    }

                                    ?>

                                    <?php

                                    $sql = "SELECT trc20 FROM users WHERE id = $login_id";
                                    $result = mysqli_query($connection, $sql);


                                    if ($result && mysqli_num_rows($result) > 0) {
                                        $row = mysqli_fetch_assoc($result);

                                        // Check if the row has non-zero values
                                        $hasNonZeroValues = false;
                                        foreach ($row as $value) {
                                            if ($value !== '' && $value !== 0) {
                                                $hasNonZeroValues = true;
                                                break;
                                            }
                                        }

                                        if ($hasNonZeroValues) {
                                            // Row has non-zero values
                                            // Your code here
                                    ?>

                                            <option value="3">USDT Account (TRC20)</option>


                                    <?php

                                        }
                                    }

                                    ?>


                                </select>
                                <label for="floatingSelect">Withdrawal Account</label>
                            </div>
                        </div>



                        <div class="input-group">
                            <span class="input-group-text fs-3"><i class="bi bi-key"></i></span>
                            <div class="form-floating">
                                <input type="password" class="form-control form-control-lg" id="withdrawal-password" placeholder="Withdrawal Password" name="withdrawal-password" required>
                                <label for="withdrawal-password">Withdrawal Password</label>
                            </div>
                        </div>

                        <button type="submit" class="btn deep-bg btn-lg" id="fund-withdraw" name="withdraw-request" value="2" disabled>Withdraw</button>
                    </div>
                    <div class="text-end mt-2">
                        <a href="./withdrawal-accounts.php">Manage Accounts</a>

                    </div>
                </form>
            </div>

            <div class="mt-4 text-danger">
                *Bank withdrawal might take up to 15 working days to be proccessed.
            </div>

            <div class="text-danger">
                **USDT Withdrawal will be proccessed within 2 working hours. If not recieved within 120 minutes, please contact customer support.
            </div>


        <?php
        } else {
        ?>

            <div class="fs-2 fw-bold text-danger text-center">
                Please <a href="./withdrawal-accounts.php">Update</a> your General Informations and add atleast one Withdrawal methid!

            </div>

    <?php
        }
    }

    ?>
</div>


<?php
include "footer.php";
?>