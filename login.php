<?php

// takes url and see which page it is 
$category_explode = explode("/", $_SERVER['REQUEST_URI']);
$page_name = $category_explode[count($category_explode) - 1];


if ($page_name !== "index.php" && $page_name !== "index.php?invited-by=" . $_GET['invited-by'] && $page_name !== "index.php?repeat-user=yes" && $page_name !== "index.php?invited-by=" . $_GET['invited-by'] . "&repeat-user=yes") {
    header("Location: index.php");
    exit;
}

$invited_by = "";
if (isset($_GET['invited-by'])) {
    $invited_by = $_GET['invited-by'];
}

$welcomeMsg = "Welcome!";
if (isset($_GET['repeat-user'])) {
    $welcomeMsg = "Welcome Back!";
}


$privacy_policy =  htmlspecialchars_decode($language_data['privacy_policy_contents'])
?>




<!-- log in modal  -->

<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl ">
        <div class="modal-content ">

            <div class="modal-body p-0 rounded-1">

                <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close"></button>

                <div class="row container-fluid h-100 p-0 m-0">

                    <div class="hidden-half col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 d-flex flex-column justify-content-center align-items-center gap-5 p-0 m-0">
                        <div class="text-center">
                            <div class="h3 fw-bold">Let's grow</div>
                            <div class="h1 fw-bold">TOGETHER!</div>

                        </div>
                        <img src="./assets/images/login-bg.png" alt="" class="w-75 mt-5">
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 light-bg row d-flex rounded justify-content-center align-items-center p-0 m-0">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-11 col-xxl-11 rounded-5 py-4 px-5">
                            <div class="d-flex flex-column justify-content-center align-items-center w-100">
                                <img src="./assets/images/profile-pictures/profile.png" alt="" class="w-50">
                            </div>
                            <h2 class="text-center mb-5 fw-bold"><?php echo $welcomeMsg ?></h2>
                            <?php show_message_admin(); ?>
                            <form action="" method="POST">
                                <div class="mb-3">
                                    <input type="text" class="form-control text-center fs-4" id="user_name" placeholder="Username" name="user_name" required>
                                </div>
                                <div class="mb-3">
                                    <input type="password" class="form-control text-center fs-4" id="password" placeholder="Password" name="password" required>
                                </div>
                                <div class="d-flex mb-3 form-check w-100">
                                    <input class="form-check-input pe-2 login-small-text" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label ps-2 login-small-text" for="remember"> Keep me logged in</label>

                                    <div class="ms-auto login-small-text" data-bs-target="#exampleModalToggle4" data-bs-toggle="modal">
                                        <a href="#">Forgot password?</a>
                                    </div>
                                </div>
                                <input type="hidden" name="table" value="users">
                                <input type="submit" class="btn btn-lg deep-bg w-100 my-2" name="login" value="Login">
                                <div class="text-center">Or</div>
                                <input type="button" class="btn btn-lg btn-outline-secondary w-100 my-2" name="login" value="Sign Up" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">

                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>





<!-- recover Pass modal  -->
<div class="modal fade" id="exampleModalToggle4" aria-hidden="true" aria-labelledby="exampleModalToggleLabel4" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl ">
        <div class="modal-content ">

            <div class="modal-body p-0 rounded-1">

                <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close"></button>

                <div class="row container-fluid h-100 p-0 m-0">

                    <div class="hidden-half col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 d-flex flex-column justify-content-center align-items-center gap-5 p-0 m-0">
                        <div class="text-center">
                            <div class="h3 fw-bold">Let's grow</div>
                            <div class="h1 fw-bold">TOGETHER!</div>

                        </div>
                        <img src="./assets/images/login-bg.png" alt="" class="w-75 mt-5">
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 light-bg row d-flex rounded justify-content-center align-items-center p-0 m-0">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-11 col-xxl-11 rounded-5 py-4 px-5 text-center">
                            <h2 class="text-center mb-5 fw-bold">Recover password</h2>

                            <h5>Verify your identity and reset your password!</h5>
                            <?php show_message_admin(); ?>
                            <div class="alert alert-danger pop_up_message alert-dismissible fade" id="alert-box2">

                                <strong id="alert-message2"></strong>
                            </div>
                            <form action="" method="POST" id="pass-rec-form">
                                <div class="mb-3">
                                    <input type="email" class="form-control text-center fs-4" id="rec-email" placeholder="Email Address" name="email" required>
                                </div>

                                <input type="submit" class="btn btn-lg deep-bg w-100 my-2" name="pass-rec-otp" value="Request OTP">
                                <div class="d-flex mb-3 form-check w-100">

                                </div>

                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>


