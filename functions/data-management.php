<?php

// ini_set('display_errors', 1);
// error_reporting(E_ALL);


date_default_timezone_set('America/New_York'); // Set timezone to Eastern Standard Time

$created_at = date('Y-m-d H:i:s');




function getUserStatus($id)
{
    global $connection;
    // Prepare the query
    $stmt = $connection->prepare("SELECT status FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);

    // Execute the query
    $stmt->execute();

    // Bind the result to a variable
    $stmt->bind_result($status);

    // Fetch the result
    $stmt->fetch();

    // Close the statement
    $stmt->close();

    // Return the user's status
    return $status;
}



if (isset($_POST['change-password'])) {

    // Sanitize inputs
    $table = mysqli_real_escape_string($connection, $_POST['table']);
    $id = mysqli_real_escape_string($connection, $_POST['id']);
    $password = mysqli_real_escape_string($connection, md5($_POST['password']));
    $new_password = mysqli_real_escape_string($connection, md5($_POST['new-password']));
    $confirm_password = mysqli_real_escape_string($connection, md5($_POST['confirm-password']));

    // execute the SQL query
    $sql = "SELECT COUNT(*) FROM $table WHERE id = $id AND password = '$password'";
    $result = mysqli_query($connection, $sql);

    // get the count from the query result
    $count = mysqli_fetch_array($result)[0];

    // check if the count is greater than zero
    if ($count > 0) {
        if ($new_password == $confirm_password) {
            $sql = "UPDATE $table SET password = '$new_password' WHERE id = $id";
            $result = mysqli_query($connection, $sql);

            if (mysqli_affected_rows($connection) > 0) {
                $_SESSION["success"] = "Password changed successfully!";
                header('Location: ' . $_SERVER['PHP_SELF']);
            }
        } else {
            $_SESSION["error"] = "Confirm password doesn't match!";
            return;
        }
    } else {

        $_SESSION["error"] = "Wrong Password!";
        return;
    }
}




if (isset($_POST['change-email'])) {


    $id = mysqli_real_escape_string($connection, $_POST['id']);
    $password = mysqli_real_escape_string($connection, md5($_POST['password']));
    $new_email = mysqli_real_escape_string($connection, md5($_POST['new-email']));

    // execute the SQL query
    $sql = "SELECT COUNT(*) FROM admins WHERE id = $id AND password = '$password'";
    $result = mysqli_query($connection, $sql);

    // get the count from the query result
    $count = mysqli_fetch_array($result)[0];

    // check if the count is greater than zero
    if ($count > 0) {

        $sql = "UPDATE admins SET user_name = '$new_email' WHERE id = $id";
        $result = mysqli_query($connection, $sql);

        if (mysqli_affected_rows($connection) > 0) {
            $_SESSION["success"] = "Email changed successfully!";
            $_SESSION['admin_user_name'] = $new_email;
            header('Location: ' . $_SERVER['PHP_SELF']);
        }
    } else {

        $_SESSION["error"] = "Wrong Password!";
        return;
    }
}




if (isset($_POST['update-status'])) {

    // entry new data 


    $id = mysqli_real_escape_string($connection, $_POST['id']);
    $value = mysqli_real_escape_string($connection, $_POST['value']);
    $table = mysqli_real_escape_string($connection, $_POST['table']);
    $continue = mysqli_real_escape_string($connection, $_POST['continue']);




    $sql = "UPDATE $table SET status = $value WHERE id = $id";
    $result = mysqli_query($connection, $sql);

    if (mysqli_affected_rows($connection) > 0) {
        $_SESSION["success"] = "Status changed successfully!";
        if ($continue == "yes") {
            // Update session variables
            $_SESSION['user_details'][status] = $value;
            header('Location: ' . $_SERVER['PHP_SELF']);
        }
    }
}




function get_user_list()
{
    global $connection;
    $data = array();

    // Loop through each table name
    $sql = "SELECT id, name, user_name, email FROM users ORDER BY name";
    // $sql = "SELECT * FROM " . $table_name;
    $result = $connection->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_object()) {
            $data[] = $row;
        }
    } else {
        $data[] = array(); // initialize as empty array
    }


    return $data;
}



if (isset($_POST['selected-id'])) {

    $user_id = $_POST['user-list'];
    $user_details = getUserData($user_id);

    if (isset($_SESSION['user_details'])) {
        unset($_SESSION['user_details']);
    }
    $_SESSION['user_details'] = $user_details;
}


// function to retrieve user data from your data source
function getUserData($user_id)
{
    global $connection;

    // Query to retrieve user data
    $query = "SELECT * FROM users WHERE id = '$user_id'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // If user data is found, return the row as an associative array
        $row = mysqli_fetch_assoc($result);
        return $row;
    } else {
        // If user data is not found, return null or false
        return null;
    }
}











// Function to handle data insertion and image upload

