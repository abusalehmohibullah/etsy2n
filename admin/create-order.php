<?php
include "header.php";
?>

<form action="" method="POST" enctype="multipart/form-data">
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

    <div class="row my-5">
        <label for="user-level" class="col-sm-2 col-form-label">User Level:</label>
        <div class="col-sm-10">
            <select class="form-select border border-gray" id="user-level" name="user-level" required>
                <option value="1">Silver</option>
                <option value="2">Gold</option>
                <option value="3">Platinum</option>
                <option value="4">Diamond</option>
                <option value="5">Crown</option>
            </select>
        </div>
    </div>

    <div class="d-flex gap-2 justify-content-end">
        <a href="index.php" class="btn btn-lg btn-outline-secondary" id="order-cancel">Cancel</a>
        <input class="btn btn-lg btn-success" type="submit" id="order-publish" name="order-publish" value="Publish">
    </div>
</form>

<?php
include "footer.php";
?>