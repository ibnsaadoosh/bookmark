<?php

$header = true;
$pageName = "Delete link";
include "init.php";
require_once "controllers/SiteController.php";

if (isset($_GET['id'])) {
    if (!is_numeric($_GET['id'])) {
        echo "<div class='alert alert-danger'>This id is <strong>not valid</strong></div>";
    } else if (empty($_GET['id'])) {
        echo "<div class='alert alert-danger'>Id can't be <strong>empty</strong></div>";
    } else {
        $siteController = new SiteController();
        if ($siteController->delete(['user_id', 'id'], [$_SESSION['user_data']['id'], intval($_GET['id'])], 'AND')) {
            echo "<div class='alert alert-success'>The site deleted successfully</div>";
        } else {
            echo "<div class='alert alert-danger'>Error heppend in website</div>";
        }
    }
}
