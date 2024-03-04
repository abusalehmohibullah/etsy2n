<?php
include "header.php";
?>


<section>
    <div class="d-flex justify-content-center mb-5">
        <div class="col-12 col-sm-12 col-md-10 col-lg-8 col-xl-8 col-xxl-6">
            <div class="text-center h2">Change Password</div>

            <form action="" method="post">
                <div class="form-floating my-3">
                    <input class="form-control" type="password" id="current-password" name="password" placeholder="Enter your current password">
                    <label for="current-password">Enter your current password</label>
                </div>

                <div class="form-floating my-3">
                    <input class="col-sm-10 form-control" type="password" id="new-password" name="new-password" placeholder="Type your new password">
                    <label for="new-password">Type your new password</label>
                </div>

                <div class="form-floating my-3">
                    <input class="form-control" type="password" id="confirm-password" name="confirm-password" placeholder="Confirm your new password">
                    <label for="confirm-password">Confirm your new password</label>
                </div>

                <input type="hidden" name="id" value="<?php echo login_admin_id() ?>">
                <input type="hidden" name="table" value="admins">
                <div class="d-flex">
                    <div class="ms-auto">
                        <input type="submit" class="btn btn-success mb-3" name="change-password" value="Change Password">
                    </div>
                </div>

            </form>

        </div>
    </div>
</section>





<?php
include "footer.php";
?>