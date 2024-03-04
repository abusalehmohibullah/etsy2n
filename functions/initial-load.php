<?php
// initial_load.php
session_start();

// error_reporting(E_ALL);
// ini_set('display_errors', '1');

include "../connection/connection.php";
$login_id = $_SESSION['login_id'];

// Retrieve the offset and limit values for the initial load
// Validate offset and limit values
$offset = isset($_GET['offset']) && is_numeric($_GET['offset']) ? max(0, (int)$_GET['offset']) : 0;
$limit = isset($_GET['limit']) && is_numeric($_GET['limit']) ? max(1, (int)$_GET['limit']) : 10;


// Retrieve other parameters for table, columns, and conditions
$table = isset($_GET['table']) ? $_GET['table'] : ''; // Table name
$columns = isset($_GET['columns']) ? $_GET['columns'] : '*'; // Columns to fetch
$conditions = isset($_GET['conditions']) ? $_GET['conditions'] : ''; // Additional conditions
$status_conditions = isset($_GET['status_conditions']) ? $_GET['status_conditions'] : ''; // Additional conditions
$condition_value = isset($_GET['condition_value']) ? $_GET['condition_value'] : ''; // Additional conditions
$order_status = isset($_GET['order-status']) ? $_GET['order-status'] : ''; // Additional conditions
$order_conditions = isset($_GET['order_conditions']) ? $_GET['order_conditions'] : ''; // Additional conditions
$group_conditions = isset($_GET['group_conditions']) ? $_GET['group_conditions'] : ''; // Additional conditions

// Generate the SQL query to count the total number of rows
$countQuery = "SELECT COUNT(*) as total FROM $table WHERE $conditions = ?";
$countStatement = mysqli_prepare($connection, $countQuery);
mysqli_stmt_bind_param($countStatement, "s", $condition_value);
mysqli_stmt_execute($countStatement);
$countResult = mysqli_stmt_get_result($countStatement);
$totalRows = 0;

if ($countResult) {
    $countRow = mysqli_fetch_assoc($countResult);
    $totalRows = $countRow['total'];
}

// Generate the SQL query with the provided parameters
$sql = "SELECT $columns FROM $table WHERE $status_conditions $conditions = ? $group_conditions ORDER BY $order_conditions  DESC LIMIT $offset, $limit";
$statement = mysqli_prepare($connection, $sql);
mysqli_stmt_bind_param($statement, "s", $condition_value);
mysqli_stmt_execute($statement);
$result = mysqli_stmt_get_result($statement);



if (isset($_GET['type']) && $_GET['type'] == "slides") {
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Generate HTML markup for the rows


?>
            <div><img src="./assets/images/slider-images/<?php echo $row[slider_image]; ?>" alt="" class="w-100"></div>
        <?php
        }


        if ($totalRows == 0) {
        ?>
            <div class="light-bg rounded text-center">No slider found!</div>

            <?php
        }
    }
}


if (is_authenticate_user() || is_authenticate()) {

    if (isset($_GET['type']) && $_GET['type'] == "products") {
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Generate HTML markup for the rows


            ?>

                <div>
                    <div class="order-item-sub-slider slider-common-class">
                        <?php
                        $productImages = explode(',', $row['product_image']);

                        foreach ($productImages as $productImage) {
                            // Process each product image
                        ?>
                            <div class="position-relative d-flex justify-content-center align-items-end">
                                <div class="ratio ratio-1x1">
                                    <img class="w-100 h-100 object-fit-cover" src="./assets/images/product-images/<?php echo $productImage; ?>" alt="">
                                </div>
                                <div class="position-absolute bottom-0 p-1 m-1 rounded w-75 text-center trans-bg">
                                    <div class="text-success fw-bolder">
                                        $<?php echo number_format($row['product_price'], 2) ?>
                                    </div>
                                    <div class="fw-semibold">
                                        <?php echo $row['product_name']; ?>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>

                </div>

            <?php
            }


            if ($totalRows == 0) {
            ?>
                <div class="light-bg rounded text-center my-5 py-5 fw-bold fs-4">Products will be available soon!</div>

            <?php
            }
        }
    }
}


if (is_authenticate_user() || is_authenticate()) {

    if (isset($_GET['type']) && $_GET['type'] == "transactions") {
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Generate HTML markup for the rows
                // ...

                $sign = "";
                if ($row['type'] == 1) {
                    $sign = "+";
                    $color = "text-success";
                } else {
                    $sign = "-";
                    $color = "text-danger";
                }
            ?>

                <div class="d-flex justify-content-between border border-start-0 border-end-0 py-2">
                    <div>
                        <div class="fw-semibold"><?php echo $row['name'] ?></div>
                        <div class="text-secondary"><?php echo "TxID: " . $row['transaction_id'] ?></div>
                    </div>
                    <div>
                        <div class="fw-semibold text-end <?php echo $color ?>"><?php echo $sign . " $ " . $row['amount'] ?></div>
                        <div class="text-secondary"><?php echo date('h:i A d/m/y', strtotime($row['created_at'])); ?></div>

                    </div>
                </div>



            <?php

            }


            if ($totalRows > 0) {
            ?>
                <div class="btn btn-white w-100 my-2" id="load-more-btn" onclick="loadMoreResults('<?php echo $condition_value ?>')">More</div>

            <?php
            } else {
            ?>
                <div class="light-bg rounded text-center">No transactions found!</div>
            <?php
            }
        }
    }
}

