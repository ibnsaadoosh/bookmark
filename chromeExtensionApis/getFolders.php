<?php

require_once "../controllers/FolderController.php";
// echo "Hello man";
session_start();

if (isset($_SESSION['user_data'])) {
	$folderController = new FolderController();
	echo json_encode($folderController->get('title', ['user_id'], [$_SESSION['user_data']['id']])->fetchAll());
} else echo false;