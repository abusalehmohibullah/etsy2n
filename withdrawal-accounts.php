<?php
include "header.php";
?>

<div class="py-3">
  <div class="fs-3 fw-bold">Setup Withdrawal Accounts</div>
</div>

<?php echo show_message() ?>

<div class="mt-4">

  <div class="position-relative pt-3">
    <div class="fs-5 fw-bold position-absolute top-0 bg-white ms-2 px-2">General Informations</div>

    <div class="border rounded p-1 pt-3">

      <div class="light-bg rounded p-3">

        <?php

        $sql = "SELECT first_name, last_name, address FROM users WHERE id = $login_id";
        $result = mysqli_query($connection, $sql);


        if ($result && mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_assoc($result);

          // Access the values from the row
          $first_name = $row['first_name'];
          $last_name = $row['last_name'];
          $address = $row['address'];

          // Check if the row has non-zero values
          $hasNonZeroValues = false;
          foreach ($row as $value) {
            if ($value !== '' && $value !== 0) {
              $hasNonZeroValues = true;
              break;
            }
          }

          if ($hasNonZeroValues) {
            // Row has non-zero values
            // Your code here
        ?>

            <!--general data has-->
            <form class="row g-3 needs-validation" novalidate>

              <div class="col-md-6">
                <label for="validationCustom01" class="form-label">First name</label>
                <input type="text" class="form-control" id="validationCustom01" value="<?php echo $first_name ?>" readonly>
                <div class="invalid-feedback">
                  Please provide a valid Name.
                </div>
              </div>

              <div class="col-md-6">
                <label for="validationCustom02" class="form-label">Last name</label>
                <input type="text" class="form-control" id="validationCustom02" value="<?php echo $last_name ?>" readonly>
                <div class="invalid-feedback">
                  Please provide a valid Name.
                </div>
              </div>

              <div class="col-md-12">
                <label for="validationCustom03" class="form-label">Address</label>
                <input type="text" class="form-control" id="validationCustom03" value="<?php echo $address ?>" readonly>
                <div class="invalid-feedback">
                  Please provide a valid Address.
                </div>
              </div>

              <div class="col-12 d-flex">
                <button class="btn btn-danger ms-auto" type="button" data-bs-toggle="modal" data-bs-target="#general_info_delete">Delete</button>
              </div>

            </form>

            <!-- Modal -->
            <div class="modal fade" id="general_info_delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header py-2 alert alert-danger">
                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Confirm Delete</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    Are you sure you want to delete this informations?
                  </div>
                  <div class="modal-footer py-1">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form action="" method="post">
                      <button type="submit" class="btn btn-danger" name="info_delete" value="1">Delete</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>


          <?php

          } else {

          ?>

            <!--general no data-->

            <form action="" method="POST" class="row g-3 needs-validation" novalidate>

              <div class="col-md-6">
                <label for="validationCustom01" class="form-label">First name</label>
                <input type="text" class="form-control" id="validationCustom01" name="first_name" value="" required>
                <div class="invalid-feedback">
                  Please provide a valid Name.
                </div>
              </div>

              <div class="col-md-6">
                <label for="validationCustom02" class="form-label">Last name</label>
                <input type="text" class="form-control" id="validationCustom02" name="last_name" value="" required>
                <div class="invalid-feedback">
                  Please provide a valid Name.
                </div>
              </div>

              <div class="col-md-12">
                <label for="validationCustom03" class="form-label">Address</label>
                <input type="text" class="form-control" id="validationCustom03" name="address" required>
                <div class="invalid-feedback">
                  Please provide a valid Address.
                </div>
              </div>

              <input type="hidden" name="bank_details" value="1">
              <div class="col-12 d-flex">
                <button class="btn deep-bg ms-auto" type="submit" name="general_info">Update</button>
              </div>
            </form>


        <?php

          }
        }
        ?>


      </div>
    </div>




  </div>

</div>


