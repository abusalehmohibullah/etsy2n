<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');

include "header.php";

// execute the SQL query
$sql = "SELECT j.*, GROUP_CONCAT(ji.jackpot_image) AS jackpot_images
        FROM jackpots j
        JOIN jackpot_image ji ON j.id = ji.upload_id
        WHERE j.target_user = $login_id AND j.status = 1
        GROUP BY j.id";


$result = mysqli_query($connection, $sql);


// Retrieve the row count
$rowCount = mysqli_num_rows($result);

// Check if the row count is greater than zero
if ($rowCount > 0) {
    // Loop through the result to retrieve the column values
    while ($row = mysqli_fetch_assoc($result)) {
        $jackpot_commission = "";
        if ($row['new_rank'] > $level) {
            if ($row['new_rank'] == 1) {
                $jackpot_commission = "0.5";
            } elseif ($row['new_rank'] == 2) {
                $jackpot_commission = "0.6";
            } elseif ($row['new_rank'] == 3) {
                $jackpot_commission = "0.7";
            } elseif ($row['new_rank'] == 4) {
                $jackpot_commission = "0.8";
            } elseif ($row['new_rank'] == 5) {
                $jackpot_commission = "0.9";
            }
        } else {
            $jackpot_commission = $commission;
        }
        // Access the column values
?>
        <!-- Modal Jackpot -->
        <div class="modal modal-lg fade" id="jackpotleModal" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content light-bg">

                    <div class="modal-body">
                        <div class="fw-semibold text-success fs-3 text-center">You have received a Jackpot!</div>
                        <div class="fw-semibold text-danger fs-6 text-center mb-2">Submit this to continue grabbing other products!</div>
                        <?php
                        if (isset($users) && !empty($users)) {
                            foreach ($users as $data) {
                                if ($data->id == login_id()) {

                                    if ($data->balance < $row['product_price'] * $row['product_quantity']) {
                        ?>
                                        <div class="alert alert-danger fw-bold" role="alert">
                                            Insufficient balance!
                                        </div>
                        <?php
                                    }
                                }
                            }
                        } ?>

                        <div class="d-flex p-0">
                            <div class="fs-6 mb-2">

                                <div id="created-time"><?php echo $language_data['created_time'] ?>: <?php echo $row['created_at'] ?></div>

                            </div>
                            <div class="ms-auto status-part fw-semibold fs-5 text-secondary fst-italic">Pending</div>
                        </div>

                        <div class="order-details-row d-flex p-0 m-0 gap-2">
                            <div class="m-0 p-0 border trans-bg shadow-sm d-flex justify-content-center align-items-center">

                                <div class="order-item-sub-slider slider-common-class jackpot-slider m-0 p-0">
                                    <?php
                                    $jackpotImages = explode(',', $row['jackpot_images']);

                                    // Iterate through the images
                                    foreach ($jackpotImages as $image) {
                                    ?>
                                        <div id="img-container">
                                            <img src="./assets/images/jackpot-images/<?php echo $image ?>" alt="" width="200px">
                                        </div>
                                    <?php

                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="px-0 flex-grow-1">
                                <div>
                                    <div class="trans-bg rounded p-2">

                                        <div class="fw-bold" id="product-name"> <?php echo $row['product_name'] ?></div>

                                        <div class="fw-semibold text-end" id="product-price"> <?php echo $row['product_price'] ?></div>

                                        <div class="ms-auto text-end" id="product-quantity"> x <?php echo $row['product_quantity'] ?></div>
                                    </div>

                                    <div class="p-2 gap-2">
                                        <div class="d-flex fw-semibold">
                                            <div><?php echo $language_data['total_amount'] ?>: </div>

                                            <div class="ms-auto" id="total-amount"><?php echo number_format($row['product_price'] * $row['product_quantity'], 2) ?></div>
                                        </div>
                                        <div class="d-flex">
                                            <div><?php echo $language_data['commission'] ?>: </div>
                                            <div class="ms-auto" id="commission"><?php echo $jackpot_commission ?>%</div>
                                        </div>

                                        <div class="d-flex text-success fw-bold fs-6">
                                            <div><?php echo $language_data['refund'] ?>: </div>
                                            <div class="ms-auto" id="est-refund">$ <?php echo number_format(($row['product_price'] * $row['product_quantity']) + ($jackpot_commission / 100) * ($row['product_price'] * $row['product_quantity']), 2) ?></div>
                                        </div>

                                    </div>

                                </div>
                                <div class="d-flex gap-2 justify-content-end mt-4">
                                    <form action="" method="POST">
                                        <input type="hidden" name="jackpot-id" value="<?php echo $row['id'] ?>">
                                        <input type="hidden" name="total-amount" value="<?php echo ($row['product_price'] * $row['product_quantity']) ?>">
                                        <input type="hidden" name="commission-amount" value="<?php echo ($row['product_price'] * $row['product_quantity']) * ($jackpot_commission / 100) ?>">
                                        <input type="hidden" name="balance" value=" <?php echo $balance ?>">
                                        <input type="hidden" name="level" value=" <?php echo $level ?>">
                                        <input type="hidden" name="target-user" value="<?php echo login_id() ?>">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button class="btn btn deep-bg text-white" type="submit" name="jackpot_grab" value="2" data-bs-dismiss="modal">Submit</i></button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>


<?php


    }
}

?>


<section>
    <div class="d-flex my-2 justify-content-between w-100 rounded">

        <div class="d-flex align-items-center p-2 justify-content-between w-100 mt-2">

            <div class="img-container">
                <img src="./assets/images/icons/<?php echo $level_image ?>" alt="" width="50px" height="50px">
            </div>
            <div class="d-flex flex-column name-n-price px-3 py-1">
                <div><?php echo $language_data['commission'] ?></div>
                <div><?php echo $commission ?>%</div>
            </div>

            <div class="balance-container fs-6 light-bg fw-bold rounded-3 ms-auto px-3 py-1 shadow-sm"><?php echo $language_data['balance'] ?>: <span class="text-success">$

                    <?php
                    echo $balance;
                    ?>

                </span>
            </div>
        </div>


    </div>
</section>


<div class="alert alert-success fw-bold fade show" id="order-alert" role="alert">
    Order completed successfully!
</div>
<div class="alert alert-danger fw-bold fade show" id="order-failed-alert" role="alert">
    Insufficient balance!
</div>

<!-- slider  -->
<section>
    <div>
        <?php
        if (isset($product_data) && !empty($product_data)) {

        ?>

            <!-- Modal product -->
            <div class="modal modal-lg fade" id="orderPrevModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content light-bg">

                        <div class="modal-body">

                            <?php

                            if (isset($product_image) && !empty($product_image)) {

                            ?>

                                <div class="d-flex p-0">
                                    <div class="fs-6 mb-2">

                                        <div id="created-time"><?php echo $language_data['created_time'] ?>: </div>
                                        <div id="order-no"><?php echo $language_data['order_no'] ?>: </div>

                                    </div>
                                    <div class="ms-auto status-part fw-semibold fs-5 text-secondary fst-italic">Pending</div>
                                </div>

                                <div class="order-details-row d-flex p-0 m-0 gap-2">
                                    <div class="m-0 p-0 border trans-bg shadow-sm d-flex justify-content-center align-items-center">

                                        <div class="m-0 p-0" id="slide-container">


                                        </div>
                                    </div>

                                    <div class="px-0 flex-grow-1">
                                        <div>
                                            <div class="trans-bg rounded p-2">

                                                <div class="fw-bold" id="product-name"></div>

                                                <div class="fw-semibold text-end" id="product-price"></div>
                                                <div class="ms-auto text-end" id="product-quantity"></div>
                                            </div>

                                            <div class="p-2 gap-2">
                                                <div class="d-flex fw-semibold">
                                                    <div><?php echo $language_data['total_amount'] ?>:</div>
                                                    <div class="ms-auto" id="total-amount"></div>
                                                </div>
                                                <div class="d-flex">
                                                    <div><?php echo $language_data['commission'] ?>:</div>
                                                    <div class="ms-auto" id="commission"></div>
                                                </div>
                                                <div class="d-flex text-success fw-bold fs-6">
                                                    <div><?php echo $language_data['refund'] ?>:</div>
                                                    <div class="ms-auto" id="est-refund"></div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="d-flex gap-2 justify-content-end mt-4">
                                            <form id="order-form">
                                                <input type="hidden" name="product-id">
                                                <input type="hidden" name="ordered-by" value="<?php echo login_id() ?>">
                                                <input type="hidden" name="total-amount">
                                            </form>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button class="btn btn deep-bg text-white" type="button" id="order-submit-button" onclick="submitOrder('order-form')" data-bs-dismiss="modal">Submit</i></button>
                                        </div>
                                    </div>
                                </div>

                            <?php
                            }
                            ?>

                        </div>


                    </div>
                </div>

            </div>

            <!-- Modal warning -->
            <div class="modal modal-lg fade" id="warningModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content p-3 light-bg">
                        <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="modal-body d-flex flex-column justify-content-center align-items-center gap-2">
                            <div><img src="./assets/images/icons/cross_icon.png" width="70px"></div>
                            <div class="text-danger text-center fw-semibold fs-4">Please submit your last order first!</div>
                            <div><a href="pending-order.php">View pending orders</a></div>
                            <!--<button type="button" class="btn deep-bg text-white px-5" data-bs-dismiss="modal">Ok</button>-->
                        </div>


                    </div>
                </div>

            </div>

            <div class="modal modal-lg fade" id="warningModal2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content p-3 light-bg">
                        <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="modal-body d-flex flex-column justify-content-center align-items-center gap-2">
                            <div><img src="./assets/images/icons/cross_icon.png" width="70px"></div>
                            <div class="text-danger text-center fw-semibold fs-4">You have reched the limit for today!</div>

                        </div>

                    </div>
                </div>

            </div>


            <div class="modal modal-lg fade" id="warningModal3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content p-3 light-bg">
                        <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="modal-body d-flex flex-column justify-content-center align-items-center gap-2">
                            <div><img src="./assets/images/icons/wait.png" width="100px"></div>
                            <div class="text-danger text-center fw-semibold fs-4">More products will be available soon!</div>


                        </div>

                    </div>
                </div>

            </div>


            <div class="slider-common-class order-item-slider mb-3">

                <?php

                // Set the parameters for the initial load
                $_GET['type'] = 'products'; // Example table name
                $columns = $_GET['columns'] = 'p.id AS product_id, p.product_name AS product_name, p.product_quantity * p.product_price AS product_price, p.user_level, GROUP_CONCAT(pi.product_image) AS product_image';
                $table = $_GET['table'] = 'products p JOIN product_image pi ON pi.upload_id = p.id';
                $_GET['conditions'] = 'p.status'; // Example additional conditions
                $_GET['condition_value'] = 1; // Example additional conditions
                $_GET['order_conditions'] = 'RAND()'; // Example additional conditions
                $_GET['group_conditions'] = 'GROUP BY p.id'; // Example additional conditions


                // Include the initial_load.php file
                include "./functions/initial-load.php";
                ?>

            </div>
        <?php
        }
        ?>

    </div>


    <?php
    if ($rowCount > 0) {
    ?>
        <!-- Button trigger modal -->
        <div class="button-container px-5">
            <div class="rounded p-2 text-center text-nowrap bg-danger text-white fw-semibold btn shadow-sm" id="order-preview-button" data-bs-toggle="modal" data-bs-target="#jackpotleModal">Grab Jackpot</div>
        </div>

    <?php
    } else {
    ?>
        <!-- Button trigger modal -->
        <div class="button-container px-5">
            <div class="rounded p-2 text-center text-nowrap deep-bg text-white fw-semibold btn shadow" id="order-preview-button" onclick="createOrder(<?php echo login_id() ?>, <?php echo $commission ?>)">Start Grabbing Order</div>
        </div>

    <?php


    }

    ?>


</section>



<section>
    <div class="row">

        <?php
        $sql = "SELECT * FROM users WHERE id = $login_id";


        if ($result = $connection->query($sql)) {
            if ($result->num_rows > 0) {
                $balance_data = $result->fetch_object();
                $balance = $balance_data->balance;
                $holding_balance = $balance_data->holding_balance;
            } else {
                $balance = 0;
                $holding_balance = 0;
            }
        } else {
            echo "Error executing SQL query: " . $connection->error;
        }


        $sql = "SELECT COUNT(*) AS order_count FROM orders WHERE ordered_by = $login_id AND DATE(ordered_at) = DATE('$now') AND status = 2";

        if ($result = $connection->query($sql)) {
            if ($result->num_rows > 0) {
                $order_count = $result->fetch_object();
                $order_count = $order_count->order_count;
            } else {
                $order_count = 0;
            }
        } else {
            echo "Error executing SQL query: " . $connection->error;
        }


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

$sql = "SELECT COALESCE(
        (SELECT SUM(commission_amount) FROM orders WHERE ordered_by = $login_id AND DATE(ordered_at) = DATE('$now') AND status = 2),
        0) +
        COALESCE(
        (SELECT SUM(commission_amount) FROM jackpots WHERE target_user = $login_id AND DATE(ordered_at) = DATE('$now') AND status = 2),
        0) AS today_commission";


        if ($result = $connection->query($sql)) {
            $row = $result->fetch_assoc();
            if ($row['today_commission'] === null || $row['today_commission'] === 0) {
                $today_commission = 0;
            } else {
                $today_commission = $row['today_commission'];
            }
        } else {
            echo "Error executing SQL query: " . $connection->error;
        }


       $sql = "SELECT 
          COALESCE((SELECT SUM(commission_amount) FROM orders WHERE ordered_by = $login_id AND DATE(ordered_at) = DATE_SUB(DATE('$now'), INTERVAL 1 DAY) AND status = 2), 0) +
          COALESCE((SELECT SUM(commission_amount) FROM jackpots WHERE target_user = $login_id AND DATE(ordered_at) = DATE_SUB(DATE('$now'), INTERVAL 1 DAY) AND status = 2), 0) AS yesterday_commission";



        if ($result = $connection->query($sql)) {
            $row = $result->fetch_assoc();
            if ($row['yesterday_commission'] === null || $row['yesterday_commission'] === 0) {
                $yesterday_commission = 0;
            } else {
                $yesterday_commission = $row['yesterday_commission'];
            }
        } else {
            echo "Error executing SQL query: " . $connection->error;
        }


        ?>

        <div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-4 col-xxl-4 p-3">
            <div class="balance-container light-bg d-flex flex-column justify-content-center align-items-center gap-2 rounded-3 w-100 py-4 shadow-sm">
                <div class="fw-bold fs-6"><?php echo $language_data['total_commission'] ?></div>
                <div class="text-success fw-bold fs-5">$ <?php echo number_format($total_commission, 2) ?></div>
            </div>
        </div>
        <div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-4 col-xxl-4 p-3">
            <div class="balance-container light-bg d-flex flex-column justify-content-center align-items-center gap-2 rounded-3 w-100 py-4 shadow-sm">
                <div class="fw-bold fs-6"><?php echo $language_data['today_commission'] ?></div>
                <div class="text-success fw-bold fs-5">$ <?php echo number_format($today_commission, 2) ?></div>
            </div>
        </div>
        <div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-4 col-xxl-4 p-3">
            <div class="balance-container light-bg d-flex flex-column justify-content-center align-items-center gap-2 rounded-3 w-100 py-4 shadow-sm">
                <div class="fw-bold fs-6"><?php echo $language_data['yesterday_commission'] ?></div>
                <div class="text-success fw-bold fs-5">$ <?php echo number_format($yesterday_commission, 2) ?></div>
            </div>
        </div>
        <div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-4 col-xxl-4 p-3">
            <div class="balance-container light-bg d-flex flex-column justify-content-center align-items-center gap-2 rounded-3 w-100 py-4 shadow-sm">
                <div class="fw-bold fs-6"><?php echo $language_data['balance'] ?></div>
                <div class="text-success fw-bold fs-5">$ <?php echo number_format($balance, 2) ?></div>
            </div>
        </div>
        <div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-4 col-xxl-4 p-3">
            <div class="balance-container light-bg d-flex flex-column justify-content-center align-items-center gap-2 rounded-3 w-100 py-4 shadow-sm">
                <div class="fw-bold fs-6"><?php echo $language_data['holding_balance'] ?></div>
                <div class="text-danger fw-bold fs-5">$ <?php echo number_format($holding_balance, 2) ?></div>
            </div>
        </div>
        <div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-4 col-xxl-4 p-3">
            <div class="balance-container light-bg d-flex flex-column justify-content-center align-items-center gap-2 rounded-3 w-100 py-4 shadow-sm">
                <div class="fw-bold fs-6"><?php echo $language_data['order_quantity'] ?></div>
                <div class="text-success fw-bold fs-5"><?php echo $order_count ?>/<?php echo $order_limit ?></div>
            </div>
        </div>

    </div>
