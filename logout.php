<?php

session_start();

if (isset($_SESSION['google'])) {
    require_once "config.php";
    unset($_SESSION['google']);
    $gClient->revokeToken();
}

session_destroy();

header("Location: index.php");
