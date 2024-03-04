<?php
session_start();

date_default_timezone_set('America/New_York'); // Set timezone to Eastern Standard Time

// ini_set('display_errors', 1);
// ini_set('log_errors', 1);
// ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
// error_reporting(E_ALL);

include "../connection/connection.php";
include "../helper/utilities.php";
include "./data-management.php";

$date = date('Y-m-d H:i:s');

if (isset($_POST["create_order"])) {
    $ordered_by = mysqli_real_escape_string($connection, $_POST["ordered_by"]);

    $sql = "SELECT id FROM orders WHERE status = 1 AND ordered_by = $ordered_by";
    $result = $connection->query($sql);

    if (!$result) {
        echo "Error executing query: " . $connection->error;
        exit();
    }

    if ($result->num_rows > 0) {
        echo "pending";
        exit();
    } else {
        $query = "SELECT level FROM users WHERE id = $ordered_by";
        $levelResult = $connection->query($query);
        if ($levelResult->num_rows > 0) {
            $row = $levelResult->fetch_assoc();
            $user_level = $row['level'];

            $commission_rate = "";
            $order_limit = "";

            if ($user_level == 1) {
                $commission_rate = "0.5%";
                $order_limit = 60;
            } else if ($user_level == 2) {
                $commission_rate = "0.6%";
                $order_limit = 80;
            } else if ($user_level == 3) {
                $commission_rate = "0.7%";
                $order_limit = 100;
            } else if ($user_level == 4) {
                $commission_rate = "0.8%";
                $order_limit = 120;
            } else if ($user_level == 5) {
                $commission_rate = "0.9%";
                $order_limit = 130;
            }

            // SQL query to get the count
            $countSql = "SELECT COUNT(*) AS order_count FROM orders WHERE ordered_by = $ordered_by AND DATE(created_at) = DATE('$date')";

            // Fetch the count result
            $countResult = $connection->query($countSql);
            $countRow = $countResult->fetch_assoc();
            $order_count = $countRow['order_count'];

            if ($order_count < $order_limit) {

                // SQL query to retrieve data from the products table
                $sql = "SELECT * FROM products WHERE status = 1 AND user_level = $user_level";

                // Execute the query
                $result = $connection->query($sql);

                // Check if the query was successful
                if ($result->num_rows > 0) {
                    $available_product_data = array(); // Initialize an empty array

                    // Loop through the query results and store each row in the array
                    while ($row = mysqli_fetch_assoc($result)) {
                        $available_product_data[] = $row;
                    }
                    $connection->begin_transaction(); // start transaction

                    $random_product = $available_product_data[array_rand($available_product_data)]; // select a random product from the array
                    $random_product_id = $random_product['id'];
                    $quantity = $random_product['product_quantity'];
                    $total_amount = $random_product['product_price'] * $random_product['product_quantity'];
                    $commission_amount = $total_amount * $commission_rate / 100;


                    // Read current sequence number and suffixes from file
                    $sql = "SELECT * FROM order_id_sequence WHERE id = 1 FOR UPDATE";
                    $result = $connection->query($sql);

                    if ($result->num_rows > 0) {
                        $sequence_data = $result->fetch_object();
                        $suffix1 = $sequence_data->suffix1;
                        $suffix2 = $sequence_data->suffix2;
                        $sequence = $sequence_data->last_sequence;
                        $sequence++;

                        $prefix = 'ORD'; // Define prefix

                        if ($sequence > 99999999) {
                            if ($sequence % 100000000 === 0) {
                                $sequence = ($sequence % 100000000) + 1;

                                if ($suffix2 < 'Z') {
                                    $suffix2 = chr(ord($suffix2) + 1);
                                } else {
                                    if ($suffix1 < 'Z') {
                                        $suffix1 = chr(ord($suffix1) + 1);
                                        $suffix2 = 'A';
                                    } else {
                                        $suffix1 = 'A';
                                        $suffix2 = 'A';
                                    }
                                }
                            }
                        }
                    }

                    $orderNo = $prefix . $suffix1 . $suffix2 . str_pad($sequence, 8, '0', STR_PAD_LEFT);

                    $sql = "UPDATE order_id_sequence SET suffix1 = '$suffix1', suffix2 = '$suffix2', last_sequence = $sequence WHERE id = 1";
                    $result = mysqli_query($connection, $sql);

                    if (!$result) {
                        $connection->rollback(); // rollback transaction on error
                        echo "Error updating order_id_sequence: " . $connection->error;
                    } else {
                        $stmt = $connection->prepare("INSERT INTO orders (order_no, created_at, ordered_by, product_id, quantity, total_amount, commission_amount) VALUES (?, ?, ?, ?, ?, ?, ?)");

                        if (!$stmt) {
                            $connection->rollback(); // rollback transaction on error
                            echo "Error preparing statement: " . $connection->error;
                        } else {
                            $stmt->bind_param("ssiiidd", $orderNo, $date, $ordered_by, $random_product_id, $quantity, $total_amount, $commission_amount);

                            if (!$stmt->execute()) {
                                $connection->rollback(); // rollback transaction on error
                                echo "Error executing statement: " . $stmt->error;
                            } else {

                                $update_products_sql = "UPDATE products SET status = 2, ordered_by = $ordered_by WHERE id = $random_product_id";
                                $update_products_result = mysqli_query($connection, $update_products_sql);

                                if (!$update_products_result) {
                                    echo "Error updating products table: " . mysqli_error($connection);
                                    exit();
                                }
                                $connection->commit(); // commit transaction
                            }
                        }
                    }

                    $sql = "SELECT product_image FROM product_image WHERE upload_id = $random_product_id";
                    $result = $connection->query($sql);

                    if ($result->num_rows > 0) {
                        $image_names = array();

                        while ($row = $result->fetch_assoc()) {
                            $image_names[] = $row["product_image"];
                        }
                    }

                    $order_data = array(
                        'random_product' => array(
                            'id' => $random_product['id'],
                            'product_name' => $random_product['product_name'],
                            'product_price' => $random_product['product_price'],
                            'product_quantity' => $random_product['product_quantity']
                        ),
                        'created_at' => $date,
                        'orderNo' => $orderNo,
                        'image_names' => $image_names
                    );

                    echo json_encode($order_data);
                } else {
                    echo "finished";
                    exit();
                }
            } else {
                echo "limit";
                exit();
            }
        }
    }
}





