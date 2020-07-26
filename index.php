<?php

include 'models/User.php';
include_once 'controllers/LoginController.php';



// $site = new folder();
// $site->setId(1);
// if ($site->delete()) {
//     echo "Deleted successfully";
// }
// include ('validator/Validator.php');
// Database::connect();
// //, 'email' => 'saad@gmail.com'
// $data = ['username' => 'saaaad', 'password' => 'pass', 'email' => 'mmm@yahoo.com'];
// $rules = [
// 'email' => ['required', 'email'],
// 'username' => ['required', 'maxLen' => 3],
// 'password' => ['required', 'minLen' => 8],
// ];
// //'email'    => ['required', 'email', 'unique' => 'users']

// //echo "hello";
// $v = new Validator;
// $v->validate($data, $rules);
// if($v->fail())
// {
//     print_r($v->_errors);
// }
// else 
//     echo "validation success";

// $user = new User();
// if ($user->checkDublication("email = 'saadoaush@gmail.com' or username = 'saadoush'")) {
//     echo "Dub";
// }

$login = new LoginController();

if ($login->login("khaled550", "SamehMohsen")) {
    echo "Logged in";
} else echo "Not logged in";
