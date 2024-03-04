<?php

date_default_timezone_set('America/New_York'); // Set timezone to Eastern Standard Time

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

// Check if the script is being run from the command line
if (php_sapi_name() !== 'cli') {
    header('HTTP/1.1 403 Forbidden');
    exit('Access denied');
}

$created_at = date('Y-m-d H:i:s');

include "/home2/cp615723/public_html/etsy2n.com/connection/connection.php";

// Update the balance and yesterday commission for all users
$stmt = $connection->prepare('UPDATE users SET yesterday_commission = 0');
$executeResult = $stmt->execute();

if (!$executeResult) {
    // Query execution failed, log error message
    echo "Failed to update yesterday commission for all users: " . $stmt->error;
    exit();
}


// Begin the transaction
$connection->begin_transaction();

try {
    // Retrieve the commission earned by each user in the last day
    $stmt = $connection->prepare('SELECT u.id AS ordered_by, u.invited_by, SUM(o.total_amount) AS spent, SUM(o.commission_amount) AS commission
                                    FROM orders AS o
                                    JOIN users AS u ON o.ordered_by = u.id
                                    WHERE o.is_processed = 1 AND o.status = 2 AND DATE(o.ordered_at) < CURDATE()
                                    GROUP BY ordered_by
                                    ');

    if (!$stmt) {
        // Query preparation failed, log error message
        echo "Failed to prepare query: " . $connection->error;
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $results = $result->fetch_all(MYSQLI_ASSOC);

    // Update the balance of each user and calculate inviter commissions
    $inviterCommissions = [];

    foreach ($results as $row) {
        $user_id = $row['ordered_by'];
        $spent = $row['spent'];
        $commission = $row['commission'];
        $refund = $spent + $commission;
        $invited_by = $row['invited_by'];

        $stmt = $connection->prepare('UPDATE users SET balance = balance + ?, yesterday_commission = ? WHERE id = ?');
        $stmt->bind_param('ddi', $refund, $commission, $user_id);
        $executeResult = $stmt->execute();


        if ($stmt->affected_rows > 0) {
            
            $logFile = './balance-update-log.txt';
            $logMessage = "code was executed on " . date('Y-m-d H:i:s');
            file_put_contents($logFile, $logMessage);

            // Track inviter commissions
            if (!isset($inviterCommissions[$invited_by])) {
                $inviterCommissions[$invited_by] = 0;
            }
            $inviterCommissions[$invited_by] += $commission * 0.1; // Add commission for the invited user

            // Insert a new row in the notification table for the user
            $yesterday = date('Y-m-d', strtotime('-1 day'));
            $formattedYesterday = date('j M Y', strtotime($yesterday));

            $notificationTitle = "Your commission of $formattedYesterday has been processed successfully!";
            $notificationDescription = "You have received $$commission as commission on the orders you made on $formattedYesterday. This is now available as your main balance.";

            $stmt = $connection->prepare('INSERT INTO notifications (title, description, target_user, created_at) VALUES (?, ?, ?, ?)');
            $stmt->bind_param('ssss', $notificationTitle, $notificationDescription, $user_id, date('Y-m-d H:i:s'));
            $executeNotification = $stmt->execute();

            if (!$executeNotification) {
                // Query execution failed, log error message
                echo "Failed to insert notification: " . $stmt->error;
                throw new Exception("Failed to insert notification: " . $stmt->error);
            }




            $create_history = (object)[
                'name' => "Grabbing Refund",
                'amount' => $spent,
                'type' => 1,
                'created_at' => $created_at,
                'created_by' => $user_id
            ];


            $create_history_2 = (object)[
                'name' => "Grabbing Commission",
                'amount' => $commission,
                'type' => 1,
                'created_at' => $created_at,
                'created_by' => $user_id
            ];



            $history_response = transaction_history($create_history);

            if ($history_response->status == 'success') {
                // header('Location: ' . $_SERVER['PHP_SELF']);

                $response = (object) [
                    'status' => 'success',
                ];

                $history_response_2 = transaction_history($create_history_2);

                if ($history_response_2->status == 'success') {
                    // header('Location: ' . $_SERVER['PHP_SELF']);

                    $response_2 = (object) [
                        'status' => 'success',
                        'message' => 'Updated Successfully!',
                    ];
                } else {
                    throw new Exception("Failed to create transaction history");
                }
            } else {
                throw new Exception("Failed to create transaction history");
            }
            

            $stmtPrc = $connection->prepare('UPDATE orders SET is_processed = 2 WHERE ordered_by = ? AND is_processed = 1 AND status = 2');
            $stmtPrc->bind_param('i', $user_id);
            $executePrc = $stmtPrc->execute();
            
            if (!$executePrc) {
                // Query execution failed, log error message
                throw new Exception("Failed to update status of order for $user_id: " . $stmt->error);
            }
        }


        if (!$executeResult) {
            // Query execution failed, log error message
            throw new Exception("Failed to update balance for user ID $user_id: " . $stmt->error);
        }
    }

    // Update inviter balances
    foreach ($inviterCommissions as $inviter_id => $inviterCommission) {
        // Retrieve the inviter's primary id based on the invitation code
        $stmt = $connection->prepare('SELECT id FROM users WHERE invitation_code = ?');
        $stmt->bind_param('s', $inviter_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $inviterRow = $result->fetch_assoc();
            $inviterPrimaryKey = $inviterRow['id'];

            $stmt = $connection->prepare('UPDATE users SET balance = balance + ? WHERE id = ?');
            $stmt->bind_param('di', $inviterCommission, $inviterPrimaryKey);
            $executeInviterCommission = $stmt->execute();


            $create_history = (object)[
                'name' => "Referral Commission",
                'amount' => $inviterCommission,
                'type' => 1,
                'created_at' => $created_at,
                'created_by' => $inviterPrimaryKey
            ];

            $history_response = transaction_history($create_history);

            if ($history_response->status == 'success') {
                // header('Location: ' . $_SERVER['PHP_SELF']);

                $response = (object) [

                    'status' => 'success',
                    'message' => 'Updated Successfully!',
                ];
            } else {
                throw new Exception("Failed to create transaction history");
            }


            // Insert a new row in the notification table for the inviter
            $yesterday = date('Y-m-d', strtotime('-1 day'));
            $formattedYesterday = date('j M Y', strtotime($yesterday));
            $notificationTitle = "Referral commission received!";
            $notificationDescription = "You have received $$inviterCommission as referral income of $formattedYesterday. This is now available as your main balance.";

            $stmt = $connection->prepare('INSERT INTO notifications (title, description, target_user, created_at) VALUES (?, ?, ?, ?)');
            $stmt->bind_param('ssss', $notificationTitle, $notificationDescription, $inviterPrimaryKey, date('Y-m-d H:i:s'));
            $notificationResult = $stmt->execute();

            if (!$notificationResult) {
                // Query execution failed, log error message
                echo "Failed to insert notification: " . $stmt->error;
                throw new Exception("Failed to insert notification: " . $stmt->error);
            }

            if (!$executeInviterCommission) {
                // Query execution failed, log error message
                throw new Exception("Failed to update balance for inviter ID $inviterPrimaryKey: " . $stmt->error);
            }
        }
    }


    // Check for deposits that have reached 30 days
    $stmt = $connection->prepare('SELECT * FROM treasury WHERE DATE(deposited_at) <= CURDATE() - INTERVAL 30 DAY AND interest_paid = 1');
    $stmt->execute();
    $result = $stmt->get_result();
    $deposits = $result->fetch_all(MYSQLI_ASSOC);

    foreach ($deposits as $deposit) {
        $deposit_id = $deposit['id'];
        $user_id = $deposit['deposited_by'];
        $amount = $deposit['deposited_amount'];
        $refund_amount = $deposit['refund_amount'];
        $interest = $refund_amount - $amount; // Calculate 10% interest

        // Update the user's balance and mark the deposit as interest paid
        $stmt = $connection->prepare('UPDATE users SET balance = balance + ?, treasury_balance = treasury_balance - ? WHERE id = ?');
        $stmt->bind_param('ddi', $refund_amount, $amount, $user_id);
        $executeInterestPayment = $stmt->execute();

        if (!$executeInterestPayment) {
            // Query execution failed, log error message
            throw new Exception("Failed to update balance for user ID $user_id: " . $stmt->error);
        }




        $create_history = (object)[
            'name' => "Treasury Refund",
            'amount' => $amount,
            'type' => 1,
            'created_at' => $created_at,
            'created_by' => $user_id
        ];


        $create_history_2 = (object)[
            'name' => "Treasury Interest",
            'amount' => $interest,
            'type' => 1,
            'created_at' => $created_at,
            'created_by' => $user_id
        ];



        $history_response = transaction_history($create_history);

        if ($history_response->status == 'success') {
            // header('Location: ' . $_SERVER['PHP_SELF']);

            $response = (object) [
                'status' => 'success',
            ];

            $history_response_2 = transaction_history($create_history_2);

            if ($history_response_2->status == 'success') {
                // header('Location: ' . $_SERVER['PHP_SELF']);

                $response_2 = (object) [
                    'status' => 'success',
                    'message' => 'Updated Successfully!',
                ];
            } else {

                throw new Exception("Failed to create transaction history");
            }
        } else {
            throw new Exception("Failed to create transaction history");
        }








        // Insert a new row in the notification table for the user
        $notificationTitle = "Deposit interest received!";
        $notificationDescription = "You have received $$interest as interest for your deposit of $$amount. This is now available as your main balance.";

        $stmt = $connection->prepare('INSERT INTO notifications (title, description, target_user, created_at) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('ssss', $notificationTitle, $notificationDescription, $user_id, date('Y-m-d H:i:s'));
        $notificationResult = $stmt->execute();

        if (!$notificationResult) {
            // Query execution failed, log error message
            echo "Failed to insert notification: " . $stmt->error;
            throw new Exception("Failed to insert notification: " . $stmt->error);
        }

        // Mark the deposit as interest paid
        $stmt = $connection->prepare('UPDATE treasury SET interest_paid = 2 WHERE id = ?');
        $stmt->bind_param('i', $deposit_id);
        $executeMarkInterestPaid = $stmt->execute();

        if (!$executeMarkInterestPaid) {
            // Query execution failed, log error message
            throw new Exception("Failed to mark deposit ID $deposit_id as interest paid: " . $stmt->error);
        }
    }


    // Retrieve the commission earned by each user in the last day
    $stmt = $connection->prepare('SELECT target_user, SUM(commission_amount) AS total_commission, SUM(total_amount) AS total_amount FROM jackpots WHERE DATE(ordered_at) < CURDATE() AND is_processed = 1 AND status = 2 GROUP BY target_user');


    if (!$stmt) {
        // Query preparation failed, log error message
        echo "Failed to prepare query: " . $connection->error;
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $results = $result->fetch_all(MYSQLI_ASSOC);



    // Update the balance of each user and insert notifications within the same transaction
    foreach ($results as $row) {
        $user_id = $row['target_user'];
        $commission = $row['total_commission'];
        $spent = $row['total_amount'];
        $refund = $spent + $commission;

        $stmt = $connection->prepare('UPDATE users SET balance = balance + ? WHERE id = ?');
        $stmt->bind_param('di', $refund, $user_id);
        $executeResult = $stmt->execute();

        if ($executeResult) {

            $notificationTitle = "Commission reccieved of Jackpot!";
            $notificationDescription = "You have received $$commission commission for the last jackpot. This is now available as your main balance.";

            $stmt = $connection->prepare('INSERT INTO notifications (title, description, target_user, created_at) VALUES (?, ?, ?, ?)');
            $stmt->bind_param('ssss', $notificationTitle, $notificationDescription, $user_id, date('Y-m-d H:i:s'));
            $executeNotification = $stmt->execute();

            if (!$executeNotification) {
                // Query execution failed, log error message
                echo "Failed to insert notification: " . $stmt->error;
                throw new Exception("Failed to insert notification: " . $stmt->error);
            }



            if ($stmt->affected_rows > 0) {

                $create_history = (object)[
                    'name' => "Jackpot Refund",
                    'amount' => $spent,
                    'type' => 1,
                    'created_at' => $created_at,
                    'created_by' => $user_id
                ];


                $create_history_2 = (object)[
                    'name' => "Jackpot Commission",
                    'amount' => $commission,
                    'type' => 1,
                    'created_at' => $created_at,
                    'created_by' => $user_id
                ];



                $history_response = transaction_history($create_history);

                if ($history_response->status == 'success') {
                    // header('Location: ' . $_SERVER['PHP_SELF']);

                    $response = (object) [
                        'status' => 'success',
                    ];

                    $history_response_2 = transaction_history($create_history_2);

                    if ($history_response_2->status == 'success') {
                        // header('Location: ' . $_SERVER['PHP_SELF']);

                        $response_2 = (object) [
                            'status' => 'success',
                            'message' => 'Updated Successfully!',
                        ];
                    } else {
                        throw new Exception("Failed to create transaction history");
                    }
                } else {
                    throw new Exception("Failed to create transaction history");
                }
            }
        } else {
            throw new Exception("Failed to update balance for user ID $user_id: " . $stmt->error);
        }
        
                    
        $stmtPrc = $connection->prepare('UPDATE jackpots SET is_processed = 2 WHERE target_user = ? AND is_processed = 1 AND status = 2');
        $stmtPrc->bind_param('i', $user_id);
        $executePrc = $stmtPrc->execute();
        
        if (!$executePrc) {
            // Query execution failed, log error message
            throw new Exception("Failed to update status of jackpot for $user_id: " . $stmt->error);
        }
    }



    // Commit the transaction if all queries executed successfully
    $connection->commit();
} catch (Exception $e) {
    // Roll back the transaction if an error occurred
    $connection->rollback();
    echo "Transaction failed: " . $e->getMessage();
}




function generateTransactionID()
{
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $id = '';

    for ($i = 0; $i < 10; $i++) {
        $randomIndex = rand(0, strlen($characters) - 1);
        $id .= $characters[$randomIndex];
    }

    return $id;
}

function transaction_history($transaction_data)
{
    global $connection;

    $name = $transaction_data->name;
    $amount = $transaction_data->amount;
    $type = $transaction_data->type;
    $created_at = $transaction_data->created_at;
    $created_by = $transaction_data->created_by;

    $transactionID = generateTransactionID();

    // Check if the generated ID already exists in the table
    $existingID = true;
    while ($existingID) {
        $stmt = $connection->prepare('SELECT COUNT(*) as count FROM transactions WHERE transaction_id = ?');
        $stmt->bind_param('s', $transactionID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $existingID = ($row['count'] > 0);

        // Regenerate ID if it already exists
        if ($existingID) {
            $transactionID = generateTransactionID();
        }
    }

    $stmt = $connection->prepare('INSERT INTO transactions (transaction_id, name, amount, type, created_at, created_by) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('ssdssi', $transactionID, $name, $amount, $type, $created_at, $created_by);
    $transactionResult = $stmt->execute();

    $history_response = (object) [
        'status' => ($transactionResult ? 'success' : 'error'),
    ];

    return $history_response;
}


?>