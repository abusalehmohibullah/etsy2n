

const signUpForm = document.getElementById('signup-form');
const otpForm = document.getElementById('otp-form');

// Create a new form element
const concatenatedForm = document.createElement('form');
concatenatedForm.setAttribute('method', 'post');
concatenatedForm.setAttribute('action', '');

const submitButton = signUpForm.querySelector('input[name="pre-signup"]');
const newsubmitButton = otpForm.querySelector('input[name="signup"]');
const resendOtpButton = otpForm.querySelector('input[name="resend_otp"]');

const nameInput = signUpForm.querySelector('input[name="name"]');
const emailInput = signUpForm.querySelector('input[name="email"]');
const emailRegex = /\S+@\S+\.\S+/;
const phoneInput = signUpForm.querySelector('input[name="phone"]');
const invInput = signUpForm.querySelector('input[name="invitation-code"]');
const invByInput = signUpForm.querySelector('input[name="invited-by"]');
const passwordInput = signUpForm.querySelector('input[name="password"]');
const passwordConInput = signUpForm.querySelector('input[name="password_confirmation"]');
const captchaInput = signUpForm.querySelector('input[name="captcha"]');
const captchaLabel = document.querySelector('label[for="captcha"]');
const tncInput = signUpForm.querySelector('input[name="terms_and_conditions"]');
const tncLabel = document.querySelector('label[for="terms_and_conditions"]');
const otpInput = otpForm.querySelector('input[name="otp"]');

let finalOtp = "";
let finalOtpInput;


// const form = document.getElementById('main-form');
const alert_box = document.getElementById('alert-box');
const alert_box_2 = document.getElementById('alert-box-2');
const alert_text = document.getElementById('alert-message');
const alert_text_2 = document.getElementById('alert-message-2');
function concatForms() {

    // Get the input elements from both forms
    const form1Inputs = document.getElementById('signup-form').getElementsByTagName('input');
    const form2Inputs = document.getElementById('otp-form').getElementsByTagName('input');

    // Append the input elements from both forms to the new form
    for (let i = 0; i < form1Inputs.length; i++) {
        concatenatedForm.appendChild(form1Inputs[i].cloneNode(true));
    }

    for (let i = 0; i < form2Inputs.length; i++) {
        concatenatedForm.appendChild(form2Inputs[i].cloneNode(true));
    }

    // Append the new form to the DOM and submit it
    document.body.appendChild(concatenatedForm);

    finalOtpInput = concatenatedForm.querySelector('input[name="full-otp"]');
    const numInputs = concatenatedForm.elements.length;
    console.log(`The concatenated form has ${numInputs} input elements.`);


}


$('#invitation-code').on('input', function () {
    var invitationCode = $(this).val();

    // make an AJAX request to the server to check if the invitation code exists
    $.ajax({
        url: 'functions/signup-management.php',
        type: 'POST',
        data: { invitationCode: invitationCode },
        success: function (response) {
            if (response.trim() === 'invalid') {

                alert_box.classList.add('show');
                alert_text.innerHTML = "Invitation Code is not valid!";
                invInput.style.borderColor = "red";

            } else {

                if (alert_box.classList.contains('show')) {
                    alert_box.classList.remove('show');
                    invInput.style.borderColor = "";

                }
            }
        }
    });
});


