<?php
require 'ClassAutoLoad.php';
require 'db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id']   = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            header("Location: index.php");
            exit;
        } else {
            echo "❌ Wrong password.";
        }
    } else {
        echo "❌ User not found.";
    }

    $stmt->close();
}
$conn->close();
