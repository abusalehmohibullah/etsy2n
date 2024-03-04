<?php
include "header.php";
?>


<!-- slider  -->
<section>
    <div class="slider-common-class slider slider-container" id="slide-container">

        <?php

        // Set the parameters for the initial load
        $_GET['type'] = 'slides'; // Example table name
        $_GET['table'] = 'slides'; // Example table name
        $_GET['conditions'] = 'status'; // Example additional conditions
        $_GET['condition_value'] = 1; // Example additional conditions
        $_GET['order_conditions'] = 'created_at'; // Example additional conditions

        // Include the initial_load.php file
        include "./functions/initial-load.php";
        ?>

    </div>
</section>



<!-- notice -->
<section>
    <div class="notice-container deep-bg d-flex flex-row rounded-3 my-3 shadow-sm">
        <div class="title deep-bg d-flex align-items-center px-1">
            <img src="./assets/images/icons/notice-bell.png" alt="" width="30px" height="30px">
        </div>

        <ul class="d-flex align-items-center">

            <?php
            if (isset($notice_text) && !empty($notice_text)) {
                foreach ($notice_text as $data) {
            ?>
                    <li class="text-white">
                        <?php echo $data->notice_text; ?>
                    </li>
            <?php
                }
            } ?>

        </ul>
    </div>
</section>








<!-- buttons  -->
<section>
    <div class="d-flex justify-content-around four-btns my-3 mx-5">

        <div class="deposit-btn d-flex flex-column justify-content-center align-items-center position-relative">
            <div class="icon-div light-bg btn shadow-sm">
                <img src="./assets/images/icons/deposit.png" alt="" width="30px" height="30px">
            </div>
            <div class="tab-name"><?php echo $language_data['deposit'] ?></div>
            <a href="./deposit.php" class="stretched-link"></a>
        </div>

        <div class="withdraw-btn d-flex flex-column justify-content-center align-items-center position-relative">
            <div class="icon-div light-bg btn shadow-sm">
                <img src="./assets/images/icons/withdraw.png" alt="" width="30px" height="30px">
            </div>
            <div class="tab-name"><?php echo $language_data['withdraw'] ?></div>
            <a href="./withdraw.php" class="stretched-link"></a>
        </div>

        <div class="invite-btn d-flex flex-column justify-content-center align-items-center position-relative">
            <div class="icon-div light-bg btn shadow-sm">
                <img src="./assets/images/icons/invite.png" alt="" width="30px" height="30px">
            </div>
            <div class="tab-name"><?php echo $language_data['invite'] ?></div>
            <a href="./invite.php" class="stretched-link"></a>
        </div>

        <div class="treasury-btn d-flex flex-column justify-content-center align-items-center position-relative">
            <div class="icon-div light-bg btn shadow-sm">
                <img src="./assets/images/icons/treasury.png" alt="" width="30px" height="30px">
            </div>
            <div class="tab-name"><?php echo $language_data['treasury'] ?></div>
            <a href="./treasury.php" class="stretched-link"></a>
        </div>

    </div>
</section>



<!-- member news -->

<section>
    <div class="section-title fs-3 fw-bold mt-5 mb-3">
        <?php echo $language_data['member_news'] ?>
    </div>
    <div class="slider-common-class slider-div-class member-slider">

        <?php
        if (isset($users) && !empty($users)) {
            foreach ($users as $data) {
                // if($data->yesterday_commission != 0){
        ?>
                <div class="news-container light-bg rounded-3 px-4 shadow-sm my-1" id="sliding-div">
                    <div class="row news-row p-2">
                        <div class="col-4 col-sm-4 col-md-6 col-lg-6 col-xl-5 col-xxl-6 d-flex gap-2">
                            <div class="id-icon px-3"> <img src="./assets/images/icons/me-dark.png" alt="" width="20px" height="20px"></div>
                            <div class="id-name flex-grow-1"><?php

                                                                $uID = $data->user_name;
                                                                $stuid = substr($uID, 0, 2);
                                                                $ltuid = substr($uID, -2);
                                                                echo $stuid . "****" . $ltuid;
                                                                ?></div>
                        </div>
                        <div class="col-8 col-sm-8 col-md-6 col-lg-6 col-xl-5 col-xxl-6 d-flex gap-2 ">
                            <div class="balance-title"><?php echo $language_data['yesterday_commission'] ?> : </div>
                            <div class="balance-amount flex-grow-1">$ <?php echo $data->yesterday_commission ?></div>
                        </div>
                    </div>
                </div>
        <?php

            }
        } else {
            echo "No member found";
        } ?>
    </div>
</section>