function handleDataAndImage($data, $imageField, $tableName, $redirectLink, $pivot_table, $uploadPath) {
    // Check if there are any images
    if ($_FILES['images']['size'] > 0 && $_FILES['images']['error'][0] !== UPLOAD_ERR_NO_FILE) {
        // Process the images
        $uploadedImages = $_FILES['images'];
        $mainTableId = "";
        $imageNames = [];

        // Iterate through each image
        foreach ($uploadedImages['tmp_name'] as $index => $tmpName) {
            $image = $uploadedImages['name'][$index];
            $fileExtension = strtolower(pathinfo($image, PATHINFO_EXTENSION));
            $uniqueName = uniqid() . '_' . mt_rand() . '.' . $fileExtension;
            $uploadDestination = $uploadPath . $uniqueName;
        
            // Check the file type
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($fileExtension, $allowedExtensions)) {
                $_SESSION['error'] = 'Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.';
                redirect($redirectLink);
                exit; // Prevent further execution
            }
        
            // Check the file size (maximum 500KB)
            $maxFileSize = 500 * 1024; // 500KB in bytes
            if ($uploadedImages['size'][$index] > $maxFileSize) {
                $_SESSION['error'] = 'Image size exceeds the allowed limit (500KB)';
                redirect($redirectLink);
                exit; // Prevent further execution
            }
        
            // Move the uploaded file to the desired destination with the unique name
            if (move_uploaded_file($tmpName, $uploadDestination)) {
                // Store the inserted image name
                $imageNames[] = $uniqueName;
            } else {
                // Handle the case where file upload failed
                $_SESSION['error'] = 'Failed to upload image';
                redirect($redirectLink);
                exit; // Prevent further execution
            }
        }


        if ($pivot_table == "") {
        
            // Iterate through each image name in the $data[$imageField] array
            foreach ($imageNames as $imageName) {
                
                // Insert the image name into the main table
                $data[$imageField] = $imageName;
                // Insert data into the main table
                $createResponse = add_data($data, $tableName);
        
            }
            
            if ($createResponse->status == 'success') {
                $mainTableId = $createResponse->insert_id;  // Get the primary key ID of the inserted row

                    $_SESSION['success'] = 'Images uploaded successfully';

                    redirect($redirectLink);
                    
            } else {
                // Handle the case where main table insertion fails
                $_SESSION['error'] = 'Failed to insert data into the main table: ' . $createResponse->message;
                redirect($redirectLink);
            }
        

        } else {


            // Insert data into the main table
            $createResponse = add_data($data, $tableName);
    
            if ($createResponse->status == 'success') {
                $mainTableId = $createResponse->insert_id;  // Get the primary key ID of the inserted row
            } else {
                // Handle the case where main table insertion fails
                $_SESSION['error'] = 'Failed to insert data into the main table: ' . $createResponse->message;
                redirect($redirectLink);
            }

        }
        // Insert image IDs into the pivot table
        foreach ($imageNames as $imageName) {
            $insert_data = (object) [
                $imageField => $imageName,
                'upload_id' => $mainTableId
        ];
            $insertResponse = add_data($insert_data, $pivot_table);  // Replace 'pivot_table' with the actual pivot table name

            if ($insertResponse->status != 'success') {
                // Handle the case where pivot table insertion fails
                $_SESSION['error'] = 'Failed to insert data into the pivot table: ' . $insertResponse->message;
                redirect($redirectLink);
            }
        
}

        $_SESSION['success'] = 'Uploaded Successfully!';
        
                
        if($tableName == "jackpots") {
            global $connection;
            $notificationTitle = "You have got a jackpot!";
            $notificationDescription = "Grab the jackpot now to get exclusive commission rate! <a href='./grabbing.php'><b>View</b></a>";
    
            $stmt = $connection->prepare('INSERT INTO notifications (title, description, target_user, created_at) VALUES (?, ?, ?, ?)');
            $stmt->bind_param('ssss', $notificationTitle, $notificationDescription, $data['target_user'], date('Y-m-d H:i:s'));
            $executeResult = $stmt->execute();
    
            if (!$executeResult) {
                // Query execution failed, log error message
                echo "Failed to insert notification: " . $stmt->error;
            }
        }
        
        redirect($redirectLink);
    } else {
        // Insert data into the main table
        $createResponse = add_data($data, $tableName);

        if ($createResponse->status == 'success') {
            $_SESSION['success'] = 'Data inserted successfully';
        } else {
            $_SESSION['error'] = 'Failed to insert data into the main table: ' . $createResponse->message;
        }

        redirect($redirectLink);
    }
}



function add_data($data, $tableName) {
    // Establish a database connection
    global $connection;

    // Convert object to an array
    $dataArray = json_decode(json_encode($data), true);

    // Prepare the SQL INSERT statement
    $columns = implode(',', array_keys($dataArray));
    $placeholders = implode(',', array_fill(0, count($dataArray), '?'));

    $query = "INSERT INTO $tableName ($columns) VALUES ($placeholders)";

    // Prepare the statement using the correct connection object
    $statement = $connection->prepare($query);

    if ($statement) {
        // Bind the values and execute the query
        $values = array_values($dataArray);
        $types = '';

        foreach ($values as $value) {
            if (is_int($value)) {
                $types .= 'i';  // Integer type
            } elseif (is_float($value)) {
                $types .= 'd';  // Double type (decimal)
            } else {
                $types .= 's';  // String type (default)
            }
        }

        $bindParams = array_merge([$types], $values);
        $bindParamsRefs = [];
        foreach ($bindParams as $key => $value) {
            $bindParamsRefs[$key] = &$bindParams[$key];
        }
        
        // Call bind_param with dynamic number of arguments using the `...` operator
        call_user_func_array([$statement, 'bind_param'], $bindParamsRefs);
        
        $success = $statement->execute();

        // Return the result or any necessary information
        if ($success) {
            return (object) [
                'status' => 'success',
                'insert_id' => $connection->insert_id,
            ];
        } else {
            return (object) [
                'status' => 'error',
                'message' => $statement->error,
            ];
        }
    } else {
        return (object) [
            'status' => 'error',
            'message' => $connection->error,
        ];
    }
}




// Entry new data
if (isset($_POST['order-publish']) && !empty($_POST['order-publish'])) {

    $data = [
        'product_name' => $_POST['product-name'],
        'product_price' => $_POST['product-price'],
        'product_quantity' => $_POST['product-quantity'],
        'user_level' => $_POST['user-level'],
        'created_by' => login_admin_id(),
        'created_at' => $created_at
    ];
    $imageField = 'product_image';
    $tableName = 'products';
    $redirectLink = 'create-order.php';
    $pivot_table = 'product_image';
    $uploadPath = '../assets/images/product-images/';
    handleDataAndImage($data, $imageField, $tableName, $redirectLink, $pivot_table, $uploadPath);
}

if (isset($_POST['slider-publish']) && !empty($_POST['slider-publish'])) {

    $data = [
        'created_by' => login_admin_id(),
        'created_at' => $created_at
    ];
    $imageField = 'slider_image';
    $tableName = 'slides';
    $redirectLink = 'slider.php';
    $pivot_table = '';
    $uploadPath = '../assets/images/slider-images/';
    handleDataAndImage($data, $imageField, $tableName, $redirectLink, $pivot_table, $uploadPath);
}

