<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if (isset($_POST["send"])) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Corrected 'stmp.gmail.com' to 'smtp.gmail.com'
        $mail->SMTPAuth = true;
        $mail->Username = 'limyuchien007@gmail.com';
        $mail->Password = 'twcmcdofxnswtttg';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('limyuchien007@gmail.com');
        $mail->addAddress($_POST["email"]);
        $mail->isHTML(true);
        $mail->Subject = "Admin Registration for Multi-FR Lock";
        $mail->Body = "Hello, You have been assigned as an Admin. Please complete your registration using the following link:
http://localhost/multiFRLock/register.php?staffid=" . $_POST["sid"] . " Thank you.";

        $mail->send();

        echo "
        <script>
        alert('Send Successfully');
        document.location.href='staffs.php';
        </script>
        ";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} 
?>
