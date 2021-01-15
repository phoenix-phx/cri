<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 1;
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'gamma385438@gmail.com';
    $mail->Password   = 'password123A';
    $mail->SMTPSecure = 'tls';
    $mail->setFrom('gamma385438@gmail.com', 'Gamma Epsilon');
    $mail->addAddress('alexanderjrsosa@gmail.com');

    $mail->isHTML(true);
    $mail->Subject = 'Hello world';
    $mail->Body    = 'Funciono XD';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}