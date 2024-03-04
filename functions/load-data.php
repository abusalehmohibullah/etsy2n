<?php
// load_more.php
session_start();

// error_reporting(E_ALL);
// ini_set('display_errors', '1');

include "../helper/utilities.php";

include "../connection/connection.php";

if (is_authenticate()) {
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





    if ($_GET['type'] == "slides") {


        // Generate the SQL query with the provided parameters
        $sql = "SELECT $columns, (SELECT COUNT(id) FROM $table WHERE $conditions $condition_value $group_conditions) AS total_count FROM $table WHERE $conditions $condition_value $group_conditions ORDER BY $order_conditions DESC LIMIT $offset, $limit";

        // Execute the query
        $result = mysqli_query($connection, $sql);


        // Initialize total count variable
        $totalCount = 0;


        // Initialize data array
        $data = array();

        // Fetch the rows and generate HTML markup
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $arr = array(
                    'id' => $row['id'],
                    'image_path' => $row['slider_image'],
                    'status' => $row['status']
                );
                $data[] = $arr;

                $totalCount = $row[total_count];
            }
        }

        // Determine if there are more rows to fetch
        $has_rows = $offset + count($data) < $totalCount ? "yes" : "no";
    }



    if ($_GET['type'] == "products") {


        // Generate the SQL query with the provided parameters
        $sql = "SELECT $columns, 
        (SELECT COUNT(*) 
         FROM (SELECT COUNT(p.id) 
               FROM $table 
               WHERE $conditions $condition_value $group_conditions) AS subquery) AS total_count 
        FROM $table 
        WHERE $conditions $condition_value $group_conditions 
        ORDER BY $order_conditions DESC 
        LIMIT $offset, $limit";



        // Execute the query
        $result = mysqli_query($connection, $sql);


        // Initialize total count variable
        $totalCount = 0;


        // Initialize data array
        $data = array();

        // Fetch the rows and generate HTML markup
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $arr = array(
                    'id' => $row['product_id'],
                    'product_name' => $row['product_name'],
                    'product_quantity' => $row['product_quantity'],
                    'product_price' => $row['product_price'],
                    'user_level' => $row['user_level'],
                    'image_ids' => explode(',', $row['image_id']),
                    'image_path' => explode(',', $row['product_image']),
                    'status' => $row['status']
                );
                $data[] = $arr;

                $totalCount = $row[total_count];
            }
        }

        // Determine if there are more rows to fetch
        $has_rows = $offset + count($data) < $totalCount ? "yes" : "no";
    }




    if ($_GET['type'] == "jackpots") {


        // Generate the SQL query with the provided parameters
        $sql = "SELECT $columns, 
        (SELECT COUNT(*) 
         FROM (SELECT COUNT(j.id) 
               FROM $table 
               WHERE $conditions $condition_value $group_conditions) AS subquery) AS total_count 
        FROM $table 
        WHERE $conditions $condition_value $group_conditions 
        ORDER BY $order_conditions DESC 
        LIMIT $offset, $limit";



        // Execute the query
        $result = mysqli_query($connection, $sql);


        // Initialize total count variable
        $totalCount = 0;


        // Initialize data array
        $data = array();

        // Fetch the rows and generate HTML markup
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $arr = array(
                    'id' => $row['product_id'],
                    'product_name' => $row['product_name'],
                    'product_quantity' => $row['product_quantity'],
                    'product_price' => $row['product_price'],
                    'targer_user' => $row['targer_user'],
                    'image_ids' => explode(',', $row['image_id']),
                    'image_path' => explode(',', $row['jackpot_image']),
                    'status' => $row['status']
                );
                $data[] = $arr;

                $totalCount = $row[total_count];
            }
        }

        // Determine if there are more rows to fetch
        $has_rows = $offset + count($data) < $totalCount ? "yes" : "no";
    }




    // Prepare the response array
    $response = array(
        'has_rows' => $has_rows,
        'data' => $data
    );

    // Encode the array as JSON
    $jsonData = json_encode($response);

    // Return the JSON response
    echo $jsonData;
}

?>
