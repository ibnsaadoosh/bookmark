<?php
$header = true;
$pageName = "Main";
include "init.php";

if (!isset($_SESSION['user_data'])) {
    header("Location: login.php");
}

echo "<pre>";
print_r($_SESSION);
echo "</pre>";

include_once "includes/footerIncludes.php";
