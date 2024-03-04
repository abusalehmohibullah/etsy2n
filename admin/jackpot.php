<?php
include "header.php";

include "users-nav.php";

$user_details =  $_SESSION['user_details'];
if (isset($user_details) && !empty($user_details)) {
?>
    <div class="row col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-9 col-xxl-9 bg-white rounded h-100 m-0 my-3">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="h3 my-3">Give <?php echo $user_details['name']; ?> a Jackpot!</div>
            <div class="row my-5">
                <label for="name" class="col-sm-2 col-form-label">Name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control border border-gray" id="product-name" name="product-name" required>
                </div>
            </div>

            <div class="row my-5 d-flex align-items-center">
                <label for="photo" class="col-sm-2 col-form-label">Photo:</label>
                <div class="slider-box col-sm-10 d-flex">
                    <div id="image-preview" class="position-relative d-inline-block overflow-x-auto align-top mb-2" style="overflow-y: visible !important; max-height: none !important; vertical-align: top;">
                        <div id="image-container" class="d-flex align-items-center position-relative"></div>
                    </div>
                    <div class="button-wrap position-relative d-inline-block align-top">
                        <label for="upload-file">
                            <div class="shown-button all-shown-button d-flex justify-content-center align-items-center ms-3" id="add-btn"><i class="fas fa-plus"></i></div>
                        </label>
                        <input type="file" class="form-control border border-gray" name="images[]" id="upload-file" onchange="getImagePreview(event, '200')" multiple required>
                    </div>
                </div>
            </div>

            <div class="row my-5">
                <label for="price" class="col-sm-2 col-form-label">Price:</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control border border-gray" id="product-price" name="product-price" required>
                </div>
            </div>


            <div class="row my-5">
                <label for="quantity" class="col-sm-2 col-form-label">Quantity:</label>
                <div class="col-sm-10 position-relative">
                    <input type="number" class="form-control border border-gray" id="product-quantity" name="product-quantity" value="1" required>
                </div>
            </div>


            <div class="d-flex gap-2 justify-content-end my-3">
                <div class="jackpot-message text-danger">Giving Jackpot will suspend the user from grabbing other orders, untill the user grab this jackpot order. Continue?</div>
            </div>
            <input type="hidden" name="target-user" value="<?php echo $user_details['id'] ?>">
            <div class="d-flex gap-2 justify-content-end me-2 mb-4">
                <a href="index.php" class="btn btn-lg btn-outline-secondary" id="jackpot-cancel">Cancel</a>
                <input class="btn btn-lg btn-success" type="submit" id="jackpot-publish" name="jackpot-publish" value="Publish">
            </div>
        </form>
    </div>

<?php
} else {

?>
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-9 col-xxl-9 d-flex align-items-center justify-content-center bg-white rounded h-100 m-0 my-3">
        <div class="h3 h-100 py-5">Select a user to give jackpot.</div>
    </div>
<?php

}
?>
</div>



<?php
include "footer.php";
?>