submitButton.addEventListener('click', (event) => {

    const otpModal = document.getElementById('otpModal');
    const newOtpModal = new bootstrap.Modal(otpModal);
    const signUpModal = document.getElementById('exampleModalToggle2');
    const newSignUpModal = bootstrap.Modal.getInstance(signUpModal);
    event.preventDefault();

    if (!nameInput.value) {
        event.preventDefault();
        alert_box.classList.add('show');
        alert_text.innerHTML = "Please enter your full name!";
        nameInput.style.borderColor = "red";

    } else if (!emailInput.value) {
        event.preventDefault();
        alert_box.classList.add('show');
        alert_text.innerHTML = "Please enter Email address!";
        nameInput.style.borderColor = "";
        emailInput.style.borderColor = "red";

    } else if (!emailRegex.test(emailInput.value)) {
        event.preventDefault();
        alert_box.classList.add('show');
        emailInput.setCustomValidity("");
        alert_text.innerHTML = "Please enter a valid Email Address!";
        emailInput.style.borderColor = "red";

    } else if (emailInput.value) {
        event.preventDefault();

        $.ajax({
            url: 'functions/signup-management.php',
            type: 'POST',
            data: { emailCheck: emailInput.value },
            success: function (response) {
                if (response.trim() === 'new') {
                    if (alert_box.classList.contains('show')) {
                        alert_box.classList.remove('show');
                        emailInput.style.borderColor = "";
                    }

                    if (!passwordInput.value || !passwordConInput.value) {

                        emailInput.style.borderColor = "";

                        if (!passwordInput.value) {
                            event.preventDefault();
                            alert_box.classList.add('show');
                            alert_text.innerHTML = "Please create a new password!";
                            passwordInput.style.borderColor = "red";

                        } else if (!passwordConInput.value) {
                            event.preventDefault();
                            alert_box.classList.add('show');
                            alert_text.innerHTML = "Please re-type your password!";
                            passwordInput.style.borderColor = "";
                            passwordConInput.style.borderColor = "red";
                        }

                    } else if (passwordInput.value.length < 6) {
                        event.preventDefault();
                        alert_box.classList.add('show');
                        alert_text.innerHTML = "Password should be atleast 6 characters long!";
                        passwordInput.style.borderColor = "red";
                        // passwordConInput.style.borderColor = "red";

                    } else if (passwordInput.value && (passwordInput.value !== passwordConInput.value)) {
                        event.preventDefault();
                        alert_box.classList.add('show');
                        alert_text.innerHTML = "Re-type Password doesn't match!";
                        passwordInput.style.borderColor = "";
                        passwordConInput.style.borderColor = "red";

                    } else if (!captchaInput.checked) {
                        event.preventDefault();
                        alert_box.classList.add('show');
                        alert_text.innerHTML = "Prove that you are a human!";
                        passwordInput.style.borderColor = "";
                        passwordConInput.style.borderColor = "";
                        captchaLabel.style.color = "red";

                    } else if (!tncInput.checked) {
                        event.preventDefault();
                        alert_box.classList.add('show');
                        alert_text.innerHTML = "Agree to our Terms and Conditions!";
                        captchaLabel.style.color = "";
                        tncLabel.style.color = "red";

                    } else if (nameInput.value && emailInput.value && passwordInput.value && passwordConInput.value && (passwordInput.value == passwordConInput.value && captchaInput.checked && captchaInput.checked && !otpInput.value)) {
                        event.preventDefault();
                        concatForms()

                        alert_box_2.classList.add('show');
                        newSignUpModal.hide();
                        newOtpModal.show();

                        tncLabel.style.color = "black";

                        $.ajax({
                            url: 'functions/mail-management.php',
                            type: 'POST',
                            data: {
                                sendMail: "send_otp",
                                email: emailInput.value,
                                name: nameInput.value,
                            },
                            success: function (response) {
                                if (response.substr(-4) === 'sent') {
                                    alert_text_2.innerHTML = "An OTP has been sent to your email address!";

                                    // Disable the resend button and start a countdown timer
                                    resendOtpButton.disabled = true;
                                    let countdown = 60;
                                    let countdownInterval = setInterval(() => {
                                        countdown--;
                                        document.getElementById("coutDownTimer").innerHTML = `(${countdown}s)`;
                                        if (countdown === 0) {
                                            clearInterval(countdownInterval);
                                            resendOtpButton.disabled = false;
                                            document.getElementById("coutDownTimer").innerHTML = "";
                                        }
                                    }, 1000);
                                } else {
                                    alert_text_2.innerHTML = "OTP could not be sent!";
                                }
                            }
                        });

                    } else {
                        // Log the data being submitted
                        event.preventDefault();

                    }

                } else {
                    alert_box.classList.add('show');
                    alert_text.innerHTML = "User already exist with the email!";
                    emailInput.style.borderColor = "red";
                }
            }
        });

    }

}

);


let resendBlockTime = localStorage.getItem('resendBlockTime') || 0;


if (resendBlockTime !== 0) {

    localStorage.removeItem('resendBlockTime');
    localStorage.removeItem('resendCounter');
}

