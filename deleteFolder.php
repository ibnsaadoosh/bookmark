<?php

$header = true;
$pageName = "Delete folder";
include "init.php";
require_once "controllers/FolderController.php";

if (isset($_GET['id'])) {
    if (!is_numeric($_GET['id'])) {
        echo "<div class='alert alert-danger'>This id is <strong>not valid</strong></div>";
    } else if (empty($_GET['id'])) {
        echo "<div class='alert alert-danger'>Id can't be <strong>empty</strong></div>";
    } else {
        $folderController = new FolderController();
        if ($folderController->delete(['user_id', 'id'], [$_SESSION['user_data']['id'], intval($_GET['id'])], 'AND')) {
            echo "<div class='alert alert-success'>The Folder deleted successfully</div>";
        } else {
            echo "<div class='alert alert-danger'>Error heppend in website</div>";
        }
    }
}
