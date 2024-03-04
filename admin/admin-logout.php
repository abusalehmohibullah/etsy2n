<?php session_start();
$_SESSION['is_authenticate'] = false;
unset($_SESSION['is_authenticate']);

setcookie('admin_username', '', time() - 3600, '/');
setcookie('admin_password', '', time() - 3600, '/');
setcookie('admin_userType', '', time() - 3600, '/');

$_SESSION['success'] = "You have been logged out successfully";

header("Location: admin-login.php");



?>