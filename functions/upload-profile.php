<?php
session_start();

include "../connection/connection.php";

// Check if a file was uploaded
if ($_FILES["file"]["name"] != '') {
    $update_id = $_GET['update_id'];

    // Check file type
    $allowed_types = array('image/jpeg', 'image/png');
    $file_type = $_FILES['file']['type'];
    if (!in_array($file_type, $allowed_types)) {
        $_SESSION["error"] = "Only JPG and PNG images are allowed.";
        header("Location: ../profile.php");
        exit;
    }

    // Check file size
    $max_size = 1 * 1024 * 1024; // 1MB
    $file_size = $_FILES['file']['size'];
    if ($file_size > $max_size) {
        $_SESSION["error"] = "The image size should not exceed 1MB.";
        header("Location: ../profile.php");
        exit;
    }

    $test = explode('.', $_FILES["file"]["name"]);
    $ext = end($test);
    $name = $update_id . '.' . $ext;
    $location = '../assets/images/profile-pictures/' . $name;
    move_uploaded_file($_FILES["file"]["tmp_name"], $location);

    // Sanitize the input
    $name = $connection->real_escape_string($name);
    $update_id = $connection->real_escape_string($update_id);

    $sql = "UPDATE users SET profile_picture = '$name' WHERE id = '$update_id'";

    $result = $connection->query($sql);

    $sql_2 = "SELECT profile_picture FROM users WHERE id = '$update_id'";
    $response = $connection->query($sql_2);
    $updated_image = $response->fetch_object();

    $_SESSION["updated_profile_image"] = $updated_image->profile_picture;

    if ($result) {
        $_SESSION["success"] = "Profile picture updated!";
        header("Location: ../profile.php");
        exit;
    } else {
        $_SESSION["error"] = "Error updating profile picture: " . $connection->error;
        header("Location: ../profile.php");
        exit;
    }
} else {
    $_SESSION["error"] = "No file selected.";
    header("Location: ../profile.php");
    exit;
}
?>