</section>

<section>
    <div class="row">
        <div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-4 col-xxl-4 p-3">
            <div class="partners-logo d-flex flex-column justify-content-center align-items-center gap-2 rounded-3 w-100 h-100 p-4">
                <div>
                    <img src="./assets/images/icons/partners/11st.png" alt="">
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-4 col-xxl-4 p-3">
            <div class="partners-logo d-flex flex-column justify-content-center align-items-center gap-2 rounded-3 w-100 h-100 p-4">
                <div>
                    <img src="./assets/images/icons/partners/ozonru.png" alt="">
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-4 col-xxl-4 p-3">
            <div class="partners-logo d-flex flex-column justify-content-center align-items-center gap-2 rounded-3 w-100 h-100 p-4">
                <div>
                    <img src="./assets/images/icons/partners/shopee.png" alt="">
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-4 col-xxl-4 p-3">
            <div class="partners-logo d-flex flex-column justify-content-center align-items-center gap-2 rounded-3 w-100 h-100 p-4">
                <div>
                    <img src="./assets/images/icons/partners/amazon.png" alt="">
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-4 col-xxl-4 p-3">
            <div class="partners-logo d-flex flex-column justify-content-center align-items-center gap-2 rounded-3 w-100 h-100 p-4">
                <div>
                    <img src="./assets/images/icons/partners/lazada.png" alt="">
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-4 col-xxl-4 p-3">
            <div class="partners-logo d-flex flex-column justify-content-center align-items-center gap-2 rounded-3 w-100 h-100 p-4">
                <div>
                    <img src="./assets/images/icons/partners/titkivn.png" alt="">
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-4 col-xxl-4 p-3">
            <div class="partners-logo d-flex flex-column justify-content-center align-items-center gap-2 rounded-3 w-100 h-100 p-4">
                <div>
                    <img src="./assets/images/icons/partners/walmart.png" alt="">
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-4 col-xxl-4 p-3">
            <div class="partners-logo d-flex flex-column justify-content-center align-items-center gap-2 rounded-3 w-100 h-100 p-4">
                <div>
                    <img src="./assets/images/icons/partners/ebay.png" alt="">
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-4 col-xxl-4 p-3">
            <div class="partners-logo d-flex flex-column justify-content-center align-items-center gap-2 rounded-3 w-100 h-100 p-4">
                <div>
                    <img src="./assets/images/icons/partners/combiz.png" alt="">
                </div>
            </div>
        </div>
    </div>
</section>

<canvas id="my-canvas"></canvas>
<?php
include "footer.php";
?>