<div class="mt-4">

  <div class="position-relative pt-3">
    <div class="fs-5 fw-bold position-absolute top-0 bg-white ms-2 px-2">Bank Accounts in</div>
    <div class="border rounded p-1 pt-3">

      <?php

      $sql = "SELECT bank_name, currency, bank_address, region, iban, bic, account_no, aba_ach_no, swift, bank_code FROM users WHERE id = $login_id";
      $result = mysqli_query($connection, $sql);


      if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $region = $row['region'];
        $bank_name = $row['bank_name'];
        $currency = $row['currency'];
        $bank_address = $row['bank_address'];
        $iban = $row['iban'];
        $bic = $row['bic'];
        $account_no = $row['account_no'];
        $aba_ach_no = $row['aba_ach_no'];
        $swift = $row['swift'];
        $bank_code = $row['bank_code'];

        // Check if the row has non-zero values
        $hasNonZeroValues = false;
        foreach ($row as $value) {
          if ($value !== '' && $value !== 0) {
            $hasNonZeroValues = true;
            break;
          }
        }

        if ($hasNonZeroValues) {

          if ($region == 1) {

      ?>

            <!--eu data has-->
            <div class="form-check form-check-inline ms-2">
              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="europe" checked>
              <label class="form-check-label" for="inlineRadio1">Europe</label>
            </div>


            <div class="light-bg rounded p-3">



              <form class="row g-3 needs-validation" novalidate>



                <div class="col-md-6">
                  <label for="validationCustom02" class="form-label">Bank name</label>
                  <input type="text" class="form-control" id="validationCustom02" value="<?php echo $bank_name ?>" readonly>
                  <div class="invalid-feedback">
                    Please provide a valid Bank Name.
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="validationCustom01" class="form-label">Account Currency</label>
                  <select class="form-select" id="validationCustom04" readonly>
                    <option selected value="">

                      <?php

                      $currencyMapping = [
                        'AUD' => ['full_form' => 'Australian Dollar (AUD)', 'sign' => '&#36;'],
                        'BDT' => ['full_form' => 'Bangladeshi Taka (BDT)', 'sign' => '&#2547;'],
                        'BRL' => ['full_form' => 'Brazilian Real (BRL)', 'sign' => '&#82;'],
                        'GBP' => ['full_form' => 'British Pound Sterling (GBP)', 'sign' => '&#163;'],
                        'CAD' => ['full_form' => 'Canadian Dollar (CAD)', 'sign' => '&#36;'],
                        'CNY' => ['full_form' => 'Chinese Yuan (CNY)', 'sign' => '&#165;'],
                        'EUR' => ['full_form' => 'Euro (EUR)', 'sign' => '&#128;'],
                        'HKD' => ['full_form' => 'Hong Kong Dollar (HKD)', 'sign' => '&#36;'],
                        'INR' => ['full_form' => 'Indian Rupee (INR)', 'sign' => '&#8377;'],
                        'JPY' => ['full_form' => 'Japanese Yen (JPY)', 'sign' => '&#165;'],
                        'KRW' => ['full_form' => 'South Korean Won (KRW)', 'sign' => '&#8361;'],
                        'MMK' => ['full_form' => 'Myanmar Kyat (MMK)', 'sign' => '&#75;'],
                        'MXN' => ['full_form' => 'Mexican Peso (MXN)', 'sign' => '&#36;'],
                        'NZD' => ['full_form' => 'New Zealand Dollar (NZD)', 'sign' => '&#36;'],
                        'NOK' => ['full_form' => 'Norwegian Krone (NOK)', 'sign' => '&#107;&#114;'],
                        'RUB' => ['full_form' => 'Russian Ruble (RUB)', 'sign' => '&#8381;'],
                        'SGD' => ['full_form' => 'Singapore Dollar (SGD)', 'sign' => '&#36;'],
                        'ZAR' => ['full_form' => 'South African Rand (ZAR)', 'sign' => '&#82;'],
                        'SEK' => ['full_form' => 'Swedish Krona (SEK)', 'sign' => '&#107;&#114;'],
                        'CHF' => ['full_form' => 'Swiss Franc (CHF)', 'sign' => '&#67;&#72;&#70;'],
                        'TRY' => ['full_form' => 'Turkish Lira (TRY)', 'sign' => '&#8378;'],
                        'USD' => ['full_form' => 'US Dollar (USD)', 'sign' => '&#36;'],
                      ];

                      // Fetch the currency value from the database (assuming you stored it in $currencyValue variable)

                      if (isset($currencyMapping[$currency])) {
                        // Currency mapping found for the given value
                        $fullForm = $currencyMapping[$currency]['full_form'];
                        $sign = $currencyMapping[$currency]['sign'];

                        // Display the full form, short form, and sign
                        echo $sign . "-" . $fullForm;
                      }

                      ?>

                    </option>
                  </select>

                  <div class="invalid-feedback">
                    Please select a Currency.
                  </div>
                </div>

                <div class="col-md-12">
                  <label for="validationCustom03" class="form-label">Bank Address</label>
                  <input type="text" class="form-control" id="validationCustom03" value="<?php echo $bank_address ?>" readonly>
                  <div class="invalid-feedback">
                    Please provide a valid Address.
                  </div>
                </div>


                <div class="col-md-6">
                  <label for="validationCustom01" class="form-label">IBAN</label>
                  <input type="text" class="form-control" id="validationCustom01" value="<?php echo $iban ?>" readonly>
                  <div class="invalid-feedback">
                    Please provide a valid Name.
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="validationCustom02" class="form-label">BIC</label>
                  <input type="text" class="form-control" id="validationCustom02" value="<?php echo $bic ?>" readonly>
                  <div class="invalid-feedback">
                    Please provide a valid Name.
                  </div>
                </div>



                <input type="hidden" name="bank_details" value="2">
                <div class="col-12 d-flex">
                  <button class="btn btn-danger ms-auto" type="button" data-bs-toggle="modal" data-bs-target="#bank_info_delete">Delete</button>
                </div>

              </form>


            </div>

          <?php

          } else if ($region == 2) {

          ?>

            <!--usa data has-->
            <div class="form-check form-check-inline ms-2">
              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="usa" checked>
              <label class="form-check-label" for="inlineRadio2">USA</label>
            </div>

            <div class="light-bg rounded p-3">

              <form action="" method="POST" class="row g-3 needs-validation" novalidate>

                <div class="col-md-6">
                  <label for="validationCustom02" class="form-label">Bank name</label>
                  <input type="text" class="form-control" id="validationCustom02" value="<?php echo $bank_name ?>" readonly>
                  <div class="invalid-feedback">
                    Please provide a valid Bank Name.
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="validationCustom01" class="form-label">Account Currency</label>
                  <select class="form-select" id="validationCustom04" readonly>
                    <option selected value="">

                      <?php

                      $currencyMapping = [
                        'AUD' => ['full_form' => 'Australian Dollar (AUD)', 'sign' => '&#36;'],
                        'BDT' => ['full_form' => 'Bangladeshi Taka (BDT)', 'sign' => '&#2547;'],
                        'BRL' => ['full_form' => 'Brazilian Real (BRL)', 'sign' => '&#82;'],
                        'GBP' => ['full_form' => 'British Pound Sterling (GBP)', 'sign' => '&#163;'],
                        'CAD' => ['full_form' => 'Canadian Dollar (CAD)', 'sign' => '&#36;'],
                        'CNY' => ['full_form' => 'Chinese Yuan (CNY)', 'sign' => '&#165;'],
                        'EUR' => ['full_form' => 'Euro (EUR)', 'sign' => '&#128;'],
                        'HKD' => ['full_form' => 'Hong Kong Dollar (HKD)', 'sign' => '&#36;'],
                        'INR' => ['full_form' => 'Indian Rupee (INR)', 'sign' => '&#8377;'],
                        'JPY' => ['full_form' => 'Japanese Yen (JPY)', 'sign' => '&#165;'],
                        'KRW' => ['full_form' => 'South Korean Won (KRW)', 'sign' => '&#8361;'],
                        'MMK' => ['full_form' => 'Myanmar Kyat (MMK)', 'sign' => '&#75;'],
                        'MXN' => ['full_form' => 'Mexican Peso (MXN)', 'sign' => '&#36;'],
                        'NZD' => ['full_form' => 'New Zealand Dollar (NZD)', 'sign' => '&#36;'],
                        'NOK' => ['full_form' => 'Norwegian Krone (NOK)', 'sign' => '&#107;&#114;'],
                        'RUB' => ['full_form' => 'Russian Ruble (RUB)', 'sign' => '&#8381;'],
                        'SGD' => ['full_form' => 'Singapore Dollar (SGD)', 'sign' => '&#36;'],
                        'ZAR' => ['full_form' => 'South African Rand (ZAR)', 'sign' => '&#82;'],
                        'SEK' => ['full_form' => 'Swedish Krona (SEK)', 'sign' => '&#107;&#114;'],
                        'CHF' => ['full_form' => 'Swiss Franc (CHF)', 'sign' => '&#67;&#72;&#70;'],
                        'TRY' => ['full_form' => 'Turkish Lira (TRY)', 'sign' => '&#8378;'],
                        'USD' => ['full_form' => 'US Dollar (USD)', 'sign' => '&#36;'],
                      ];

                      // Fetch the currency value from the database (assuming you stored it in $currencyValue variable)

                      if (isset($currencyMapping[$currency])) {
                        // Currency mapping found for the given value
                        $fullForm = $currencyMapping[$currency]['full_form'];
                        $sign = $currencyMapping[$currency]['sign'];

                        // Display the full form, short form, and sign
                        echo $sign . "-" . $fullForm;
                      }


                      ?>

                    </option>
                  </select>

                  <div class="invalid-feedback">
                    Please select a Currency.
                  </div>
                </div>

                <div class="col-md-12">
                  <label for="validationCustom03" class="form-label">Bank Address</label>
                  <input type="text" class="form-control" id="validationCustom03" value="<?php echo $bank_address ?>" readonly>
                  <div class="invalid-feedback">
                    Please provide a valid Address.
                  </div>
                </div>

                <div class="col-md-4">
                  <label for="validationCustom01" class="form-label">Account No.</label>
                  <input type="text" class="form-control" id="validationCustom01" value="<?php echo $account_no ?>" readonly>
                  <div class="invalid-feedback">
                    Please provide a valid Name.
                  </div>
                </div>

                <div class="col-md-4">
                  <label for="validationCustom02" class="form-label">ABA-ACH No.</label>
                  <input type="text" class="form-control" id="validationCustom02" value="<?php echo $aba_ach_no ?>" readonly>
                  <div class="invalid-feedback">
                    Please provide a valid Name.
                  </div>
                </div>

                <div class="col-md-4">
                  <label for="validationCustom03" class="form-label">SWIFT</label>
                  <input type="text" class="form-control" id="validationCustom03" value="<?php echo $swift ?>" readonly>
                  <div class="invalid-feedback">
                    Please provide a valid Address.
                  </div>
                </div>

                <input type="hidden" name="bank_details" value="3">
                <div class="col-12 d-flex">
                  <button class="btn btn-danger ms-auto" type="button" data-bs-toggle="modal" data-bs-target="#bank_info_delete">Delete</button>
                </div>

              </form>

              <!-- Modal -->


            </div>


          <?php


          } else if ($region == 3) {

          ?>

            <!--else data has-->
            <div class="form-check form-check-inline ms-2">
              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="else" checked>
              <label class="form-check-label" for="inlineRadio3">Elsewhere</label>
            </div>



            <div class="light-bg rounded p-3">


              <form action="" method="POST" class="row g-3 needs-validation" novalidate>



                <div class="col-md-6">
                  <label for="validationCustom02" class="form-label">Bank name</label>
                  <input type="text" class="form-control" id="validationCustom02" value="<?php echo $bank_name ?>" readonly>
                  <div class="invalid-feedback">
                    Please provide a valid Bank Name.
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="validationCustom01" class="form-label">Account Currency</label>
                  <select class="form-select" id="validationCustom04" readonly>
                    <option selected value="">

                      <?php

                      $currencyMapping = [
                        'AUD' => ['full_form' => 'Australian Dollar (AUD)', 'sign' => '&#36;'],
                        'BDT' => ['full_form' => 'Bangladeshi Taka (BDT)', 'sign' => '&#2547;'],
                        'BRL' => ['full_form' => 'Brazilian Real (BRL)', 'sign' => '&#82;'],
                        'GBP' => ['full_form' => 'British Pound Sterling (GBP)', 'sign' => '&#163;'],
                        'CAD' => ['full_form' => 'Canadian Dollar (CAD)', 'sign' => '&#36;'],
                        'CNY' => ['full_form' => 'Chinese Yuan (CNY)', 'sign' => '&#165;'],
                        'EUR' => ['full_form' => 'Euro (EUR)', 'sign' => '&#128;'],
                        'HKD' => ['full_form' => 'Hong Kong Dollar (HKD)', 'sign' => '&#36;'],
                        'INR' => ['full_form' => 'Indian Rupee (INR)', 'sign' => '&#8377;'],
                        'JPY' => ['full_form' => 'Japanese Yen (JPY)', 'sign' => '&#165;'],
                        'KRW' => ['full_form' => 'South Korean Won (KRW)', 'sign' => '&#8361;'],
                        'MMK' => ['full_form' => 'Myanmar Kyat (MMK)', 'sign' => '&#75;'],
                        'MXN' => ['full_form' => 'Mexican Peso (MXN)', 'sign' => '&#36;'],
                        'NZD' => ['full_form' => 'New Zealand Dollar (NZD)', 'sign' => '&#36;'],
                        'NOK' => ['full_form' => 'Norwegian Krone (NOK)', 'sign' => '&#107;&#114;'],
                        'RUB' => ['full_form' => 'Russian Ruble (RUB)', 'sign' => '&#8381;'],
                        'SGD' => ['full_form' => 'Singapore Dollar (SGD)', 'sign' => '&#36;'],
                        'ZAR' => ['full_form' => 'South African Rand (ZAR)', 'sign' => '&#82;'],
                        'SEK' => ['full_form' => 'Swedish Krona (SEK)', 'sign' => '&#107;&#114;'],
                        'CHF' => ['full_form' => 'Swiss Franc (CHF)', 'sign' => '&#67;&#72;&#70;'],
                        'TRY' => ['full_form' => 'Turkish Lira (TRY)', 'sign' => '&#8378;'],
                        'USD' => ['full_form' => 'US Dollar (USD)', 'sign' => '&#36;'],
                      ];

                      // Fetch the currency value from the database (assuming you stored it in $currencyValue variable)

                      if (isset($currencyMapping[$currency])) {
                        // Currency mapping found for the given value
                        $fullForm = $currencyMapping[$currency]['full_form'];
                        $sign = $currencyMapping[$currency]['sign'];

                        // Display the full form, short form, and sign
                        echo $sign . "-" . $fullForm;
                      }

                      ?>

                    </option>
                  </select>

                  <div class="invalid-feedback">
                    Please select a Currency.
                  </div>
                </div>

                <div class="col-md-12">
                  <label for="validationCustom03" class="form-label">Bank Address</label>
                  <input type="text" class="form-control" id="validationCustom03" value="<?php echo $bank_address ?>" readonly>
                  <div class="invalid-feedback">
                    Please provide a valid Address.
                  </div>
                </div>


                <div class="col-md-4">
                  <label for="validationCustom01" class="form-label">Account No.</label>
                  <input type="text" class="form-control" id="validationCustom01" value="<?php echo $account_no ?>" readonly>
                  <div class="invalid-feedback">
                    Please provide a valid Name.
                  </div>
                </div>

                <div class="col-md-4">
                  <label for="validationCustom03" class="form-label">SWIFT</label>
                  <input type="text" class="form-control" id="validationCustom03" value="<?php echo $swift ?>" readonly>
                  <div class="invalid-feedback">
                    Please provide a valid Address.
                  </div>
                </div>

                <div class="col-md-4">
                  <label for="validationCustom02" class="form-label">Bank Code</label>
                  <input type="text" class="form-control" id="validationCustom02" value="<?php echo $bank_code ?>" readonly>
                  <div class="invalid-feedback">
                    Please provide a valid Name.
                  </div>
                </div>


                <input type="hidden" name="bank_details" value="4">
                <div class="col-12 d-flex">
                  <button class="btn btn-danger ms-auto" type="button" data-bs-toggle="modal" data-bs-target="#bank_info_delete">Delete</button>
                </div>

              </form>

            </div>

          <?php

          }

          ?>
          <!-- Modal -->
          <div class="modal fade" id="bank_info_delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header py-2 alert alert-danger">
                  <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Confirm Delete</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  Are you sure you want to delete this informations?
                </div>
                <div class="modal-footer py-1">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <form action="" method="post">
                    <button type="submit" class="btn btn-danger" name="info_delete" value="2">Delete</button>
                  </form>
                </div>
              </div>
            </div>
          </div>

        <?php
        } else {
        ?>

          <!--bank details no data-->

          <!--radio btns -->

          <div class="form-check form-check-inline ms-2">
            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="europe">
            <label class="form-check-label" for="inlineRadio1">Europe</label>
          </div>
          <div class="form-check form-check-inline ms-2">
            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="usa">
            <label class="form-check-label" for="inlineRadio2">USA</label>
          </div>
          <div class="form-check form-check-inline ms-2">
            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="else">
            <label class="form-check-label" for="inlineRadio3">Elsewhere</label>
          </div>

          <div class="light-bg rounded p-3 fs-3 fw-bold text-center p-3" id="placeholder">

            Select a region!

          </div>

          <!--eu no data-->

          <div class="light-bg rounded p-3 bank-details-form" id="europe">

            <form action="" method="POST" class="row g-3 needs-validation" novalidate>


              <div class="col-md-6">
                <label for="validationCustom02" class="form-label">Bank name</label>
                <input type="text" class="form-control" id="validationCustom02" name="bank_name" value="" required>
                <div class="invalid-feedback">
                  Please provide a valid Bank Name.
                </div>
              </div>

              <div class="col-md-6">
                <label for="validationCustom01" class="form-label">Account Currency</label>
                <select class="form-select" id="validationCustom04" name="currency" required>
                  <option selected value="">Choose Account Currency</option>
                  <option value="AUD">&#36; - Australian Dollar (AUD)</option>
                  <option value="BDT">&#2547; - Bangladeshi Taka (BDT)</option>
                  <option value="BRL">&#82; - Brazilian Real (BRL)</option>
                  <option value="GBP">&#163; - British Pound Sterling (GBP)</option>
                  <option value="CAD">&#36; - Canadian Dollar (CAD)</option>
                  <option value="CNY">&#165; - Chinese Yuan (CNY)</option>
                  <option value="EUR">&#128; - Euro (EUR)</option>
                  <option value="HKD">&#36; - Hong Kong Dollar (HKD)</option>
                  <option value="INR">&#8377; - Indian Rupee (INR)</option>
                  <option value="JPY">&#165; - Japanese Yen (JPY)</option>
                  <option value="KRW">&#8361; - South Korean Won (KRW)</option>
                  <option value="MMK">&#75; - Myanmar Kyat (MMK)</option>
                  <option value="MXN">&#36; - Mexican Peso (MXN)</option>
                  <option value="NZD">&#36; - New Zealand Dollar (NZD)</option>
                  <option value="NOK">&#107;&#114; - Norwegian Krone (NOK)</option>
                  <option value="RUB">&#8381; - Russian Ruble (RUB)</option>
                  <option value="SGD">&#36; - Singapore Dollar (SGD)</option>
                  <option value="ZAR">&#82; - South African Rand (ZAR)</option>
                  <option value="SEK">&#107;&#114; - Swedish Krona (SEK)</option>
                  <option value="CHF">&#67;&#72;&#70; - Swiss Franc (CHF)</option>
                  <option value="TRY">&#8378; - Turkish Lira (TRY)</option>
                  <option value="USD">&#36; - US Dollar (USD)</option>
                </select>

                <div class="invalid-feedback">
                  Please select a Currency.
                </div>
              </div>

              <div class="col-md-12">
                <label for="validationCustom03" class="form-label">Bank Address</label>
                <input type="text" class="form-control" id="validationCustom03" name="bank_address" required>
                <div class="invalid-feedback">
                  Please provide a valid Address.
                </div>
              </div>

              <div class="col-md-6">
                <label for="validationCustom01" class="form-label">IBAN</label>
                <input type="text" class="form-control" id="validationCustom01" name="iban" value="" required>
                <div class="invalid-feedback">
                  Please provide a valid Name.
                </div>
              </div>

              <div class="col-md-6">
                <label for="validationCustom02" class="form-label">BIC</label>
                <input type="text" class="form-control" id="validationCustom02" name="bic" value="" required>
                <div class="invalid-feedback">
                  Please provide a valid Name.
                </div>
              </div>

              <input type="hidden" name="bank_details" value="2">
              <div class="col-12 d-flex">
                <button class="btn deep-bg ms-auto" type="submit" name="europe_info">Add</button>
              </div>
            </form>

          </div>

          <!--usa no data-->

          <div class="light-bg rounded p-3 bank-details-form" id="usa">

            <form action="" method="POST" class="row g-3 needs-validation" novalidate>


              <div class="col-md-6">
                <label for="validationCustom02" class="form-label">Bank name</label>
                <input type="text" class="form-control" id="validationCustom02" name="bank_name" value="" required>
                <div class="invalid-feedback">
                  Please provide a valid Bank Name.
                </div>
              </div>

              <div class="col-md-6">
                <label for="validationCustom01" class="form-label">Account Currency</label>
                <select class="form-select" id="validationCustom04" name="currency" required>
                  <option selected value="">Choose Account Currency</option>
                  <option value="AUD">&#36; - Australian Dollar (AUD)</option>
                  <option value="BDT">&#2547; - Bangladeshi Taka (BDT)</option>
                  <option value="BRL">&#82; - Brazilian Real (BRL)</option>
                  <option value="GBP">&#163; - British Pound Sterling (GBP)</option>
                  <option value="CAD">&#36; - Canadian Dollar (CAD)</option>
                  <option value="CNY">&#165; - Chinese Yuan (CNY)</option>
                  <option value="EUR">&#128; - Euro (EUR)</option>
                  <option value="HKD">&#36; - Hong Kong Dollar (HKD)</option>
                  <option value="INR">&#8377; - Indian Rupee (INR)</option>
                  <option value="JPY">&#165; - Japanese Yen (JPY)</option>
                  <option value="KRW">&#8361; - South Korean Won (KRW)</option>
                  <option value="MMK">&#75; - Myanmar Kyat (MMK)</option>
                  <option value="MXN">&#36; - Mexican Peso (MXN)</option>
                  <option value="NZD">&#36; - New Zealand Dollar (NZD)</option>
                  <option value="NOK">&#107;&#114; - Norwegian Krone (NOK)</option>
                  <option value="RUB">&#8381; - Russian Ruble (RUB)</option>
                  <option value="SGD">&#36; - Singapore Dollar (SGD)</option>
                  <option value="ZAR">&#82; - South African Rand (ZAR)</option>
                  <option value="SEK">&#107;&#114; - Swedish Krona (SEK)</option>
                  <option value="CHF">&#67;&#72;&#70; - Swiss Franc (CHF)</option>
                  <option value="TRY">&#8378; - Turkish Lira (TRY)</option>
                  <option value="USD">&#36; - US Dollar (USD)</option>
                </select>

                <div class="invalid-feedback">
                  Please select a Currency.
                </div>
              </div>

              <div class="col-md-12">
                <label for="validationCustom03" class="form-label">Bank Address</label>
                <input type="text" class="form-control" id="validationCustom03" name="bank_address" required>
                <div class="invalid-feedback">
                  Please provide a valid Address.
                </div>
              </div>

              <div class="col-md-4">
                <label for="validationCustom01" class="form-label">Account No.</label>
                <input type="text" class="form-control" id="validationCustom01" name="account_no" value="" required>
                <div class="invalid-feedback">
                  Please provide a valid Name.
                </div>
              </div>

              <div class="col-md-4">
                <label for="validationCustom02" class="form-label">ABA-ACH No.</label>
                <input type="text" class="form-control" id="validationCustom02" name="aba_ach_no" value="" required>
                <div class="invalid-feedback">
                  Please provide a valid Name.
                </div>
              </div>

              <div class="col-md-4">
                <label for="validationCustom03" class="form-label">SWIFT</label>
                <input type="text" class="form-control" id="validationCustom03" name="swift" required>
                <div class="invalid-feedback">
                  Please provide a valid Address.
                </div>
              </div>

              <input type="hidden" name="bank_details" value="3">
              <div class="col-12 d-flex">
                <button class="btn deep-bg ms-auto" type="submit" name="usa_info">Add</button>
              </div>
            </form>

          </div>


          <!--else no data-->

          <div class="light-bg rounded p-3 bank-details-form" id="else">


            <form action="" method="POST" class="row g-3 needs-validation" novalidate>


              <div class="col-md-6">
                <label for="validationCustom02" class="form-label">Bank name</label>
                <input type="text" class="form-control" id="validationCustom02" name="bank_name" value="" required>
                <div class="invalid-feedback">
                  Please provide a valid Bank Name.
                </div>
              </div>

              <div class="col-md-6">
                <label for="validationCustom01" class="form-label">Account Currency</label>
                <select class="form-select" id="validationCustom04" name="currency" required>
                  <option selected value="">Choose Account Currency</option>
                  <option value="AUD">&#36; - Australian Dollar (AUD)</option>
                  <option value="BDT">&#2547; - Bangladeshi Taka (BDT)</option>
                  <option value="BRL">&#82; - Brazilian Real (BRL)</option>
                  <option value="GBP">&#163; - British Pound Sterling (GBP)</option>
                  <option value="CAD">&#36; - Canadian Dollar (CAD)</option>
                  <option value="CNY">&#165; - Chinese Yuan (CNY)</option>
                  <option value="EUR">&#128; - Euro (EUR)</option>
                  <option value="HKD">&#36; - Hong Kong Dollar (HKD)</option>
                  <option value="INR">&#8377; - Indian Rupee (INR)</option>
                  <option value="JPY">&#165; - Japanese Yen (JPY)</option>
                  <option value="KRW">&#8361; - South Korean Won (KRW)</option>
                  <option value="MMK">&#75; - Myanmar Kyat (MMK)</option>
                  <option value="MXN">&#36; - Mexican Peso (MXN)</option>
                  <option value="NZD">&#36; - New Zealand Dollar (NZD)</option>
                  <option value="NOK">&#107;&#114; - Norwegian Krone (NOK)</option>
                  <option value="RUB">&#8381; - Russian Ruble (RUB)</option>
                  <option value="SGD">&#36; - Singapore Dollar (SGD)</option>
                  <option value="ZAR">&#82; - South African Rand (ZAR)</option>
                  <option value="SEK">&#107;&#114; - Swedish Krona (SEK)</option>
                  <option value="CHF">&#67;&#72;&#70; - Swiss Franc (CHF)</option>
                  <option value="TRY">&#8378; - Turkish Lira (TRY)</option>
                  <option value="USD">&#36; - US Dollar (USD)</option>
                </select>

                <div class="invalid-feedback">
                  Please select a Currency.
                </div>
              </div>

              <div class="col-md-12">
                <label for="validationCustom03" class="form-label">Bank Address</label>
                <input type="text" class="form-control" id="validationCustom03" name="bank_address" required>
                <div class="invalid-feedback">
                  Please provide a valid Address.
                </div>
              </div>

              <div class="col-md-4">
                <label for="validationCustom01" class="form-label">Account No.</label>
                <input type="text" class="form-control" id="validationCustom01" name="account_no" value="" required>
                <div class="invalid-feedback">
                  Please provide a valid Name.
                </div>
              </div>

              <div class="col-md-4">
                <label for="validationCustom03" class="form-label">SWIFT</label>
                <input type="text" class="form-control" id="validationCustom03" name="swift" required>
                <div class="invalid-feedback">
                  Please provide a valid Address.
                </div>
              </div>

              <div class="col-md-4">
                <label for="validationCustom02" class="form-label">Bank Code</label>
                <input type="text" class="form-control" id="validationCustom02" name="bank_code" value="" required>
                <div class="invalid-feedback">
                  Please provide a valid Name.
                </div>
              </div>


              <input type="hidden" name="bank_details" value="4">
              <div class="col-12 d-flex">
                <button class="btn deep-bg ms-auto" type="submit" name="elsewhere_info">Add</button>
              </div>
            </form>

          </div>

      <?php

        }
      }

      ?>
    </div>
  </div>

