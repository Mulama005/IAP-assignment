<?php
require_once "Layouts/layouts.php";   // include the class

$conf = [
    "site_name" => "My Website",
    "site_lang" => "en"
];

$layout = new Layouts();      
$layout->header($conf);       
$layout->navbar($conf);       
$layout->banner($conf);       
$layout->footer($conf);       
?>
