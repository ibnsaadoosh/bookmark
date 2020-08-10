<?php
session_start();

if (!isset($_SESSION['user_data'])) {
    header("Location: login.php");
}

echo "<pre>";
print_r($_SESSION['user_data']);
echo "</pre>";