</div>


<div class="mt-4">

  <div class="position-relative pt-3">
    <div class="fs-5 fw-bold position-absolute top-0 bg-white ms-2 px-2">USDT Accounts</div>
    <div class="border rounded p-1 pt-3">

      <div class="light-bg rounded p-3">

        <?php
        $sql = "SELECT erc20 FROM users WHERE id = $login_id";
        $result = mysqli_query($connection, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_assoc($result);

          $erc20 = $row['erc20'];

          // Check if the row has non-zero values
          $hasNonZeroValues = false;
          foreach ($row as $value) {
            if ($value !== '' && $value !== 0) {
              $hasNonZeroValues = true;
              break;
            }
          }

          if ($hasNonZeroValues) {
            // Row has non-zero values
            // Your code here
        ?>

            <!--erc data has -->

            <form action="" method="POST" class="row g-3 needs-validation" novalidate>


              <div class="col-md-12">
                <label for="validationCustom03" class="form-label">ERC20 Account Address</label>
                <input type="text" class="form-control" id="validationCustom03" value="<?php echo $erc20 ?>" readonly>
                <div class="invalid-feedback">
                  Please provide a valid Address.
                </div>
              </div>

              <input type="hidden" name="bank_details" value="5">
              <div class="col-12 d-flex">
                <button class="btn btn-danger ms-auto" type="button" data-bs-toggle="modal" data-bs-target="#erc20_info_delete">Delete</button>
              </div>

            </form>

            <!-- Modal -->
            <div class="modal fade" id="erc20_info_delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header py-2 alert alert-danger">
                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Confirm Delete</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    Are you sure you want to delete this informations?
                  </div>
                  <div class="modal-footer py-1">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form action="" method="post">
                      <button type="submit" class="btn btn-danger" name="info_delete" value="3">Delete</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

          <?php

          } else {
          ?>

            <!--erc no data-->

            <form action="" method="POST" class="row g-3 needs-validation" novalidate>


              <div class="col-md-12">
                <label for="validationCustom03" class="form-label">ERC20 Account Address</label>
                <input type="text" class="form-control" id="validationCustom03" name="erc20" required>
                <div class="invalid-feedback">
                  Please provide a valid Address.
                </div>
              </div>

              <input type="hidden" name="bank_details" value="5">
              <div class="col-12 d-flex">
                <button class="btn deep-bg ms-auto" type="submit" name="erc20_info">Add</button>
              </div>
            </form>

        <?php

          }
        }


        ?>


        <?php
        $sql = "SELECT trc20 FROM users WHERE id = $login_id";
        $result = mysqli_query($connection, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_assoc($result);
          $trc20 = $row['trc20'];
          // Check if the row has non-zero values
          $hasNonZeroValues = false;
          foreach ($row as $value) {
            if ($value !== '' && $value !== 0) {
              $hasNonZeroValues = true;
              break;
            }
          }

          if ($hasNonZeroValues) {
            // Row has non-zero values

        ?>

            <!--trc data has-->

            <form action="" method="POST" class="row g-3 needs-validation" novalidate>
              <div class="col-md-12">
                <label for="validationCustom03" class="form-label">TRC20 Account Address</label>
                <input type="text" class="form-control" id="validationCustom03" value="<?php echo $trc20 ?>" readonly>
                <div class="invalid-feedback">
                  Please provide a valid Address.
                </div>
              </div>
              <input type="hidden" name="bank_details" value="6">
              <div class="col-12 d-flex">
                <button class="btn btn-danger ms-auto" type="button" data-bs-toggle="modal" data-bs-target="#trc20_info_delete">Delete</button>
              </div>

            </form>

            <!-- Modal -->
            <div class="modal fade" id="trc20_info_delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header py-2 alert alert-danger">
                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Confirm Delete</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    Are you sure you want to delete this informations?
                  </div>
                  <div class="modal-footer py-1">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form action="" method="post">
                      <button type="submit" class="btn btn-danger" name="info_delete" value="4">Delete</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

          <?php

          } else {
          ?>

            <!--trc no data-->
            <form action="" method="POST" class="row g-3 needs-validation" novalidate>
              <div class="col-md-12">
                <label for="validationCustom03" class="form-label">TRC20 Account Address</label>
                <input type="text" class="form-control" id="validationCustom03" name="trc20" required>
                <div class="invalid-feedback">
                  Please provide a valid Address.
                </div>
              </div>
              <input type="hidden" name="bank_details" value="6">
              <div class="col-12 d-flex">
                <button class="btn deep-bg ms-auto" type="Add" name="trc20_info">Add</button>
              </div>
            </form>


        <?php

          }
        }

        ?>

      </div>
    </div>
  </div>

</div>


<?php
include "footer.php";
?>