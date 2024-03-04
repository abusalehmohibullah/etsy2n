


function changeLanguage(language, url) {
    if (url.indexOf('?') > -1) {
        url = url.split("?")[0];
    }
    window.location.href = url + "?language=" + language;
}




const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));


// Example starter JavaScript for disabling form submissions if there are invalid fields
(() => {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
        }, false)
    })
})()


// Function to set the number of slides to show based on screen size
function setSlidesToShow(xl, lg, md, sm) {
    var windowWidth = $(window).width();

    if (windowWidth >= 1400) {
        return xl;
    } else if (windowWidth >= 992) {
        return lg;
    } else if (windowWidth >= 576) {
        return md;
    } else {
        return sm;
    }
}




var path = window.location.pathname; // Get the path component of the URL
var parts = path.split('/'); // Split the path into an array of parts
var lastPart = parts[parts.length - 1]; // Get the last part of the path

if (lastPart === 'withdraw.php') {

    document.addEventListener('DOMContentLoaded', function () {
        // Get the deposit amount input field
        var msg = document.getElementById('msg-box');
        var withdrawAmountInput = document.getElementById('withdrawal-amount');
        var withdrawStatus = document.getElementById('withdraw-status');
        var availableBalanceInput = document.getElementById('available-balance');
        msg.innerHTML = '';




        // Add an event listener to calculate the interest amount on input change
        withdrawAmountInput.addEventListener('input', function () {

            if (withdrawStatus.value == 2) {
                msg.innerHTML = 'Already made a request!';
                msg.classList.add("alert", "alert-danger");
                $("#fund-withdraw").prop('disabled', true);
                return;
            } else if (availableBalanceInput.value < 1) {
                msg.innerHTML = 'Insufficient Balance!';
                msg.classList.add("alert", "alert-danger");
                availableBalanceInput.classList.add("text-danger");
                $("#fund-withdraw").prop('disabled', true);
            }

            // Get the deposit amount entered by the user
            var withdrawAmount = parseFloat(withdrawAmountInput.value);


            if (withdrawAmount < 1) {

                $("#fund-withdraw").prop('disabled', true);
                return;
            }

            if (availableBalanceInput.value >= 1 && withdrawAmount >= 1 && availableBalanceInput.value >= withdrawAmount) {
                $("#fund-withdraw").prop('disabled', false);
                withdrawAmountInput.classList.remove("text-danger");
                withdrawAmountInput.classList.add("text-success");
            } else {
                $("#fund-withdraw").prop('disabled', true);
                withdrawAmountInput.classList.remove("text-success");
                withdrawAmountInput.classList.add("text-danger");
            }

        });

    });

}



var path = window.location.pathname; // Get the path component of the URL
var parts = path.split('/'); // Split the path into an array of parts
var lastPart = parts[parts.length - 1]; // Get the last part of the path

