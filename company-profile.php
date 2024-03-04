<?php
include "header.php";
?>


<?php $company_profile =  htmlspecialchars_decode($language_data['company_profile_contents']) ?>

<div class="py-3">
    <div class="fs-3 fw-bold"><?php echo $language_data['company_profile'] ?></div>
    <!--<div class="balance-container light-bg fw-bold rounded-3 ms-auto px-2 py-1">Mark all as read</div>-->
</div>


<div class="light-bg p-3 rounded contents-section">

    <?php echo $company_profile ?>

</div>




<?php
include "footer.php";
?>