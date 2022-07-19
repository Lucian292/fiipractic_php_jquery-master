<?php
session_start();

ini_set('display_errors', 1);

require_once "config.php";

$username = $_POST['username'];
$password = $_POST['password'];

$_SESSION['user_is_logged_in'] = false;
$_COOKIE['error_message'] = null;

if($username === USERNAME && $password === PASSWORD) {
    $_SESSION['user_is_logged_in'] = true;
    header("Location: /index.php");
} else {
    setcookie("error_message", "Invalid credentails");
    header("Location: /login.php");

}

