<?php
include "header.php";

$invitation_code = "";
if (isset($users) && !empty($users)) {
    foreach ($users as $data) {
        if ($data->id == login_id()) {
            $invitation_code = $data->invitation_code;
        }
    }
}

?>

<div class="py-3">
    <div class="fs-3 fw-bold">Invite</div>
    <!--<div class="balance-container light-bg fw-bold rounded-3 ms-auto px-2 py-1">Mark all as read</div>-->
</div>

<div class="d-flex bg-light p-2 my-2 rounded">

    <div class="d-flex position-relative">
        <div class="img-container me-2 rounded-circle">
            <img src="./assets/images/profile-pictures/<?php echo $profile_picture ?>" alt="" width="70px" height="70px" class="rounded-circle">

        </div>
        <div class="d-flex flex-column justify-content-center name-n-price gap-0">
            <div class="fs-5 fw-semibold"> <?php echo $name; ?></div>
            <div>@<?php echo $user_name; ?></div>
        </div>
        <a href="./profile.php" class="stretched-link"></a>
    </div>

</div>

<div class="light-bg rounded px-3">

    <div class="row container-fluid h-100 p-2 m-0">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 d-flex flex-column justify-content-center align-items-center p-4 m-0">
            <div class="fs-3 fw-bold">Invite Friends.</div>
            <div class="fs-5 fw-bold text-success text-center mb-3">Get 10% of their earnings for lifetime.</div>
            <img src="./assets/images/invite-bg.png" alt="" class="w-100">
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 row d-flex rounded justify-content-center align-items-center p-0 m-0">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-11 col-xxl-11 d-flex flex-column justify-content-center rounded-5 py-2 px-3">

                <div class="d-flex gap-3 my-3">

                    <div><img src="./assets/images/icons/invite-1.png" alt="" width="40px"></div>
                    <div class="p-2 bg-white rounded flex-grow-1">Share our website with friends</div>
                </div>

                <div class="d-flex gap-3 my-3">

                    <div><img src="./assets/images/icons/invite-2.png" alt="" width="40px"></div>
                    <div class="p-2 bg-white rounded flex-grow-1">Invite friends to put your ID when they sign up</div>
                </div>

                <div class="d-flex gap-3 my-3">

                    <div><img src="./assets/images/icons/invite-3.png" alt="" width="40px"></div>
                    <div class="p-2 bg-white rounded flex-grow-1">Receive 10% of their earning for lifetime</div>
                </div>

                <div class="d-flex ps-2 py-0 bg-white rounded mt-5 align-items-center">

                    <div class="text-secondary">Your ID</div>

                    <div class="flex-grow-1 text-end">
                        <span id="refer-id"><?php echo $invitation_code ?></span>
                        <span id="copy-refer" class="btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Copy"><i class="fa fa-clone"></i></span>

                    </div>
                </div>



                <div class="d-flex ps-2 py-0 bg-white rounded my-3 align-items-center d-flex flex-row">

                    <div class="text-secondary text-nowrap me-2">Invitation Link</div>

                    <div class="flex-grow-1 text-end align-items-center justify-content-end d-flex flex-row overflow-hidden ">
                        <span class="overflow-auto text-nowrap" id="refer-link"><?php echo $_SERVER['HTTP_HOST'] . '/index.php?invited-by=' . $invitation_code ?></span>
                        <span id="copy-link" class="btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Copy"><i class="fa fa-clone"></i></span>

                    </div>
                </div>

                <div class="btn btn-lg deep-bg mb-5" id="shareButton" onclick="inviteFriends('<?php echo '/index.php?invited-by=' . $invitation_code ?>')">
                    <i class="bi bi-share"></i> Invite Friends
                </div>

            </div>

        </div>


    </div>


    <?php
    include "footer.php";
    ?>