if (lastPart === 'treasury.php') {

    document.addEventListener('DOMContentLoaded', function () {
        // Get the deposit amount input field
        var rateLevel = document.getElementById('rate-level');
        var msg = document.getElementById('msg-box');
        var depositAmountInput = document.getElementById('deposit-amount');
        var availableBalanceInput = document.getElementById('available-balance');
        msg.innerHTML = '';
        rateLevel.innerHTML = '';

        // Add an event listener to calculate the interest amount on input change
        depositAmountInput.addEventListener('input', function () {

            if (availableBalanceInput.value < 500) {
                msg.innerHTML = 'Insufficient Balance! Minimum amount is $500.';
                msg.classList.add("alert", "alert-danger");
                availableBalanceInput.classList.add("text-danger");
                $("#treasury-deposit").prop('disabled', true);
            }

            // Get the deposit amount entered by the user
            var depositAmount = parseFloat(depositAmountInput.value);
            // Get the interest input field
            var interestInput = document.getElementById('monthly-interest');
            var refundInput = document.getElementById('est-refund');
            // Determine the level based on the deposit amount
            var level;


            if (depositAmount >= 500 && depositAmount <= 999) {
                level = 'Silver';
            } else if (depositAmount >= 1000 && depositAmount <= 9999) {
                level = 'Gold';
            } else if (depositAmount >= 10000 && depositAmount <= 99999) {
                level = 'Platinum';
            } else if (depositAmount >= 100000) {
                level = 'Diamond';
            } else {
                // Deposit amount does not meet the conditions, clear the interest input field
                interestInput.value = '';
                refundInput.value = '';
                $("#treasury-deposit").prop('disabled', true);
                depositAmountInput.classList.remove("text-success");
                depositAmountInput.classList.add("text-danger");
                return;
            }

            if (availableBalanceInput.value >= 500 && depositAmount >= 500 && availableBalanceInput.value >= depositAmount) {
                $("#treasury-deposit").prop('disabled', false);
                depositAmountInput.classList.remove("text-danger");
                depositAmountInput.classList.add("text-success");
            } else {
                $("#treasury-deposit").prop('disabled', true);
                depositAmountInput.classList.remove("text-success");
                depositAmountInput.classList.add("text-danger");
            }

            // Calculate the interest amount based on the level
            var interestRate;
            switch (level) {
                case 'Silver':
                    interestRate = 0.2;
                    break;
                case 'Gold':
                    interestRate = 0.21;
                    break;
                case 'Platinum':
                    interestRate = 0.22;
                    break;
                case 'Diamond':
                    interestRate = 0.25;
                    break;
                default:
                    return;
            }

            rateLevel.innerHTML = 'Calculated by ' + level + ' rate (' + interestRate * 100 + '% Per Month)';

            var interestAmount = depositAmount * interestRate;
            var refundAmount = depositAmount + interestAmount;

            // Update the Monthly Interest field with the calculated amount
            interestInput.value = interestAmount.toFixed(2);

            // Update the Monthly Interest field with the calculated amount
            refundInput.value = refundAmount.toFixed(2);


        });

    });

}


var path = window.location.pathname; // Get the path component of the URL
var parts = path.split('/'); // Split the path into an array of parts
var lastPart = parts[parts.length - 1]; // Get the last part of the path

if (lastPart === 'invite.php') {

    $('#copy-refer').click(function () {
        navigator.clipboard.writeText($('#refer-id').html());
        $('#copy-refer').html("<i class='bi bi-check2'></i>");

        setTimeout(function () {
            $('#copy-refer').html("<i class='fa fa-clone'></i>");
        }, 1000);
    });


    $('#copy-link').click(function () {
        navigator.clipboard.writeText($('#refer-link').html());
        $('#copy-link').html("<i class='bi bi-check2'></i>");

        setTimeout(function () {
            $('#copy-link').html("<i class='fa fa-clone'></i>");
        }, 1000);
    });


    // Add click event listener to the share button
    function inviteFriends(websiteLink) {
        // Check if the Web Share API is supported by the browser
        if (navigator.share) {
            // Use the share() method to invoke the native sharing capabilities
            navigator.share({
                title: 'Signup and start earning today!',
                text: 'Signup and start earning today!',
                url: websiteLink
            })
                .then(() => console.log('Shared successfully.'))
                .catch((error) => console.log('Error sharing:', error));
        } else {
            console.log('Web Share API not supported.');
        }
    }

}


var path = window.location.pathname; // Get the path component of the URL
var parts = path.split('/'); // Split the path into an array of parts
var lastPart = parts[parts.length - 1]; // Get the last part of the path

