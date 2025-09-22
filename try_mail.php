<?php
require __DIR__ . '/vendor/autoload.php'; // Composer autoload

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // SMTP settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'bonimechii80@gmail.com';   // your Gmail
    $mail->Password   = 'igfevzjmdjupwtik';         // your Gmail app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // TLS
    $mail->Port       = 587;

    // From/To
    $mail->setFrom('bonimechii80@gmail.com', 'ICS B Academy Test');
    $mail->addAddress('bonimechii80@gmail.com', 'Test User'); // send to yourself

    // Content
    $mail->isHTML(true);
    $mail->Subject = '✅ Test Email from PHPMailer';
    $mail->Body    = '<h2>This is a test email.</h2><p>If you see this, your PHPMailer config works!</p>';

    $mail->send();
    echo "<p style='color:green;font-weight:bold;'>✅ Test email sent successfully! Check your inbox/spam.</p>";

} catch (Exception $e) {
    echo "<p style='color:red;font-weight:bold;'>❌ Test email failed. Error: {$mail->ErrorInfo}</p>";
}
