<?php
include "header.php";
?>


<div class="py-3">
    <div class="fs-3 fw-bold">Treasury</div>
</div>

<?php echo show_message() ?>
<div class="d-flex bg-light p-2 my-2 rounded">
    <?php

    $balance = "";
    $treasury_balance = "";
    if (isset($users) && !empty($users)) {
        foreach ($users as $data) {
            if ($data->id == login_id()) {
                $balance = $data->balance;
                $treasury_balance = $data->treasury_balance;

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


<div class="light-bg rounded px-3 mb-2">

    <div class="row container-fluid h-100 p-2 m-0">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 d-flex flex-column justify-content-center align-items-center p-4 m-0">
            <img src="./assets/images/login-bg.png" alt="" class="w-100">
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 row d-flex rounded justify-content-center align-items-center p-0 m-0">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-11 col-xxl-11 rounded-5 py-2 px-3">

                <h3>Introducing to our Treasury</h3>
                <div>

                    You are here because you already are a member. Are you tired of grabbing orders? We are introducing you a better investment option now. Our treasury invest your deposited funds in many way to earn for you and give you a fair interest better than banks. Welcome to our treasure program. Let us work for you and let's grow together.
                </div>



            </div>
        </div>

    </div>



    <div class="row container-fluid h-100 p-2 m-0">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-5 col-xxl-6 d-flex flex-column justify-content-start align-items-center p-2 m-0">

<?php

$sql = "SELECT * FROM treasury WHERE deposited_by = $login_id AND interest_paid = 1";

$result = mysqli_query($connection, $sql);
if ($result) {
?>
    <div>
        <div class="h5 fw-semibold text-center">Current Treasury</div>

        <table class="table text-center w-100">
            <thead class="table-success">
                <tr>
                    <th>#</th>
                    <th>Deposit Amount</th>
                    <th>Refund Amount</th>
                    <th>Refund Date</th>
                </tr>
            </thead>
            <tbody class="table-group-divider table-light">
                <?php
                $counter = 1; // Initialize the counter variable
                while ($row = mysqli_fetch_assoc($result)) {
                    // Loop through each row
                ?>
                    <tr>
                        <td><?php echo $counter; ?></td> <!-- Add the counter value -->
                        <td><?php echo $row['deposited_amount'] ?></td>
                        <td><?php echo $row['refund_amount'] ?></td>
                        <td><?php echo date('d M Y', strtotime($row['deposited_at'] . ' + 30 days')) ?></td>
                    </tr>
                <?php
                    $counter++; // Increment the counter
                }
                ?>
            </tbody>
        </table>
    </div>
<?php
}
?>



            <form class="needs-validation" action="" method="POST" novalidate>
                <div class="d-flex flex-column gap-2">

                    <div class="h5 fw-semibold text-center">Deposit to Treasury</div>

                    <div class="text-dark text-center">Enter an amount to calculate monthly interest</div>

                    <div class="fw-bold mb-0" id="msg-box" role="alert">

                    </div>
                    <div class="input-group ">
                        <span class="input-group-text fs-3 text-success"><i class="bi bi-cash-coin"></i></span>
                        <div class="form-floating">

                            <input class="form-control form-control-lg text-success fw-bold" type="text" id="available-balance" value="<?php echo $balance; ?>" aria-label="readonly input example" readonly required>

                            <label for="available-balance">Available Balance</label>
                        </div>
                    </div>

                    <input type="hidden" name="id" value="<?php echo $login_id ?>">
                    <input type="hidden" name="adjust_column" value="balance">
                    <input type="hidden" name="adjust_column_2" value="treasury_balance">
                    <input type="hidden" name="table_name" value="users">
                    <input type="hidden" name="current_balance" value="<?php echo $balance ?>">
                    <input type="hidden" name="adjust_type" value="treasury">

                    <div class="input-group">
                        <span class="input-group-text fs-3 fw-bold text-success"><i class="bi bi-currency-dollar fw-bold"></i></span>
                        <div class="form-floating">
                            <input type="number" class="form-control form-control-lg text-danger fw-bold" id="deposit-amount" placeholder="Dipositing Amount" name="adjust_value" required>
                            <label for="deposit-amount">Depositing Amount</label>
                        </div>
                        <div class="invalid-feedback">
                            Enter an amount!
                        </div>
                    </div>

                    <div class="input-group ">
                        <span class="input-group-text fs-3"><i class="bi bi-graph-up-arrow"></i></span>
                        <div class="form-floating">
                            <input class="form-control form-control-lg fw-bold text-dark" type="text" id="monthly-interest" value="" aria-label="readonly input example" Placeholder="Monthly Interest" readonly required>
                            <label for="monthly-interest">Monthly Interest</label>
                        </div>
                    </div>

                    <div class="input-group ">
                        <span class="input-group-text fs-3"><i class="bi bi-arrow-return-left"></i></span>
                        <div class="form-floating">
                            <input class="form-control form-control-lg fw-bold text-success" type="text" id="est-refund" name="adjust_value_2" aria-label="readonly input example" Placeholder="Est. Refund" readonly required>
                            <label for="est-refund">Est. Refund</label>
                        </div>
                    </div>

                    <div id="rate-level">

                    </div>

                    <button type="submit" class="btn deep-bg btn-lg" id="treasury-deposit" name="adjust-balance" value="2" disabled>Deposit</button>
                </div>
            </form>


        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-7 col-xxl-6 light-bg row d-flex rounded justify-content-center align-items-start p-2 m-0">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 rounded-5 px-2">
                <div class="h5 fw-semibold">Interest Rates</div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-12 col-xl-6 col-xxl-6 p-1">
                        <div class="rounded border bg-white p-2">
                            <b>Silver level <span class="text-success">$500 ~ $999</span></b> <br>
                            Revenue rate <span class="text-danger">20% per month </span><br>
                            Fixed duration 30 days
                        </div>
                    </div>


                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-12 col-xl-6 col-xxl-6 p-1">
                        <div class="rounded border border-warning bg-white p-2">
                            <b>Gold level <span class="text-success">$1000 ~ $9999</span></b> <br>
                            Revenue rate <span class="text-danger">21% per month </span><br>
                            Fixed duration 30 days
                        </div>
                    </div>


                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-12 col-xl-6 col-xxl-6 p-1">
                        <div class="rounded border border-secondary bg-white p-2">
                            <b>Platinum level <span class="text-success">$10000 ~ $99999</span></b> <br>
                            Revenue rate <span class="text-danger">22% per month </span><br>
                            Fixed duration 30 days
                        </div>
                    </div>


                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-12 col-xl-6 col-xxl-6 p-1">
                        <div class="rounded border border-info bg-white p-2">
                            <b>Diamond level <span class="text-success">$100000+</span></b> <br>
                            Revenue rate <span class="text-danger">25% per month </span><br>
                            Fixed duration 30 days
                        </div>
                    </div>

                </div>


            </div>
        </div>

    </div>

</div>


<?php
include "footer.php";
?>