if (isset($_POST['jackpot-publish']) && !empty($_POST['jackpot-publish'])) {

    $target_user = $_POST['target-user'];

    // execute the SQL query
    $sql = "SELECT COUNT(*) FROM jackpots WHERE target_user = $target_user AND status = 1";
    $result = mysqli_query($connection, $sql);

    // get the count from the query result
    $count = mysqli_fetch_array($result)[0];

    // check if the count is greater than zero
    if ($count > 0) {
        $_SESSION["error"] = "User already has a pending jackpot!";
        return;
    } else {// Insert product data


        // Prepare the SQL query
        $query = "SELECT level FROM users WHERE id = $target_user";

        // Execute the query
        $result = mysqli_query($connection, $query);

        // Check if the query was successful
        if ($result) {
            // Fetch the row as an associative array
            $row = mysqli_fetch_assoc($result);

            $prev_rank = $row['level'];
            $jackpot_price = $_POST['product-price'] * $_POST['product-quantity'];

            $new_rank = "";
            if ($jackpot_price < 1000) {
                $new_rank = 1; 
            } elseif ($jackpot_price >= 1000 && $jackpot_price < 3000) {
                $new_rank = 2;
            } elseif ($jackpot_price >= 3000 && $jackpot_price < 5000) {
                $new_rank = 3;
            } elseif ($jackpot_price >= 5000 && $jackpot_price < 10000) {
                $new_rank = 4;
            } else {
                $new_rank = 5;
            }
            
            $data = [
                'product_name' => $_POST['product-name'],
                'product_price' => $_POST['product-price'],
                'product_quantity' => $_POST['product-quantity'],
                'target_user' => $_POST['target-user'],
                'created_by' => login_admin_id(),
                'prev_rank' => $prev_rank,
                'new_rank' => $new_rank,
                'created_at' => $created_at
            ];
            $imageField = 'jackpot_image';
            $tableName = 'jackpots';
            $redirectLink = 'jackpot.php';
            $pivot_table = 'jackpot_image';
            $uploadPath = '../assets/images/jackpot-images/';
        
        }
    }
     handleDataAndImage($data, $imageField, $tableName, $redirectLink, $pivot_table, $uploadPath);

}

if (isset($_POST['notice-publish']) && !empty($_POST['notice-publish'])) {
    $data = [
        'notice_text' => $_POST['notice-text'],
        'created_by' => login_admin_id(),
        'created_at' => $created_at
    ];
    $imageField = '';
    $tableName = 'notices';
    $redirectLink = 'slider.php';
    $pivot_table = '';
    $uploadPath = '';
    handleDataAndImage($data, $imageField, $tableName, $redirectLink, $pivot_table, $uploadPath);
}

if (isset($_POST['notification-publish']) && !empty($_POST['notification-publish'])) {

    $data = [
        'title' => $_POST['title'],
        'description' => $_POST['description'],
        'target_user' => implode(',', $_POST['user_ids']),
        'created_by' => login_admin_id(),
        'created_at' => $created_at
    ];
    $imageField = 'notification_image';
    $tableName = 'notifications';
    $redirectLink = 'notification.php';
    $pivot_table = 'notification_image';
    $uploadPath = '../assets/images/notification-images/';
    handleDataAndImage($data, $imageField, $tableName, $redirectLink, $pivot_table, $uploadPath);
}

if (isset($_POST['popup-publish']) && !empty($_POST['popup-publish'])) {
   
    $data = [
        'titles' => $_POST['title'],
        'descriptions' => $_POST['description'],
        'target_user' => implode(',', $_POST['user_ids']),
        'created_by' => login_admin_id(),
        'created_at' => $created_at
    ];
    $imageField = 'images';
    $tableName = 'popups';
    $redirectLink = 'popup.php';
    $pivot_table = '';
    $uploadPath = '../assets/images/popup-images/';
    handleDataAndImage($data, $imageField, $tableName, $redirectLink, $pivot_table, $uploadPath);
}




function get_data($table_names, $status)
{
    global $connection;
    $data = array();

    // Loop through each table name
    foreach ($table_names as $table_name) {
        $sql = "SELECT * FROM $table_name WHERE status = $status";

        $result = $connection->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
                $data[$table_name][] = $row;
            }
        } else {
            $data[$table_name] = array(); // initialize as empty array
        }
    }

    return $data;
}



if ((isset($_POST['change-logo']) && !empty($_FILES['logo-image']['name'])) || (isset($_POST['change-favicon']) && !empty($_FILES['favicon-image']['name']))) {
    if (isset($_POST['change-logo']) && !empty($_FILES['logo-image']['name'])) {

        // receive data from form:
        $filename = $_FILES['logo-image']['name'];
        $tmp_name = $_FILES['logo-image']['tmp_name'];
        $filetype = $_FILES['logo-image']['type'];
        $filesize = $_FILES['logo-image']['size'];
        // Check if the file size exceeds 500KB
        $max_filesize = 500 * 1024; // 500KB
        if ($filesize > $max_filesize) {
            $_SESSION["error"] = "File size exceeds the limit of 500KB.";
            return;
        }
        // Check if file is a valid image
        $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed_extensions)) {
            echo "Error: uploaded file is not a valid image (allowed extensions: " . implode(', ', $allowed_extensions) . ")";
            return;
        }

        // Generate a unique filename
        $new_filename = "logo.png";

        // Move the uploaded file to a directory on the server
        $upload_dir = '../assets/images/logo/';
        $upload_path = $upload_dir . $new_filename;
        if (!move_uploaded_file($tmp_name, $upload_path)) {
            $_SESSION['error'] = 'Error adding logo!';
            $redirectLink = 'change-logo.php';
            return;
        } else {
            $_SESSION['success'] = 'Logo changed successfully!';
            $redirectLink = 'change-logo.php';
        }

        redirect($redirectLink);
    } else if (isset($_POST['change-favicon']) && !empty($_FILES['favicon-image']['name'])) {

        // receive data from form:
        // Check if the file size exceeds 500KB
        $max_filesize = 500 * 1024; // 500KB
        if ($filesize > $max_filesize) {
            $_SESSION["error"] = "File size exceeds the limit of 500KB.";
            return;
        }
        $filename = $_FILES['favicon-image']['name'];
        $tmp_name = $_FILES['favicon-image']['tmp_name'];
        $filetype = $_FILES['favicon-image']['type'];
        $filesize = $_FILES['favicon-image']['size'];

        // Check if file is a valid image
        $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed_extensions)) {
            echo "Error: uploaded file is not a valid image (allowed extensions: " . implode(', ', $allowed_extensions) . ")";
            return;
        }

        // Generate a unique filename
        $new_filename = "favicon.png";

        // Move the uploaded file to a directory on the server
        $upload_dir = '../assets/images/logo/';
        $upload_path = $upload_dir . $new_filename;
        if (!move_uploaded_file($tmp_name, $upload_path)) {
            $_SESSION['error'] = 'Error changing favicon!';
            $redirectLink = 'change-logo.php';
            return;
        } else {
            $_SESSION['success'] = 'Favicon changed successfully!';
            $redirectLink = 'change-logo.php';
        }

        redirect($redirectLink);
    }
}