if (lastPart === 'withdrawal-accounts.php') {

    // Add event listener to the radio buttons
    const radioButtons = document.querySelectorAll('input[name="inlineRadioOptions"]');
    radioButtons.forEach(radio => {
        radio.addEventListener('change', function () {
            const selectedDiv = document.getElementById(this.value);
            const allDivs = document.querySelectorAll('.bank-details-form');
            allDivs.forEach(div => {
                if (div === selectedDiv) {
                    div.style.display = 'block';
                    document.getElementById("placeholder").style.display = 'none';
                } else {
                    div.style.display = 'none';
                    // document.getElementById("placeholder").style.display = 'block';
                }
            });
        });
    });

}


var path = window.location.pathname; // Get the path component of the URL
var parts = path.split('/'); // Split the path into an array of parts
var lastPart = parts[parts.length - 1]; // Get the last part of the path

if (lastPart === 'grabbing.php') {

    $(document).ready(function () {

        $('#jackpotleModal').modal('show');

    });

    const orderPreBtn = document.getElementById('order-preview-button');
    const orderSubmitBtn = document.getElementById('order-submit-button');
    const orderPreImg = document.getElementsByClassName('order-item-preview');

    function createOrder(ordered_by, commission) {


        $.ajax({
            url: 'functions/order-management.php',
            type: 'POST',
            data: {
                create_order: "create_order",
                ordered_by: ordered_by

            },
            success: function (data) {

                if (data.trim() === 'pending') {

                    const myModal = new bootstrap.Modal('#warningModal');
                    const warningModal = document.getElementById('warningModal');
                    myModal.show(warningModal);

                } else if (data.trim() === 'limit') {

                    const myModal = new bootstrap.Modal('#warningModal2');
                    const warningModal = document.getElementById('warningModal2');
                    myModal.show(warningModal2);

                } else if (data.trim() === 'finished') {

                    const myModal = new bootstrap.Modal('#warningModal3');
                    const warningModal = document.getElementById('warningModal3');
                    myModal.show(warningModal3);

                } else {
                    var responseData = JSON.parse(data); // parse the JSON string into an object
                    if (responseData.random_product) {
                        var random_product = responseData.random_product;
                        var createdTime = responseData.created_at;
                        var orderNo = responseData.orderNo;
                        var productId = random_product.id;
                        var productName = random_product.product_name;
                        var productPrice = random_product.product_price;
                        var productQuantity = random_product.product_quantity;
                        var totalAmount = productPrice * parseFloat(productQuantity);
                        var commissionAmount = (commission / 100) * totalAmount;
                        // select the order form by its ID
                        var orderForm = document.getElementById('order-form');

                        // select the product-id input element by its name attribute
                        var productIdInput = orderForm.querySelector('input[name="product-id"]');
                        productIdInput.value = productId;

                        // select the product-id input element by its name attribute
                        var totalAmountInput = orderForm.querySelector('input[name="total-amount"]');
                        totalAmountInput.value = totalAmount;

                        // calculate estimated refund
                        var estRefund = totalAmount + commissionAmount;
                        var imageNames = responseData.image_names;

                        // access any other key-value pairs in the random_product array as needed
                        document.getElementById('order-no').innerText = "Order No: " + orderNo;
                        document.getElementById('created-time').innerText = "Created Time: " + createdTime;
                        document.getElementById('product-name').innerText = productName;
                        document.getElementById('product-price').innerText = "$ " + productPrice;
                        document.getElementById('product-quantity').innerText = "x " + productQuantity;
                        document.getElementById('total-amount').innerText = totalAmount.toFixed(2);
                        document.getElementById('commission').innerText = commission + "%";
                        document.getElementById('est-refund').innerText = "$ " + estRefund.toFixed(2);

                        // create a div for each image and append it to the container
                        var slideContainer = document.getElementById('slide-container');
                        slideContainer.innerHTML = ''; // clear any previous images

                        // create a div for the container and add classes
                        var imageContainer = document.createElement('div');
                        imageContainer.classList.add('slider-common-class', 'order-item-prev-slider');
                        imageContainer.setAttribute('id', 'image-container');
                        imageContainer.setAttribute('style', 'width: 250px;');

                        for (var i = 0; i < imageNames.length; i++) {
                            var div = document.createElement('div');
                            var img = document.createElement('img');
                            img.classList.add('order-item-preview');
                            img.src = './assets/images/product-images/' + imageNames[i];
                            img.alt = '';
                            img.style.width = '250px';
                            div.classList.add('w-100');
                            div.appendChild(img);
                            imageContainer.appendChild(div);
                            slideContainer.appendChild(imageContainer);
                        }
                    }

                    const myModal = new bootstrap.Modal('#orderPrevModal');
                    const orderPrevModal = document.getElementById('orderPrevModal');
                    myModal.show(orderPrevModal);
                }

            },

            error: function (jqXHR, textStatus, errorThrown) {
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            }

        });


        // Delay the slick slider initialization code by 2 seconds
        // Hide the slider images
        for (let i = 0; i < orderPreImg.length; i++) {
            orderPreImg[i].style.display = "none";
        }

        // Wait for 2 seconds
        setTimeout(() => {
            // Show the slider images
            for (let i = 0; i < orderPreImg.length; i++) {
                orderPreImg[i].style.display = "block";
                orderPreImg[i].style.opacity = 1;
            }

            $('.order-item-prev-slider').slick({
                arrows: true,
                dots: true,
                infinite: true,
                speed: 300,
                slidesToShow: 1,
                slidesToScroll: 1,
                responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 800,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
                ]
            });
        }, 500); // Delay time in milliseconds

    };

}

