<?php
include "header.php";
?>

<div class="my-3">
    <label for="upload-slider-file" class="form-label">Slider Announcement</label>
</div>


<form action="" method="POST" enctype="multipart/form-data">
    <div class="slider-box w-100 col-sm-10 mb-5 d-flex nowrap">
        <div id="image-preview" class="position-relative d-inline-block overflow-x-auto align-top mb-2" style="overflow-y: visible !important; max-height: none !important; vertical-align: top;">
            <div id="image-container" class="d-flex align-items-center position-relative"></div>
        </div>
        <div class="button-wrap position-relative d-inline-block align-top">
            <label for="upload-file">
                <div class="shown-button slider-shown-button d-flex justify-content-center align-items-center ms-3" id="add-btn"><i class="fas fa-plus"></i></div>
            </label>
            <input type="file" class="form-control border border-gray" name="images[]" id="upload-file" onchange="getImagePreview(event, '400')" multiple required>
        </div>
    </div>

    <div class="d-flex gap-2 justify-content-end mt-5">
    <a href="index.php" class="btn btn-lg btn-outline-secondary" id="slider-cancel">Cancel</a>
        <input class="btn btn-lg btn-success" type="submit" name="slider-publish" id="slider-publish" value="Publish">
    </div>

</form>


<form action="" method="POST">
    <div class="my-3 w-100">
        <label for="exampleFormControlTextarea1" class="form-label">Slider Notice</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" name="notice-text" rows="8" required></textarea>
    </div>

    <div class="d-flex gap-2 justify-content-end mt-5">
    <a href="index.php" class="btn btn-lg btn-outline-secondary" id="slider-cancel">Cancel</a>
        <input class="btn btn-lg btn-success" type="submit" name="notice-publish" id="notice-publish" value="Publish">
    </div>
</form>


<?php
include "footer.php";
?>