if (isset($_POST['delete-button']) && !empty($_POST['delete-button'])) {

    // receive data from form:

    // Insert data into the products table
    $create_data = (object)[
        'id' => $_POST['id'],
        'table_name' => $_POST['table-name'],
        'continue_2' => $_POST['continue'],
    ];
    $createResponse = del_data($create_data);

    if ($createResponse->status == 'success') {
        $upload_id  = $createResponse->insert_id;
        $redirectLink = $_SERVER['PHP_SELF'];
    } else {
        $redirectLink = $_SERVER['PHP_SELF'];
    }

    $_SESSION[$createResponse->status] = $createResponse->message;
    redirect($redirectLink);
}



function del_data($del_data)
{
    global $connection;

    $id = $del_data->id;
    $table_name = $del_data->table_name;
    $continue = $del_data->continue_2;

    $query = "DELETE FROM $table_name WHERE id = $id";

    $result = mysqli_query($connection, $query);

    if (!$result) {
        $response = (object) [
            'status' => 'error',
            'message' => 'Failed to delete record from database'
        ];
    } else {

        $response = (object) [
            'status' => 'success',
            'message' => 'Record deleted successfully',
        ];

        if (isset($_POST['delete-image']) && !empty($_POST['delete-image'])) {
            $image_name = $_POST['delete-image'];
            if (unlink($image_name)) {
                $response = (object) [
                    'status' => 'success',
                    'message' => 'Record deleted successfully',
                ];
            } else {
                echo "Error deleting the image.";
            }
        }


        if ($continue == "yes") {
            // unset session variables
            if (isset($_SESSION['user_details'])) {
                unset($_SESSION['user_details']);
            }
        }
    }

    return $response;
}


