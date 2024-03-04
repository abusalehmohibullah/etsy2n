</div>

<!--adds a blank space at bottom-->
<div class="bottom-div"></div>

<?php
// include login modal if user is not loggedin 
if (!is_authenticate_user()) {
  include "login.php";
}

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- jQuery library for DOM manipulation and event handling -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js" integrity="sha512-HGOnQO9+SP1V92SrtZfjqxxtLmVzqZpjFFekvzZVWoiASSQgSr4cw9Kqd2+l8Llp4Gm0G8GIFJ4ddwZilcdb8A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- Slick Carousel library for creating responsive carousels and sliders -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha3/js/bootstrap.bundle.min.js" integrity="sha512-vIAkTd3Ary9rwf0lrb9kIipyIkavKpYGnyopBXs6SiLfNSzAvCNvvQvKwBV5Xlag4O8oZpZ5U5n4bHoErGQxjw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- Bootstrap library for enhanced styling and interactivity -->

<script src="./assets/js/js.js"></script>
<!-- Custom JavaScript file for general functionality -->

<script src="./assets/js/sign-up.js"></script>
<!-- Custom JavaScript file for sign-up functionality -->

<script>
  // Initialize and show the login modal
  $(document).ready(function() {
    $('#exampleModalToggle').modal('show');
  });
</script>
<!-- Custom JavaScript code to show the login modal on page load -->
<?php
// include the popup only if the user is logged in
if (is_authenticate_user()) {
  include "./popup.php";
} ?>

</body>

</html>