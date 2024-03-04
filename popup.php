<?php
$sql = "SELECT *
        FROM popups
        WHERE FIND_IN_SET($login_id, target_user) > 0 AND FIND_IN_SET($login_id, read_by) = 0
        ORDER BY created_at DESC";

// Execute the query and fetch the results
$result = mysqli_query($connection, $sql);

// Check if the query was successful
if ($result) {
    // Fetch all the rows into an array
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    // Loop through the result set
    foreach ($rows as $row) {
        // Access individual columns of each row
        $popupId = $row['id'];
        $title = $row['titles'];
        $description = $row['descriptions'];
        $image = $row['images'];
?>

        <!-- Modal Jackpot -->
        <div class="modal modal-lg fade" id="popupModal-<?php echo $popupId ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content position-relative">
                    <div class="position-absolute top-0 end-0 m-2 z-3">
                        <button type="button" class="btn-close z-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">



                        <?php
                        // Check if there is both an image and title/description
                        if (!empty($image) && (!empty($title) || !empty($description))) {
                            // Display the image in the middle, with title above and description below
                        ?>

                            <div class="p-2">
                                <div class="fw-bold fs-4 text-center mb-2">
                                    <?php echo $title ?>
                                </div>
                                <img class='img-fluid p-2' src='../assets/images/popup-images/<?php echo $image ?>' alt=''>
                                <div class="text-center fs-5">
                                    <?php echo $description ?>
                                </div>


                            </div>

                        <?php
                        } elseif (!empty($image)) {
                        ?>

                            <img class='w-100' src='../assets/images/popup-images/<?php echo $image ?>' alt=''>

                        <?php
                        } else {

                        ?>

                            <div class="p-2">
                                <div class="fw-bold fs-4 text-center mb-2">
                                    <?php echo $title ?>
                                </div>
                                <div class="text-center fs-5">
                                    <?php echo $description ?>
                                </div>


                            </div>

                        <?php


                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>

<?php



    }

    // Free the result set
    $result->free();
} else {
    // Query execution failed
    echo "Error executing query: " . $connection->error;
}
?>
<script>
    $(document).ready(function() {
        var modalIds = <?php echo json_encode(array_column($rows, 'id')); ?>;
        var userId = <?php echo $login_id; ?>;

        function showNextModal() {
            if (modalIds.length > 0) {
                const nextModalId = modalIds.shift();
                $('#popupModal-' + nextModalId).modal('show');


                $.ajax({
                    url: 'functions/data-management.php',
                    type: 'POST',
                    data: {
                        read_popup: userId,
                        popup_id: nextModalId,
                    },
                    success: function(response) {
                        console.log(response)

                    }
                });
            }
        }

        // Trigger the initial modal
        showNextModal();

        $('.btn-close').on('click', function() {
            $(this).closest('.modal').modal('hide');
            showNextModal();

        });
    });
</script>