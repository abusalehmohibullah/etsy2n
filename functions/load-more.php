<?php
// load_more.php
session_start();

// error_reporting(E_ALL);
// ini_set('display_errors', '1');

include "../helper/utilities.php";

include "../connection/connection.php";

$login_id = isset($_SESSION['login_id']) ? $_SESSION['login_id'] : ''; 

$language_data = isset($_SESSION['language-data']) ? $_SESSION['language-data'] : '';


// Retrieve the offset and limit values from the GET parameters
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;

// Retrieve other parameters for table, columns, and conditions
$table = isset($_GET['table']) ? $_GET['table'] : ''; // Table name
$columns = isset($_GET['columns']) ? $_GET['columns'] : '*'; // Columns to fetch
$conditions = isset($_GET['conditions']) ? $_GET['conditions'] : ''; // Additional conditions
$condition_value = isset($_GET['condition_value']) ? $_GET['condition_value'] : ''; // Additional conditions
$order_conditions = isset($_GET['order_conditions']) ? $_GET['order_conditions'] : ''; // Additional conditions
$group_conditions = isset($_GET['group_conditions']) ? $_GET['group_conditions'] : ''; // Additional conditions

// Generate the SQL query with the provided parameters
$sql = "SELECT $columns FROM $table WHERE $conditions = ? $group_conditions ORDER BY $order_conditions DESC LIMIT $offset, $limit";
$statement = mysqli_prepare($connection, $sql);
mysqli_stmt_bind_param($statement, "s", $condition_value);
mysqli_stmt_execute($statement);
$result = mysqli_stmt_get_result($statement);

if (isset($_GET['type']) && $_GET['type'] == "slides") {


    if ($result) {
        $images = array(); // Array to store the image URLs

        while ($row = mysqli_fetch_assoc($result)) {
            // Add the image URL to the array
            $images[] = './assets/images/slider-images/' . $row['slider_image'];
        }

        // Send the response as JSON
        header('Content-Type: application/json');
        echo json_encode($images);
    }
}



if (is_authenticate_user() || is_authenticate()) {

    if (isset($_GET['type']) && $_GET['type'] == "products") {

        $products = array();

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Generate HTML markup for the rows

                $product = array(
                    'product_id' => $row['product_id'],
                    'product_name' => $row['product_name'],
                    'product_price' => $row['product_price'],
                    'product_images' => explode(',', $row['product_image'])
                );

                $products[] = $product;
            }
        }

        // Encode the array as JSON
        $jsonData = json_encode($products);

        // Return the JSON response
        echo $jsonData;
    }
}


if (is_authenticate_user() || is_authenticate()) {

    if (isset($_GET['type']) && $_GET['type'] == "transactions") {

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
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
                            </div>
                        </div>
                    </div>
                </div>
<?php

            }
        }
    }
}


?>