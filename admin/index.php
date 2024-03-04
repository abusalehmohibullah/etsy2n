<?php
include "header.php";
?>

<!-- manage withdrawals -->

<div class="accordion my-4" id="slidesAccordion">
    <div class="accordion-item  position-relative">

        <button class="accordion-button d-flex position-relative ps-2 pe-3 py-2 deep-bg" type="button" data-bs-toggle="collapse" data-bs-target="#collapseZero" aria-expanded="true" aria-controls="collapseZero">
            <div class="align-self-center m-0 p-0 text-dark fw-semibold">Withdrawal Requests</div>
        </button>

        <div id="collapseZero" class="accordion-collapse show" aria-labelledby="headingTwo">
            <div class="accordion-body row gx-1 py-0 px-2">

                <div class="container-fluid px-2 py-1">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">User Info</th>
                                    <th class="text-nowrap">Bank Details</th>
                                    <th class="text-nowrap">Amount</th>
                                    <th class="text-nowrap">Action</th>
                                </tr>
                            </thead>


                            <tbody class="table-group-divider">


                                <?php
                                // Prepare and execute the query
                                $query = "SELECT * FROM withdrawals WHERE status IN (1, 2)";
                                $result = $connection->query($query);

                                if ($result->num_rows > 0) {

                                    // Output data of each row
                                    while ($row = $result->fetch_assoc()) {
                                        $requestId = $row['id'];
                                        $amount = $row['amount'];
                                        $withdrawBy = $row['withdraw_by'];
                                        $account = $row['account'];
                                        $status = $row['status'];
                                        $createdAt = new DateTime($row['created_at']);
                                        $currentDateTime = new DateTime();
                                        // Calculate the difference between the target and current DateTime
                                        $interval = $currentDateTime->diff($createdAt);
                                        // Get the days, hours, and minutes from the interval
                                        $days = $interval->days;
                                        $hours = $interval->h;
                                        $minutes = $interval->i;
                                        
                                        // Format the result
                                        $time = '';
                                        if ($days > 0) {
                                            $time .= $days . ' day';
                                            if ($days > 1) {
                                                $time .= 's';
                                            }
                                            $time .= ' ';
                                        } else {
                                            if ($hours > 0) {
                                                $time .= $hours . ' hr ';
                                            }
                                            if ($minutes > 0) {
                                                $time .= $minutes . ' min ';
                                            }
                                        }
                                        if (empty($time)) {
                                            $time = 'Just now';
                                        } else {
                                            $time .= 'ago';
                                        }

                                        // Retrieve additional user information based on the account type
                                        $query = "SELECT user_name, phone, balance, first_name, last_name, address, bank_name, currency, bank_address, region, iban, bic, account_no, aba_ach_no, swift, bank_code, erc20, trc20 FROM users WHERE id = ?";
                                        $stmt = $connection->prepare($query);
                                        $stmt->bind_param("i", $withdrawBy);
                                        $stmt->execute();
                                        $userResult = $stmt->get_result();

                                        if ($userResult->num_rows > 0) {
                                            $userRow = $userResult->fetch_assoc();
                                            $userName = $userRow['user_name'];
                                            $firstName = $userRow['first_name'];
                                            $lastName = $userRow['last_name'];
                                            $balance = $userRow['balance'];
                                            $phone = $userRow['phone'];
                                            $address = $userRow['address'];
                                            $bankName = $userRow['bank_name'];
                                            $currency = $userRow['currency'];
                                            $bankAddress = $userRow['bank_address'];
                                            $region = $userRow['region'];
                                            $iban = $userRow['iban'];
                                            $bic = $userRow['bic'];
                                            $accountNo = $userRow['account_no'];
                                            $abaAchNo = $userRow['aba_ach_no'];
                                            $swift = $userRow['swift'];
                                            $bankCode = $userRow['bank_code'];
                                            $erc20 = $userRow['erc20'];
                                            $trc20 = $userRow['trc20'];

                                            // Output common fields
                                ?>

                                            <tr class="position-relative">

                                                <td class="position-relative">
                                                    <?php

                                                    if ($status == 1) {
                                                    ?>
                                                        <span class="position-absolute top-50 start-0 translate-middle p-1 bg-warning border border-light h-100">
                                                            <span class="visually-hidden">New alerts</span>
                                                        </span> <?php

                                                            } elseif ($status == 2) {
                                                                ?>
                                                        <span class="position-absolute top-50 start-0 translate-middle p-1 bg-success border border-light h-100">
                                                            <span class="visually-hidden">New alerts</span>
                                                        </span>

                                                    <?php
                                                            }
                                                    ?>
                                                    <div class="text-nowrap"><?php echo $firstName . " " . $lastName . " (@" . $userName . ")" ?></div>
                                                    <div class="text-nowrap">Phone: <?php echo $phone ?></div>
                                                    <div>Address: <?php echo $address ?></div>
                                                </td>


                                                <td>


                                                    <?php

                                                    if ($account == 1) {
                                                    ?>
                                                        <div class="text-nowrap">Bank Name: <?php echo $bankName . " (Currency: " . $currency . ")" ?></div>
                                                        <div>Bank Address: <?php echo $bankAddress ?></div>
                                                        <?php

                                                        // Output additional fields based on the account type
                                                        if ($region == 1) {
                                                        ?>
                                                            <div class="text-nowrap">IBAN: <?php echo $iban ?></div>
                                                            <div class="text-nowrap">BIC: <?php echo $bic ?></div>

                                                        <?php

                                                        } elseif ($region == 2) {
                                                        ?>
                                                            <div class="text-nowrap">Account No: <?php echo $accountNo ?></div>
                                                            <div class="text-nowrap">ABA/ACH No: <?php echo $abaAchNo ?></div>
                                                            <div class="text-nowrap">SWIFT: <?php echo $swift ?></div>
                                                        <?php

                                                        } elseif ($region == 3) {
                                                        ?>
                                                            <div class="text-nowrap">Account No: <?php echo $accountNo ?></div>
                                                            <div class="text-nowrap">SWIFT: <?php echo $swift ?></div>
                                                            <div class="text-nowrap">Bank Code: <?php echo $bankCode ?></div>
                                                        <?php
                                                        }
                                                    } elseif ($account == 2) {
                                                        ?>
                                                        <div class="text-nowrap">ERC20 Address: : <?php echo $erc20 ?></div>
                                                    <?php

                                                    } elseif ($account == 3) {
                                                    ?>
                                                        <div class="text-nowrap">TRC20 Address: : <?php echo $trc20 ?></div>
                                                    <?php

                                                    }

                                                    ?>


                                                </td>
                                                <td>
                                                    <div class="fs-5 fw-bold text-success text-nowrap">Requested: $<?php echo $amount ?></div>
                                                    <div class="fs-6 text-secondary text-nowrap">Available: $<?php echo $balance + $amount ?></div>
                                                    <div class="fs-6 text-secondary text-nowrap">
                                                        <?php
                                                        // Get the current DateTime

                                                        echo $time

                                                        ?></div>
                                                </td>

                                                <td class="align-middle">
                                                    <?php


                                                    if ($status == 1) {
                                                    ?>
                                                        <div class="fst-italic text-danger mb-2">Pending</div>
                                                        <div>

                                                            <form action="" method="post">

                                                                <input type="hidden" name="id" value="<?php echo $withdrawBy ?>">
                                                                <input type="hidden" name="adjust_type" value="process-withdraw">
                                                                <input type="hidden" name="continue_status" value="no">

                                                                <button class="btn btn-secondary" type="submit" name="adjust-balance" value="1">Process</button>

                                                            </form>
                                                        </div>
                                                    <?php

                                                    } elseif ($status == 2) {
                                                    ?>
                                                        <div class="fst-italic text-secondary mb-2">Processing</div>
                                                        <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#withdraw-<?php echo $requestId; ?>">Complete</button>
                                                    <?php
                                                    }

                                                    ?>
                                                </td>
                                            </tr>

                                            <!-- Modal -->
                                            <div class="modal fade" id="withdraw-<?php echo $requestId; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header py-2 alert alert-success">
                                                            <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Confirm</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to mark this as completed?
                                                        </div>
                                                        <div class="modal-footer py-1">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <form action="" method="post">
                                                                <input type="hidden" name="id" value="<?php echo $withdrawBy ?>">
                                                                <input type="hidden" name="current_balance" value="<?php echo $balance ?>">
                                                                <input type="hidden" name="adjust_type" value="withdraw">
                                                                <input type="hidden" name="adjust_value" value="<?php echo $amount ?>">
                                                                <input type="hidden" name="continue_status" value="no">
                                                                <button type="submit" class="btn btn-danger" name="adjust-balance" value="1">Confirm</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                    <?php
                                        } else {

                                            echo "User not found.";
                                        }
                                    }
                                } else {
                                    ?>

                                    <tr>
                                        <td colspan="4">No pending request found.</td>
                                    </tr>

                                <?php
                                }

                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- manage slides  -->

