
ClassicEditor
    .create(document.querySelector('#content-editor'), {
        toolbar: ['undo', 'redo', '|', 'heading', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote', 'link'],
        
        toolbarLocation: 'top',
        
        config: {
            htmlAllowed: true
        }
    })
    .catch(error => {
        console.error(error);
    });



function showHideUpdateOptions(selectElement) {
    var selectedValue = selectElement.value;
    var updateDetails = document.getElementById('updateDetails');

    if (selectedValue !== "") {
        updateDetails.style.display = "block"; // show the element
    }
}


function updateTextAreaName(selectElement) {
    var selectedValue = selectElement.value;
    var textAreaElement = document.getElementById('content-editor');
    var textAreaDiv = document.getElementById('content-editor-div');
    textAreaElement.name = selectedValue;
    if (selectedValue !== "") {
        textAreaDiv.style.display = "block"; // show the element
    }
}


ClassicEditor
    .create(document.querySelector('#format-top-editor'), {
        toolbar: ['undo', 'redo', '|', 'Heading', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote' , 'link' ]
    })
    .catch(error => {
        console.error(error);
    });

ClassicEditor
    .create(document.querySelector('#format-bottom-editor'), {
        toolbar: ['undo', 'redo', '|', 'Heading', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote' , 'link' ]
    })
    .catch(error => {
        console.error(error);
    });

ClassicEditor
    .create(document.querySelector('#format-bottom-editor-2'), {
        toolbar: ['undo', 'redo', '|', 'Heading', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote' , 'link' ]
    })
    .catch(error => {
        console.error(error);
    });

ClassicEditor
    .create(document.querySelector('#format-bottom-editor-3'), {
        toolbar: ['undo', 'redo', '|', 'Heading', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote' , 'link' ]
    })
    .catch(error => {
        console.error(error);
    });

ClassicEditor
    .create(document.querySelector('#custom-top-editor'), {
        toolbar: ['undo', 'redo', '|', 'Heading', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote' , 'link' ]
    })
    .catch(error => {
        console.error(error);
    });

ClassicEditor
    .create(document.querySelector('#custom-bottom-editor'), {
        toolbar: ['undo', 'redo', '|', 'Heading', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote' , 'link' ]
    })
    .catch(error => {
        console.error(error);
    });

ClassicEditor
    .create(document.querySelector('#custom-bottom-editor-2'), {
        toolbar: ['undo', 'redo', '|', 'Heading', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote' , 'link' ]
    })
    .catch(error => {
        console.error(error);
    });

ClassicEditor
    .create(document.querySelector('#custom-bottom-editor-3'), {
        toolbar: ['undo', 'redo', '|', 'Heading', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote' , 'link' ]
    })
    .catch(error => {
        console.error(error);
    });




function copyValue(valueID) {
    var range = document.createRange();
    range.selectNode(document.getElementById('id-' + valueID));
    window.getSelection().removeAllRanges();
    window.getSelection().addRange(range);
    document.execCommand('copy');
    window.getSelection().removeAllRanges();
}


var path = window.location.pathname; // Get the path component of the URL
var parts = path.split('/'); // Split the path into an array of parts
var lastPart = parts[parts.length - 1]; // Get the last part of the path

if (lastPart === 'users.php' || lastPart === 'jackpot.php') {

    $(document).ready(function () {
        console.log("ready");
        $('#user-list').selectpicker({
            size: 10,
            noneSelectedText: 'Search or Scroll and Select User',
            noneResultsText: 'Oopss! There is no such user!',
            liveSearchPlaceholder: 'Type to Search...',

        });
    });

    // get the form element
    const userListForm = document.getElementById('user-list-form');

    // add an event listener to the select input to detect changes
    const userSelect = document.getElementById('user-list');
    try {
        const userListForm = document.getElementById('user-list-form');
        const userSelect = document.getElementById('user-list');

        userSelect.addEventListener('change', function () {
            console.log('change event triggered');
            userListForm.submit();
            console.log('form submitted');
        });
    } catch (error) {
        console.error('Error setting up event listener:', error);
    }

}

var path = window.location.pathname; // Get the path component of the URL
var parts = path.split('/'); // Split the path into an array of parts
var lastPart = parts[parts.length - 1]; // Get the last part of the path

if (lastPart === 'users.php') {

    // Get the input field and submit button
    var promoteList = document.getElementById("promote-level-list");
    var promoteBtn = document.getElementById("promote-button");

    // Disable the submit button by default
    promoteBtn.disabled = true;

    // Enable the submit button when the input field has a value
    promoteList.addEventListener("input", function () {

        if (promoteList.value !== "" && promoteList.value !== "select") {
            promoteBtn.disabled = false;
        } else {
            promoteBtn.disabled = true;
        }

    });

}

var path = window.location.pathname; // Get the path component of the URL
var parts = path.split('/'); // Split the path into an array of parts
var lastPart = parts[parts.length - 1]; // Get the last part of the path

if (lastPart === 'notification.php' || lastPart === 'popup.php') {

    // add event listener to "check all" checkbox
    document.getElementById("check-all").addEventListener("click", function () {
        var checkboxes = document.querySelectorAll('#notification-goes-to input[type=checkbox]');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = this.checked;
        }
    });

    // add event listener to user search box
    document.getElementById("user-search").addEventListener("keyup", function () {
        var input, filter, checkboxes, user_label, i, txtValue;
        input = document.getElementById("user-search");
        filter = input.value.toUpperCase();
        checkboxes = document.querySelectorAll('#notification-goes-to .user-checkbox');
        for (i = 0; i < checkboxes.length; i++) {
            user_label = checkboxes[i].getElementsByTagName("label")[0];
            txtValue = user_label.textContent || user_label.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                checkboxes[i].style.display = "";
            } else {
                checkboxes[i].style.display = "none";
            }
        }
    });

}


var path = window.location.pathname; // Get the path component of the URL
var parts = path.split('/'); // Split the path into an array of parts
var lastPart = parts[parts.length - 1]; // Get the last part of the path

if (lastPart === 'manage-emails.php') {

    // add event listener to "check all" checkbox
    document.getElementById("check-all").addEventListener("click", function () {
        var checkboxes = document.querySelectorAll('#email-goes-to input[type=checkbox]');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = this.checked;
        }
    });

    // add event listener to user search box
    document.getElementById("user-search").addEventListener("keyup", function () {
        var input, filter, checkboxes, user_label, i, txtValue;
        input = document.getElementById("user-search");
        filter = input.value.toUpperCase();
        checkboxes = document.querySelectorAll('#email-goes-to .user-checkbox');
        for (i = 0; i < checkboxes.length; i++) {
            user_label = checkboxes[i].getElementsByTagName("label")[0];
            txtValue = user_label.textContent || user_label.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                checkboxes[i].style.display = "";
            } else {
                checkboxes[i].style.display = "none";
            }
        }
    });

}



var path = window.location.pathname; // Get the path component of the URL
var parts = path.split('/'); // Split the path into an array of parts
var lastPart = parts[parts.length - 1]; // Get the last part of the path

if (lastPart === 'index.php' || lastPart === '') {

}

$('.order-item-sub-slider').slick({
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


$('.slider-common-class img').each(function () {
    var $img = $(this);
    var src = $img.attr('src');
    $('<img>').attr('src', src).on('load', function () {
        $img.addClass('loaded');
    });
});


var path = window.location.pathname; // Get the path component of the URL
var parts = path.split('/'); // Split the path into an array of parts
var lastPart = parts[parts.length - 1]; // Get the last part of the path

if (lastPart === 'create-order.php' || lastPart === 'slider.php' || lastPart === 'notification.php' || lastPart === 'popup.php' || lastPart === 'jackpot.php') {

    // creates a preview of selected file(s)
    function getImagePreview(event, dynamicWidth) {
        var imageDiv = document.getElementById('image-container');
        var addBtn = document.getElementById('add-btn');

        // generate a unique ID for each preview div
        function generatePreviewId() {
            return Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
        }

        // loop through selected files and create preview divs
        for (let i = 0; i < event.target.files.length; i++) {
            // generate a unique ID for the preview div
            const previewId = generatePreviewId();

            // create the preview div
            const previewDiv = document.createElement('div');
            previewDiv.id = previewId;
            var image = URL.createObjectURL(event.target.files[i]);
            var newImg = document.createElement('img');
            var newTitle = document.createElement('div');
            var delBtn = document.createElement('div');
            var delIcon = document.createElement('i');

            previewDiv.classList.add("preview-container", "d-flex", "justify-content-center", "position-relative");

            delBtn.classList.add("delete-button", "position-absolute", "d-flex", "justify-content-center", "align-items-center");
            delIcon.classList.add("delete-icon", "fas", "fa-trash", "fa-2x", "btn", "btn-lg", "btn-outline-danger", "rounded-5", "p-3");

            newImg.src = image;
            newImg.height = "200";
            newImg.width = dynamicWidth;

            delBtn.style.setProperty('height', '200px');
            delBtn.style.setProperty('width', dynamicWidth + 'px');
            newTitle.style.setProperty('width', dynamicWidth + 'px');

            newImg.style.border = "1px solid lightgray";
            newImg.style.marginRight = "10px";

            newTitle.classList.add("preview-title", "text-center");
            newTitle.textContent = event.target.files[i].name;

            delBtn.appendChild(delIcon);
            previewDiv.appendChild(newImg);
            previewDiv.appendChild(newTitle);
            previewDiv.appendChild(delBtn);
            imageDiv.appendChild(previewDiv);

            // add event listener to delete button
            delIcon.addEventListener('click', function () {
                // remove preview div from the image container
                const previewToRemove = document.getElementById(previewId);
                imageDiv.removeChild(previewToRemove);
                window.location.reload ()
            });
            


        }
            addBtn.style.setProperty("display", "none", "important");
    }

}

var path = window.location.pathname; // Get the path component of the URL
var parts = path.split('/'); // Split the path into an array of parts
var lastPart = parts[parts.length - 1]; // Get the last part of the path

if (lastPart === 'users.php') {
    var offset = 10; // Number of records already loaded
    var limit = 10; // Number of records to load per request

    // Function to load more results
    function loadMoreResults(condition) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '../functions/load-more.php?type=transactions&offset=' + offset + '&limit=' + limit + '&table=transactions&conditions=created_by&condition_value=' + condition, true);

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


var path = window.location.pathname; // Get the path component of the URL
var parts = path.split('/'); // Split the path into an array of parts
var lastPart = parts[parts.length - 1]; // Get the last part of the path

if (lastPart === 'create-order.php' || lastPart === 'slider.php' || lastPart === 'notification.php' || lastPart === 'popup.php' || lastPart === 'jackpot.php') {


    // shows the name of the selected file(s)
    const fileInput = document.getElementById('upload-file');

    fileInput.addEventListener('change', (event) => {
        const fileName = document.getElementById('image-title');

        if (event.target.files.length === 1) {
            fileName.textContent = event.target.files[0].name;
        } else if (event.target.files.length > 1) {
            fileName.textContent = event.target.files.length + " files selected";
        } else {
            fileName.textContent = "No files selected";
        }

        getImagePreview(event);
    });

}


function toggleMainDiv(mainDivId, editableDivId) {
    // Get the main_div and editable_div elements by their IDs
    const mainDiv = document.getElementById(mainDivId);
    const editableDiv = document.getElementById(editableDivId);
    // Hide the main_div and show the editable_div
    mainDiv.style.display = "none";
    editableDiv.style.display = "block";
}

function toggleEditableDiv(mainDivId, editableDivId) {
    // Get the main_div and editable_div elements by their IDs
    const mainDiv = document.getElementById(mainDivId);
    const editableDiv = document.getElementById(editableDivId);
    // Hide the editable_div and show the main_div
    editableDiv.style.display = "none";
    mainDiv.style.display = "block";
}


var path = window.location.pathname; // Get the path component of the URL
var parts = path.split('/'); // Split the path into an array of parts
var lastPart = parts[parts.length - 1]; // Get the last part of the path

if (lastPart === '' || lastPart === 'index.php') {

    var offsetSliders = 0; // Number of records already loaded for sliders
    var offsetProducts = 0; // Number of records already loaded for products
    var offsetJackpots = 0; // Number of records already loaded for products
    var limit = 10; // Number of records to load per request


    // Function to load more results
    function loadSliders(condition) {

        var xhr = new XMLHttpRequest();
        xhr.open('GET', '../functions/load-data.php?type=slides&offset=' + offsetSliders + '&limit=' + limit + '&table=slides&conditions=status&condition_value=' + condition + '&order_conditions=id', true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                var response = xhr.responseText;
                // Parse the JSON string into an array
                var slides = JSON.parse(response);
                // Create a variable to store the HTML markup
                var html = '';
                // Loop through the response array
                slides.data.forEach(function (row) {
                    // Generate the HTML markup for each row
                    html += `
                    <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 col-xxl-3 p-1 position-relative">
                        <img src="../assets/images/slider-images/${row.image_path}" alt="" class="w-100">
                        
                        ${row.status == 3 ? `
                            <div class="d-flex flex-wrap align-content-center align-items-center position-absolute top-0 start-0 w-100 h-100 transparent-bg">
                                <div class="w-100 text-center text-white fw-bold fs-4"><i class="bi bi-eye-slash"></i> Hidden</div>
                            </div>
                        ` : ''}
                        
                        <div class="d-flex position-absolute bottom-0 end-0 gap-1 px-2 py-1 m-2">
                            
                            <div>
                                ${row.status == 1 ? `
                                    <form action="" method="post">
                                        <input type="hidden" name="id" value="${row.id}">
                                        <input type="hidden" name="table" value="slides">
                                        <input type="hidden" name="value" value="3">
                                        <button class="btn btn-secondary" type="submit" name="update-status">
                                            <i class="bi bi-eye-slash"></i>
                                        </button>
                                    </form>
                                ` : (row.status == 3 ? `
                                    <form action="" method="post">
                                        <input type="hidden" name="id" value="${row.id}">
                                        <input type="hidden" name="table" value="slides">
                                        <input type="hidden" name="value" value="1">
                                        <button class="btn btn-success" type="submit" name="update-status">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </form>
                                ` : '')}
                            </div>


                            <div class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal-${row.id}">
                                <i class="bi bi-trash"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal-${row.id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header py-2 alert alert-danger">
                                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Confirm Delete</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this slide?
                                </div>
                                <div class="modal-footer py-1">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <form action="" method="post">
                                        <input type="hidden" name="id" value="${row.id}">
                                        <input type="hidden" name="table-name" value="slides">
                                        <input type="hidden" name="delete-image" value="../assets/images/slider-images/${row.image_path}">
                                        <input type="submit" class="btn btn-danger" name="delete-button" value="Delete">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                });

                // Append the HTML markup to the existing div
                var slidesDiv = document.getElementById("slides-row");
                slidesDiv.innerHTML += html;

                // Remove the onclick function from the button
                var accordionButton = document.getElementById("load-slider");
                accordionButton.removeAttribute("onclick");

                var buttonDiv = document.getElementById('load-more-slides');
                if (buttonDiv) {
                    buttonDiv.remove();
                }

                if (slides.has_rows == "yes") {
                    var loadMoreButton = `<div class="btn btn-white w-100 my-2" id="load-more-slides" onclick="loadSliders('IN (1, 3)')">More</div>`
                    slidesDiv.insertAdjacentHTML('beforeend', loadMoreButton);
                } else if (slides.has_rows == "no") {
                    var endResult = '<div class="text-center w-100 my-2">No more result found!</div>'
                    slidesDiv.insertAdjacentHTML('beforeend', endResult);
                }


            }
        };


        // Update the offset
        offsetSliders += limit;

        xhr.send();
    }


    // Function to load more results
    function loadProducts(condition) {


        var xhr = new XMLHttpRequest();
        xhr.open('GET', '../functions/load-data.php?type=products&offset=' + offsetProducts + '&limit=' + limit + '&columns=p.id AS product_id, p.product_name AS product_name, p.product_quantity AS product_quantity, p.product_quantity * p.product_price AS product_price, p.user_level AS user_level, p.status AS status, GROUP_CONCAT(pi.product_image) AS product_image, GROUP_CONCAT(pi.id) AS image_id&table=products p JOIN product_image pi ON pi.upload_id = p.id&conditions=p.status&condition_value=' + condition + '&order_conditions=p.id&group_conditions=GROUP BY p.id', true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                var response = xhr.responseText;
                // Parse the JSON string into an array
                var products = JSON.parse(response);
                // Create a variable to store the HTML markup
                var html = '';
                // Loop through the response array
                products.data.forEach(function (row) {

                    // Generate the HTML markup for each row
                    html += `

                <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 col-xxl-3 p-1">
                <div class="order-item-sub-slider-container position-relative border">
                    <div class="order-item-sub-slider slider-common-class mb-2" id="order-item-sub-slider-${row.id}">;`


                    // Iterate over the image_path array within each row
                    row.image_path.forEach(function (image, index) {
                        // Get the corresponding image ID from the image_ids array
                        var imageId = row.image_ids[index];

                        html += `
    <div class="position-relative">

      <img src="../assets/images/product-images/${image}" alt="">
      ${row.status == 3 ? `
        <div class="d-flex flex-wrap align-content-center align-items-center position-absolute top-0 start-0 w-100 h-100 transparent-bg">
          <div class="w-100 text-center text-white fw-bold fs-4"><i class="bi bi-eye-slash"></i> Hidden</div>
        </div>
      ` : ''}
                                            
      <div class="position-absolute bottom-0 end-0 px-2 py-1 m-0">

        <div class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#productImageDeleteModal-${imageId}">
          <i class="bi bi-trash"></i>
        </div>
      </div>
      <div class="position-absolute bottom-0 start-0 p-1 m-1 fw-semibold rounded"> x
        ${row.product_quantity}
      </div>
    </div>
  `;
                    });


                    html += `
                    </div>
                

                    
                    <div class="d-flex p-1">
                        <div class="notice-text-preview">${row.product_name}</div>
                        <div class="ms-auto text-nowrap text-success fw-semibold">$${row.product_price}</div>
                    </div>
                    
                    <div class="position-absolute top-0 start-0 p-1">
                        ${row.user_level == 1 ? `
                            <img src="../assets/images/icons/silver.png" alt="" width="50px">
                        ` : (row.user_level == 2 ? `
                            <img src="../assets/images/icons/gold.png" alt="" width="50px">
                        ` : (row.user_level == 3 ? `
                            <img src="../assets/images/icons/platinum.png" alt="" width="50px">
                        ` : (row.user_level == 4 ? `
                            <img src="../assets/images/icons/diamond.png" alt="" width="50px">
                        ` : (row.user_level == 5 ? `
                            <img src="../assets/images/icons/crown.png" alt="" width="50px">
                        ` : ''))))}
                    </div>

                </div>
                
                <div class="d-flex justify-content-center border">
                    <div class="px-2 py-1 d-flex flex-nowrap gap-1">
                        <div>
                            ${row.status == 1 ? `
                                <form action="" method="post">
                                    <input type="hidden" name="id" value="${row.id}">
                                    <input type="hidden" name="table" value="products">
                                    <input type="hidden" name="value" value="3">
                                    <button class="btn btn-secondary" type="submit" name="update-status">
                                        <i class="bi bi-eye-slash"></i>
                                    </button>
                                </form>
                            ` : (row.status == 3 ? `
                                <form action="" method="post">
                                    <input type="hidden" name="id" value="${row.id}">
                                    <input type="hidden" name="table" value="products">
                                    <input type="hidden" name="value" value="1">
                                    <button class="btn btn-success" type="submit" name="update-status">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </form>
                            ` : '')}
                        </div>
                        <div class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#productDeleteModal-${row.id}">
                            <i class="bi bi-trash"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            
            
            <!-- Modal -->
            <div class="modal fade" id="productDeleteModal-${row.id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header py-2 alert alert-danger">
                            <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Confirm Delete</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this product?
                        </div>
                        <div class="modal-footer py-1">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <form action="" method="post">
                                <input type="hidden" name="id" value="${row.id}">
                                <input type="hidden" name="table-name" value="products">
                                <input type="submit" class="btn btn-danger" name="delete-button" value="Delete">
                            </form>
                        </div>
                    </div>
                </div>
            </div>


                `;



                    // Iterate over the image_path array within each row
                    row.image_path.forEach(function (image, index) {
                        // Get the corresponding image ID from the image_ids array
                        var imageId = row.image_ids[index];


                        html += `

                              <!-- Modal -->
                    <div class="modal fade" id="productImageDeleteModal-${imageId}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header py-2 alert alert-danger">
                                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Confirm Delete</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this product image?
                                </div>
                                <div class="modal-footer py-1">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <form action="" method="post">
                                        <input type="hidden" name="id" value="${imageId}">
                                        <input type="hidden" name="table-name" value="product_image">
                                        <input type="submit" class="btn btn-danger" name="delete-button" value="Delete">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    `;


                    });



                });

                // Append the HTML markup to the existing div
                var productsDiv = document.getElementById("products-row");
                productsDiv.innerHTML += html;
                // Initialize the sub-slider


                // Initialize the Slick slider after the HTML markup has been added to the DOM
                products.data.forEach(function (row) {
                    $('#order-item-sub-slider-' + row.id).slick({
                        arrows: true,
                        dots: true,
                        infinite: true,
                        speed: 300,
                        slidesToShow: 1,
                        slidesToScroll: 1
                    });
                });

                // Add image loaded class
                $('.slider-common-class img').each(function () {
                    var $img = $(this);
                    var src = $img.attr('src');
                    $('<img>').attr('src', src).on('load', function () {
                        $img.addClass('loaded');
                    });
                });

                // Remove the onclick function from the button
                var accordionButton = document.getElementById("load-products");
                accordionButton.removeAttribute("onclick");

                var buttonDiv = document.getElementById('load-more-products');
                if (buttonDiv) {
                    buttonDiv.remove();
                }

                if (products.has_rows == "yes") {
                    var loadMoreButton = `<div class="btn btn-white w-100 my-2" id="load-more-products" onclick="loadProducts('IN (1, 3)')">More</div>`
                    productsDiv.insertAdjacentHTML('beforeend', loadMoreButton);
                } else if (products.has_rows == "no") {
                    var endResult = '<div class="text-center w-100 my-2">No more result found!</div>'
                    productsDiv.insertAdjacentHTML('beforeend', endResult);
                }


            }
        };


        // Update the offset
        offsetProducts += limit;

        xhr.send();
    }



    // Function to load more results
    function loadJackpots(condition) {


        var xhr = new XMLHttpRequest();
        xhr.open('GET', '../functions/load-data.php?type=jackpots&offset=' + offsetJackpots + '&limit=' + limit + '&columns=j.id AS product_id, j.product_name AS product_name, j.product_quantity AS product_quantity, j.product_quantity * j.product_price AS product_price, j.target_user AS target_user, j.status AS status, GROUP_CONCAT(ji.jackpot_image) AS jackpot_image, GROUP_CONCAT(ji.id) AS image_id&table=jackpots j JOIN jackpot_image ji ON ji.upload_id = j.id&conditions=j.status&condition_value=' + condition + '&order_conditions=j.id&group_conditions=GROUP BY j.id', true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                var response = xhr.responseText;


                // Parse the JSON string into an array
                var jackpots = JSON.parse(response);
                // Create a variable to store the HTML markup
                var html = '';
                // Loop through the response array
                jackpots.data.forEach(function (row) {

                    // Generate the HTML markup for each row
                    html += `

                <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 col-xxl-3 p-1">
                <div class="order-item-sub-slider-container position-relative border">
                    <div class="order-item-sub-slider slider-common-class mb-2" id="order-item-sub-slider-${row.id}">`


                    // Iterate over the image_path array within each row
                    row.image_path.forEach(function (image, index) {
                        // Get the corresponding image ID from the image_ids array
                        var imageId = row.image_ids[index];

                        html += `
                        <div class="position-relative">

                        <img src="../assets/images/jackpot-images/${image}" alt="">
                        ${row.status == 3 ? `
                            <div class="d-flex flex-wrap align-content-center align-items-center position-absolute top-0 start-0 w-100 h-100 transparent-bg">
                            <div class="w-100 text-center text-white fw-bold fs-4"><i class="bi bi-eye-slash"></i> Hidden</div>
                            </div>
                        ` : ''}
                                                                
                        <div class="position-absolute bottom-0 end-0 px-2 py-1 m-0">

                            <div class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#jackpotImageDeleteModal-${imageId}">
                            <i class="bi bi-trash"></i>
                            </div>
                        </div>
                        <div class="position-absolute bottom-0 start-0 p-1 m-1 fw-semibold rounded"> x
                            ${row.product_quantity}
                        </div>
                        </div>
                    `;
                    });


                    html += `
                    </div>
                

                    
                    <div class="d-flex p-1">
                        <div class="notice-text-preview">${row.product_name}</div>
                        <div class="ms-auto text-nowrap text-success fw-semibold">$${row.product_price}</div>
                    </div>
                    
                    <div class="position-absolute top-0 start-0 p-1">
                        ${row.user_level == 1 ? `
                            <img src="../assets/images/icons/silver.png" alt="" width="50px">
                        ` : (row.user_level == 2 ? `
                            <img src="../assets/images/icons/gold.png" alt="" width="50px">
                        ` : (row.user_level == 3 ? `
                            <img src="../assets/images/icons/platinum.png" alt="" width="50px">
                        ` : (row.user_level == 4 ? `
                            <img src="../assets/images/icons/diamond.png" alt="" width="50px">
                        ` : (row.user_level == 5 ? `
                            <img src="../assets/images/icons/crown.png" alt="" width="50px">
                        ` : ''))))}
                    </div>

                </div>
                
                <div class="d-flex justify-content-center border">
                    <div class="px-2 py-1 d-flex flex-nowrap gap-1">
                        <div>
                            ${row.status == 1 ? `
                                <form action="" method="post">
                                    <input type="hidden" name="id" value="${row.id}">
                                    <input type="hidden" name="table" value="jackpots">
                                    <input type="hidden" name="value" value="3">
                                    <button class="btn btn-secondary" type="submit" name="update-status">
                                        <i class="bi bi-eye-slash"></i>
                                    </button>
                                </form>
                            ` : (row.status == 3 ? `
                                <form action="" method="post">
                                    <input type="hidden" name="id" value="${row.id}">
                                    <input type="hidden" name="table" value="jackpots">
                                    <input type="hidden" name="value" value="1">
                                    <button class="btn btn-success" type="submit" name="update-status">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </form>
                            ` : '')}
                        </div>
                        <div class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#jackpotDeleteModal-${row.id}">
                            <i class="bi bi-trash"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal -->
            <div class="modal fade" id="jackpotDeleteModal-${row.id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header py-2 alert alert-danger">
                            <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Confirm Delete</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this jackpot?
                        </div>
                        <div class="modal-footer py-1">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <form action="" method="post">
                                <input type="hidden" name="id" value="${row.id}">
                                <input type="hidden" name="table-name" value="jackpots">
                                <input type="submit" class="btn btn-danger" name="delete-button" value="Delete">
                            </form>
                        </div>
                    </div>
                </div>
            </div>


                `;

                    // Iterate over the image_path array within each row
                    row.image_path.forEach(function (image, index) {
                        // Get the corresponding image ID from the image_ids array
                        var imageId = row.image_ids[index];


                        html += `

                              <!-- Modal -->
                    <div class="modal fade" id="jackpotImageDeleteModal-${imageId}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header py-2 alert alert-danger">
                                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Confirm Delete</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this jackpot image?
                                </div>
                                <div class="modal-footer py-1">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <form action="" method="post">
                                        <input type="hidden" name="id" value="${imageId}">
                                        <input type="hidden" name="table-name" value="jackpot_image">
                                        <input type="submit" class="btn btn-danger" name="delete-button" value="Delete">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    `;


                    });



                });

                // Append the HTML markup to the existing div
                var jackpotsDiv = document.getElementById("jackpots-row");
                jackpotsDiv.innerHTML += html;
                // Initialize the sub-slider


                // Initialize the Slick slider after the HTML markup has been added to the DOM
                jackpots.data.forEach(function (row) {
                    $('#order-item-sub-slider-' + row.id).slick({
                        arrows: true,
                        dots: true,
                        infinite: true,
                        speed: 300,
                        slidesToShow: 1,
                        slidesToScroll: 1
                    });
                });

                // Add image loaded class
                $('.slider-common-class img').each(function () {
                    var $img = $(this);
                    var src = $img.attr('src');
                    $('<img>').attr('src', src).on('load', function () {
                        $img.addClass('loaded');
                    });
                });

                // Remove the onclick function from the button
                var accordionButton = document.getElementById("load-jackpots");
                accordionButton.removeAttribute("onclick");

                var buttonDiv = document.getElementById('load-more-jackpots');
                if (buttonDiv) {
                    buttonDiv.remove();
                }

                if (jackpots.has_rows == "yes") {
                    var loadMoreButton = `<div class="btn btn-white w-100 my-2" id="load-more-jackpots" onclick="loadJackpots('IN (1, 3)')">More</div>`
                    jackpotsDiv.insertAdjacentHTML('beforeend', loadMoreButton);
                } else if (jackpots.has_rows == "no") {
                    var endResult = '<div class="text-center w-100 my-2">No more result found!</div>'
                    jackpotsDiv.insertAdjacentHTML('beforeend', endResult);
                }


            }
        };


        // Update the offset
        offsetJackpots += limit;

        xhr.send();
    }


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
    } else {
      // Enable the button if form validation fails
      button.prop('disabled', false);
    }
  });
});




