<?php
require_once "vendors/config.php";
require_once "controllers/RegisterController.php";
require_once "controllers/LoginController.php";
require_once "models/User.php";

if (isset($_SESSION['access_token']))
    $gClient->setAccessToken($_SESSION['access_token']);
else if (isset($_GET['code'])) {
    $token = $gClient->fetchAccessTokenWithAuthCode($_GET['code']);
    $_SESSION['access_token'] = $token;
} else {
    header('Location: login.php');
    exit();
}

$oAuth = new Google_Service_Oauth2($gClient);
$userData = $oAuth->userinfo_v2_me->get();

$login = new LoginController();
$loginRes = $login->loginWithGoogle($userData['email']);

if ($loginRes === true) {
    header("Location: index.php");
    die();
}

$user = new User();
$user->set(null, null, null, $userData['givenName'], $userData['familyName'], $userData['email'], $userData['picture'], $_SERVER['REMOTE_ADDR']);

$register = new RegisterController();
$registerRes = $register->registerWithGoogle($user);

$_SESSION['google'] = true;
$_SESSION['user_data']['id'] = "google";
$_SESSION['user_data']['firstName'] = $userData['givenName'];
$_SESSION['user_data']['lastName'] = $userData['familyName'];
$_SESSION['user_data']['username'] = null;
$_SESSION['user_data']['password'] = null;
$_SESSION['user_data']['email'] = $userData['email'];
$_SESSION['user_data']['image'] = $userData['picture'];
$_SESSION['user_data']['date'] = date("Y-m-d h:i:s");
$_SESSION['user_data']['ip'] = $_SERVER['REMOTE_ADDR'];

header("Location: index.php");
die();