if (isset($_POST['adjust-balance']) && !empty($_POST['adjust-balance'])) {
    // receive data from form:


    // Insert data into the products table
    $create_data = (object)[
        'id' => mysqli_real_escape_string($connection, $_POST['id']),
        'adjust_column' => mysqli_real_escape_string($connection, $_POST['adjust_column']),
        'adjust_column_2' => mysqli_real_escape_string($connection, $_POST['adjust_column_2']),
        'adjust_value' => mysqli_real_escape_string($connection, $_POST['adjust_value']),
        'adjust_value_2' => mysqli_real_escape_string($connection, $_POST['adjust_value_2']),
        'table_name' => mysqli_real_escape_string($connection, $_POST['table_name']),
        'current_hold' => mysqli_real_escape_string($connection, $_POST['current_hold']),
        'adjust_type' => mysqli_real_escape_string($connection, $_POST['adjust_type']),
        'created_at' => $created_at,
        'continue_status' => mysqli_real_escape_string($connection, $_POST['continue_status'])
    ];
    $createResponse = adjust_data($create_data);

    if ($createResponse->status == 'success') {
        // $upload_id  = $createResponse->insert_id;
        header('Location: ' . $_SERVER['PHP_SELF']);
    } else {
        header('Location: ' . $_SERVER['PHP_SELF']);
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    $_SESSION[$createResponse->status] = $createResponse->message;
}


function adjust_data($adjust_data)
{
    global $connection;

    $id = $adjust_data->id;
    $adjust_column = $adjust_data->adjust_column;
    $adjust_column_2 = $adjust_data->adjust_column_2;
    $new_value = "";
    $adjust_value = $adjust_data->adjust_value;
    $adjust_value_2 = $adjust_data->adjust_value_2;
    $table_name = $adjust_data->table_name;
    $current_hold = $adjust_data->current_hold;
    $adjust_type = $adjust_data->adjust_type;
    $created_at = $adjust_data->created_at;
    $continue = $adjust_data->continue_status;

    $notificationTitle = "";
    $notificationDescription = "";
    
    // Begin the transaction
    
    mysqli_begin_transaction($connection);

    try {
        
        // Retrieve current balance from the database
        $balQuery = "SELECT balance FROM users WHERE id = $id FOR UPDATE";
        $balResult = mysqli_query($connection, $balQuery);
        
        if ($balResult) {
            $row = mysqli_fetch_assoc($balResult);
            $current_balance = $row['balance'];
            
            if ($adjust_type == "deposit") {
                $new_value = $current_balance + $adjust_value;
    
                $notificationTitle = "Deposit successful!";
                $notificationDescription = "$$adjust_value successfully deposited. Your current balance is $$new_value.";
    
    
    
    
                $create_history = (object)[
                    'name' => "Fund Deposit",
                    'amount' => $adjust_value,
                    'type' => 1,
                    'created_at' => $created_at,
                    'created_by' => $id
                ];
            } else if ($adjust_type == "process-withdraw") {
                $new_value = $current_balance;
    
                $notificationTitle = "Withdrawal in process!";
                $notificationDescription = "Your fund withdrawal request have been recieved. It will be processed soon.";
    
    
                $stmt = $connection->prepare('UPDATE withdrawals SET status = 2 WHERE withdraw_by = ? AND status = 1');
                $stmt->bind_param('i', $id);
                $withdrawResult = $stmt->execute();
    
                if (!$withdrawResult) {
                    // Query execution failed, log error message
                    echo "Failed to withdraw: " . $stmt->error;
                    throw new Exception("Failed to withdraw: " . $stmt->error);
                }
            } else if ($adjust_type == "withdraw") {
                $new_value = $current_balance;
    
                $notificationTitle = "Withdraw successful!";
                $notificationDescription = "$$adjust_value has been withdrawn successfully. Your current balance is $$new_value.";
    
    
                $stmt = $connection->prepare('UPDATE withdrawals SET status = 3 WHERE withdraw_by = ? AND status = 2');
                $stmt->bind_param('i', $id);
                $withdrawResult = $stmt->execute();
    
                if (!$withdrawResult) {
                    // Query execution failed, log error message
                    echo "Failed to withdraw: " . $stmt->error;
                    throw new Exception("Failed to withdraw: " . $stmt->error);
                }
    
    
    
                $create_history = (object)[
                    'name' => "Fund Withdraw",
                    'amount' => $adjust_value,
                    'type' => 2,
                    'created_at' => $created_at,
                    'created_by' => $id
                ];
            } else if ($adjust_type == "hold") {
                $new_value = $current_balance - $adjust_value;
    
                $notificationTitle = "Your balance is on hold!";
                $notificationDescription = "$$adjust_value of your balance is on hold. You can not use or withdraw this amount until it is released. Your available balance is $$new_value.";
    
    
                $create_history = (object)[
                    'name' => "Balance Hold",
                    'amount' => $adjust_value,
                    'type' => 2,
                    'created_at' => $created_at,
                    'created_by' => $id
                ];
    
    
    
                $adjust_value = $current_hold + $adjust_value;
            } else if ($adjust_type == "release") {
                $new_value = $current_balance + $adjust_value;
    
    
                $notificationTitle = "$$adjust_value of holding balance is released!";
                $notificationDescription = "The released amount is now available as your main balance. Your available balance is $$new_value.";
    
    
    
    
                $create_history = (object)[
                    'name' => "Balance Released",
                    'amount' => $adjust_value,
                    'type' => 1,
                    'created_at' => $created_at,
                    'created_by' => $id
                ];
    
    
    
    
                $adjust_value = $current_hold - $adjust_value;
            } else if ($adjust_type == "treasury") {
    
                if ($adjust_value > $current_balance) {
                    echo "Error";
                    exit();
                }
                $new_value = $current_balance - $adjust_value;
                
                
                $maturityDate = date('d F Y', strtotime('+30 days'));
    
                $notificationTitle = "Balance deposited to treasury successfully!";
                $notificationDescription = "$$adjust_value has been deposited to treasure. This will be returned in your account on $maturityDate with interest.";
    
                $stmt = $connection->prepare('INSERT INTO treasury (deposited_amount, refund_amount, deposited_at, deposited_by) VALUES (?, ?, ?, ?)');
                $stmt->bind_param('ddsi', $adjust_value, $adjust_value_2, $created_at, $id);
                $notificationResult = $stmt->execute();
    
                if (!$notificationResult) {
                    // Query execution failed, log error message
                    echo "Failed to deposit: " . $stmt->error;
                    throw new Exception("Failed to deposit: " . $stmt->error);
                }
    
    
    
                $create_history = (object)[
                    'name' => "Treasury Deposit",
                    'amount' => $adjust_value,
                    'type' => 2,
                    'created_at' => $created_at,
                    'created_by' => $id
                ];
            }
            
        } else {
            throw new Exception("Failed to retrieve current balance!");
        }



        $history_response = transaction_history($create_history);

        if ($history_response->status == 'success') {
            header('Location: ' . $_SERVER['PHP_SELF']);

            $response = (object) [
                'status' => 'success',
                'message' => 'Updated Successfully!',
            ];
        } else {
            throw new Exception("Failed to create transaction history");
        }


        if ($continue !== "no") {
            $query = "UPDATE $table_name SET $adjust_column = $new_value WHERE id = $id";
            $result = mysqli_query($connection, $query);

            if (!$result) {
                throw new Exception("Failed to adjust!");
            }

            if ($_POST['adjust-balance'] == 2) {
                $query = "UPDATE $table_name SET $adjust_column_2 = $adjust_column_2 + $adjust_value WHERE id = $id";
                $result = mysqli_query($connection, $query);

                if (!$result) {
                    throw new Exception("Failed to adjust!");
                }
            }
        }

        // Commit the transaction if all queries are successful
        mysqli_commit($connection);

        if ($continue !== "no") {
            // Update session variables
            $_SESSION['user_details'][$adjust_column] = $new_value;
            $_SESSION['user_details'][$adjust_column_2] = $adjust_value;
        }
        $response = (object) [
            'status' => 'success',
            'message' => 'Adjusted successfully!',
        ];
    } catch (Exception $e) {
        // Rollback the transaction on error
        mysqli_rollback($connection);

        $response = (object) [
            'status' => 'error',
            'message' => $e->getMessage(),
        ];
    }


    $stmt = $connection->prepare('INSERT INTO notifications (title, description, target_user, created_at) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('ssss', $notificationTitle, $notificationDescription, $id, date('Y-m-d H:i:s'));
    $executeResult = $stmt->execute();

    if (!$executeResult) {
        // Query execution failed, log error message
        echo "Failed to insert notification: " . $stmt->error;
    }



    return $response;
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


if (isset($_POST['update-balance']) && !empty($_POST['update-balance'])) {
    // receive data from form:

    // Insert data into the products table
    $create_data = (object)[
        'id' => mysqli_real_escape_string($connection, $_POST['id']),
        'update_column' => mysqli_real_escape_string($connection, $_POST['update_column']),
        'current_value' => mysqli_real_escape_string($connection, $_POST['current_value']),
        'update_value' => mysqli_real_escape_string($connection, $_POST['update_value']),
        'table_name' => mysqli_real_escape_string($connection, $_POST['table_name']),
    ];
    $createResponse = update_data($create_data);

    if ($createResponse->status == 'success') {
        $upload_id  = $createResponse->insert_id;
        $redirectLink = $_SERVER['PHP_SELF'];
    } else {
        $redirectLink = $_SERVER['PHP_SELF'];
    }

    $_SESSION[$createResponse->status] = $createResponse->message;
    redirect($redirectLink);
}



function update_data($update_data)
{
    global $connection;

    $id = $update_data->id;
    $update_column = $update_data->update_column;
    $current_value = $update_data->current_value;
    $update_value = $update_data->update_value;
    $table_name = $update_data->table_name;

    $query = "UPDATE $table_name SET $update_column = '$update_value' WHERE id = $id";


    $result = mysqli_query($connection, $query);

    if (!$result) {
        $response = (object) [
            'status' => 'error',
            'message' => 'Failed to update!'
        ];
    } else {
        $_SESSION['user_details'][$update_column] = $update_value;
        $response = (object) [
            'status' => 'success',
            'message' => 'Updated successfully!',
        ];




        if ($update_column == "level") {

            $level_name = "";
            $commission_rate = "";
            $order_limit = "";

            if ($update_value == 1) {
                $level_name = "Silver";
                $commission_rate = "0.5%";
                $order_limit = "60";
            } else if ($update_value == 2) {
                $level_name = "Gold";
                $commission_rate = "0.6%";
                $order_limit = "80";
            } else if ($update_value == 3) {
                $level_name = "Platinum";
                $commission_rate = "0.7%";
                $order_limit = "100";
            } else if ($update_value == 4) {
                $level_name = "Diamond";
                $commission_rate = "0.8%";
                $order_limit = "120";
            } else if ($update_value == 5) {
                $level_name = "Crown";
                $commission_rate = "0.9%";
                $order_limit = "130";
            }

            if ($update_value > $current_value) {
                $notificationTitle = "Congratulations! You are promoted to $level_name level.";
                $notificationDescription = "Now you can enjoy new commission rate of $commission_rate and can grab up to $order_limit orders per day.";

                $stmt = $connection->prepare('INSERT INTO notifications (title, description, target_user, created_at) VALUES (?, ?, ?, ?)');
                $stmt->bind_param('ssss', $notificationTitle, $notificationDescription, $id, date('Y-m-d H:i:s'));
                $executeResult = $stmt->execute();

                if (!$executeResult) {
                    // Query execution failed, log error message
                    echo "Failed to insert notification: " . $stmt->error;
                }
            } else if ($update_value < $current_value) {
                $notificationTitle = "Your level changed to $level_name.";
                $notificationDescription = "Your new commission rate is $commission_rate and you can grab maximum $order_limit orders per day.";

                $stmt = $connection->prepare('INSERT INTO notifications (title, description, target_user, created_at) VALUES (?, ?, ?, ?)');
                $stmt->bind_param('ssss', $notificationTitle, $notificationDescription, $id, date('Y-m-d H:i:s'));
                $executeResult = $stmt->execute();

                if (!$executeResult) {
                    // Query execution failed, log error message
                    echo "Failed to insert notification: " . $stmt->error;
                }
            }
        }
    }

    return $response;
}



if (isset($_POST['update-pass']) && !empty($_POST['update-pass'])) {

    // receive data from form:
    $email = mysqli_real_escape_string($connection, $_POST['hidden-email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $table_name = mysqli_real_escape_string($connection, $_POST['table']);

    echo "Received form data: email=$email, password=$password, table_name=$table_name";

    // Insert data into the products table
    $create_data = (object)[
        'email' => $email,
        'password' => $password,
        'table_name' => $table_name,
    ];
    $createResponse = update_pass($create_data);

    if ($createResponse->status == 'success') {
        $insert_id  = $createResponse->insert_id;
        $redirectLink = $_SERVER['PHP_SELF'];
    } else {
        $redirectLink = $_SERVER['PHP_SELF'];
    }

    $_SESSION[$createResponse->status] = $createResponse->message;
    redirect($redirectLink);
}

function update_pass($pss_data)
{
    global $connection;

    $email = $pss_data->email;
    $new_password = md5($pss_data->password);
    $table_name = $pss_data->table_name;

    $query = "UPDATE $table_name SET password = '$new_password' WHERE email = '$email'";

    $result = mysqli_query($connection, $query);

    if (!$result) {
        $response = (object) [
            'status' => 'error',
            'message' => 'Failed to change password!'
        ];
    } else {
        // Query the database to check if the data was inserted correctly
        $select_query = "SELECT * FROM $table_name WHERE email='$email'";
        $select_result = mysqli_query($connection, $select_query);
        $row_count = mysqli_num_rows($select_result);

        if ($row_count > 0) {
            $response = (object) [
                'status' => 'success',
                'message' => 'Password changed successfully!',
            ];
        } else {
            $response = (object) [
                'status' => 'error',
                'message' => 'Failed to change password'
            ];
        }
    }

    return $response;
}



if (isset($_POST['bank_details']) && !empty($_POST['bank_details'])) {
    $first_name = mysqli_real_escape_string($connection, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($connection, $_POST['last_name']);
    $address = mysqli_real_escape_string($connection, $_POST['address']);
    $bank_name = mysqli_real_escape_string($connection, $_POST['bank_name']);
    $currency = mysqli_real_escape_string($connection, $_POST['currency']);
    $bank_address = mysqli_real_escape_string($connection, $_POST['bank_address']);
    $login_id = $_SESSION['login_id'];

    $query = "";

    if ($_POST['bank_details'] == 1) {
        $query = "UPDATE users SET first_name = ?, last_name = ?, address = ? WHERE id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("sssi", $first_name, $last_name, $address, $login_id);
    } elseif ($_POST['bank_details'] == 2) {
        $iban = $_POST['iban'];
        $bic = $_POST['bic'];
        $query = "UPDATE users SET region = 1, bank_name = ?, currency = ?, bank_address = ?, iban = ?, bic = ? WHERE id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("sssssi", $bank_name, $currency, $bank_address, $iban, $bic, $login_id);
    } elseif ($_POST['bank_details'] == 3) {
        $account_no = $_POST['account_no'];
        $aba_ach_no = $_POST['aba_ach_no'];
        $swift = $_POST['swift'];
        $query = "UPDATE users SET region = 2, bank_name = ?, currency = ?, bank_address = ?, account_no = ?, aba_ach_no = ?, swift = ? WHERE id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("ssssssi", $bank_name, $currency, $bank_address, $account_no, $aba_ach_no, $swift, $login_id);
    } elseif ($_POST['bank_details'] == 4) {
        $account_no = $_POST['account_no'];
        $swift = $_POST['swift'];
        $bank_code = $_POST['bank_code'];
        $query = "UPDATE users SET region = 3, bank_name = ?, currency = ?, bank_address = ?, account_no = ?, swift = ?, bank_code = ? WHERE id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("ssssssi", $bank_name, $currency, $bank_address, $account_no, $swift, $bank_code, $login_id);
    } elseif ($_POST['bank_details'] == 5) {
        $erc20 = $_POST['erc20'];
        $query = "UPDATE users SET erc20 = ? WHERE id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("si", $erc20, $login_id);
    } elseif ($_POST['bank_details'] == 6) {
        $trc20 = $_POST['trc20'];
        $query = "UPDATE users SET trc20 = ? WHERE id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("si", $trc20, $login_id);
    }

    if ($stmt->execute()) {
        $response = [
            'status' => 'success',
            'message' => 'Successfully updated user details!'
        ];
        // echo json_encode($response);
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Failed to update user details!'
        ];
        // echo json_encode($response);
    }
}



if (isset($_POST['info_delete']) && !empty($_POST['info_delete'])) {
    // include "../connection/connection.php";
    $login_id = $_SESSION['login_id'];
    $infoDelete = mysqli_real_escape_string($connection, $_POST['info_delete']);

    // Prepare the update query with placeholders
    $query = "";

    if ($infoDelete === '1') {
        $query = "UPDATE users SET first_name = '', last_name = '', address = '' WHERE id = ?";
    } elseif ($infoDelete === '2') {
        $query = "UPDATE users SET region = '', bank_name = '', currency = '', bank_address = '', iban = '', bic = '', account_no = '', aba_ach_no = '', swift = '', bank_code = '' WHERE id = ?";
    } elseif ($infoDelete === '3') {
        $query = "UPDATE users SET erc20 = '' WHERE id = ?";
    } elseif ($infoDelete === '4') {
        $query = "UPDATE users SET trc20 = '' WHERE id = ?";
    }

    // Prepare the statement
    $stmt = $connection->prepare($query);

    if ($stmt) {
        // Bind the parameter
        $stmt->bind_param("i", $login_id);

        // Execute the statement
        if ($stmt->execute()) {
            $response = [
                'status' => 'success',
                'message' => 'Successfully delete user details!'
            ];
            echo json_encode($response);
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Failed to delete user details!'
            ];
            echo json_encode($response);
        }

        // Close the statement
        $stmt->close();
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Failed to prepare statement!'
        ];
        echo json_encode($response);
    }
}


if (isset($_POST['withdraw-request']) && !empty($_POST['withdraw-request'])) {
    include "../connection/connection.php";
    $withdraw_by = $_SESSION['login_id'];
    $amount = mysqli_real_escape_string($connection, $_POST['amount']);
    $account = mysqli_real_escape_string($connection, $_POST['account']);
    $withdrawal_password = mysqli_real_escape_string($connection, $_POST['withdrawal-password']);

    // Check if the user with the provided withdrawal password exists
    $checkQuery = "SELECT id FROM users WHERE id = ? AND withdrawal_password = ?";
    $checkStmt = $connection->prepare($checkQuery);
    $checkStmt->bind_param("is", $withdraw_by, $withdrawal_password);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // User with the provided withdrawal password exists

        // Begin the transaction
        mysqli_begin_transaction($connection);

        try {
            // Insert the withdrawal request
            $query = "INSERT INTO withdrawals (amount, withdraw_by, account, created_at) VALUES (?, ?, ?, ?)";
            $stmt = $connection->prepare($query);

            if ($stmt) {
                // Generate the created_at timestamp
                $created_at = date('Y-m-d H:i:s');

                // Bind the parameters
                $stmt->bind_param("diis", $amount, $withdraw_by, $account, $created_at);
                $stmt->execute();

                // Check if the insertion was successful
                if ($stmt->affected_rows > 0) {
                    // Withdrawal request inserted successfully

                    // Update the user's balance
                    $updateQuery = "UPDATE users SET balance = balance - ? WHERE id = ?";
                    $updateStmt = $connection->prepare($updateQuery);
                    $updateStmt->bind_param("di", $amount, $withdraw_by);
                    $updateStmt->execute();

                    // Check if the update was successful
                    if ($updateStmt->affected_rows > 0) {
                        // Commit the transaction
                        mysqli_commit($connection);

                        $_SESSION['success'] = "Submitted successfully!";
                        header("Location: withdraw.php"); // Redirect to success page
                        exit();
                    } else {
                        // Rollback the transaction
                        mysqli_rollback($connection);

                        $_SESSION['error'] = "Failed to update balance.";
                        header("Location: withdraw.php"); // Redirect to error page
                        exit();
                    }
                } else {
                    // Rollback the transaction
                    mysqli_rollback($connection);

                    $_SESSION['error'] = "Failed to submit the withdrawal request.";
                    header("Location: withdraw.php"); // Redirect to error page
                    exit();
                }
            } else {
                // Rollback the transaction
                mysqli_rollback($connection);

                $_SESSION['error'] = "Error preparing the statement.";
                header("Location: withdraw.php"); // Redirect to error page
                exit();
            }
        } catch (Exception $e) {
            // An exception occurred, rollback the transaction
            mysqli_rollback($connection);

            $_SESSION['error'] = "An error occurred during the withdrawal process.";
            header("Location: withdraw.php"); // Redirect to error page
            exit();
        }
    } else {
        // User with the provided withdrawal password does not exist
        $_SESSION['error'] = "Invalid withdrawal password.";
        header("Location: withdraw.php"); // Redirect to error page
        exit();
    }

    // Close the statements and connection
    $checkStmt->close();
    $stmt->close();
    $connection->close();
}


if (isset($_POST['jackpot_grab']) && !empty($_POST['jackpot_grab'])) {
    $login_id = $_SESSION['login_id'];
    $jackpot_id = mysqli_real_escape_string($connection, $_POST['jackpot-id']);
    $total_amount = mysqli_real_escape_string($connection, $_POST['total-amount']);
    $commission_amount = mysqli_real_escape_string($connection, $_POST['commission-amount']);
    $balance = mysqli_real_escape_string($connection, $_POST['balance']);
    $level = mysqli_real_escape_string($connection, $_POST['level']);

    // Get the current timestamp
    $created_at = date('Y-m-d H:i:s');

    // Begin the transaction
    mysqli_begin_transaction($connection);

    try {
        if ($balance >= $total_amount) {
            $query = "UPDATE jackpots SET status = 2, total_amount = ?, commission_amount = ?, ordered_at = ? WHERE id = ? AND target_user = ?";

            // Prepare the statement
            $stmt = $connection->prepare($query);

            if ($stmt) {
                // Bind the parameters
                $stmt->bind_param("ddsii", $total_amount, $commission_amount, $created_at, $jackpot_id, $login_id);

                // Execute the statement
                if ($stmt->execute()) {
                    $response = [
                        'status' => 'success',
                        'message' => 'Successfully grabbed jackpot!'
                    ];

                    // Call the function to create transaction history
                    $create_history = (object)[
                        'name' => "Jackpot Deduction",
                        'amount' => $total_amount,
                        'type' => 2,
                        'created_at' => $created_at,
                        'created_by' => $login_id
                    ];

                    $history_response = transaction_history($create_history);

                    if ($history_response->status == 'success') {
                        
                        $new_rank = "";
                        if ($total_amount < 1000) {
                            $new_rank = 1; 
                        } elseif ($total_amount >= 1000 && $total_amount < 3000) {
                            $new_rank = 2;
                        } elseif ($total_amount >= 3000 && $total_amount < 5000) {
                            $new_rank = 3;
                        } elseif ($total_amount >= 5000 && $total_amount < 10000) {
                            $new_rank = 4;
                        } else {
                            $new_rank = 5;
                        }
                        if ($new_rank < $level) {
                            $new_rank = $level;
                        }
                        // Update the balance in the users table
                        $update_query = "UPDATE users SET balance = balance - ?, level = ? WHERE id = ?";
                        $update_stmt = $connection->prepare($update_query);
                        $update_stmt->bind_param("dii", $total_amount, $new_rank, $login_id);
                        $update_stmt->execute();
                        $update_stmt->close();

                        // Commit the transaction if everything is successful
                        mysqli_commit($connection);

                        $response = (object) [
                            'status' => 'success',
                            'message' => 'Updated Successfully!',
                        ];
                        // header("Location: " . $_SERVER['PHP_SELF']);
                        // exit();
                    } else {
                        throw new Exception("Failed to create transaction history");
                    }
                } else {
                    $response = [
                        'status' => 'error',
                        'message' => 'Failed!'
                    ];
                    echo json_encode($response);
                    throw new Exception("Failed to execute statement");
                }

                // Close the statement
                $stmt->close();
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Failed to prepare statement!'
                ];
                echo json_encode($response);
                throw new Exception("Failed to prepare statement");
            }
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Insufficient Balance!'
            ];
            throw new Exception("Insufficient Balance");
        }
    } catch (Exception $e) {
        // Rollback the transaction on error
        mysqli_rollback($connection);

        $response = (object) [
            'status' => 'error',
            'message' => $e->getMessage(),
        ];
    }
}