function submitOrder(formId) {
      // Disable the button
      var submitButton = document.getElementById('order-submit-button');
      submitButton.disabled = true;
      console.log("disabled");
    
    // select the order form by its ID
    var orderForm = document.getElementById(formId);

    // select the product-id input element by its name attribute
    var productIdInput = orderForm.querySelector('input[name="product-id"]');
    product_id = productIdInput.value;

    // select the product-id input element by its name attribute
    var totalAmountInput = orderForm.querySelector('input[name="total-amount"]');
    total_amount = totalAmountInput.value;
    
    // Remove commas from the total_amount value
    total_amount = total_amount.replace(/,/g, '');
    
    // select the product-id input element by its name attribute
    var orderedByInput = orderForm.querySelector('input[name="ordered-by"]');
    ordered_by = orderedByInput.value;

    $.ajax({
        url: 'functions/order-management.php',
        type: 'POST',
        data: {
            submit_order: "submit_order",
            product_id: product_id,
            ordered_by: ordered_by,
            total_amount: total_amount
            
        },
        success: function (data) {

            // Check if the data contains "Insufficient balance"
            if (data.includes("Insufficient balance")) {
                                // Redirect to the same page
                window.location.href = window.location.href;
                
                // Display an error message
                document.getElementById("order-failed-alert").style.display = "block";
                setTimeout(function () {
                    document.getElementById("order-failed-alert").style.display = "none";
                }, 3000);
            } else {
                // Redirect to the same page
                window.location.href = window.location.href;

                // Display a success message
                document.getElementById("order-alert").style.display = "block";
                setTimeout(function () {
                    document.getElementById("order-alert").style.display = "none";
                }, 3000);
            }
        }
    });
}


var path = window.location.pathname; // Get the path component of the URL
var parts = path.split('/'); // Split the path into an array of parts
var lastPart = parts[parts.length - 1]; // Get the last part of the path