<!-- OTP modal  recover id-->
<div class="modal fade" id="recPassOtpModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" aria-labelledby="exampleModalToggleLabel4" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">

            <div class="modal-body p-0 rounded-1">

                <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close"></button>


                <div class="row container-fluid h-100 p-0 m-0">

                    <div class="hidden-half col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 d-flex flex-column justify-content-center align-items-center gap-5 p-0 m-0 my-5">
                        <div class="text-center">
                            <div class="h3 fw-bold">Let's grow</div>
                            <div class="h1 fw-bold">TOGETHER!</div>

                        </div>
                        <img src="./assets/images/login-bg.png" alt="" class="w-75 mt-3">
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 light-bg row d-flex rounded justify-content-center align-items-center p-0 m-0">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-11 col-xxl-11 rounded-5 py-4 px-5">
                            <form id="rec-pass-otp-form" action="" method="POST">
                                <h2 class="text-center fw-bold my-5">OTP Verification</h2>
                                <?php show_message_admin(); ?>
                                <div class="alert alert-info pop_up_message alert-dismissible fade" id="alert-box2-2">

                                    <strong id="alert-message2-2"></strong>
                                </div>

                                <div class="container mb-3">
                                    <div class="input-field d-flex gap-2 w-100 justify-content-center align-items-center">
                                        <input type="hidden" name="full-otp2" id="full-otp2">
                                        <input class="form-control form-control-lg w-100 text-center otp-input2" type="number" name="otpx" maxlength="1" pattern="\d+" />
                                        <input class="form-control form-control-lg w-100 text-center otp-input2" type="number" name="otp2x" disabled maxlength="1" pattern="\d+" />
                                        <input class="form-control form-control-lg w-100 text-center otp-input2" type="number" name="otp3x" disabled maxlength="1" pattern="\d+" />
                                        <input class="form-control form-control-lg w-100 text-center otp-input2" type="number" name="otp4x" disabled maxlength="1" pattern="\d+" />
                                    </div>
                                </div>

                                <input type="submit" class="btn btn-lg deep-bg w-100 my-3" id="verify" name="verify" value="Verify">
                                <div class="d-flex justify-content-center align-items-center gap-1">Didn't get the OTP? <input class="btn btn-link fw-semibold p-0" name="resend_otp" type="submit" value="Resend"><span id=coutDownTimer2></span></div>
                            </form>
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
</div>

<!-- Set new pass modal-->
<div class="modal fade" id="newPassModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel4" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">

            <div class="modal-body p-0 rounded-1">

                <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close"></button>


                <div class="row container-fluid h-100 p-0 m-0">

                    <div class="hidden-half col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 d-flex flex-column justify-content-center align-items-center gap-5 p-0 m-0 my-5">
                        <div class="text-center">
                            <div class="h3 fw-bold">Let's grow</div>
                            <div class="h1 fw-bold">TOGETHER!</div>

                        </div>
                        <img src="./assets/images/login-bg.png" alt="" class="w-75 mt-3">
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 light-bg row d-flex rounded justify-content-center align-items-center p-0 m-0">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-11 col-xxl-11 rounded-5 py-4 px-5">
                            <form id="new-pass-form" action="" method="POST">
                                <h2 class="text-center fw-bold my-5">Set new password</h2>
                                <?php show_message_admin(); ?>
                                <div class="alert alert-info pop_up_message alert-dismissible fade" id="alert-box2-3">

                                    <strong id="alert-message2-3"></strong>
                                </div>

                                <div class="mb-3">
                                    <input type="password" class="form-control text-center fs-4" id="reset-password" placeholder="Password" name="password">
                                </div>
                                <div class="mb-3">
                                    <input type="password" class="form-control text-center fs-4" id="reset-password-confirmation" placeholder="Re-type Password" name="password_confirmation">
                                </div>
                                <input type="hidden" name="table" value="users">


                                <input type="hidden" name="hidden-email">
                                <input type="hidden" name="update-pass" value="update-pass">
                                <input type="submit" class="btn btn-lg deep-bg w-100 my-3" id="submit" name="update-pass" value="Submit">

                            </form>
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
</div>




