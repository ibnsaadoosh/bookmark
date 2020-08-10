<?php
require_once "GoogleAPI/vendor/autoload.php";
$gClient = new Google_Client();
$gClient->setClientId("537000685570-gbje757qj6mekr1bhm89r13s2j1c3kiv.apps.googleusercontent.com");
$gClient->setClientSecret("sbEj0wmJPCVlgfDwE8Tws0Je");
$gClient->setApplicationName("Bookmark saver");
$gClient->setRedirectUri("http://localhost:8080/PHPWork/bookmark/googleCallback.php");
$gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");
