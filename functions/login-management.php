<?php

// error_reporting(E_ALL);
// ini_set('display_errors', '1');

if (isset($_COOKIE['admin_username']) && isset($_COOKIE['admin_password'])) {
    $user_name = $_COOKIE['admin_username'];
    $password = $_COOKIE['admin_password'];
    $table = $_COOKIE['admin_userType'];

    $sql = "SELECT id, name, user_name, status FROM $table WHERE user_name = '$user_name' AND password = '$password'";

    $result = $connection->query($sql);
    if ($result->num_rows > 0) {

        $user_data = $result->fetch_object();

        if ($user_data->status == 1) {
            if ($table === "admins") {
                $_SESSION["is_authenticate"] = true;

                if ($_POST['remember']) {
                    // Set a cookie to remember the user's login information
                    setcookie('admin_username', $user_name, time() + 60 * 60 * 24 * 30, '/');
                    setcookie('admin_password', $password, time() + 60 * 60 * 24 * 30, '/');
                    setcookie('admin_userType', $table, time() + 60 * 60 * 24 * 30, '/');
                }
            }

            // $_SESSION["email"] = $email;
            $_SESSION["login_admin_id"] = $user_data->id;
            $_SESSION["admin_name"] = $user_data->name;
            $_SESSION["admin_user_name"] = $user_data->user_name;

            $status = "success";

            deleteLog($user_name);
        } else {
            $status = "error";
            $_SESSION["error"] = "Your account has been restricted!";
        }
    }
}

if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
    $user_name = $_COOKIE['username'];
    $password = $_COOKIE['password'];
    $table = $_COOKIE['userType'];

    $sql = "SELECT id, name, user_name, status FROM $table WHERE user_name = '$user_name' AND password = '$password'";

    $result = $connection->query($sql);
    if ($result->num_rows > 0) {

        $user_data = $result->fetch_object();

        if ($user_data->status == 1) {
            if ($table === "users") {
                $_SESSION["is_authenticate_user"] = true;

                if ($_POST['remember']) {
                    // Set a cookie to remember the user's login information
                    setcookie('username', $user_name, time() + 60 * 60 * 24 * 30, '/');
                    setcookie('password', $password, time() + 60 * 60 * 24 * 30, '/');
                    setcookie('userType', $table, time() + 60 * 60 * 24 * 30, '/');
                }
            }

            $_SESSION["login_id"] = $user_data->id;
            $_SESSION["name"] = $user_data->name;
            $_SESSION["user_name"] = $user_data->user_name;

            $status = "success";

            deleteLog($user_name);
        } else {
            $status = "error";
            $_SESSION["error"] = "Your account has been restricted!";
        }
    }
}



if (isset($_POST["login"]) && !empty($_POST["login"])) {
    $attempt_time = time() - 1800;
    $user_name = mysqli_real_escape_string($connection, $_POST["user_name"]);
    $password = mysqli_real_escape_string($connection, $_POST["password"]);
    $table = mysqli_real_escape_string($connection, $_POST["table"]);

    $sql = "SELECT id FROM login_log WHERE user_name = '$user_name' AND attempt_time > $attempt_time";
    $result = $connection->query($sql);
    $attempt_counter = $result->num_rows;
    if ($result->num_rows < 5) {

        $sql = "SELECT id FROM $table WHERE user_name = '$user_name'";
        $result = $connection->query($sql);
        if ($result->num_rows > 0) {

            $password = md5($password);
            $sql = "SELECT id, name, user_name, status FROM $table WHERE user_name = '$user_name' AND password = '$password'";

            $result = $connection->query($sql);
            if ($result->num_rows > 0) {

                $user_data = $result->fetch_object();

                if ($user_data->status == 1) {
                    if ($table === "admins") {
                        $_SESSION["is_authenticate"] = true;


                        if ($_POST['remember']) {
                            // Set a cookie to remember the user's login information
                            setcookie('admin_username', $user_name, time() + 60 * 60 * 24 * 30, '/');
                            setcookie('admin_password', $password, time() + 60 * 60 * 24 * 30, '/');
                            setcookie('admin_userType', $table, time() + 60 * 60 * 24 * 30, '/');
                        }


                        $_SESSION["login_admin_id"] = $user_data->id;
                        $_SESSION["admin_name"] = $user_data->name;
                        $_SESSION["admin_user_name"] = $user_data->user_name;
                    } else {
                        $_SESSION["is_authenticate_user"] = true;


                        if ($_POST['remember']) {
                            // Set a cookie to remember the user's login information
                            setcookie('username', $user_name, time() + 60 * 60 * 24 * 30, '/');
                            setcookie('password', $password, time() + 60 * 60 * 24 * 30, '/');
                            setcookie('userType', $table, time() + 60 * 60 * 24 * 30, '/');
                        }
                        $_SESSION["login_id"] = $user_data->id;
                        $_SESSION["name"] = $user_data->name;
                        $_SESSION["user_name"] = $user_data->user_name;
                    }

                    $status = "success";

                    deleteLog($user_name);
                } else {
                    $status = "error";
                    $_SESSION["error"] = "Your account has been restricted!";
                }
            } else {
                if ($attempt_counter == 3) {
                    $status = "error";
                    $_SESSION["error"] = "One more invalid attempt will lock your account!";
                } else if ($attempt_counter == 4) {
                    $status = "error";
                    $_SESSION["error"] = "Too many invalid attempts. Please try again later or contact support.";
                } else {
                    $status = "error";
                    $_SESSION["error"] = "Password was incorrect!";
                }
                $time = time();
                mysqli_query($connection, "insert into login_log (user_name, attempt_time) values ('$user_name', '$time')");
            }
        } else {
            $status = "error";
            $_SESSION["error"] = "No user found with this username: " . $user_name;
        }
    } else {
        $status = "error";
        $_SESSION["error"] = "Too many invalid attempts. Please try again after 30 Minutes.";
    }

    if ($status == "error") {
        header("Location: index.php");
        exit;
    } else {
        header("Location: index.php");
        exit;
    }
}



if (isset($_POST['deleteLog']) && !empty($_POST["deleteLog"])) {
    $user_name = mysqli_real_escape_string($connection, $_POST['user_name']);
    $result = deleteLog($user_name);
    if ($result["status"] == "success") {
        // Success: Display message
        $_SESSION[$result["status"]] = $result["message"];
        $redirectLink = 'users.php';
    } else {
        // Error: Display message
        $_SESSION[$result["status"]] = $result["message"];
        $redirectLink = 'users.php';
    }
    redirect($redirectLink);
}


function deleteLog($user_name)
{
    global $connection;
    $sql = "DELETE FROM login_log WHERE user_name = '$user_name'";
    $result = mysqli_query($connection, $sql);

    if (mysqli_affected_rows($connection) > 0) {
        // If rows are affected, return success status and message
        return array("status" => "success", "message" => "Unlocked successfully.");
    } else {
        // If no rows are affected, return error status and message
        return array("status" => "error", "message" => "No login logs found for this user.");
    }
}

?>
