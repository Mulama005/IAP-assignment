<?php
require_once "Layouts/layouts.php";  

$conf = [
    "site_name" => "Task app",
    "site_lang" => "en"
];

$layout = new Layouts();      
$layout->header($conf);       
$layout->navbar($conf);       
?>

<h2>Sign In</h2>

<form action="signin_process.php" method="POST">
    <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" name="email" id="email" required>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
    </div>

    <button type="submit" class="btn">Login</button>
</form>

<?php
$layout->footer($conf);       
?>
