<?php
    
    include_once 'Database.php';
    include ('validator/Validator.php');
    Database::connect();
    //, 'email' => 'saad@gmail.com'
    $data = ['username' => 'saaaad', 'password' => 'pass', 'email' => 'mmm@yahoo.com'];
    $rules = [
    'email' => ['required', 'email'],
    'username' => ['required', 'maxLen' => 3],
    'password' => ['required', 'minLen' => 8],
    ];
    //'email'    => ['required', 'email', 'unique' => 'users']

    //echo "hello";
    $v = new Validator;
    $v->validate($data, $rules);
    if($v->fail())
    {
        print_r($v->_errors);
    }
    else 
        echo "validation success";
?>
