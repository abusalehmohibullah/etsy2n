<?php

session_start();

// error_reporting(E_ALL);
// ini_set('display_errors', '1');

date_default_timezone_set('America/New_York'); // Set timezone to Eastern Standard Time

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


if (isset($_SESSION['otp'])) {
    unset($_SESSION['otp']);
}

$_SESSION['otp'] = rand(1000, 9999);

$otp = $_SESSION['otp'];


function generateUniqueId($connection)
{
    // Generate random ID
    $digits = sprintf("%02d", rand(0, 99));
    $capitalLetter = chr(rand(65, 90));
    $numbers = sprintf("%05d", rand(0, 99999));
    $memberId = $digits . $capitalLetter . $numbers;

    // Check if the ID exists in the users table
    $stmt = $connection->prepare("SELECT COUNT(*) FROM users WHERE user_name = ?");
    $stmt->bind_param("s", $memberId);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        // ID already exists, generate a new one
        return generateUniqueId($connection);
    }

    return $memberId;
}

if (isset($_POST['sendMail'])) {

    // check if the invitation code exists in the users table
    include "../connection/connection.php";

    // Select the logo column from the logo table
    $sql = "SELECT logo_image FROM logo LIMIT 1";
    
    // Execute the query
    $result = $connection->query($sql);
    
    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // Fetch the first row
        $row = $result->fetch_assoc();
        
        // Get the logo value from the row
        $logo = $row['logo'];
        
    } else {
        echo "No logo found.";
    }


    $domain = $_SERVER['HTTP_HOST'];
    
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $emails = $_POST['email'];
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $format = mysqli_real_escape_string($connection, $_POST['sendMail']);
    $subject = "";
    $image = "";
    $code = "";
    $top_text = "";
    $bottom_text = "";
    $bottom_text_2 = "";
    $bottom_text_3 = "";
    // $attachments= array();

    if ($format === "send_otp" || $format === "resend_otp") {
        $code = $otp;
    } else if ($format === "send_confirmation") {

        // Generate a unique ID
        $memberId = generateUniqueId($connection);

        $_SESSION['memberId'] = $memberId;
        $code = $memberId;
    }
    if ($format === "resend_otp") {
        $format = "send_otp";
    }
    

    // Create a folder to store the uploaded images
    $uploadDir = '../assets/images/email-images/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }    
    
    if($format === "custom_email") {
        $subject = $_POST['subject'];
            // Process the top banner image
            if (isset($_FILES['top_banner']) && $_FILES['top_banner']['error'] === UPLOAD_ERR_OK) {
            $topBanner = $_FILES['top_banner'];

            $image = uniqid() . '_' . $topBanner['name']; // Generate a unique name for the banner image
    
            // Move the uploaded banner image to the uploads folder with the new name
            $bannerDestination = $uploadDir . $image;
            move_uploaded_file($topBanner['tmp_name'], $bannerDestination);
        }
        $top_text = $_POST['top_text'];
        $bottom_text = $_POST['bottom_text'];
        $bottom_text_2 = $_POST['bottom_text_2'];
        $bottom_text_3 = $_POST['bottom_text_3'];

    } else {
        $sql = "SELECT * FROM email_format WHERE format_name = '$format'";
        $result = $connection->query($sql);
        if ($result->num_rows > 0) {
    
            $mail_data = $result->fetch_object();
            $subject = $mail_data->subject;
            $image = $mail_data->image;
            $top_text = $mail_data->top_text;
            $bottom_text = $mail_data->bottom_text;
            $bottom_text_2 = $mail_data->bottom_text_2;
            $bottom_text_3 = $mail_data->bottom_text_3;
            $status = "success";
        }
    }
    
    $body = '<div>
                        <table style="width:100%;border-spacing:0" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <th>
                                        <table style="width:100%;max-width:596px;border-spacing:0;margin:0 auto" cellpadding="0" cellspacing="0" align="center">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <table style="margin:0%;width:100%;border-spacing:0;table-layout:fixed" cellpadding="0" cellspacing="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <cite>
                                                                            <div style="height:20px"></div>
                                                                            <table cellpadding="0" cellspacing="0" style="width:100%;margin:0;padding:0">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td align="center">
                                                                                            <div style="width:100%;background:#ffffff;">
                                                                                            <div style="height:5px;background-color: gray;"></div>
                                                                                            <div style="height:20px"></div>
                                                                                            <!-- logo  -->
                                                                                                <a href="'.$domain.'" title="Etsy.com" style="display:inline-block">
                                                                                                    <img src="'.$domain.'/assets/images/logo/logo.png" border="0" alt="Etsy" height="34" class="CToWUd">
                                                                                                </a>
                                                                                                <div style="height:2px;background-color: gray;"></div>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </cite>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </th>
                                </tr>
                                <tr>
                                    <th style="background:#ffffff;height:28px"></th>
                                </tr>
                                <tr>
                                    <th style="background:#ffffff;font-weight:normal;text-align:left">
                                        <table style="width:100%;max-width:596px;border-spacing:0;margin:0 auto" cellpadding="0" cellspacing="0" align="center">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <table style="margin:0%;width:100%;border-spacing:0;table-layout:fixed;font-family:Arial,Helvetica,sans-serif" cellpadding="0" cellspacing="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td align="center" style="padding:0 3.358%;font-size:16px;color:#444;line-height:24px">'
                                                                    
                                                                    
                                                                    . ($image != "" ? '
                                                                        <!-- image  -->
                                                                        <img src="'.$domain.'/assets/images/email-images/'.$image.'" style="width:100%;display:block" class="CToWUd a6T" tabindex="0">
                                                                        <div style="height:20px"></div>'
                                                                         : '') .
                                                                         
                                                                         
                                                                        '<div>
                                                                            <table cellpadding="0" cellspacing="0" style="width:100%;margin:0;padding:0">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td align="center">
                                                                                            <div style="width:100%">
                                                                                            <!-- main content  -->
                                                                                                <div style="font-size:16px;color:#444444;text-align:center">
                                                                                                    '.$top_text.'
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            <div style="height:20px"></div>'
                                                                            
                                                                            
                                                                            . ($code != "" ? '
                                                                            <span style="background-color:#222222;border-bottom-left-radius:24px;border-bottom-right-radius:24px;border-top-left-radius:24px;border-top-right-radius:24px;border-width:2px;border-color:#222222;border-style:solid;box-sizing:border-box;color:#ffffff;display:inline-block;font-family:-apple-system,system-ui,Roboto,&quot;Droid Sans&quot;,&quot;Segoe UI&quot;,Helvetica,Arial,sans-serif;font-size:16px;font-weight:500;line-height:22px;min-width:48px;padding:10px 18px;vertical-align:middle;width:auto">
                                                                                '.$code.'
                                                                            </span>
                                                                            
                                                                            <div style="height:20px"></div>'
                                                                             : '') .
                                                                            
                                                                            
                                                                            ($bottom_text != ""? '
                                                                            <table cellpadding="0" cellspacing="0" style="width:100%;margin:0;padding:0">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td align="center">
                                                                                            <div style="width:100%">
                                                                                            <!-- Additional content  -->
                                                                                                <div style="font-size:13px;color:#444444;text-align: center">
                                                                                                    '.$bottom_text.'
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            
                                                                            
                                                                            <div style="height:20px"></div>'
                                                                             : '') .
                                                                            
                                                                            
                                                                            ($bottom_text_2 != ""? '
                                                                            <table cellpadding="0" cellspacing="0" style="width:100%;margin:0;padding:0">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td align="center">
                                                                                            <div style="width:100%">
                                                                                            <!-- Additional content  -->
                                                                                                <div style="font-size:16px;color:#444444;text-align: center">
                                                                                                    '.$bottom_text_2.'
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            
                                                                            <div style="height:20px"></div>'
                                                                             : '') .
                                                                            
                                                                            
                                                                            ($bottom_text_3 != ""? '
                                                                            <table cellpadding="0" cellspacing="0" style="width:100%;margin:0;padding:0">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td align="center">
                                                                                            <div style="width:100%">
                                                                                            <!-- Additional content  -->
                                                                                                <div style="font-size:13px;color:#444444;text-align: center">
                                                                                                    '.$bottom_text_3.'
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>'
                                                                            : '') .
                                                                            
                                                                            
                                                                        '</div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                        
                        ';
    
    
    //Load Composer's autoloader
    require '../assets/vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require '../assets/vendor/phpmailer/phpmailer/src/SMTP.php';
    require '../assets/vendor/phpmailer/phpmailer/src/Exception.php';

    