if (isset($_POST['read_popup']) && !empty($_POST['read_popup'])) {
    include "../connection/connection.php";

    $login_id = mysqli_real_escape_string($connection, $_POST['read_popup']);
    $id = mysqli_real_escape_string($connection, $_POST['popup_id']);
    $sql = "SELECT *,         
        CASE 
          WHEN FIND_IN_SET($login_id, read_by) > 0 THEN 'read'
        END AS read_status 
        FROM popups 
        WHERE id = $id";

    // Execute the query and fetch the results
    $result = mysqli_query($connection, $sql);
    if ($result) {


        // Separate the notifications based on their creation date
        while ($row = mysqli_fetch_assoc($result)) {

            if ($row['read_status'] !== 'read') {
                $read_by = "";
                // Combine the user IDs
                if ($row['read_by'] !== '') {
                    $read_by .= ',' . $login_id;
                } else {
                    $read_by = $login_id;
                }

                $updateSql = "UPDATE popups SET read_by = CONCAT(read_by, '$read_by') WHERE id = $id";
                // Execute the update query
                $updateResult = mysqli_query($connection, $updateSql);

                if (!$updateResult) {
                    // Error handling if the update query fails
                    echo "Failed to update read_by column: " . mysqli_error($connection);
                }

                echo "updated";
            }


            // Echo the notification details

        }
    }
}




