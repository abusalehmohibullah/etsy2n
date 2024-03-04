<?php
include "header.php";
?>


<?php $agency_cooperation =  htmlspecialchars_decode($language_data['agency_cooperation_contents']) ?>

<div class="py-3">
    <div class="fs-3 fw-bold"><?php echo $language_data['agency'] ?></div>
    <!--<div class="balance-container light-bg fw-bold rounded-3 ms-auto px-2 py-1">Mark all as read</div>-->
</div>


<div class="light-bg p-3 rounded contents-section">

    <?php echo $agency_cooperation ?>

</div>




<?php
include "footer.php";
?>