if (lastPart === 'all-order.php' || lastPart === 'completed-order.php' || lastPart === 'pending-order.php') {
    const orderPreImg = document.getElementsByClassName('order-image-preview');


    $(document).ready(function () {
        $('.slider-common-class img').each(function () {
            var $img = $(this);
            var src = $img.attr('src');
            $('<img>').attr('src', src).on('load', function () {
                $img.addClass('loaded');
            });
        });
    });

    $(document).ready(function () {
        $('.slider-common-class div').each(function () {
            var slidingDiv = $(this);

            setTimeout(function () {
                slidingDiv.addClass('loaded');
            }, 100); // 2000 milliseconds = 2 seconds
        });
    });

    initializeSlickSlider();
    function initializeSlickSlider() {
        // Delay the slick slider initialization code by 2 seconds
        // Hide the slider images
        for (let i = 0; i < orderPreImg.length; i++) {
            orderPreImg[i].style.display = "none";
        }

        // Wait for 2 seconds
        setTimeout(() => {
            // Show the slider images
            for (let i = 0; i < orderPreImg.length; i++) {
                orderPreImg[i].style.display = "block";
                orderPreImg[i].style.opacity = 1;
            }

            $('.order-item-history-slider').slick({
                autoplay: true,
                autoplaySpeed: 2000, // Set the time between each slide to 2 seconds
                arrows: true,
                dots: true,
                infinite: true,
                speed: 300,
                slidesToShow: 1,
                slidesToScroll: 1,
                responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 800,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                ]
            });

        }, 500); // Delay time in milliseconds

    }
}




var path = window.location.pathname; // Get the path component of the URL
var parts = path.split('/'); // Split the path into an array of parts
var lastPart = parts[parts.length - 1]; // Get the last part of the path

if (lastPart === '' || lastPart === 'index.php' || lastPart === 'grabbing.php' || lastPart === 'notification-details.php') {

    $('.slider').slick({
        autoplay: true,
        autoplaySpeed: 2000, // Set the time between each slide to 2 seconds
        arrows: false,
        infinite: true,
        speed: 300,
        slidesToShow: setSlidesToShow(2, 2, 1, 1),
        slidesToScroll: 1
    });

    $('.member-slider').slick({
        autoplay: true,
        autoplaySpeed: 1000, // Set the time between each slide to 2 seconds
        arrows: false,
        infinite: true,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 1,
        vertical: true,
        verticalSwiping: true,
        responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 1,
                infinite: true,
            }
        },
        {
            breakpoint: 800,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 1,
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 1,
            }
        }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });


    $('.winner-slider').slick({
        autoplay: true,
        autoplaySpeed: 2000, // Set the time between each slide to 2 seconds
        arrows: false,
        infinite: true,
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
                infinite: true,
            }
        },
        {
            breakpoint: 800,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });

    $('.order-item-slider').slick({
        autoplay: true,
        autoplaySpeed: 2000, // Set the time between each slide to 2 seconds
        arrows: false,
        infinite: true,
        speed: 300,
        slidesToShow: setSlidesToShow(3, 3, 2, 1),
        slidesToScroll: 1,
        autoplayHoverPause: true
    });


    $('.order-item-sub-slider').slick({
        arrows: true,
        dots: true,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        slidesToScroll: 1,
    });


    $(document).ready(function () {
        $('.slider-common-class img').each(function () {
            var $img = $(this);
            var src = $img.attr('src');
            $('<img>').attr('src', src).on('load', function () {
                $img.addClass('loaded');
            });
        });
    });

    $(document).ready(function () {
        $('.slider-div-class div').each(function () {
            var slidingDiv = $(this);

            setTimeout(function () {
                slidingDiv.addClass('loaded');
            }, 100); // 2000 milliseconds = 2 seconds
        });
    });
}



var path = window.location.pathname; // Get the path component of the URL
var parts = path.split('/'); // Split the path into an array of parts
var lastPart = parts[parts.length - 1]; // Get the last part of the path

if (lastPart === 'index.php' || lastPart === '') {

    const ul = document.querySelector(".notice-container ul");
    const container = document.querySelector(".notice-container");
    const ulWidth = ul.scrollWidth;
    const containerWidth = container.offsetWidth;
    const animationDuration = ulWidth / 60; // adjust this value to change the animation speed
    const style = document.createElement("style");
    style.textContent = `
.notice-container ul {
  animation: scroll ${animationDuration}s infinite linear;
}

  @keyframes scroll {
    from {
      transform: translateX(calc(${containerWidth}px));
    }
  
    to {
      transform: translateX(calc(-${ulWidth}px));
    }
  }

`;
    document.head.appendChild(style);

}





