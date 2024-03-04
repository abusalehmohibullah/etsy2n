<div class="d-flex align-items-center justify-content-center py-3 mt-2">
    <div class="fs-4 fw-bold"><?php echo $language_data['grabbing_history'] ?></div>
    <div class="balance-container fs-6 light-bg fw-bold rounded-3 ms-auto px-3 shadow-sm py-1"><?php echo $language_data['balance'] ?>:<span class="text-success">$

            <?php
            if (isset($users) && !empty($users)) {
                foreach ($users as $data) {
                    if ($data->id == login_id()) {

                        echo $data->balance;
                    }
                }
            } ?>

        </span>
    </div>
</div>




<nav class="navbar bg-white order-nav sticky-top rounded py-1 mb-4">
    <div class="container p-0">
        <ul class="navbar-nav order-nav d-flex flex-row justify-content-between align-items-end gap-3 w-100">

            <li class="nav-item light-bg rounded-4 text-center p-0 w-100 shadow-sm">
                <a class="nav-link p-2 
                <?php if ($page_name == "all-order.php") {
                    echo "fw-semibold text-dark";
                } ?>
                " href="all-order.php">
                    <?php echo $language_data['all_orders'] ?>
                </a>
            </li>
            <li class="nav-item light-bg rounded-4 text-center p-0 w-100 shadow-sm">
                <a class="nav-link p-2
                <?php if ($page_name == "pending-order.php") {
                    echo "fw-semibold text-dark";
                } ?>
                " href="pending-order.php">
                    <?php echo $language_data['pending'] ?>
                </a>
            </li>

            <li class="nav-item light-bg rounded-4 text-center p-0 w-100 shadow-sm">
                <a class="nav-link p-2
                <?php if ($page_name == "completed-order.php") {
                    echo "fw-semibold text-dark";
                } ?>
                " href="completed-order.php">
                    <?php echo $language_data['completed'] ?>
                </a>
            </li>

        </ul>
    </div>
</nav>






<div class="alert alert-success fw-bold fade show" id="order-alert" role="alert">
    Order completed successfully!
</div>
<div class="alert alert-danger fw-bold fade show" id="order-failed-alert" role="alert">
    Insufficient balance!
</div>


<div id="order-history">


    <?php

    // Set the parameters for the initial load
    $_GET['type'] = 'all-orders'; // Example table name
    $columns = $_GET['columns'] = 'o.*, p.id AS product_id, p.product_name AS product_name, p.product_quantity AS product_quantity, p.product_price AS product_price, GROUP_CONCAT(pi.product_image) AS product_image';
    $table = $_GET['table'] = 'orders o JOIN products p ON p.id = o.product_id JOIN product_image pi ON pi.upload_id = p.id';
    $_GET['conditions'] = 'o.ordered_by'; // Example additional conditions
    $_GET['condition_value'] = $login_id; // Example additional conditions
    $_GET['order_conditions'] = 'o.id'; // Example additional conditions
    $_GET['group_conditions'] = 'GROUP BY p.id'; // Example additional conditions

    // Include the initial_load.php file
    include "./functions/initial-load.php";
    ?>
    
</div>