<!-- vips levels  -->
<section>
    <div class="container-fluid">
        <div class="section-title fs-3 fw-bold mt-5 mb-3">
            <?php echo $language_data['vip_levels'] ?>
        </div>
    </div>
    <div class="vip-levels">
        <div class="card" id="silver-card">
            <div class="inner-card light-bg rounded-3 pb-3 shadow-sm">
                <div class="img-div">
                    <img src="./assets/images/icons/silver.png" alt="">
                </div>
                <div class="m-1 text-center">
                    <div>
                        <?php echo $language_data['entry_limit'] ?>: 100
                    </div>
                    <div>
                        <?php echo $language_data['daily_order'] ?>: 60
                    </div>
                    <div>
                        <?php echo $language_data['commission_rate'] ?>: 0.5%
                    </div>

                </div>
            </div>
        </div>
        <div class="card" id="gold-card">
            <div class="inner-card light-bg rounded-3 pb-3 shadow-sm">
                <div class="img-div">
                    <img src="./assets/images/icons/gold.png" alt="">
                </div>
                <div class="m-1 text-center">
                    <div>
                        <?php echo $language_data['entry_limit'] ?>: 1000
                    </div>
                    <div>
                        <?php echo $language_data['daily_order'] ?>: 80
                    </div>
                    <div>
                        <?php echo $language_data['commission_rate'] ?>: 0.6%
                    </div>

                </div>
            </div>
        </div>
        <div class="card" id="platinum-card">
            <div class="inner-card light-bg rounded-3 pb-3 shadow-sm">
                <div class="img-div">
                    <img src="./assets/images/icons/platinum.png" alt="">
                </div>
                <div class="m-1 text-center">
                    <div>
                        <?php echo $language_data['entry_limit'] ?>: 3000
                    </div>
                    <div>
                        <?php echo $language_data['daily_order'] ?>: 100
                    </div>
                    <div>
                        <?php echo $language_data['commission_rate'] ?>: 0.7%
                    </div>

                </div>
            </div>
        </div>
        <div class="card" id="diamond-card">
            <div class="inner-card light-bg rounded-3 pb-3 shadow-sm">
                <div class="img-div">
                    <img src="./assets/images/icons/diamond.png" alt="">
                </div>
                <div class="m-1 text-center">
                    <div>
                        <?php echo $language_data['entry_limit'] ?>: 5000
                    </div>
                    <div>
                        <?php echo $language_data['daily_order'] ?>: 120
                    </div>
                    <div>
                        <?php echo $language_data['commission_rate'] ?>: 0.8%
                    </div>

                </div>
            </div>
        </div>
        <div class="card" id="crown-card">
            <div class="inner-card light-bg rounded-3 pb-3 shadow-sm">
                <div class="img-div">
                    <img src="./assets/images/icons/crown.png" alt="">
                </div>
                <div class="m-1 text-center">
                    <div>
                        <?php echo $language_data['entry_limit'] ?>: 10000
                    </div>
                    <div>
                        <?php echo $language_data['daily_order'] ?>: 130
                    </div>
                    <div>
                        <?php echo $language_data['commission_rate'] ?>: 0.9%
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>



<!-- winner slider  -->
<section>
    <div class="container-fluid rounded">
        <div class="section-title fs-3 fw-bold mt-5 mb-3">
            <?php echo $language_data['jackpot_winners'] ?>
        </div>

        <div class="slider-common-class slider-div-class winner-slider rounded">

            <?php
            if (isset($jackpot_data) && !empty($jackpot_data)) {
                foreach ($jackpot_data as $jackpot) {
                    $currentDateTime = new DateTime();

                    // Subtract 24 hours from the current time
                    $currentDateTime->modify('-24 hours');

                    // Format the resulting time as desired
                    $twentyFourHoursAgo = $currentDateTime->format('Y-m-d H:i:s');


                    if ($twentyFourHoursAgo <= $jackpot->created_at) {
                        $prev_rank = $jackpot->prev_rank;
                        $new_rank = $jackpot->new_rank;


                        if ($prev_rank == 1) {

                            $prev_level_image = "silver.png";
                        } elseif ($prev_rank == 2) {

                            $prev_level_image = "gold.png";
                        } elseif ($prev_rank == 3) {

                            $prev_level_image = "platinum.png";
                        } elseif ($prev_rank == 4) {

                            $prev_level_image = "diamond.png";
                        } elseif ($prev_rank == 5) {

                            $prev_level_image = "crown.png";
                        }

                        if ($new_rank == 1) {

                            $new_level_image = "silver.png";
                        } elseif ($new_rank == 2) {

                            $new_level_image = "gold.png";
                        } elseif ($new_rank == 3) {

                            $new_level_image = "platinum.png";
                        } elseif ($new_rank == 4) {

                            $new_level_image = "diamond.png";
                        } elseif ($new_rank == 5) {

                            $new_level_image = "crown.png";
                        }

            ?>
                        <div class=" d-flex flex-column justify-content-center align-items-center gap-2 slide-container light-bg rounded-3 shadow-sm p-3">
                            <div class="icon-div">
                                <img src="./assets/images/icons/me-dark.png" alt="" width="40px" height="40px">
                            </div>
                            <div class="id-div">
                                <?php
                                foreach ($users as $data) {
                                    if ($jackpot->target_user == $data->id) {
                                        $uID = $data->user_name;
                                        $stuid = substr($uID, 0, 2);
                                        $ltuid = substr($uID, -2);


                                        echo $stuid . "****" . $ltuid;
                                    }
                                }
                                ?> </div>


                            <div class="levels d-flex justify-content-center align-items-center gap-3">

                                <?php
                                if ($prev_rank < $new_rank) {

                                ?>
                                    <div class="previous-level">
                                        <img src="./assets/images/icons/<?php echo $prev_level_image ?>" alt="" width="40px" height="40px">
                                    </div>


                                    <div class="to">
                                        <img src="./assets/images/icons/to.png" alt="" width="30px" height="30px">
                                    </div>
                                    
                                    <div class="new-level">
                                        <img src="./assets/images/icons/<?php echo $new_level_image ?>" alt="" width="60px" height="60px">
                                    </div>

                                <?php
                                } else {
                                ?>
                                    <div class="new-level">
                                        <img src="./assets/images/icons/<?php echo $new_level_image ?>" alt="" width="60px" height="60px">
                                    </div>

                                <?php 
                                    
                                }
                                ?>


                            </div>
                        </div>
                    <?php
                    }
                    ?>

                <?php


                }
            } else {
                ?>
                <div class="slider-common-class slider-div-class rounded">
                    <div class="text-center light-bg rounded-3 shadow-sm p-3">
                        No member found
                    </div>
                </div>

            <?php
            }
            ?>

        </div>
    </div>
</section>


<?php
include "footer.php";
?>