var path = window.location.pathname; // Get the path component of the URL
var parts = path.split('/'); // Split the path into an array of parts
var lastPart = parts[parts.length - 1]; // Get the last part of the path

if (lastPart === 'me.php') {

    var offset = 10; // Number of records already loaded
    var limit = 10; // Number of records to load per request


    // Function to load more results
    function loadMoreResults(condition) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', './functions/load-more.php?type=transactions&offset=' + offset + '&limit=' + limit + '&table=transactions&conditions=created_by&condition_value=' + condition + '&order_conditions=created_at', true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                var response = xhr.responseText;


                // Remove the button div
                var buttonDiv = document.getElementById('load-more-btn');
                if (buttonDiv) {
                    buttonDiv.remove();
                }

                // Append new results to the transaction history container
                document.getElementById('transaction-history').insertAdjacentHTML('beforeend', response);

                // Update the offset
                offset += limit;

                if (response !== "") {
                    // Add the "Load More" button again
                    var loadMoreButton = '<div class="btn btn-white w-100 my-2" id="load-more-btn">More</div>';
                    document.getElementById('transaction-history').insertAdjacentHTML('beforeend', loadMoreButton);
                } else {
                    if (buttonDiv) {
                        buttonDiv.remove();
                    }
                    var endResult = '<div class="text-center my-2">End of results!</div>';
                    document.getElementById('transaction-history').insertAdjacentHTML('beforeend', endResult);
                }

                // Set the event listener for the initial "Load More" button
                document.getElementById('load-more-btn').addEventListener('click', function () {
                    // var user_id = '<?php echo $condition_value ?>';
                    loadMoreResults(condition);
                });
            }
        };

        xhr.send();
    }
}


// updates profile picture 
function update_image(update_id) {

    $(document).ready(function () {
        $(document).on('change', '#file', function () {
            var name = document.getElementById("file").files[0].name;
            var form_data = new FormData();
            var ext = name.split('.').pop().toLowerCase();
            if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                alert("Invalid Image File");
                exit;
            }
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("file").files[0]);
            var f = document.getElementById("file").files[0];
            var fsize = f.size || f.fileSize;
            if (fsize > 2000000) {
                alert("Image File Size is very big");
            } else {
                var form_data = new FormData();
                form_data.append("file", document.getElementById('file').files[0]);
                $.ajax({
                    url: "functions/upload-profile.php?update_id=" + update_id,
                    method: "POST",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                        $('#uploaded_image').html("<label class='text-success'>Image Uploading...</label>");
                    },
                    success: function (data) {
                        $('#uploaded_image').html(data);
                        window.location.href = "profile.php";
                    }
                });
            }
        });
    });
}


var path = window.location.pathname; // Get the path component of the URL
var parts = path.split('/'); // Split the path into an array of parts
var lastPart = parts[parts.length - 1]; // Get the last part of the path

