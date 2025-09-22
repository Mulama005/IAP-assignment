<?php
// Load Composer autoloader for PHPMailer and other Composer packages
require __DIR__ . '/vendor/autoload.php';

// Load configuration
require 'conf.php';

// Custom autoloader for your own classes
$directories = ['Layouts', 'Forms', 'Global'];

spl_autoload_register(function ($class_name) use ($directories) {
    foreach ($directories as $directory) {
        $file = __DIR__ . '/' . $directory . '/' . $class_name . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});


$ObjSendMail = new SendMail($conf);  
$ObjLayout   = new Layouts();
$ObjForm     = new Forms();
