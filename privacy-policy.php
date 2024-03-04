<?php
include "header.php";
?>


<?php $privacy_policy =  htmlspecialchars_decode($language_data['privacy_policy_contents'])?>

<div class="py-3">
    <div class="fs-3 fw-bold">Privacy Policy</div>
</div>


<div class="light-bg p-3 rounded contents-section">
    
    <?php echo $privacy_policy?>
    
</div>




<?php
include "footer.php";
?>