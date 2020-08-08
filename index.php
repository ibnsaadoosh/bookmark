<?php

include "controllers/UserController.php";

$newData = [
    'id' => 4,
    'username' => 'newUsername',
    'firstName' => 'newFirstName'
];

$userController = new UserController();
$res = $userController->update($newData);
if ($res == true) {
    echo "Updated successfully";
} else {
    echo "<pre>";
    print_r($res);
    echo "</pre>";
}