if (isset($_POST["submit_order"])) {
    $product_id = mysqli_real_escape_string($connection, $_POST["product_id"]);
    $ordered_by = mysqli_real_escape_string($connection, $_POST["ordered_by"]);
    $total_amount = mysqli_real_escape_string($connection, $_POST["total_amount"]);

    // Retrieve the current balance
    $balance_sql = "SELECT balance FROM users WHERE id = $ordered_by";
    $balance_result = mysqli_query($connection, $balance_sql);

    if (!$balance_result) {
        echo "Error retrieving balance: " . mysqli_error($connection);
        exit();
    }

    $row = mysqli_fetch_assoc($balance_result);
    $current_balance = $row['balance'];

    // Check if the balance will be negative after deduction
    if ($current_balance - $total_amount < 0) {
        echo "Insufficient balance";
        exit();
    }

    // Start a transaction
    mysqli_begin_transaction($connection);

    try {
        // Update the balance
        $update_balance_sql = "UPDATE users SET balance = balance - $total_amount WHERE id = $ordered_by";
        $update_balance_result = mysqli_query($connection, $update_balance_sql);

        if (!$update_balance_result) {
            throw new Exception("Error updating balance: " . mysqli_error($connection));
        }

        $update_orders_sql = "UPDATE orders SET status = 2, ordered_at = '$date' WHERE product_id = $product_id";
        $update_orders_result = mysqli_query($connection, $update_orders_sql);

        if (!$update_orders_result) {
            throw new Exception("Error updating orders table: " . mysqli_error($connection));
        }

        $create_history = (object) array(
            'name' => "Grabbing Deduction",
            'amount' => $total_amount,
            'type' => 2,
            'created_at' => $date,
            'created_by' => $ordered_by
        );

        $history_response = transaction_history($create_history);

        if ($history_response->status != 'success') {
            throw new Exception("Failed to create transaction history");
        }

        // Commit the transaction
        mysqli_commit($connection);

        $response = (object) array(
            'status' => 'success',
            'message' => 'Updated Successfully!'
        );

        echo "Status updated successfully";
    } catch (Exception $e) {
        // Rollback the transaction on error
        mysqli_rollback($connection);
        echo $e->getMessage();
        exit();
    }
}


?>