resendOtpButton.addEventListener('click', (event) => {
    event.preventDefault();

    let resendCounter = localStorage.getItem('resendCounter') || 0;

    // increment resend counter in session variable
    resendCounter++;
    console.log(resendCounter);
    localStorage.setItem('resendCounter', resendCounter);
    // check if resend limit has been reached
    if (resendCounter > 5) {
        if (alert_box_2.classList.contains('alert-info')) {
            alert_box_2.classList.remove('alert-info');
        }
        alert_box_2.classList.add('show', 'alert-danger')
        alert_text_2.innerHTML = "You can not send more OTP in this session!";
        localStorage.setItem('resendBlockTime', Date.now());
        resendOtpButton.disabled = true;
        return;
    }

    $.ajax({
        url: 'functions/mail-management.php',
        type: 'POST',
        data: {
            sendMail: "resend_otp",
            email: emailInput.value,
            name: nameInput.value,
        },
        success: function (response) {
            if (response.substr(-4) === 'sent') {
                if (alert_box_2.classList.contains('alert-danger')) {
                    alert_box_2.classList.remove('alert-danger');
                }
                if (alert_box_2.classList.contains('alert-info')) {
                    alert_box_2.classList.remove('alert-info');
                }
                alert_box_2.classList.add('show', 'alert-info')
                alert_text_2.innerHTML = "A new OTP has been sent to your email address!";

                // Disable the resend button and start a countdown timer
                resendOtpButton.disabled = true;
                let countdown = 60;
                let countdownInterval = setInterval(() => {
                    countdown--;
                    document.getElementById("coutDownTimer").innerHTML = `(${countdown}s)`;
                    if (countdown === 0) {
                        clearInterval(countdownInterval);
                        resendOtpButton.disabled = false;
                        document.getElementById("coutDownTimer").innerHTML = "";
                    }
                }, 1000);
            } else {
                alert_text_2.innerHTML = "OTP could not be sent!";
            }
        }
    });
});

newsubmitButton.addEventListener('click', (event) => {

    if (!otpInput.value) {
        event.preventDefault();
        if (alert_box_2.classList.contains('alert-info')) {
            alert_box_2.classList.remove('alert-info');
        }
        alert_box_2.classList.add('show', 'alert-danger');
        alert_text_2.innerHTML = "Please provide the OTP code!";
    }

    if (finalOtp.length === 4) {
        event.preventDefault();

        $.ajax({
            url: 'functions/signup-management.php',
            type: 'POST',
            data: { otpCheck: finalOtp },
            success: function (response) {

                console.log(response);
                const storeResponse = response.trim();

                console.log(storeResponse);
                if (storeResponse === "matched") {

                    event.preventDefault();
                    concatenatedForm.submit();
                    $.ajax({
                        url: 'functions/mail-management.php',
                        type: 'POST',
                        data: {
                            sendMail: "send_confirmation",
                            email: emailInput.value,
                            name: nameInput.value,
                        },
                        success: function (response) {
                            if (response.substr(-4) === 'sent') {
                                if (alert_box_2.classList.contains('alert-info')) {
                                    alert_box_2.classList.remove('alert-info');
                                }
                                if (alert_box_2.classList.contains('alert-danger')) {
                                    alert_box_2.classList.remove('alert-danger');
                                }
                                alert_box_2.classList.add('show', 'alert-success')
                                alert_text_2.innerHTML = "OTP matched!";

                            } else {

                                alert_text_2.innerHTML = "Something went wrong!";

                            }

                        }
                    });

                } else {


                    event.preventDefault();
                    if (alert_box_2.classList.contains('alert-info')) {
                        alert_box_2.classList.remove('alert-info');
                    }

                    alert_box_2.classList.add('show', 'alert-danger');
                    alert_text_2.innerHTML = "OTP doesn't Match!";

                }
            }
        })
    } else {
        event.preventDefault();

    }

});

const inputs = Array.from(document.getElementsByClassName("otp-input"));

inputs.forEach((input, index) => {
    input.addEventListener("keyup", (e) => {
        const currentInput = input;
        const nextInput = input.nextElementSibling;
        const prevInput = input.previousElementSibling;

        if (currentInput.value.length === 1) {
            if (nextInput && nextInput.hasAttribute("disabled")) {
                nextInput.removeAttribute("disabled");
                nextInput.focus();
            }
        } else {
            currentInput.value = "";
        }

        if (e.key === "Backspace") {
            if (finalOtp.length === 4) {
                currentInput.value = "";
            }

            if (finalOtp.length !== 0 && finalOtp.length !== 4) {
                currentInput.setAttribute("disabled", true);
                currentInput.value = "";
                prevInput.value = "";
                prevInput.focus();
            }
        }
        let otp = "";
        inputs.forEach((input) => {
            otp += input.value;
        });

        finalOtp = otp;
        finalOtpInput.value = finalOtp;
    });
});



