<?php

require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


function sendMail($toEmail, $toName, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
       
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'bonimechii80@gmail.com';      // Your Gmail
        $mail->Password   = 'igfevzmdjupwtik';             // 16-char app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use TLS
        $mail->Port       = 587;

        
        $mail->setFrom('bonimechii80@gmail.com', 'Task App');
        $mail->addAddress($toEmail, $toName);

        
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}


$email = $_POST['email'] ?? '';
$name  = $_POST['name'] ?? '';

if (!empty($email) && !empty($name)) {
    $subject = "Welcome to our site";
    $body    = "Hi $name, <br> Thanks for signing up!";

    if (sendMail($email, $name, $subject, $body)) {
        echo "✅ Email sent successfully!";
    } else {
        echo "❌ Failed to send email.";
    }
} else {
    echo "❌ Please provide name and email.";
}
