<?php
session_start();

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

date_default_timezone_set('America/New_York'); // Set timezone to Eastern Standard Time

if (isset($_SESSION['otp'])) {
  $otp = $_SESSION['otp'];
}


if (isset($_POST['otpCheck'])) {
  $otpInput = $_POST['otpCheck'];
  if ($otpInput == $otp) {
    echo 'matched ';
    unset($_SESSION['otp']);
  } else {
    echo 'not-matched';
  }
}


if (isset($_POST['emailCheck'])) {

  // check if the invitation code exists in the users table
  include "../connection/connection.php";
  $email = mysqli_real_escape_string($connection, $_POST['emailCheck']);
  $query = "SELECT id FROM users WHERE email = '$email'";
  $result = mysqli_query($connection, $query);

  if (mysqli_num_rows($result) > 0) {
    // the invitation code is valid
    echo 'exist';
  } else {
    // the invitation code is invalid
    echo 'new';
  }
}


if (isset($_POST['invitationCode'])) {

  // check if the invitation code exists in the users table
  include "../connection/connection.php";
  $invitationCode = mysqli_real_escape_string($connection, $_POST['invitationCode']);
  $query = "SELECT id FROM users WHERE invitation_code = '$invitationCode'";
  $result = mysqli_query($connection, $query);

  if (mysqli_num_rows($result) > 0) {
    // the invitation code is valid
    $row = mysqli_fetch_assoc($result);
    $userId = $row['id'];
    echo $userId;
  } else {
    // the invitation code is invalid
    echo 'invalid';
  }
}


if (isset($_POST['signup']) && !empty($_POST['signup'])) {

  // receive data from form:
  $created_at = date('Y-m-d H:i:s');

  $memberId = $_SESSION['memberId'];

  $create_data = (object)[
    'name' => mysqli_real_escape_string($connection, $_POST['name']),
    'email' => mysqli_real_escape_string($connection, $_POST['email']),
    'user_name' => $memberId,
    'phone' => mysqli_real_escape_string($connection, $_POST['phone']),
    'password' => mysqli_real_escape_string($connection, $_POST['password']),
    'invited_by' => mysqli_real_escape_string($connection, $_POST['invited-by']),
    'created_at' => $created_at,
  ];


  $createResponse = register_user($create_data);

  if ($createResponse->status == 'success') {

    $insert_id  = $createResponse->insert_id;

    $redirectLink = 'index.php';
  } else {

    $redirectLink = 'index.php';
  }

  $_SESSION[$createResponse->status] = $createResponse->message;
  redirect($redirectLink);
}

