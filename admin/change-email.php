<?php
include "header.php";
?>


<section>
    <div class="d-flex justify-content-center mb-5">
        <div class="col-12 col-sm-12 col-md-10 col-lg-8 col-xl-8 col-xxl-6">
            <div class="text-center h2">Change Email</div>

            <form action="" method="post">

                <div class="form-floating my-3">
                    <input class="form-control" type="email" id="new-email" name="new-email" placeholder="Enter your current password">
                    <label for="new-email">Enter your new email address</label>
                </div>

                <div class="form-floating my-3">
                    <input class="form-control" type="password" id="confirm-password" name="password" placeholder="Type your password">
                    <label for="confirm-password">Type your password</label>
                </div>
                <input type="hidden" name="id" value="<?php echo login_admin_id() ?>">
                <div class="d-flex">
                    <div class="ms-auto">
                        <input type="submit" class="btn btn-success mb-3" name="change-email" value="Change Email">
                    </div>
                </div>

            </form>

        </div>
    </div>
</section>





<?php
include "footer.php";
?>