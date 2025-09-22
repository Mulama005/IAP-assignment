<?php
require_once "Layouts/layouts.php";   // include the class

$conf = [
    "site_name" => "My Website",
    "site_lang" => "en"
];

$layout = new Layouts();      // create an object
$layout->header($conf);       // call header
$layout->navbar($conf);       // call navbar
$layout->banner($conf);       // call banner
$layout->footer($conf);       // call footer
?>
