<?php
session_start();

$userIsLoggedIn = $_SESSION['user_is_logged_in'];
if(!$userIsLoggedIn) {
    header("Location: /login.php");
    exit;
}
