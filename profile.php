<?php
include "header.php";
?>
<div class="py-3">
    <div class="fs-3 fw-bold">Personal Informations</div>
</div>


<?php echo show_message() ?>

<section>
    <div class="d-flex justify-content-center mb-5 light-bg shadow-sm rounded p-2">
        <div class="col-12 col-sm-12 col-md-10 col-lg-8 col-xl-8 col-xxl-6 mt-3 mb-5">

            <div class="flex-grow-1 px-3">

                <div class="row container-fluid mx-0 px-0">

                    <div class="d-flex align-items-center col-sm-12 col-md-12 col-lg-12 col-xl-12 flex-column mt-4">

                        <div class="upload">


                            <img src="./assets/images/profile-pictures/<?php echo $profile_picture ?>" alt="" width="150" height="150" class="rounded-circle align-self-center">



                            <div class="round border bg-white">
                                <input type="file" name="file" id="file" onclick="update_image('<?php echo login_id() ?>')">
                                <i class="bi bi-camera-fill"></i>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-center d-inline mt-3"><b> <?php echo $name; ?></b></h4>
                            <h5 class="text-center">@<?php echo $user_name; ?></h5>
                        </div>
                    </div>
                </div>
            </div>
            <form action="" method="post">

                <div class="form-floating my-3">
                    <input class="form-control" type="text" id="name" name="name" value="<?php echo $name; ?>" placeholder="Enter your Full Name">
                    <label for="name">Full Name</label>
                </div>

                <div class="form-floating my-3">
                    <input class="col-sm-10 form-control" type="email" id="eamil" name="email" value="<?php echo $email; ?>" placeholder="Enter your Email Address">
                    <label for="email">Email Address</label>
                </div>

                <div class="form-floating my-3">
                    <input class="form-control" type="number" id="phone" name="phone" value="<?php echo $phone; ?>" placeholder="Enter Phone No">
                    <label for="phone">Phone No</label>
                </div>

                <input type="hidden" name="primary_key" value="id">
                <input type="hidden" name="primary_value" value="<?php echo login_id() ?>">

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn deep-bg" name="table_name" value="users">Update</button>
                </div>


            </form>

        </div>
    </div>
</section>


<?php
include "footer.php";
?>