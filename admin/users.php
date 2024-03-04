<?php
include "header.php";

$user_details =  $_SESSION['user_details'];

include "users-nav.php";

if (isset($user_details) && !empty($user_details)) {

?>

    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-9 col-xxl-9 h-100 m-0 my-3">

        <div class="bg-white row rounded">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-6 mb-2">
                <div class="table-responsive">
                    <table class="table w-100">
                        <tr>
                            <td class="py-2">Real Name</td>
                            <td class="px-2 py-2"> : </td>
                            <td class="py-2"><?php echo $user_details['name'] ?></td>
                        </tr>
                        <tr>
                            <td class="py-2">User Name</td>
                            <td class="px-2 py-2"> : </td>
                            <td class="py-2"><?php echo $user_details['user_name'] ?></td>
                        </tr>
                        <tr>
                            <td class="py-2">Email Address</td>
                            <td class="px-2 py-2"> : </td>
                            <td class="py-2"><?php echo $user_details['email'] ?></td>
                        </tr>
                        <tr>
                            <td class="py-2">Phone</td>

                            <td class="px-2 py-2"> : </td>
                            <td class="py-2"><?php echo $user_details['phone'] ?></td>
                        </tr>
                        <tr>
                            <td class="py-2">Address</td>
                            <td class="px-2 py-2"> : </td>
                            <td class="py-2"><?php echo $user_details['address'] ?></td>
                        </tr>
                        <tr>
                            <td class="py-2">Bank Name</td>

                            <td class="px-2 py-2"> : </td>
                            <td class="py-2"><?php echo $user_details['bank_name'] ?></td>
                        </tr>
                        <tr>
                            <td class="py-2">Bank Address</td>
                            <td class="px-2 py-2"> : </td>
                            <td class="py-2"><?php echo $user_details['bank_address'] ?></td>
                        </tr>
                        <tr>
                            <td class="py-2">Account Details</td>
                            <td class="px-2 py-2"> : </td>
                            <td class="py-2">

                                <?php
                                if ($user_details['region'] == 1) {
                                ?>
                                    <div class="text-nowrap">IBAN: <?php echo $user_details['iban'] ?></div>
                                    <div class="text-nowrap">BIC: <?php echo $user_details['bic'] ?></div>

                                <?php

                                } elseif ($user_details['region'] == 2) {
                                ?>
                                    <div class="text-nowrap">Account No: <?php echo $user_details['account_no'] ?></div>
                                    <div class="text-nowrap">ABA/ACH No: <?php echo $user_details['aba_ach_no'] ?></div>
                                    <div class="text-nowrap">SWIFT: <?php echo $user_details['swift'] ?></div>
                                <?php

                                } elseif ($user_details['region'] == 3) {
                                ?>
                                    <div class="text-nowrap">Account No: <?php echo $user_details['account_no'] ?></div>
                                    <div class="text-nowrap">SWIFT: <?php echo $user_details['swift'] ?></div>
                                    <div class="text-nowrap">Bank Code: <?php echo $user_details['bank_code'] ?></div>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2">USDT-TRC20 Address</td>
                            <td class="px-2 py-2"> : </td>
                            <td class="py-2"><?php echo $user_details['trc20'] ?></td>
                        </tr>
                        <tr>
                            <td class="py-2">USDT-ERC20 Address</td>
                            <td class="px-2 py-2"> : </td>
                            <td class="py-2"><?php echo $user_details['erc20'] ?></td>
                        </tr>
                        <tr>
                            <td class="py-2 text-nowrap">Promote This User As</td>
                            <td class="px-2 py-2"> : </td>
                            <td class="py-2 w-100">
                                <form action="" method="POST">
                                    <div class="d-flex w-100">
                                        <div class="w-100">
                                            <select class="form-select border border-gray rounded-4" id="promote-level-list" name="update_value">
                                                <option value="select">Select</option>
                                                <option value="1">Silver</option>
                                                <option value="2">Gold</option>
                                                <option value="3">Platinum</option>
                                                <option value="4">Diamond</option>
                                                <option value="5">Crown</option>
                                            </select>
                                        </div>
                                        <input type="hidden" name="selected-id">
                                        <input type="hidden" name="user-list" value="<?php echo $user_details['id'] ?>">
                                        <input type="hidden" name="id" value="<?php echo $user_details['id'] ?>">
                                        <input type="hidden" name="update_column" value="level">
                                        <input type="hidden" name="current_value" value="<?php echo $user_details['level'] ?>">
                                        <input type="hidden" name="table_name" value="users">

                                        <button type="submit" class="btn btn-outline-none border-0 p-0" id="promote-button" name="update-balance" value="1" disabled>
                                            <i class="bi bi-check-lg px-1 fs-4 text-success py-0"></i>
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-6 mb-1">
                <div class="d-flex w-100 gap-3 m-0">
                    <div class="p-0 w-100">
                        <div class="w-100 p-0 my-2">
                            <div id="bal_main_div" class="rounded-4 balance-display w-100 py-2 px-3">

                                <div class="fs-6 d-flex">
                                    <div class="title-div">Balance</div>
                                    <div class="icon-div ms-auto">
                                        <div>
                                            <i id="bal_edit_button" class="bi bi-pencil-square btn px-1 py-0" onclick="toggleMainDiv('bal_main_div', 'bal_editable_div')"></i>
                                        </div>
                                    </div>
                                </div>

                                <Div class="h2 mx-0 my-1 d-flex">
                                    <div class="dollar-div">$</div>
                                    <div class="number-div ms-auto"><?php echo number_format($user_details['balance'], 2) ?></div>
                                </Div>

                            </div>

                            <div id="bal_editable_div" class="rounded-4 balance-display w-100 py-2 px-3" style="display:none;">
                                <form action="" method="POST">

                                    <div class="fs-6 d-flex">
                                        <div class="title-div">Balance</div>
                                        <div class="icon-div d-flex ms-auto">

                                            <div>
                                                <i id="bal_cross_button" class="bi bi-x-lg btn px-1 py-0" onclick="toggleEditableDiv('bal_main_div', 'bal_editable_div')"></i>
                                            </div>


                                            <input type="hidden" name="selected-id">
                                            <input type="hidden" name="user-list" value="<?php echo $user_details['id'] ?>">
                                            <input type="hidden" name="id" value="<?php echo $user_details['id'] ?>">
                                            <input type="hidden" name="update_column" value="balance">
                                            <input type="hidden" name="table_name" value="users">
                                            <button type="submit" class="btn btn-outline-none p-0" name="update-balance" value="1">
                                                <i id="bal_save_button" class="bi bi-check-lg px-1 py-0"></i>
                                            </button>


                                        </div>
                                    </div>

                                    <Div class="h2 mx-0 my-1 d-flex w-100">
                                        <div class="dollar-div">$</div>
                                        <div class="number-div mx-2"><input class="w-100 h3 text-end m-0 ms-2" type="text" name="update_value" value="<?php echo number_format($user_details['balance'], 2, '.', '') ?>"></div>
                                    </Div>

                                </form>
                            </div>

                        </div>
                    </div>

                    <div class="p-0 w-100">
                        <div class="w-100 p-0 my-2">

                            <div id="tr_bal_main_div" class="rounded-4 balance-display w-100 py-2 px-3">

                                <div class="fs-6 d-flex">
                                    <div class="title-div">Treasury Balance</div>
                                    <div class="icon-div ms-auto">
                                        <div>
                                            <i id="tr_bal_edit_button" class="bi bi-pencil-square btn px-1 py-0" onclick="toggleMainDiv('tr_bal_main_div', 'tr_bal_editable_div')"></i>
                                        </div>
                                    </div>
                                </div>
                                <Div class="h2 mx-0 my-1 d-flex">
                                    <div class="dollar-div">$</div>
                                    <div class="number-div ms-auto"><?php echo number_format($user_details['treasury_balance'], 2) ?></div>
                                </Div>

                            </div>

                            <div id="tr_bal_editable_div" class="rounded-4 balance-display w-100 py-2 px-3" style="display:none;">
                                <form action="" method="POST">
                                    <div class="fs-6 d-flex">
                                        <div class="title-div">Treasury Balance</div>
                                        <div class="icon-div d-flex ms-auto">

                                            <div>
                                                <i id="tr_bal_cross_button" class="bi bi-x-lg btn px-1 py-0" onclick="toggleEditableDiv('tr_bal_main_div', 'tr_bal_editable_div')"></i>
                                            </div>

                                            <input type="hidden" name="selected-id">
                                            <input type="hidden" name="user-list" value="<?php echo $user_details['id'] ?>">
                                            <input type="hidden" name="id" value="<?php echo $user_details['id'] ?>">
                                            <input type="hidden" name="update_column" value="treasury_balance">
                                            <input type="hidden" name="table_name" value="users">
                                            <button type="submit" class="btn btn-outline-none p-0" name="update-balance" value="1">
                                                <i id="tr_bal_save_button" class="bi bi-check-lg px-1 py-0"></i>
                                            </button>

                                        </div>
                                    </div>

                                    <Div class="h2 mx-0 my-1 d-flex w-100">
                                        <div class="dollar-div">$</div>
                                        <div class="number-div mx-2"><input class="w-100 h3 text-end m-0 ms-2" type="text" name="update_value" value="<?php echo number_format($user_details['treasury_balance'], 2, '.', '') ?>"></div>
                                    </Div>
                                </form>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="d-flex w-100 gap-3 m-0">

                    <div class="p-0 w-100">
                        <div class="w-100 p-0 my-2">

                            <div id="hl_bal_main_div" class="rounded-4 balance-display w-100 py-2 px-3">

                                <div class="fs-6 d-flex">
                                    <div class="title-div">Holding Balance</div>
                                    <div class="icon-div ms-auto">
                                        <div>
                                            <i id="hl_bal_edit_button" class="bi bi-pencil-square btn px-1 py-0" onclick="toggleMainDiv('hl_bal_main_div', 'hl_bal_editable_div')"></i>
                                        </div>
                                    </div>
                                </div>

                                <Div class="h2 mx-0 my-1 d-flex">
                                    <div class="dollar-div">$</div>
                                    <div class="number-div ms-auto"><?php echo number_format($user_details['holding_balance'], 2) ?></div>
                                </Div>

                            </div>

                            <div id="hl_bal_editable_div" class="rounded-4 balance-display w-100 py-2 px-3" style="display:none;">
                                <form action="" method="POST">
                                    <div class="fs-6 d-flex">
                                        <div class="title-div">Holding Balance</div>
                                        <div class="icon-div d-flex ms-auto">

                                            <div>
                                                <i id="hl_bal_cross_button" class="bi bi-x-lg btn px-1 py-0" onclick="toggleEditableDiv('hl_bal_main_div', 'hl_bal_editable_div')"></i>
                                            </div>

                                            <input type="hidden" name="selected-id">
                                            <input type="hidden" name="user-list" value="<?php echo $user_details['id'] ?>">
                                            <input type="hidden" name="id" value="<?php echo $user_details['id'] ?>">
                                            <input type="hidden" name="update_column" value="holding_balance">
                                            <input type="hidden" name="table_name" value="users">
                                            <button type="submit" class="btn btn-outline-none p-0" name="update-balance" value="1">
                                                <i id="hl_bal_save_button" class="bi bi-check-lg px-1 py-0"></i>
                                            </button>

                                        </div>
                                    </div>

                                    <Div class="h2 mx-0 my-1 d-flex w-100">
                                        <div class="dollar-div">$</div>
                                        <div class="number-div mx-2"><input class="w-100 h3 text-end m-0 ms-2" type="text" name="update_value" value="<?php echo number_format($user_details['holding_balance'], 2, '.', '') ?>"></div>
                                    </Div>
                                </form>
                            </div>

                        </div>
                    </div>

                    <div class="p-0 w-100">
                        <div class="w-100 p-0 my-2">

                            <div id="wd_pwd_main_div" class="rounded-4 balance-display w-100 py-2 px-3">

                                <div class="fs-6 d-flex">
                                    <div class="title-div">Withdrawal Password</div>
                                    <div class="icon-div ms-auto">
                                        <div>
                                            <i id="wd_pwd_edit_button" class="bi bi-pencil-square btn px-1 py-0" onclick="toggleMainDiv('wd_pwd_main_div','wd_pwd_editable_div')"></i>
                                        </div>
                                    </div>
                                </div>

                                <Div class="h2 mx-0 my-1 d-flex">

                                    <div class="number-div text-center w-100">
                                        <?php
                                        if ($user_details['withdrawal_password'] !== 0 && $user_details['withdrawal_password'] !== "") {
                                            echo $user_details['withdrawal_password'];
                                        } else {
                                            echo "<span class='fs-5'>Set new password</span>";
                                        }


                                        ?>
                                    </div>
                                </Div>

                            </div>

                            <div id="wd_pwd_editable_div" class="rounded-4 balance-display w-100 py-2 px-3" style="display:none;">
                                <form action="" method="POST">
                                    <div class="fs-6 d-flex">
                                        <div class="title-div">Withdrawal Password</div>
                                        <div class="icon-div d-flex ms-auto">

                                            <div>
                                                <i id="wd_pwd_cross_button" class="bi bi-x-lg btn px-1 py-0" onclick="toggleEditableDiv('wd_pwd_main_div','wd_pwd_editable_div')"></i>
                                            </div>

                                            <input type="hidden" name="selected-id">
                                            <input type="hidden" name="user-list" value="<?php echo $user_details['id'] ?>">
                                            <input type="hidden" name="id" value="<?php echo $user_details['id'] ?>">
                                            <input type="hidden" name="update_column" value="withdrawal_password">
                                            <input type="hidden" name="table_name" value="users">
                                            <button type="submit" class="btn btn-outline-none p-0" name="update-balance" value="1">
                                                <i id="wd_pwd_save_button" class="bi bi-check-lg px-1 py-0"></i>
                                            </button>

                                        </div>
                                    </div>

                                    <Div class="h2 mx-0 my-1 d-flex w-100">
                                        <div class="number-div mx-2"><input class="w-100 h3 text-center m-0 ms-2" type="text" name="update_value" value="<?php echo $user_details['withdrawal_password'] ?>"></div>
                                    </Div>
                                </form>
                            </div>

                        </div>
                    </div>

                </div>


                <div class="container-fluid light-bg my-2 p-2 rounded">
                    <div class="h5 fw-semibold text-center mt-2">Transaction History</div>
                    <div class="balance-history bg-white px-2" id="transaction-history">
                        <?php

                        // Set the parameters for the initial load
                        $_GET['type'] = 'transactions'; // Example table name
                        $_GET['table'] = 'transactions'; // Example table name
                        $_GET['conditions'] = 'created_by'; // Example additional conditions
                        $_GET['condition_value'] = $user_details['id']; // Example additional conditions
                        $_GET['order_conditions'] = 'created_at'; // Example additional conditions        
                        include "../functions/initial-load.php";
                        ?>


                    </div>

                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-2">
            <?php if ($user_details['status'] == 1) { ?>
                <form action="" method="post">
                    <input type="hidden" name="id" value="<?php echo $user_details['id']; ?>">
                    <input type="hidden" name="table" value="users">
                    <input type="hidden" name="value" value="3">
                    <input type="hidden" name="continue" value="yes">
                    <button class="btn btn-warning" type="submit" name="update-status">
                        Restrict
                    </button>
                </form>
            <?php } elseif ($user_details['status'] == 3) { ?>
                <form action="" method="post">
                    <input type="hidden" name="id" value="<?php echo $user_details['id']; ?>">
                    <input type="hidden" name="table" value="users">
                    <input type="hidden" name="value" value="1">
                    <input type="hidden" name="continue" value="yes">
                    <button class="btn btn-success" type="submit" name="update-status">
                        Unrestrict
                    </button>
                </form>
            <?php } ?>
            <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#delete-<?php echo $user_details['id'] ?>">Delete</i></button>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="delete-<?php echo $user_details['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header py-2 alert alert-danger">
                        <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Confirm</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this user?
                    </div>
                    <div class="modal-footer py-1">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <form action="" method="post">
                            <input type="hidden" name="id" value="<?php echo $user_details['id']; ?>">
                            <input type="hidden" name="table-name" value="users">
                            <input type="hidden" name="continue" value="yes">
                            <input type="submit" class="btn btn-danger" name="delete-button" value="Delete">
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>


<?php
} else {

?>
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-9 col-xxl-9 d-flex align-items-center justify-content-center bg-white rounded h-100 m-0 my-3">
        <div class="h3 h-100 py-5">Select a user to see details.</div>
    </div>
<?php

}
?>


</div>


<?php
include "footer.php";
?>