<!-- sign up modal  -->
<div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">

            <div class="modal-body p-0 rounded-1">

                <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close"></button>


                <div class="row container-fluid h-100 p-0 m-0">

                    <div class="hidden-half col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 d-flex flex-column justify-content-center align-items-center gap-5 p-0 m-0">
                        <div class="text-center">
                            <div class="h3 fw-bold">Let's grow</div>
                            <div class="h1 fw-bold">TOGETHER!</div>

                        </div>
                        <img src="./assets/images/login-bg.png" alt="" class="w-75 mt-5">
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 light-bg row d-flex rounded justify-content-center align-items-center p-0 m-0">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-11 col-xxl-11 rounded-5 py-4 px-5">

                            <h2 class="text-center fw-bold">Sign Up</h2>
                            <?php show_message_admin(); ?>

                            <div class="alert alert-danger pop_up_message alert-dismissible fade" id="alert-box">

                                <strong id="alert-message"></strong>
                            </div>
                            <form id="signup-form" action="" method="POST">
                                <div class="mb-3">
                                    <input type="text" class="form-control text-center fs-4" id="name" placeholder="Full Name" name="name">
                                </div>
                                <div class="mb-3">
                                    <input type="email" class="form-control text-center rounded fs-4" id="signup-email" placeholder="Email Address" name="email">
                                </div>
                                <div class="mb-3">
                                    <input type="number" class="form-control text-center rounded fs-4" id="phone" placeholder="Phone Number (Optional)" name="phone">
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control text-center rounded fs-4" id="invitation-code" placeholder="Invitation Code (Optional)" name="invited-by" value="<?php echo $invited_by ?>">
                                </div>
                                <div class="mb-3">
                                    <input type="password" class="form-control text-center fs-4" id="signup-password" placeholder="Password" name="password">
                                </div>
                                <div class="mb-3">
                                    <input type="password" class="form-control text-center fs-4" id="signup-password-confirmation" placeholder="Re-type Password" name="password_confirmation">
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="captcha" id="captcha">
                                    <label class="form-check-label" for="captcha">I am a human</label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="terms_and_conditions" id="terms_and_conditions">
                                    <label class="form-check-label" for="terms_and_conditions">
                                        I agree to the
                                    </label>
                                    <span class="fw-semibold" type="button" data-bs-target="#exampleModalToggle3" data-bs-toggle="modal">
                                        <u>Terms of Use</u>
                                    </span>
                                </div>
                                <input type="hidden" name="signup" value="signup">

                                <input type="submit" class="btn btn-lg deep-bg w-100 my-3" id="pre-signup" name="pre-signup" value="Sign Up">
                                <div class="text-center">Already have an account? <span class="text-primary fw-semibold" type="button" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Login</span></div>
                            </form>
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
</div>






<!-- OTP modal  signup-->
<div class="modal fade" id="otpModal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalToggleLabel4" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">

            <div class="modal-body p-0 rounded-1">

                <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close"></button>


                <div class="row container-fluid h-100 p-0 m-0">

                    <div class="hidden-half col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 d-flex flex-column justify-content-center align-items-center gap-5 p-0 m-0 my-5">
                        <div class="text-center">
                            <div class="h3 fw-bold">Let's grow</div>
                            <div class="h1 fw-bold">TOGETHER!</div>

                        </div>
                        <img src="./assets/images/login-bg.png" alt="" class="w-75 mt-3">
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 light-bg row d-flex rounded justify-content-center align-items-center p-0 m-0">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-11 col-xxl-11 rounded-5 py-4 px-5">
                            <form id="otp-form" action="" method="POST">
                                <h2 class="text-center fw-bold my-5">OTP Verification</h2>
                                <?php show_message_admin(); ?>
                                <div class="alert alert-info pop_up_message alert-dismissible fade" id="alert-box-2">
                                    <strong id="alert-message-2"></strong>
                                </div>

                                <div class="container mb-3">
                                    <div class="input-field d-flex gap-2 w-100 justify-content-center align-items-center">
                                        <input type="hidden" name="full-otp" id="full-otp">
                                        <input class="form-control form-control-lg w-100 text-center otp-input" type="number" name="otp" maxlength="1" pattern="\d+" />
                                        <input class="form-control form-control-lg w-100 text-center otp-input" type="number" name="otp2" disabled maxlength="1" pattern="\d+" />
                                        <input class="form-control form-control-lg w-100 text-center otp-input" type="number" name="otp3" disabled maxlength="1" pattern="\d+" />
                                        <input class="form-control form-control-lg w-100 text-center otp-input" type="number" name="otp4" disabled maxlength="1" pattern="\d+" />
                                    </div>
                                </div>




                                <input type="submit" class="btn btn-lg deep-bg w-100 my-3" id="signup" name="signup" value="Verify">
                                <div class="d-flex justify-content-center align-items-center gap-1">Didn't get the OTP? <input class="btn btn-link fw-semibold p-0" name="resend_otp" type="submit" value="Resend"><span id=coutDownTimer></span></div>
                            </form>
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
</div>









<!-- TnC modal  -->
<div class="modal fade" id="exampleModalToggle3" aria-hidden="true" aria-labelledby="exampleModalToggleLabel3" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-body p-0 rounded-1">


                <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal"></button>

                <div class="row container-fluid h-100 p-0 m-0">






                    <div class="light-bg p-3 rounded">
                        <h2 class="text-center mb-5 fw-bold">Terms of Use</h2>
                        <div>
                            <?php $rules_and_terms =  htmlspecialchars_decode($language_data['rules_and_terms_contents']) ?>
                            <?php echo $rules_and_terms ?>

                        </div>
                        <div class="mt-5 d-flex align-items-center justify-content-center">
                            <span type="button" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">
                                <input class="form-check-input pe-2" type="checkbox" name="terms_and_conditions" id="terms_and_conditions">
                                <label class="form-check-label ps-2" for="terms_and_conditions">I have read and agree to <u><b>Terms of Use</b></u></label>
                            </span>
                        </div>
                    </div>

                </div>



            </div>
        </div>
    </div>
</div>