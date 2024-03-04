<?php
include "header.php";
?>



<div class="py-3">
    <div class="fs-3 fw-bold">Deposit</div>
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

<div class="light-bg d-flex flex-column justify-content-center align-items-center rounded px-3 position-relative">

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-5 col-xl-4 col-xxl-3 d-flex flex-column justify-content-center align-items-center p-4 m-0">
        <img src="./assets/images/customer-support.png" alt="" class="w-100">
    </div>


    <div class="text-center fs-3 fw-bold text-primary mb-4">Please contact our customer support to deposit your fund.</div>
    <a class="stretched-link" href="https://direct.lc.chat/15657222/" target="_blank"></a>
</div>






<?php
include "footer.php";
?>