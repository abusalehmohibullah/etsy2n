<?php
include "header.php";
?>





<div class="py-3">
    <div class="fs-3 fw-bold">Notifications</div>
    <!--<div class="balance-container light-bg fw-bold rounded-3 ms-auto px-2 py-1">Mark all as read</div>-->
</div>


<div class="light-bg rounded p-3">
    <?php

    $id = $_GET['notification_id'];
    $sql = "SELECT *,         
        CASE 
          WHEN FIND_IN_SET($login_id, read_by) > 0 THEN 'read'
        END AS read_status 
        FROM notifications 
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

                $updateSql = "UPDATE notifications SET read_by = CONCAT(read_by, '$read_by') WHERE id = $id";
                // Execute the update query
                $updateResult = mysqli_query($connection, $updateSql);

                if (!$updateResult) {
                    // Error handling if the update query fails
                    echo "Failed to update read_by column: " . mysqli_error($connection);
                }
            }


            // Echo the notification details

    ?>



            <div class="fs-4 fw-bold"><a href="../notification.php" class="link-secondary"><i class="fw-bold bi bi-chevron-left"></i></a> <?php echo $row['title'] ?></div>
            
            <?php

            if ($row['created_by'] == 0) {
            ?>

                <div class="d-flex justify-content-center py-2">
                    <img class="notification-image" src="./assets/images/notification-images/dolar.png">
                </div>

            <?php
            } else {


            ?>
                <div class="order-item-sub-slider-container position-relative">
                    <div class="order-item-sub-slider slider-common-class mb-2">
                        <?php
                        $sql = "SELECT * FROM notification_image WHERE upload_id = $id";

                        // Execute the query and fetch the results
                        $result = mysqli_query($connection, $sql);
                        if ($result) {
                            // Fetch all rows from the result set
                            $images = mysqli_fetch_all($result, MYSQLI_ASSOC);

                            if (!empty($images)) {
                                // Iterate over the images using a foreach loop
                                foreach ($images as $image) {
                        ?>
                                    <div class="position-relative">
                                        <img class="notification-image mx-auto" src="../assets/images/notification-images/<?php echo $image['notification_image']; ?>" alt="">
                                    </div>


                                <?php
                                }
                            } else {
                                ?>
                                <div class="d-flex justify-content-center py-2">
                                    <img class="notification-image" src="./assets/images/notification-images/default.png">
                                </div>

                            <?php
                            }

                            ?>

                        <?php

                            // Free the result set
                            mysqli_free_result($result);
                        } else {
                            echo "Error executing query: " . mysqli_error($connection);
                        }

                        ?>

                    </div>

                </div>
            <?php
            }
            ?>

            <div>
            <?php echo $row['description'];
        } ?>
            </div>

        <?php

        mysqli_free_result($result);
    } else {
        echo "Error executing query: " . mysqli_error($connection);
    }
        ?>

</div>


<?php
include "footer.php";
?>