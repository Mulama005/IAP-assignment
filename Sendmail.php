<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class SendMail
{
    private $conf;

    public function __construct($conf)
    {
        $this->conf = $conf;
    }

    public function sendWelcomeEmail($toEmail, $toName)
    {
        $mail = new PHPMailer(true);

        try {
            // Enable/disable debugging from config
            if (!empty($this->conf['smtp_debug']) && $this->conf['smtp_debug'] === true) {
                $mail->SMTPDebug  = 2;        // Show client <-> server messages
                $mail->Debugoutput = 'html';  // Format output nicely for browser
            } else {
                $mail->SMTPDebug = 0;         // No debug (production)
            }

            // SMTP configuration (from conf.php)
            $mail->isSMTP();
            $mail->Host       = $this->conf['smtp_host'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->conf['smtp_user'];
            $mail->Password   = $this->conf['smtp_pass'];

            // Secure connection
            if ($this->conf['smtp_secure'] === 'ssl') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            } else {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            }

            $mail->Port       = $this->conf['smtp_port'];

            // Sender & recipient
            $mail->setFrom($this->conf['smtp_user'], $this->conf['site_name']);
            $mail->addAddress($toEmail, $toName);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Welcome to ' . $this->conf['site_name'];
            $mail->Body = "
    <h2>✅ Signup Successful!</h2>
    <p>Hello <b>{$toName}</b>,</p>
    <p>Thank you for signing up at <b>{$this->conf['site_name']}</b>.</p>
    <p>You can now log in by clicking the button below:</p>
    <p>
        <a href='{$this->conf['site_url']}/signin.php' style='
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
    <p>-- {$this->conf['site_name']} Team</p>
";


            $mail->AltBody = "Hi {$toName},\n\nWelcome to {$this->conf['site_name']}! You can log in here: {$this->conf['site_url']}/signin.php";


            $mail->send();
            return true;

        } catch (Exception $e) {
            return "Mailer Error: " . $mail->ErrorInfo;
        }
    }
}