if (lastPart === 'all-order.php' || lastPart === 'completed-order.php') {

    var offset = 10; // Number of records already loaded
    var limit = 10; // Number of records to load per request

    // Function to load more results
    function loadMoreResults(condition) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', './functions/load-more.php?type=all-orders&offset=' + offset + '&limit=' + limit + '&columns=o.*, p.id AS product_id, p.product_name AS product_name, p.product_quantity AS product_quantity, p.product_price AS product_price, pi.product_image AS product_image&table=orders o JOIN products p ON p.id = o.product_id JOIN product_image pi ON pi.upload_id = p.id&conditions=o.ordered_by&condition_value=' + condition + '&order_conditions=o.ordered_at&group_conditions=GROUP BY p.id', true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                var response = xhr.responseText;


                // Remove the button div
                var buttonDiv = document.getElementById('load-more-btn');
                if (buttonDiv) {
                    buttonDiv.remove();
                }

                // Append new results to the transaction history container
                document.getElementById('order-history').insertAdjacentHTML('beforeend', response);

                // Update the offset
                offset += limit;

                if (response !== "") {
                    // Add the "Load More" button again
                    var loadMoreButton = '<div class="btn btn-white w-100 my-2" id="load-more-btn">More</div>';
                    document.getElementById('order-history').insertAdjacentHTML('beforeend', loadMoreButton);
                    initializeSlickSlider();
                } else {
                    var buttonDiv = document.getElementById('load-more-btn');
                    if (buttonDiv) {
                        buttonDiv.remove();
                    }
                    var endResult = '<div class="text-center my-2">End of results!</div>';
                    document.getElementById('order-history').insertAdjacentHTML('beforeend', endResult);
                }

                // Set the event listener for the initial "Load More" button
                document.getElementById('load-more-btn').addEventListener('click', function () {
                    // var user_id = '<?php echo $condition_value ?>';
                    loadMoreResults(condition);
                });
            }
        };

        xhr.send();
    }


}

var path = window.location.pathname; // Get the path component of the URL
var parts = path.split('/'); // Split the path into an array of parts
var lastPart = parts[parts.length - 1]; // Get the last part of the path

if (lastPart === '' || lastPart === 'index.php') {
    var offset = 10; // Number of records already loaded
    var limit = 10; // Number of records to load per request
    var condition = 1; // Condition for the request

    // Variable to store the interval ID
    var intervalID;

    // Function to load more results
    function loadMoreResults(condition) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', './functions/load-more.php?type=slides&offset=' + offset + '&limit=' + limit + '&table=slides&conditions=status&condition_value=' + condition + '&order_conditions=created_at', true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                var response = xhr.responseText;


                // Check if the response is empty
                if (response.trim() === '') {
                    // Stop calling the function if the response is empty
                    clearInterval(intervalID);
                    return;
                }

                // Parse the response as JSON or modify the code based on the response format
                var images = JSON.parse(response);

                // Loop through the images and add them to the slider
                images.forEach(function (image) {
                    $('.slider').slick('slickAdd', '<div><img src="' + image + '" alt="" class="w-100"></div>');
                });

                $('.slider-common-class img').each(function () {
                    var $img = $(this);
                    var src = $img.attr('src');
                    $('<img>').attr('src', src).on('load', function () {
                        $img.addClass('loaded');
                    });
                });

                $('.slider-div-class div').each(function () {
                    var slidingDiv = $(this);

                    setTimeout(function () {
                        slidingDiv.addClass('loaded');
                    }, 100); // 2000 milliseconds = 2 seconds
                });

                // Update the offset
                offset += limit;
            }
        };

        xhr.send();
    }

    // Call the loadMoreResults function initially
    loadMoreResults(condition);

    // Set the timeout function to call loadMoreResults every 10 seconds
    intervalID = setInterval(function () {
        loadMoreResults(condition);
    }, 10000); // 10 seconds (10,000 milliseconds)

}



var path = window.location.pathname; // Get the path component of the URL
var parts = path.split('/'); // Split the path into an array of parts
var lastPart = parts[parts.length - 1]; // Get the last part of the path