if (is_array($emails)) {
    foreach ($emails as $email) {
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);


    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'mail.etsy2n.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'emails@mail.etsy2n.com';                     //SMTP username
        $mail->Password   = '[~z[a^KRX=3g';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('emails@mail.etsy2n.com', 'Etsy');
        $mail->addAddress($email);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $body;
                // Upload and attach the files
        if (isset($_FILES['attachments']) && !empty($_FILES['attachments']['tmp_name'][0])) {
            $attachments = $_FILES['attachments'];
        
            // Loop through the attachments
            foreach ($attachments['tmp_name'] as $index => $tmpName) {
                $attachmentName = $attachments['name'][$index];
        
                // Generate a unique filename for the attachment
                $newFileName = uniqid() . '_' . $attachmentName;
        
                // Move the uploaded file to the desired directory
                $destination = $uploadDir . $newFileName;
                
                move_uploaded_file($tmpName, $destination);
        
                // Add the attachment to the email
                $mail->addAttachment($destination, $newFileName);
            }
        }

        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->SMTPDebug = 0; // Disable debug output
        $mail->send();

    if($format !== "custom_email") {
        // send success response to AJAX request
        echo "sent";
    }
                 $_SESSION['Success'] = 'Email sent successfully!';
    } catch (Exception $e) {
        // send error response to AJAX request
        echo "failed";
    }



    }
} else {
    // Handle the case when there is a single recipient (not an array)
    $mail = new PHPMailer(true);


    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'mail.etsy2n.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'emails@mail.etsy2n.com';                     //SMTP username
        $mail->Password   = '[~z[a^KRX=3g';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('emails@mail.etsy2n.com', 'Etsy');
        $mail->addAddress($email);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $body;
        // Upload and attach the files
        if (isset($_FILES['attachments']) && !empty($_FILES['attachments']['tmp_name'][0])) {
            $attachments = $_FILES['attachments'];
        
            // Loop through the attachments
            foreach ($attachments['tmp_name'] as $index => $tmpName) {
                $attachmentName = $attachments['name'][$index];
        
                // Generate a unique filename for the attachment
                $newFileName = uniqid() . '_' . $attachmentName;
        
                // Move the uploaded file to the desired directory
                $destination = $uploadDir . $newFileName;
                
                // Check for any errors during the file upload
                move_uploaded_file($tmpName, $destination);

                // Add the attachment to the email
                $mail->addAttachment($destination, $newFileName);
            }
        }

        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->SMTPDebug = 0; // Disable debug output
        $mail->send();

    if($format !== "custom_email") {
        // send success response to AJAX request
        echo "sent";
    }
                  $_SESSION['Success'] = 'Email sent successfully!';
    } catch (Exception $e) {
        // send error response to AJAX request
        echo "failed";
    }

}


}


?>