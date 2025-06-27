<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: templates/login.html");
    exit();
}
?>