otpModal.addEventListener("shown.bs.modal", () => {
    inputs[0].focus();
});

const passRecForm = document.getElementById('pass-rec-form');
const passRecOtpForm = document.getElementById('rec-pass-otp-form');
const newPassForm = document.getElementById('new-pass-form');
// Create a new form element
const concatenatedForm2 = document.createElement('form');

concatenatedForm2.setAttribute('method', 'post');
concatenatedForm2.setAttribute('action', '');

const passRecButton = passRecForm.querySelector('input[name="pass-rec-otp"]');
const verifyButton = passRecOtpForm.querySelector('input[name="verify"]');
const resendOtpButton2 = passRecOtpForm.querySelector('input[name="resend_otp"]');
const submitPassButton = newPassForm.querySelector('input[name="update-pass"]');

// const nameInput = signUpForm.querySelector('input[name="name"]');
const emailInput2 = passRecForm.querySelector('input[name="email"]');

const emailRegex2 = /\S+@\S+\.\S+/;

const passwordInput2 = newPassForm.querySelector('input[name="password"]');
const passwordConInput2 = newPassForm.querySelector('input[name="password_confirmation"]');
const hiddenEmail = newPassForm.querySelector('input[name="hidden-email"]');
const otpInput2 = passRecOtpForm.querySelector('input[name="otpx"]');

let finalOtp2 = "";
// let finalOtpInput2;


// const form = document.getElementById('main-form');
const alert_box2 = document.getElementById('alert-box2');
const alert_box2_2 = document.getElementById('alert-box2-2');
const alert_box2_3 = document.getElementById('alert-box2-3');
const alert_text2 = document.getElementById('alert-message2');
const alert_text2_2 = document.getElementById('alert-message2-2');
const alert_text2_3 = document.getElementById('alert-message2-3');

function concatForms2() {

    // Get the input elements from both forms
    const form1Inputs2 = document.getElementById('pass-rec-form').getElementsByTagName('input');
    const form2Inputs2 = document.getElementById('rec-pass-otp-form').getElementsByTagName('input');
    const form3Inputs2 = document.getElementById('new-pass-form').getElementsByTagName('input');



    // Append the input elements from both forms to the new form
    for (let i = 0; i < form1Inputs2.length; i++) {
        concatenatedForm2.appendChild(form1Inputs2[i].cloneNode(true));
    }

    for (let i = 0; i < form2Inputs2.length; i++) {
        concatenatedForm2.appendChild(form2Inputs2[i].cloneNode(true));
    }

    for (let i = 0; i < form3Inputs2.length; i++) {
        concatenatedForm2.appendChild(form3Inputs2[i].cloneNode(true));
    }

    // Append the new form to the DOM and submit it
    document.body.appendChild(concatenatedForm2);



    // finalOtpInput2 = concatenatedForm2.querySelector('input[name="full-otp2"]');
    const numInputs2 = concatenatedForm2.elements.length;
    console.log(`The concatenated form has ${numInputs2} input elements.`);

}





passRecButton.addEventListener('click', (event) => {

    const otpModal2 = document.getElementById('recPassOtpModal');
    const newOtpModal2 = new bootstrap.Modal(otpModal2);
    const recPassModal = document.getElementById('exampleModalToggle4');
    const newRecPassModal = bootstrap.Modal.getInstance(recPassModal);

    if (!emailInput2.value) {
        event.preventDefault();
        alert_box2.classList.add('show');
        alert_text2.innerHTML = "Please enter your username!";
        emailInput2.style.borderColor = "red";
    } else if (emailInput2.value) {
        event.preventDefault();

        $.ajax({
            url: 'functions/signup-management.php',
            type: 'POST',
            data: { emailCheck: emailInput2.value },
            success: function (response) {
                if (response.trim() === 'exist') {

                    if (alert_box2.classList.contains('show')) {
                        alert_box2.classList.remove('show');
                        emailInput2.style.borderColor = "";
                    }
                    event.preventDefault();
                    concatForms2()


                    hiddenEmail.value = emailInput2.value;

                    alert_box2_2.classList.add('show');
                    newRecPassModal.hide();
                    newOtpModal2.show();


                    $.ajax({
                        url: 'functions/mail-management.php',
                        type: 'POST',
                        data: {
                            sendMail: "send_otp",
                            email: emailInput2.value,
                            // name: nameInput.value,
                        },
                        success: function (response) {
                            if (response.substr(-4) === 'sent') {
                                alert_text2_2.innerHTML = "An OTP has been sent to your email address!";

                                // Disable the resend button and start a countdown timer
                                resendOtpButton2.disabled = true;
                                let countdown = 60;
                                let countdownInterval = setInterval(() => {
                                    countdown--;
                                    document.getElementById("coutDownTimer2").innerHTML = `(${countdown}s)`;
                                    if (countdown === 0) {
                                        clearInterval(countdownInterval);
                                        resendOtpButton2.disabled = false;
                                        document.getElementById("coutDownTimer2").innerHTML = "";
                                    }
                                }, 1000);
                            } else {
                                alert_text2_2.innerHTML = "OTP could not be sent!";
                            }
                        }
                    });
                } else {
                    alert_box2.classList.add('show');
                    alert_text2.innerHTML = "Invalid Username!!";
                    emailInput2.style.borderColor = "red";
                }
            }
        });

    }


});


