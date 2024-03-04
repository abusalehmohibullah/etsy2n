<?php
include "header.php";
?>

<div class="py-3">
    <div class="fs-3 fw-bold">Notifications</div>
    <!--<div class="balance-container light-bg fw-bold rounded-3 ms-auto px-2 py-1">Mark all as read</div>-->
</div>


<?php

$sql = "SELECT *,
        CASE 
          WHEN DATE(created_at) = CURDATE() THEN DATE_FORMAT(created_at, '%h:%i %p')
          WHEN DATE(created_at) = CURDATE() - INTERVAL 1 DAY THEN DATE_FORMAT(created_at, 'Yesterday at %h:%i %p')
          WHEN YEARWEEK(created_at) = YEARWEEK(CURDATE()) THEN DATE_FORMAT(created_at, '%W at %h:%i %p')
          ELSE DATE_FORMAT(created_at, '%e %b %Y at %h:%i %p')
        END AS formatted_created_at,
        CASE 
          WHEN FIND_IN_SET($login_id, target_user) > 0 AND FIND_IN_SET($login_id, read_by) > 0 THEN 'read'
          WHEN FIND_IN_SET($login_id, target_user) > 0 THEN 'unread'
        END AS read_status
        FROM notifications
        WHERE (FIND_IN_SET($login_id, target_user) > 0 OR FIND_IN_SET($login_id, read_by) > 0) AND status = 1
        ORDER BY created_at DESC";

// Execute the query and fetch the results
$result = mysqli_query($connection, $sql);
if ($result) {
    $todayNotifications = array();
    $weeklyNotifications = array();
    $olderNotifications = array();

    // Get the start and end dates of the current week
    $startDate = date('Y-m-d', strtotime('this week'));
    $endDate = date('Y-m-d', strtotime('this week +6 days'));

    // Separate the notifications based on their creation date
    while ($row = mysqli_fetch_assoc($result)) {
        $createdAt = date('Y-m-d', strtotime($row['created_at']));
        $notification = array(
            'id' => $row['id'],
            'title' => $row['title'],
            'description' => $row['description'],
            'status' => $row['read_status']
        );

        // Determine the section based on the creation date
        if ($createdAt == date('Y-m-d')) {
            $todayNotifications[] = $notification;
        } elseif ($createdAt >= $startDate && $createdAt <= $endDate) {
            $weeklyNotifications[] = $notification;
        } else {
            $olderNotifications[] = $notification;
        }
    }

    mysqli_free_result($result);
} else {
    echo "Error executing query: " . mysqli_error($connection);
}
?>




<!--Todays notificartion-->
<section>
    <?php
    if (isset($todayNotifications) && !empty($todayNotifications)) {
    ?>
        <h4>Today</h4>

        <div class="light-bg rounded">

            <?php
            foreach ($todayNotifications as $notification) {
            ?>
                <div class="d-flex notifications m-2 position-relative">
                    <div class="d-flex justify-content-center align-items-center fs-2 px-3 py-1">
                        <i class="bi bi-bell-fill"></i>
                    </div>
                    <div class="flex-grow-1 p-2 ps-0">
                        <?php
                        if ($notification['status'] == "unread") {
                        ?>
                            <div class="fw-bold position-relative notification-text-preview">
                                <span class="mx-2">
                                    <span class="position-absolute top-50 translate-middle p-1 bg-danger rounded-circle"></span>
                                </span>
                            <?php
                        } else {
                            ?>

                                <div class="notification-text-preview">

                                <?php
                            }
                            echo $notification['title']
                                ?>
                                </div>

                                <div class="notification-text-preview">
                                    <?php echo $notification['description'] ?>
                                </div>

                                <a href="./notification-details.php?notification_id=<?php echo $notification['id'] ?>" class="stretched-link"></a>

                            </div>
                    </div>

                <?php } ?>

                </div>

            <?php } ?>
</section>

<!--this weeks notificartion-->
<section>

    <?php
    if (isset($weeklyNotifications) && !empty($weeklyNotifications)) {
    ?>
        <h4>This week</h4>

        <div class="light-bg rounded">

            <?php
            foreach ($weeklyNotifications as $notification) {
            ?>
                <div class="d-flex notifications m-2 position-relative">
                    <div class="d-flex justify-content-center align-items-center fs-2 px-3 py-1">
                        <i class="bi bi-bell-fill"></i>
                    </div>
                    <div class="flex-grow-1 p-2 ps-0">
                        <?php
                        if ($notification['status'] == "unread") {
                        ?>
                            <div class="fw-bold position-relative notification-text-preview">
                                <span class="mx-2">
                                    <span class="position-absolute top-50 translate-middle p-1 bg-danger rounded-circle"></span>
                                </span>
                            <?php
                        } else {
                            ?>

                                <div class="notification-text-preview">

                                <?php
                            }
                            echo $notification['title']
                                ?>
                                </div>

                                <div class="notification-text-preview">
                                    <?php echo $notification['description'] ?>
                                </div>

                                <a href="./notification-details.php?notification_id=<?php echo $notification['id'] ?>" class="stretched-link"></a>

                            </div>
                    </div>

                <?php } ?>

                </div>

            <?php } ?>


</section>

<!--older notificartion-->
<section>

    <?php
    if (isset($olderNotifications) && !empty($olderNotifications)) {
    ?>
        <h4>Older</h4>

        <div class="light-bg rounded">

            <?php
            foreach ($olderNotifications as $notification) {
            ?>
                <div class="d-flex notifications m-2 position-relative">
                    <div class="d-flex justify-content-center align-items-center fs-2 px-3 py-1">
                        <i class="bi bi-bell-fill"></i>
                    </div>
                    <div class="flex-grow-1 p-2 ps-0">
                        <?php
                        if ($notification['status'] == "unread") {
                        ?>
                            <div class="fw-bold position-relative notification-text-preview">
                                <span class="mx-2">
                                    <span class="position-absolute top-50 translate-middle p-1 bg-danger rounded-circle"></span>
                                </span>
                            <?php
                        } else {
                            ?>

                                <div class="notification-text-preview">

                                <?php
                            }
                            echo $notification['title']
                                ?>
                                </div>

                                <div class="notification-text-preview">
                                    <?php echo $notification['description'] ?>
                                </div>

                                <a href="./notification-details.php?notification_id=<?php echo $notification['id'] ?>" class="stretched-link"></a>

                            </div>
                    </div>

                <?php } ?>

                </div>

            <?php } ?>
</section>



<?php
include "footer.php";
?>