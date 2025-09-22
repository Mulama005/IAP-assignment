<?php
// Site timezone
$conf['site_timezone'] = 'Africa/Nairobi';

// Site information
$conf['site_name']  = 'ICS B Academy';
$conf['site_url']   = 'http://localhost/IAP%20assignment';
$conf['admin_email'] = 'admin@icsbacademy.com';

// Site language
$conf['site_lang'] = 'en';

// Database configuration
$conf['db_type'] = 'pdo';
$conf['db_host'] = 'localhost';
$conf['db_user'] = 'root';
$conf['db_pass'] = '';
$conf['db_name'] = 'tol';

// Email configuration
$conf['mail_type']    = 'smtp'; 
$conf['smtp_host']    = 'smtp.gmail.com';
$conf['smtp_user']    = 'bonimechii80@gmail.com';
$conf['smtp_pass']    = 'igfevzjmdjupwtik'; // Gmail App Password
$conf['smtp_port']    = 587;   // Gmail STARTTLS port
$conf['smtp_secure']  = 'tls'; // ✅ fixed typo
$conf['smtp_debug']   = false;  // true = show SMTP logs, false = disable