if (lastPart === 'grabbing.php') {
    var offset = 10; // Number of records already loaded
    var limit = 10; // Number of records to load per request
    var condition = 1; // Condition for the request

    // Variable to store the interval ID
    var intervalID;

    // Function to load more results
    function loadMoreResults(condition) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', './functions/load-more.php?type=products&offset=' + offset + '&limit=' + limit + '&columns=p.id AS product_id, p.product_name AS product_name, p.product_quantity * p.product_price AS product_price, p.user_level, GROUP_CONCAT(pi.product_image) AS product_image&table=products p JOIN product_image pi ON pi.upload_id = p.id&conditions=p.status&condition_value=' + condition + '&order_conditions=p.id&group_conditions=GROUP BY p.id', true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                var response = xhr.responseText;


                // Check if the response is empty
                if (response.trim() === '') {
                    // Stop calling the function if the response is empty
                    clearInterval(intervalID);
                    return;
                }

                // Parse the response string into a JavaScript object
                var products = JSON.parse(response);

                // Loop through the products and add them to the slider
                // Loop through the products and add them to the slider
                products.forEach(function (product) {
                    var productImages = product.product_images; // Assuming product_images is an array of image URLs

                    // Create the new slide HTML
                    var newSlideDiv = '<div class="order-item-sub-slider shimmer slider-common-class" id="order-item-sub-slider-' + product.product_id + '">';
                    newSlideDiv += '</div>';

                    // Add the new slide to the main slider
                    $('.order-item-slider').slick('slickAdd', newSlideDiv);

                    // Initialize the sub-slider
                    $('#order-item-sub-slider-' + product.product_id).slick({
                        arrows: true,
                        dots: true,
                        infinite: true,
                        speed: 300,
                        slidesToShow: 1,
                        slidesToScroll: 1
                    });

                    // Loop through productImages and add them to the sub-slider
                    productImages.forEach(function (imageUrl) {
                        var newSlide = '<div class="position-relative d-flex justify-content-center align-items-end">' +
                            '<div class="ratio ratio-1x1">' +
                            '<img class="w-100 h-100 object-fit-cover" src="./assets/images/product-images/' + imageUrl + '" alt="">' +
                            '</div>' +
                            '<div class="position-absolute bottom-0 p-1 m-1 rounded w-75 text-center trans-bg">' +
                            '<div class="text-success fw-bolder">$' + product.product_price + '</div>' +
                            '<div class="fw-semibold">' + product.product_name + '</div>' +
                            '</div>' +
                            '</div>';

                        // Add the new slide to the sub-slider
                        $('#order-item-sub-slider-' + product.product_id).slick('slickAdd', newSlide);
                    });

                    // Add image loaded class
                    $('.slider-common-class img').each(function () {
                        var $img = $(this);
                        var src = $img.attr('src');
                        $('<img>').attr('src', src).on('load', function () {
                            $img.addClass('loaded');
                        });
                    });

                    // Add loaded class to sliding divs
                    $('.slider-common-class div').each(function () {
                        var slidingDiv = $(this);
                        setTimeout(function () {
                            slidingDiv.addClass('loaded');
                        }, 1000); // 1000 milliseconds = 1 second
                    });
                });

                // Initialize the order-item-sub-slider

                $('.slider-common-class img').each(function () {
                    var $img = $(this);
                    var src = $img.attr('src');
                    $('<img>').attr('src', src).on('load', function () {
                        $img.addClass('loaded');
                    });
                });

                $('.slider-div-class div').each(function () {
                    var slidingDiv = $(this);

                    setTimeout(function () {
                        slidingDiv.addClass('loaded');
                    }, 1000); // 2000 milliseconds = 2 seconds
                });

                // Update the offset
                offset += limit;
            }
        };

        xhr.send();
    }

    // Call the loadMoreResults function initially
    loadMoreResults(condition);

    // Set the timeout function to call loadMoreResults every 10 seconds
    intervalID = setInterval(function () {
        loadMoreResults(condition);
    }, 10000); // 10 seconds (10,000 milliseconds)

}


$(document).ready(function() {
  $('.common-submit').click(function() {
    var button = $(this);
    var form = button.closest('form');

    // Disable the clicked button
    button.prop('disabled', true);

    // Check form validity
    if (form[0].checkValidity()) {
      // Submit the form if it is valid
      form.submit();
        // Redirect to the same page
        window.location.href = window.location.href;
    } else {
      // Enable the button if form validation fails
      button.prop('disabled', false);
    }
  });
});

