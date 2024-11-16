<?php
require 'PHPMailer/PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer/PHPMailer-master/src/SMTP.php';
require 'PHPMailer/PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendOtp($toEmail, $otp) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'sijukanobara@gmail.com'; // Your Gmail email
        $mail->Password = 'hvsu ixst ikfh rivd'; // Your Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Sender and recipient settings
        $mail->setFrom('sijukanobara@gmail.com', 'Your App Name');
        $mail->addAddress($toEmail); // Recipient's email

        // Email content
        $mail->isHTML(true);
        $mail->Subject = "Your OTP Code";
        $mail->Body = "<h3>Your OTP is: <strong>$otp</strong></h3><p>Use this OTP to verify your email address.</p>";

        // Send the email
        if ($mail->send()) {
            echo 'OTP has been sent successfully.';
        } else {
            echo 'Failed to send OTP.';
        }
    } catch (Exception $e) {
        echo "Error: {$mail->ErrorInfo}";
    }
}
?>
