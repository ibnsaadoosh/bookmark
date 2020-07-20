<?php
    
    include_once 'Database.php';
    include ('validator/Validator.php');
    Database::connect();
    //, 'email' => 'saad@gmail.com'
    $data = ['username' => '', 'password' => 'pass'];
    $rules = [
    'username' => ['required', 'minLen' => 6,'maxLen' => 150, 'unique' => 'users'],
    'password' => ['required', 'minLen' => 8],
    ];
    //'email'    => ['required', 'email', 'unique' => 'users']

    //echo "hello";
    $v = new Validator;
    $v->validate($data, $rules);
    
    if($v->fail())
    {
        echo "fail";
        //print_r($v->error);
    }
    else 
        echo "validation success";
?>
