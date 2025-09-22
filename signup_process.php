<?php
require __DIR__ . '/ClassAutoLoad.php';
require 'db.php';
require 'conf.php'; // include your config

// Composer autoloader for PHPMailer
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// -----------------------------
// Reusable function to send email
// -----------------------------
function sendWelcomeEmail($toEmail, $toName, $conf) {
    $mail = new PHPMailer(true);

    try {
        // SMTP server settings
        $mail->isSMTP();
        $mail->Host       = $conf['smtp_host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $conf['smtp_user'];
        $mail->Password   = $conf['smtp_pass'];
        $mail->SMTPSecure = $conf['smtp_secure']; // "tls" or "ssl"
        $mail->Port       = $conf['smtp_port'];

        // Debug (0 = off, 2 = detailed logs)
        $mail->SMTPDebug = $conf['smtp_debug'] ? 2 : 0;

        // Sender & recipient
        $mail->setFrom($conf['smtp_user'], $conf['site_name']);
        $mail->addAddress($toEmail, $toName);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Welcome to ' . $conf['site_name'] . '!';

        $loginUrl = $conf['site_url'] . '/signin.php';

        $mail->Body = "
            <h2>✅ Signup Successful!</h2>
            <p>Hello <b>{$toName}</b>,</p>
            <p>Thank you for signing up at <b>{$conf['site_name']}</b>.</p>
            <p>You can now log in by clicking the button below:</p>
            <p>
                <a href='{$loginUrl}' style='
                    display: inline-block;
                    padding: 10px 20px;
                    font-size: 16px;
                    color: #ffffff;
                    background-color: #28a745;
                    text-decoration: none;
                    border-radius: 5px;
                '>Click Here to Login</a>
            </p>
            <br>
            <p>-- {$conf['site_name']} Team</p>
        ";

        // Plain text fallback
        $mail->AltBody = "Hi {$toName},\n\nWelcome to {$conf['site_name']}! You can log in here: {$loginUrl}";

        $mail->send();
        return "<p style='color:green;'>📧 A confirmation email has been sent to {$toEmail}.</p>";
    } catch (Exception $e) {
        return "<p style='color:red;'>❌ Email could not be sent. Error: {$mail->ErrorInfo}</p>";
    }
}

// -----------------------------
// Process signup form
// -----------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("<div style='color:red; font-weight:bold;'>❌ Invalid email</div>");
    }

    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        // Send welcome email
        $emailMsg = sendWelcomeEmail($email, $name, $conf);

        // Show success message
        echo "
        <div style='
            margin: 50px auto; 
            padding: 20px; 
            max-width: 500px; 
            border: 2px solid green; 
            border-radius: 10px; 
            background: #e6ffe6; 
            text-align: center;
            font-family: Arial, sans-serif;
        '>
            <h2>✅ Signup Successful!</h2>
            <p>Welcome, <b>{$name}</b> 🎉</p>
            <p>You can now <a href='signin.php'>login here</a>.</p>
            {$emailMsg}
        </div>";
    } else {
        echo "<div style='color:red; font-weight:bold;'>❌ Error: " . $conn->error . "</div>";
    }

    $stmt->close();
}
$conn->close();
