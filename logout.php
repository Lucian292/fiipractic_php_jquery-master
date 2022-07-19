<?php
session_start();
$_SESSION["user_is_logged_in"] = false;
header("Location: /login.php");
?>