if (is_authenticate_user() || is_authenticate()) {

    if (isset($_GET['type']) && $_GET['type'] == "all-orders") {

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Generate HTML markup for the rows
                // ...

            ?>

                <div class="container order-details-container light-bg shadow-sm rounded-3 my-3 p-3">
                    <div class="d-flex p-0">
                        <div class="fs-6 mb-2">

                            <?php

                            $order_status = $row[status];
                            if ($order_status == 1) {
                                $status_color = 'text-secondary';
                                $status = $language_data['pending'];
                                $time = $language_data['created_time'] . ": " . $row[created_at];
                            } elseif ($order_status == 2) {
                                $status_color = 'text-success';
                                $status = $language_data['completed'];
                                $time = $language_data['created_time'] . ": " . $row[ordered_at];
                            }
                            ?>

                            <div id="created-time"><?php echo $time ?></div>
                            <div id="order-no"><?php echo $language_data['order_no'] ?>: <?php echo $row[order_no] ?></div>

                        </div>
                        <div class="ms-auto status-part fw-semibold fst-italic fs-5 <?php echo $status_color; ?>"><?php echo $status; ?></div>
                    </div>

                    <div class=" order-details-row d-flex p-0 m-0 gap-2">
                        <div class="m-0 p-0 border trans-bg shadow-sm d-flex justify-content-center align-items-center">
                            <div class="order-item-history-slider slider-common-class" style="width: 200px" ;>
                                <?php

                                $productImages = explode(',', $row['product_image']);

                                foreach ($productImages as $productImage) {
                                    // Process each product image
                                ?>
                                    <div>
                                        <img class="order-image-preview" src="./assets/images/product-images/<?php echo $productImage; ?>" alt="" width="200px">
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>


                        <div class="px-0 flex-grow-1">
                            <div>
                                <div class="trans-bg p-2 shadow-sm rounded">

                                    <div class="fw-bold" id="product-name"><?php echo $row[product_name] ?></div>

                                    <div class="text-end fw-semibold" id="product-price">$ <?php echo number_format($row[product_price], 2) ?></div>
                                    <div class="ms-auto text-end" id="product-quantity">x <?php echo $row[product_quantity] ?></div>

                                </div>

                                <div class="p-2 gap-2">
                                    <div class="d-flex fw-semibold">
                                        <div><?php echo $language_data['total_amount'] ?>:</div>
                                        <div class="ms-auto" id="total-amount">$ <?php echo number_format($row[total_amount], 2) ?></div>
                                    </div>
                                    <div class="d-flex">
                                        <div><?php echo $language_data['commission'] ?>:</div>
                                        <div class="ms-auto" id="commission"><?php echo number_format(($row[commission_amount] / $row[total_amount])*100, 1) ?>%</div>
                                    </div>
                                    <div class="d-flex text-success fw-bold fs-6">
                                        <div><?php echo $language_data['refund'] ?>:</div>
                                        <div class="ms-auto" id="est-refund">$ <?php echo number_format($row[total_amount] + $row[commission_amount], 2) ?></div>
                                    </div>
                                </div>
                                <?php if ($order_status == 1) { ?>
                                    <div class="d-flex gap-2 justify-content-end mt-4">
                                        <form id="order-form_<?php echo $row[product_id] ?>">
                                            <input type="hidden" name="product-id" value="<?php echo $row[product_id] ?>">
                                            <input type="hidden" name="ordered-by" value="<?php echo login_id() ?>">
                                            <input type="hidden" name="total-amount" value="<?php echo number_format($row[total_amount], 2) ?>">
                                        </form>
                                        <button class="btn btn deep-bg text-white" type="button" id="order-submit-button" onclick="submitOrder('order-form_<?php echo $row[product_id] ?>')">Submit</i></button>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>


            <?php

            }

            if ($totalRows > 0) {
            ?>
                <div class="btn btn-outline-light text-dark w-100 my-2" id="load-more-btn" onclick="loadMoreResults('<?php echo $condition_value ?>')">More</div>

            <?php
            } else {
            ?>
                <div class="light-bg rounded text-center">No orders found!</div>
<?php
            }
        }
    }
}

?>