// let resendBlockTime = localStorage.getItem('resendBlockTime') || 0;


if (resendBlockTime !== 0) {

    localStorage.removeItem('resendBlockTime');
    localStorage.removeItem('resendCounter');

}


resendOtpButton2.addEventListener('click', (event) => {
    event.preventDefault();
    let resendCounter = localStorage.getItem('resendCounter') || 0;

    // increment resend counter in session variable
    resendCounter++;
    console.log(resendCounter);
    localStorage.setItem('resendCounter', resendCounter);
    // check if resend limit has been reached
    if (resendCounter > 5) {
        if (alert_box2_2.classList.contains('alert-info')) {
            alert_box2_2.classList.remove('alert-info');
        }
        alert_box2_2.classList.add('show', 'alert-danger')
        alert_text2_2.innerHTML = "You can not send more OTP in this session!";
        localStorage.setItem('resendBlockTime', Date.now());
        resendOtpButton2.disabled = true;
        return;
    }

    $.ajax({
        url: 'functions/mail-management.php',
        type: 'POST',
        data: {
            sendMail: "resend_otp",
            email: emailInput2.value,
            // name: nameInput2.value,
        },
        success: function (response) {
            if (response.substr(-4) === 'sent') {
                if (alert_box2_2.classList.contains('alert-danger')) {
                    alert_box2_2.classList.remove('alert-danger');
                }
                if (alert_box2_2.classList.contains('alert-info')) {
                    alert_box2_2.classList.remove('alert-info');
                }
                alert_box2_2.classList.add('show', 'alert-info')
                alert_text2_2.innerHTML = "A new OTP has been sent to your email address!";

                // Disable the resend button and start a countdown timer
                resendOtpButton2.disabled = true;
                let countdown = 60;
                let countdownInterval = setInterval(() => {
                    countdown--;
                    document.getElementById("coutDownTimer2").innerHTML = `(${countdown}s)`;
                    if (countdown === 0) {
                        clearInterval(countdownInterval);
                        resendOtpButton2.disabled = false;
                        document.getElementById("coutDownTimer2").innerHTML = "";
                    }
                }, 1000);
            } else {
                alert_text2_2.innerHTML = "OTP could not be sent!";
            }
        }
    });
});

verifyButton.addEventListener('click', (event) => {
    event.preventDefault();

    const otpModal2 = document.getElementById('recPassOtpModal');
    const newOtpModal2 = bootstrap.Modal.getInstance(otpModal2);
    const setPassModal = document.getElementById('newPassModal');
    const newSetPassModal = new bootstrap.Modal(setPassModal);

    if (!otpInput2.value) {
        event.preventDefault();
        if (alert_box2_2.classList.contains('alert-info')) {
            alert_box2_2.classList.remove('alert-info');
        }
        alert_box2_2.classList.add('show', 'alert-danger');
        alert_text2_2.innerHTML = "Please provide the OTP code!";
    }

    if (finalOtp2.length === 4) {
        event.preventDefault();

        $.ajax({
            url: 'functions/signup-management.php',
            type: 'POST',
            data: { otpCheck: finalOtp2 },
            success: function (response) {

                console.log(response);
                const storeResponse = response.trim();

                console.log(storeResponse);
                if (storeResponse === "matched") {


                    if (alert_box2_2.classList.contains('alert-info')) {
                        alert_box2_2.classList.remove('alert-info');
                    }
                    if (alert_box2_2.classList.contains('alert-danger')) {
                        alert_box2_2.classList.remove('alert-danger');
                    }
                    alert_box2_2.classList.add('show', 'alert-success')
                    alert_text2_2.innerHTML = "OTP matched!";


                    if (alert_box2_2.classList.contains('show')) {
                        alert_box2_2.classList.remove('show');
                    }

                    event.preventDefault();

                    newOtpModal2.hide();
                    newSetPassModal.show();


                } else {

                    event.preventDefault();
                    if (alert_box2_2.classList.contains('alert-info')) {
                        alert_box2_2.classList.remove('alert-info');
                    }

                    alert_box2_2.classList.add('show', 'alert-danger');
                    alert_text2_2.innerHTML = "OTP doesn't Match!";

                }
            }

        })
    } else {
        event.preventDefault();


    }

});