if (isset($_POST['add_language']) && !empty($_POST['add_language'])) {
    $language_name = mysqli_real_escape_string($connection, $_POST['language_name']);

    $query = "INSERT INTO languages (language_name) VALUES (?)";
    $stmt = $connection->prepare($query);

    if ($stmt) {

        // Bind the parameters
        $stmt->bind_param("s", $language_name);
        $stmt->execute();

        // Check if the insertion was successful
        if ($stmt->affected_rows > 0) {
            // Set the success message in the session
            $_SESSION['success'] = "Language added successfully!";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }
}





// Assuming you have already established a database connection

// Check if the necessary $_POST values are present
if (isset($_POST['table_name'], $_POST['primary_key'], $_POST['primary_value'])) {
    $connection->set_charset('utf8mb4');

    // Get the table name, primary key column, and primary key value from $_POST
    $table_name = mysqli_real_escape_string($connection, $_POST['table_name']);
    $primary_key = mysqli_real_escape_string($connection, $_POST['primary_key']);
    $primary_value = mysqli_real_escape_string($connection, $_POST['primary_value']);

// Create an empty array to store the column-value pairs
$updates = array();

// Iterate through $_POST to collect column-value pairs
foreach ($_POST as $key => $value) {
    // Skip the known keys (table_name, primary_key, primary_value)
    if ($key !== 'table_name' && $key !== 'primary_key' && $key !== 'primary_value' && $value !== '') {
        // Escape the values to prevent SQL injection
        $column = mysqli_real_escape_string($connection, $key);
        $update_value = mysqli_real_escape_string($connection, $value);

        // Add the column-value pair to the $updates array
        $updates[] = "`$column` = '$update_value'";
    }
}

if ($_POST['table_name'] == "email_format") {
    // Create a folder to store the uploaded images
    $uploadDir = '../assets/images/email-images/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Process the top banner image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $topBanner = $_FILES['image'];

        $image = uniqid() . '_' . $topBanner['name']; // Generate a unique name for the banner image

        // Move the uploaded banner image to the uploads folder with the new name
        $bannerDestination = $uploadDir . $image;
        move_uploaded_file($topBanner['tmp_name'], $bannerDestination);

        // Add the column-value pair for the image to the $updates array
        $updates[] = "`image` = '$image'";
    }
}

    // Check if any updates were collected
    if (!empty($updates)) {
        // Construct the SQL update query
        $sql = "UPDATE `$table_name` SET " . implode(', ', $updates) . " WHERE `$primary_key` = '$primary_value'";

        // Execute the SQL query
        $result = mysqli_query($connection, $sql);

        if ($result) {

            $_SESSION['success'] = "Update successful!";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {

            $_SESSION['error'] = "Error executing update query: " . mysqli_error($connection);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    } else {
        echo "No updates found.";
    }
}


?>