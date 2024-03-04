<?php
include "header.php";
?>
<form action="" method="POST" enctype="multipart/form-data">
    <div class="row mt-5">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7 col-xl-7 col-xxl-7">

            <div class="row m-0 d-flex align-items-center">
                <label for="photo" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-2 col-form-label">Photo:</label>
                <div class="slider-box col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-10 d-flex">
                    <div id="image-preview" class="position-relative d-inline-block overflow-x-auto align-top mb-2" style="overflow-y: visible !important; max-height: none !important; vertical-align: top;">
                        <div id="image-container" class="d-flex align-items-center position-relative"></div>
                    </div>
                    <div class="button-wrap position-relative d-inline-block align-top">
                        <label for="upload-file">
                            <div class="shown-button all-shown-button d-flex justify-content-center align-items-center ms-3" id="add-btn"><i class="fas fa-plus"></i></div>
                        </label>
                        <input type="file" class="form-control border border-gray" name="images[]" id="upload-file" onchange="getImagePreview(event, '200')" multiple>
                    </div>
                </div>
            </div>

            <div class="row my-5">
                <label for="title" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-2 col-form-label">Title:</label>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-10">
                    <input type="text" class="form-control border border-gray" id="title" name="title">
                </div>
            </div>

            <div class="row my-4">
                <label for="description" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-2 col-form-label">Popup Message:</label>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-10">
                    <textarea class="form-control" id="description" name="description" rows="8"></textarea>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-5 col-xxl-5 mb-5">
            <label class="mb-2" for="notification-goes-to">Popup goes to:</label>
            <div class="bg-white rounded h-100 p-2 overflow-auto" id="notification-goes-to">

                <div class="mb-2">
                    <input type="text" class="form-control" id="user-search" placeholder="Search here">
                </div>

                <?php
                if (isset($user_list) && !empty($user_list)) {
                ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="check-all" name="check-all" value="all">
                        <label class="form-check-label" for="check-all">Select All</label>
                    </div>
                    <?php
                    foreach ($user_list as $data) {
                    ?>

                        <div class="form-check user-checkbox">
                            <input class="form-check-input" type="checkbox" id="<?php echo $data->id ?>" name="user_ids[]" value="<?php echo $data->id ?>">
                            <label class="form-check-label" for="<?php echo $data->id ?>"><?php echo $data->name ?> (@<?php echo $data->user_name ?>)</label>
                        </div>
                <?php
                    }
                } else {
                    echo "No member found";
                }
                ?>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2 justify-content-end">
        <a href="index.php" class="btn btn-lg btn-outline-secondary" id="notificationr-cancel">Cancel</a>
        <input class="btn btn-lg btn-success" type="submit" id="notification-publish" name="popup-publish" value="Publish">
    </div>
</form>
<?php
include "footer.php";
?>