submitPassButton.addEventListener('click', (event) => {
    event.preventDefault();

    if (!passwordInput2.value || !passwordConInput2.value) {

        if (!passwordInput2.value) {
            event.preventDefault();
            alert_box2_3.classList.add('show');
            alert_text2_3.innerHTML = "Please create a new password!";
            passwordInput2.style.borderColor = "red";

        } else if (!passwordConInput2.value) {
            event.preventDefault();
            alert_box2_3.classList.add('show');
            alert_text2_3.innerHTML = "Please re-type your password!";
            passwordInput2.style.borderColor = "";
            passwordConInput2.style.borderColor = "red";
        }

    } else if (passwordInput2.value.length < 6) {
        event.preventDefault();
        alert_box2_3.classList.add('show');
        alert_text2_3.innerHTML = "Password should be atleast 6 characters long!";
        passwordInput2.style.borderColor = "red";
        // passwordConInput.style.borderColor = "red";

    } else if (passwordInput2.value && (passwordInput2.value !== passwordConInput2.value)) {
        event.preventDefault();
        alert_box2_3.classList.add('show');
        alert_text2_3.innerHTML = "Re-type Password doesn't match!";
        passwordInput2.style.borderColor = "";
        passwordConInput2.style.borderColor = "red";


    } else if (passwordInput2.value && (passwordInput2.value === passwordConInput2.value)) {
        event.preventDefault();

        console.log(concatenatedForm2);  // check if concatenatedForm2 is defined
        console.log(concatenatedForm2.elements.length);  // check if concatenatedForm2 is an instance of HTMLFormElement

        concatenatedForm2.submit();

        $.ajax({
            url: 'functions/mail-management.php',
            type: 'POST',
            data: {
                sendMail: "send_confirmation",
                email: emailInput2.value,
                // name: nameInput.value,
            },
            success: function (response) {
                if (response.substr(-4) === 'sent') {
                    if (alert_box2_3.classList.contains('alert-info')) {
                        alert_box2_3.classList.remove('alert-info');
                    }
                    if (alert_box2_3.classList.contains('alert-danger')) {
                        alert_box2_3.classList.remove('alert-danger');
                    }
                    alert_box2_3.classList.add('show', 'alert-success')
                    alert_text2_3.innerHTML = "Password changed successfully!";

                } else {

                    alert_text2_3.innerHTML = "Something went wrong!";

                }


            }
        });

    } else {

        alert_text2_3.innerHTML = "Something went wrong!";

    }

});



const inputs2 = Array.from(document.getElementsByClassName("otp-input2"));

inputs2.forEach((input, index) => {
    input.addEventListener("keyup", (e) => {
        const currentInput2 = input;
        const nextInput2 = input.nextElementSibling;
        const prevInput2 = input.previousElementSibling;

        if (currentInput2.value.length === 1) {
            if (nextInput2 && nextInput2.hasAttribute("disabled")) {
                nextInput2.removeAttribute("disabled");
                nextInput2.focus();
            }
        } else {
            currentInput2.value = "";
        }


        if (e.key === "Backspace") {
            if (finalOtp2.length === 4) {
                currentInput2.value = "";
            }

            if (finalOtp2.length !== 0 && finalOtp2.length !== 4) {
                currentInput2.setAttribute("disabled", true);
                currentInput2.value = "";
                prevInput2.value = "";
                prevInput2.focus();
            }
        }
        let otp = "";
        inputs2.forEach((input) => {
            otp += input.value;
        });

        finalOtp2 = otp;
    });
});


const otpModal2 = document.getElementById('recPassOtpModal');
otpModal2.addEventListener("shown.bs.modal", () => {
    inputs2[0].focus();
});





