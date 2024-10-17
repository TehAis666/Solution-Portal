<?php
require_once "layouts/config.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once 'vendor/phpmailer/src/Exception.php';
require_once 'vendor/phpmailer/src/PHPMailer.php';
require_once 'vendor/phpmailer/src/SMTP.php';

function send_email($to, $subject, $body, $cc = null) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->Username = 'noreply@heitechpartnerconnect.com';
        $mail->Password = 'h31tech.23m4iL';

        // Sender and recipient settings
        $mail->setFrom('noreply@heitechpartnerconnect.com', 'HeiTech Partner Connect');
        $mail->addAddress($to);
        $mail->addReplyTo('partner@heitech.com.my', 'Partner Connect');

        // Add CC if provided
        if ($cc) {
            $mail->addCC($cc);
        }

        // Setting the email content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        // Send the email
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
