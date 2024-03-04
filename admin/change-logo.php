<?php
include "header.php";
?>

<section>
    <div class="d-flex justify-content-center mb-5">
        <div class="col-12 col-sm-12 col-md-10 col-lg-8 col-xl-8 col-xxl-6">
            <div class="text-center h2">Change Logo</div>

            <form action="" method="post" enctype="multipart/form-data">

                <div class="d-flex align-items-center gap-3 flex-wrap my-3">
                    <div>
                        <label for="formFile" class="form-label m-0">Select Logo:</label>
                    </div>
                    <div class="flex-grow-1">

                        <input class="form-control" type="file" id="formFile" name="logo-image">
                    </div>
                </div>

                <div class="d-flex">
                    <div class="ms-auto">
                        <input type="submit" class="btn btn-success mb-3" name="change-logo" value="Change">
                    </div>
                </div>

            </form>

        </div>
    </div>
</section>

<section>
    <div class="d-flex justify-content-center">
        <div class="col-12 col-sm-12 col-md-10 col-lg-8 col-xl-8 col-xxl-6">
            <div class="text-center h2">Change Favicon</div>

            <form action="" method="post" enctype="multipart/form-data">

                <div class="d-flex align-items-center gap-3 flex-wrap my-3">
                    <div>
                        <label for="formFile" class="form-label m-0">Select Favicon:</label>
                    </div>

                    <div class="flex-grow-1">
                        <input class="form-control" type="file" id="formFile" name="favicon-image">
                    </div>
                </div>

                <div class="d-flex">
                    <div class="ms-auto">
                        <button type="submit" class="btn btn-success mb-3" name="change-favicon">Change</button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</section>




<?php
include "footer.php";
?>