<?php
include "header.php";
?>


<?php $rules_and_terms =  htmlspecialchars_decode($language_data['rules_and_terms_contents']) ?>

<div class="py-3">
    <div class="fs-3 fw-bold"><?php echo $language_data['rules'] ?></div>
</div>


<div class="light-bg p-3 rounded contents-section">

    <?php echo $rules_and_terms ?>

</div>




<?php
include "footer.php";
?>