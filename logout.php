<?php session_start();
$_SESSION['is_authenticate_user'] = false;
unset($_SESSION['is_authenticate_user']);

setcookie('username', '', time() - 3600, '/');
setcookie('password', '', time() - 3600, '/');
setcookie('userType', '', time() - 3600, '/');


$_SESSION['success'] = "You have been logged out successfully";

header("Location: index.php");



?>