function register_user($user_data)
{

  global $connection;
  $name = $user_data->name;
  $email = $user_data->email;
  $memberId = $user_data->user_name;
  $phone = $user_data->phone;
  $password = md5($user_data->password);
  $created_at = $user_data->created_at;
  $invited_by = $user_data->invited_by;
  $invitationCode = generateInvitationCode();

  // Check if the generated ID already exists in the table
  $existingCode = true;
  while ($existingCode) {
    $query = $connection->prepare('SELECT COUNT(*) as count FROM users WHERE invitation_code = ?');
    $query->bind_param('s', $invitationCode);
    $query->execute();
    $result = $query->get_result();
    $row = $result->fetch_assoc();
    $existingCode = ($row['count'] > 0);

    // Regenerate ID if it already exists
    if ($existingCode) {
      $invitationCode = generateInvitationCode();
    }
  }

  // use prepared statements to prevent SQL injection
  $stmt = $connection->prepare("INSERT INTO users (name, user_name, email, phone, password, invitation_code, invited_by, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("sssissss", $name, $memberId, $email, $phone, $password, $invitationCode, $invited_by, $created_at);
  $stmt->execute();

  if ($stmt->affected_rows > 0) {
    $message = 'Registration Successful! Your User ID is ' . $memberId . '.';
    $insert_id = $stmt->insert_id;
    $status = 'success';
  } else {
    $message = "Error: " . $stmt->error;
    $insert_id = '';
    $status = 'error';
  }

  $stmt->close();


  if (isset($_SESSION['memberId'])) {
    unset($_SESSION['memberId']);
  }


  return (object)[
    'status' => $status,
    'message' => $message,
    'insert_id' => $insert_id,
  ];
}


function generateInvitationCode()
{
  global $connection;
  // Generate random ID
  $digits = sprintf("%02d", rand(0, 99));
  $capitalLetter = chr(rand(65, 90));
  $numbers = sprintf("%05d", rand(0, 99999));
  $invitation_code = $digits . $capitalLetter . $numbers;

  // Check if the ID exists in the users table
  $stmt = $connection->prepare("SELECT COUNT(*) FROM users WHERE invitation_code = ?");
  $stmt->bind_param("s", $invitation_code);
  $stmt->execute();
  $stmt->bind_result($count);
  $stmt->fetch();
  $stmt->close();

  if ($count > 0) {
    // ID already exists, generate a new one
    return generateInvitationCode();
  }

  return $invitation_code;
}



if (isset($_POST['add-admin']) && !empty($_POST['add-admin'])) {

  // receive data from form:
  $created_at = date('Y-m-d H:i:s');

  $create_data = (object)[
    'name' => mysqli_real_escape_string($connection, $_POST['name']),
    'email' => mysqli_real_escape_string($connection, $_POST['email']),
    'password' => mysqli_real_escape_string($connection, $_POST['password']),
    'is_user' => mysqli_real_escape_string($connection, $_POST['add-admin']),
    'invited_by' => mysqli_real_escape_string($connection, $_POST['invitation_code']),
    'created_at' => $created_at,

  ];


  $createResponse = register_admin($create_data);

  if ($createResponse->status == 'success') {

    $insert_id  = $createResponse->insert_id;

    $redirectLink = $_SERVER['PHP_SELF'];

  } else {

    $redirectLink = $_SERVER['PHP_SELF'];
  }

  $_SESSION[$createResponse->status] = $createResponse->message;
  redirect($redirectLink);
}

function register_admin($user_data)
{

  global $connection;
  $name = $user_data->name;
  $email = $user_data->email;
  $is_user = $user_data->is_user;
  $invited_by = $user_data->invited_by;
  $password = md5($user_data->password);
  $created_at = $user_data->created_at;

  $memberId = "";
  $userId = "";

  if ($is_user == "user") {

    $query = "SELECT id FROM users WHERE invitation_code = '$invited_by'";
    $result = mysqli_query($connection, $query);

    if ($invited_by == "" || mysqli_num_rows($result) > 0) {
      // the invitation code is valid

      // Generate a unique ID
      $memberId = generateUniqueId($connection);

      $userId = "Username :" . $memberId;

      $invitationCode = generateInvitationCode();

      // use prepared statements to prevent SQL injection
      $stmt2 = $connection->prepare("INSERT INTO users (user_name, password, invitation_code, invited_by, created_at) VALUES (?, ?, ?, ?, ?)");

      $stmt2->bind_param("sssss", $memberId, $password, $invitationCode, $invited_by, $created_at);
    } else {
      $_SESSION['error'] = 'Invalid invitation code!';
      header("Location: users.php");
    }
  } else {
    // use prepared statements to prevent SQL injection
    $stmt2 = $connection->prepare("INSERT INTO admins (name, user_name, password, created_at) VALUES (?, ?, ?, ?)");

    $stmt2->bind_param("ssss", $name, $email, $password, $created_at);
  }


  $stmt2->execute();

  if ($stmt2->affected_rows > 0) {
    $message = 'Success! ' . $userId;
    $insert_id = $stmt->insert_id;
    $status = 'success';
  } else {
    $message = "Error: " . $stmt->error;
    $insert_id = '';
    $status = 'error';
  }

  $stmt2->close();


  return (object)[
    'status' => $status,
    'message' => $message,
    'insert_id' => $insert_id,
  ];
}


?>