<div class="accordion my-4" id="slidesAccordion">
    <div class="accordion-item  position-relative">

        <button class="accordion-button d-flex position-relative ps-2 pe-3 py-2 deep-bg collapsed" id="load-slider" onclick="loadSliders('IN (1, 3)')" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            <div class="align-self-center m-0 p-0 text-dark fw-semibold">Slides</div>
        </button>

        <div id="collapseOne" class="collapse" aria-labelledby="headingOne">
            <div class="accordion-body row gx-1 py-0 px-2">

                <div class="container-fluid px-2 py-1">
                    <div class="row" id="slides-row">



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- manage notices -->
<div class="accordion my-4" id="noticesAccordion">
    <div class="accordion-item  position-relative">

        <button class="accordion-button d-flex position-relative ps-2 pe-3 py-2 deep-bg collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseOne">
            <div class="align-self-center m-0 p-0 text-dark fw-semibold">Notices</div>
        </button>

        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo">
            <div class="accordion-body row gx-1 py-0 px-2">

                <div class="container-fluid px-2 py-1">
                    <div class="row notice-preview-container">

                        <?php
                        if (isset($notice_text) && !empty($notice_text)) {
                            foreach ($notice_text as $data) {
                        ?>
                                <div class="notice-preview-row d-flex align-items-center position-relative p-1 w-100">

                                    <?php if ($data->status == 3) { ?>
                                        <div class="d-flex flex-wrap align-content-center align-items-center position-absolute top-0 start-0 w-100 h-100 transparent-bg">
                                            <div class="w-100 text-center text-white fw-bold fs-4"><i class="bi bi-eye-slash"></i> Hidden</div>
                                        </div>
                                    <?php }  ?>

                                    <div class="notice-text-preview"><?php echo $data->notice_text; ?></div>
                                    <div class="ms-auto px-2 py-1 d-flex z-1 flex-nowrap gap-1">
                                        <div>
                                            <?php if ($data->status == 1) { ?>
                                                <form action="" method="post">
                                                    <input type="hidden" name="id" value="<?php echo $data->id; ?>">
                                                    <input type="hidden" name="table" value="notices">
                                                    <input type="hidden" name="value" value="3">
                                                    <button class="btn btn-secondary" type="submit" name="update-status">
                                                        <i class="bi bi-eye-slash"></i>
                                                    </button>
                                                </form>
                                            <?php } elseif ($data->status == 3) { ?>
                                                <form action="" method="post">
                                                    <input type="hidden" name="id" value="<?php echo $data->id; ?>">
                                                    <input type="hidden" name="table" value="notices">
                                                    <input type="hidden" name="value" value="1">
                                                    <button class="btn btn-success" type="submit" name="update-status">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                </form>
                                            <?php } ?>
                                        </div>
                                        <div class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal-<?php echo $data->id; ?>">
                                            <i class="bi bi-trash"></i>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        } else {
                            echo "No notice found";
                        } ?>
                    </div>

                    <?php
                    if (isset($notice_text) && !empty($notice_text)) {
                        foreach ($notice_text as $data) {
                    ?>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal-<?php echo $data->id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header py-2 alert alert-danger">
                                            <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Confirm Delete</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete this notice?
                                        </div>
                                        <div class="modal-footer py-1">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <form action="" method="post">
                                                <input type="hidden" name="id" value="<?php echo $data->id; ?>">
                                                <input type="hidden" name="table-name" value="notices">
                                                <input type="submit" class="btn btn-danger" name="delete-button" value="Delete">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }  ?>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- manage orders -->
<div class="accordion my-4" id="productsAccordion">
    <div class="accordion-item  position-relative">

        <button class="accordion-button d-flex position-relative ps-2 pe-3 py-2 deep-bg collapsed" id="load-products" onclick="loadProducts('IN (1, 3)')" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
            <div class="align-self-center m-0 p-0 text-dark fw-semibold">Products</div>
        </button>

        <div id="collapseThree" class="collapse" aria-labelledby="headingOne">
            <div class="accordion-body row gx-1 py-0 px-2">
                <div class="container-fluid px-2 py-1">
                    <div class="d-flex justify-content-end mt-1">
                        <div>
                            
                                        <select class="form-control form-control-lg">
  <?php
  // Assuming you have established a database connection

  $query = "SELECT user_level, COUNT(*) AS product_count, (SELECT COUNT(*) FROM products WHERE status = 1) AS total_count
            FROM products
            WHERE status = 1
            GROUP BY user_level;";

  $result = mysqli_query($connection, $query);

  if ($result) {
    $totalCount = 0; // Initialize total count variable
    while ($row = mysqli_fetch_assoc($result)) {
      $userLevel = $row['user_level'];
      $productCount = $row['product_count'];
      $totalCount += $productCount; // Accumulate total count
      
      $levelName = ''; // Initialize level name variable
      // Assign level name based on user_level value
      switch ($userLevel) {
        case 1:
          $levelName = 'Silver';
          break;
        case 2:
          $levelName = 'Gold';
          break;
        case 3:
          $levelName = 'Platinum';
          break;
        case 4:
          $levelName = 'Diamond';
          break;
        case 5:
          $levelName = 'Crown';
          break;
        default:
          $levelName = 'Unknown';
          break;
      }
      
      ?>
      <option value="<?php echo $userLevel; ?>">
        <?php echo $levelName . ' × ' . $productCount; ?>
      </option>
      <?php
    }
    ?>
    <option value="Total" selected>
      Products × <?php echo $totalCount; ?>
    </option>
    <?php
  } else {
    echo "Error executing query: " . mysqli_error($connection);
  }

  ?>
                    </select>
                        </div>      
                        
                    </div>

                    <div class="row" id="products-row">


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>







<!-- manage jackpots -->
<div class="accordion my-4" id="jackpotsAccordion">
    <div class="accordion-item  position-relative">

        <button class="accordion-button d-flex position-relative ps-2 pe-3 py-2 deep-bg collapsed" id="load-jackpots" onclick="loadJackpots('IN (1, 3)')" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
            <div class="align-self-center m-0 p-0 text-dark fw-semibold">Jackpots</div>
        </button>

        <div id="collapseFour" class="collapse" aria-labelledby="headingOne">
            <div class="accordion-body row gx-1 py-0 px-2">
                <div class="container-fluid px-2 py-1">
                    <div class="row" id="jackpots-row">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>






<?php
include "footer.php";
?>