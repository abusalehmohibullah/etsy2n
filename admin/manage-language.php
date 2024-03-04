<?php
include "header.php";
?>

<section>
    <div class="fs-4 fw-semi-bold">Manage Languages</div>

    <div class="accordion my-4" id="slidesAccordion">
        <div class="accordion-item  position-relative">

            <button class="accordion-button d-flex position-relative ps-2 pe-3 py-2 deep-bg collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseZero" aria-expanded="true" aria-controls="collapseZero">
                <div class="align-self-center m-0 p-0 text-dark fw-semibold">View Language Details</div>
            </button>

            <div id="collapseZero" class="collapse" aria-labelledby="headingTwo">
                <div class="accordion-body row gx-1 py-0 px-2">

                    <div class="container-fluid px-2 py-1">

                        <div class="table-responsive">

                            <?php
                            // Query to fetch data from the "languages" table
                            $query = "SELECT * FROM languages";
                            $connection->set_charset('utf8');
                            $result = $connection->query($query);

                            // Check if any rows are returned
                            if ($result->num_rows > 0) {
                                // Start the HTML table
                                echo '<table class="table bg-white">';

                                // Fetch the column names
                                $fields = $result->fetch_fields();

                                // Output the table header row
                                echo '<tr>';
                                foreach ($fields as $field) {
                                    echo '<th>' . $field->name . '</th>';
                                }
                                echo '</tr>';

                                // Output the table data rows
                                while ($row = $result->fetch_assoc()) {
                                    echo '<tr>';
                                    foreach ($row as $columnName => $columnValue) {
                                        if ($columnName === 'id') {
                                            $language_id = $columnValue;
                                        }

                                        if ($columnName === 'status') {

                            ?>
                                            <td>
                                                <div>
                                                    <?php if ($columnValue == 1) { ?>
                                                        <div class="fst-italic text-secondary mb-1">Hidden</div>
                                                        <div class="ms-auto px-2 py-1 d-flex z-1 flex-nowrap gap-1">
                                                            <form action="" method="post">
                                                                <input type="hidden" name="id" value="<?php echo $language_id ?>">
                                                                <input type="hidden" name="table" value="languages">
                                                                <input type="hidden" name="value" value="2">
                                                                <button class="btn btn-success" type="submit" name="update-status">
                                                                    <i class="bi bi-eye"></i>
                                                                </button>
                                                            </form>
                                                            <div class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal-<?php echo $language_id; ?>">
                                                                <i class="bi bi-trash"></i>
                                                            </div>
                                                        <?php } elseif ($columnValue == 2) { ?>
                                                            <div class="fst-italic text-success mb-">Published</div>
                                                            <div class="ms-auto px-2 py-1 d-flex z-1 flex-nowrap gap-1">
                                                                <form action="" method="post">
                                                                    <input type="hidden" name="id" value="<?php echo $language_id ?>">
                                                                    <input type="hidden" name="table" value="languages">
                                                                    <input type="hidden" name="value" value="1">
                                                                    <button class="btn btn-secondary" type="submit" name="update-status">
                                                                        <i class="bi bi-eye-slash"></i>
                                                                    </button>
                                                                </form>
                                                                <div class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal-<?php echo $language_id; ?>">
                                                                    <i class="bi bi-trash"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>

                                                </div> 
                                            </td>

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal-<?php echo $language_id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header py-2 alert alert-danger">
                                                            <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Confirm Delete</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete this language?
                                                        </div>
                                                        <div class="modal-footer py-1">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <form action="" method="post">
                                                                <input type="hidden" name="id" value="<?php echo $language_id ?>">
                                                                <input type="hidden" name="table-name" value="languages">
                                                                <input type="submit" class="btn btn-danger" name="delete-button" value="Delete">
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                            <?php
                                        } else {
                                            ?>
                                            <td class="truncate">
                                                <div class="d-flex">
                                                    <div class="truncate-content" id="id-<?php echo $language_id ?>-<?php echo $columnName ?>"><?php echo $columnValue ?></div>
                                                    <span class="btn ms-auto" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Copy" onclick='copyValue("<?php echo $language_id ?><?php echo '-' ?><?php echo $columnName ?>")'><i class="fa fa-clone"></i></span>
                                                </div>

                                                    </td>
                                                    <?php
                                        }
                                    }
                                    echo '</tr>';
                                }

                                // End the HTML table
                                echo '</table>';
                            } else {
                                echo 'No rows found.';
                            }

                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--add new language -->
    <form action="" method="POST">

        <div class="input-group my-3">
            <div class="form-floating">
                <input type="text" class="form-control" id="floatingInputGroup1" placeholder="Username" name="language_name">
                <label for="floatingInputGroup1">Add New Language</label>
            </div>
            <button type="submit" class="input-group-text btn btn-lg btn-success" name="add_language" value="1"><i class="bi bi-plus-lg"></i></button>
        </div>

    </form>


    <div class="mt-4">
        <form action="" method="POST" accept-charset="UTF-8">

            <div class="position-relative pt-3">
                <div class="fs-5 fw-bold position-absolute top-0 ms-2 px-2">
                    <input type="hidden" name="primary_key" value="id">
                    <select class="form-select" name="primary_value" aria-label="Default select example" onchange="showHideUpdateOptions(this)" required>
                        <option selected disabled value="">Select the language to update</option>

                        <?php
                        $sql = "SELECT id, language_name FROM languages";
                        $connection->set_charset('utf8');
                        $result = $connection->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $id = $row["id"];
                                $language_name = $row["language_name"];
                        ?>
                                <option value="<?php echo $id; ?>"><?php echo $language_name; ?></option>
                        <?php
                            }
                        }
                        ?>

                    </select>

                </div>

                <div class="border rounded p-2 pt-3">
                <div id="updateDetails">

                    <!--navbar-->
                    <div class="accordion my-4" id="accordionExample">
                        <div class="accordion-item  position-relative">

                            <button class="accordion-button d-flex position-relative ps-2 pe-3 py-2 deep-bg collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <div class="align-self-center m-0 p-0 text-dark fw-semibold">Navbar</div>
                            </button>

                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne">
                                <div class="accordion-body row gx-1 py-0 px-2">

                                    <div class="container-fluid px-2 py-1">
                                        <div class="row">
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="home" name="home" placeholder=" " />
                                                <label for="home" class="ms-1">Home</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="order" name="orders" placeholder=" " />
                                                <label for="order" class="ms-1">Order</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="grabbing" name="grabbing" placeholder=" " />
                                                <label for="grabbing" class="ms-1">Grabbing</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="services" name="services" placeholder=" " />
                                                <label for="services" class="ms-1">Services</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="me" name="me" placeholder=" " />
                                                <label for="me" class="ms-1">Me</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="more1" name="more" placeholder=" " />
                                                <label for="more1" class="ms-1">More</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="profile" name="company_profile" placeholder=" " />
                                                <label for="profile" class="ms-1">Company Profile</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="agency" name="agency" placeholder=" " />
                                                <label for="agency" class="ms-1">Agency Cooperation</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="rules" name="rules" placeholder=" " />
                                                <label for="rules" class="ms-1">Rules and Terms</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="privacy" name="privacy" placeholder=" " />
                                                <label for="privacy" class="ms-1">Privacy Policy</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="about" name="about" placeholder=" " />
                                                <label for="about" class="ms-1">About Us</label>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--home page-->
                    <div class="accordion my-4" id="accordionExample">
                        <div class="accordion-item  position-relative">

                            <button class="accordion-button d-flex position-relative ps-2 pe-3 py-2 deep-bg collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                <div class="align-self-center m-0 p-0 text-dark fw-semibold">Home Page</div>
                            </button>

                            <div id="collapseTwo" class="collapse" aria-labelledby="headingOne">
                                <div class="accordion-body row gx-1 py-0 px-2">

                                    <div class="container-fluid px-2 py-1">
                                        <div class="row">
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="deposit" name="deposit" placeholder=" " />
                                                <label for="deposit" class="ms-1">Deposit</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="withdraw" name="withdraw" placeholder=" " />
                                                <label for="withdraw" class="ms-1">Withdraw</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="invite" name="invite" placeholder=" " />
                                                <label for="invite" class="ms-1">Invite</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="treasury" name="treasury" placeholder=" " />
                                                <label for="treasury" class="ms-1">Treasury</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="member-news" name="member_news" placeholder=" " />
                                                <label for="member-news" class="ms-1">Member News</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="balance" name="yesterday_commission" placeholder=" " />
                                                <label for="balance" class="ms-1">Yesterday Commission</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="vip-levels" name="vip_levels" placeholder=" " />
                                                <label for="vip-levels" class="ms-1">VIP Levels</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="entry-limit" name="entry_limit" placeholder=" " />
                                                <label for="entry-limit" class="ms-1">Entry Limit</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="daily-order" name="daily_order" placeholder=" " />
                                                <label for="daily-order" class="ms-1">Daily Order</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="commission-rate" name="commission_rate" placeholder=" " />
                                                <label for="commission-rate" class="ms-1">Commission Rate</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="jackpot-winners" name="jackpot_winners" placeholder=" " />
                                                <label for="jackpot-winners" class="ms-1">Jackpot Winners</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--order page-->
                    <div class="accordion my-4" id="accordionExample">
                        <div class="accordion-item  position-relative">

                            <button class="accordion-button d-flex position-relative ps-2 pe-3 py-2 deep-bg collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                <div class="align-self-center m-0 p-0 text-dark fw-semibold">Order Page</div>
                            </button>

                            <div id="collapseThree" class="collapse" aria-labelledby="headingOne">
                                <div class="accordion-body row gx-1 py-0 px-2">

                                    <div class="container-fluid px-2 py-1">
                                        <div class="row">
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="grabbing-history" name="grabbing_history" placeholder=" " />
                                                <label for="grabbing-history" class="ms-1">Grabbing History</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="remaining-balance" name="balance" placeholder=" " />
                                                <label for="remaining-balance" class="ms-1">Balance</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="all" name="all_orders" placeholder=" " />
                                                <label for="all" class="ms-1">All</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="pending" name="pending" placeholder=" " />
                                                <label for="pending" class="ms-1">Pending</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="completed" name="completed" placeholder=" " />
                                                <label for="completed" class="ms-1">Completed</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="created-time" name="created_time" placeholder=" " />
                                                <label for="created-time" class="ms-1">Created Time</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="order-no" name="order_no" placeholder=" " />
                                                <label for="order-no" class="ms-1">Order No</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="total-amount" name="total_amount" placeholder=" " />
                                                <label for="total-amount" class="ms-1">Total Amount</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="commission" name="commission" placeholder=" " />
                                                <label for="commission" class="ms-1">Commission</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="refund" name="refund" placeholder=" " />
                                                <label for="refund" class="ms-1">Refund</label>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!--grabbing page -->
                    <div class="accordion my-4" id="accordionExample">
                        <div class="accordion-item  position-relative">

                            <button class="accordion-button d-flex position-relative ps-2 pe-3 py-2 deep-bg collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                <div class="align-self-center m-0 p-0 text-dark fw-semibold">Grabbing Page</div>
                            </button>

                            <div id="collapseFour" class="collapse" aria-labelledby="headingOne">
                                <div class="accordion-body row gx-1 py-0 px-2">

                                    <div class="container-fluid px-2 py-1">
                                        <div class="row">
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="all" name="start_grabbing_order" placeholder=" " />
                                                <label for="all" class="ms-1">Start Grabbing Order</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="pending" name="grab_jackpot" placeholder=" " />
                                                <label for="pending" class="ms-1">Grab Jackpot</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="completed" name="total_commission" placeholder=" " />
                                                <label for="completed" class="ms-1">Total Commission</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="frozen" name="today_commission" placeholder=" " />
                                                <label for="frozen" class="ms-1">Today Commission</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="created-time" name="holding_balance" placeholder=" " />
                                                <label for="created-time" class="ms-1">Holding Balance</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="order-no" name="order_quantity" placeholder=" " />
                                                <label for="order-no" class="ms-1">Order Quantity</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!--me page -->
                    <div class="accordion my-4" id="accordionExample">
                        <div class="accordion-item  position-relative">

                            <button class="accordion-button d-flex position-relative ps-2 pe-3 py-2 deep-bg collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                                <div class="align-self-center m-0 p-0 text-dark fw-semibold">Me Page</div>
                            </button>

                            <div id="collapseFive" class="collapse" aria-labelledby="headingOne">
                                <div class="accordion-body row gx-1 py-0 px-2">

                                    <div class="container-fluid px-2 py-1">
                                        <div class="row">
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="treasury_balance" name="treasury_balance" placeholder=" " />
                                                <label for="treasury_balance" class="ms-1">Treasury Balance</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="daily_income" name="daily_income" placeholder=" " />
                                                <label for="daily_income" class="ms-1">Daily Income</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="deposit-history" name="transaction_history" placeholder=" " />
                                                <label for="deposit-history" class="ms-1">Transaction History</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="withdraw-account" name="withdrawal_accounts" placeholder=" " />
                                                <label for="withdraw-account" class="ms-1">Withdrawal Accounts</label>
                                            </div>
                                            <div class="form-floating col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 p-1">
                                                <input type="text" class="form-control" id="profile" name="profile" placeholder=" " />
                                                <label for="profile" class="ms-1">Profile</label>
                                            </div>
                                            <div class="form-floating col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 col-xxl-3 p-1">
                                                <input type="text" class="form-control" id="modify-login-password" name="modify_login_password" placeholder=" " />
                                                <label for="modify-login-password" class="ms-1">Modify Login Password</label>
                                            </div>
                                            <div class="form-floating col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 col-xxl-3 p-1">
                                                <input type="text" class="form-control" id="logout" name="logout" placeholder=" " />
                                                <label for="logout" class="ms-1">Logout</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!--more page -->
                    <div class="accordion my-4" id="accordionExample">
                        <div class="accordion-item  position-relative">

                            <button class="accordion-button d-flex position-relative ps-2 pe-3 py-2 deep-bg collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
                                <div class="align-self-center m-0 p-0 text-dark fw-semibold">More Page</div>
                            </button>

                            <div id="collapseSix" class="collapse" aria-labelledby="headingOne">
                                <div class="accordion-body row gx-1 py-0 px-2">

                                    <div class="container-fluid px-2 py-1">

                                        <div class="my-3">
                                            <select class="form-select" aria-label="Default select example" onchange="updateTextAreaName(this)">
                                                <option disabled selected>Select Section</option>
                                                <option value="company_profile_contents">Company Profile</option>
                                                <option value="agency_cooperation_contents">Agency Cooperation</option>
                                                <option value="rules_and_terms_contents">Rules and Terms</option>
                                                <option value="privacy_policy_contents">Privacy Policy</option>
                                                <option value="about_us_contents">About Us</option>
                                            </select>
                                        </div>

                                        <div class="mb-3" id="content-editor-div">
                                            <textarea class="form-control" id="content-editor" name="" rows="10" value= " sdhsd hfsdajh ksdhfskdjaf"></textarea>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success" name="table_name" value="languages">Update</button>
                    </div>
                </div>
                </div>
            </div>
        </form>
    </div>

</section>




<?php
include "footer.php";
?>