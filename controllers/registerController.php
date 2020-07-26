<?php

include_once "validation/Validator.php";
include_once "models/User.php";

class RegisterController
{
    public function register($userObj)
    {
        $validatoinRules = array(
            'username' => ['required', 'minLen' => 8, 'maxLen' => 20],
            'password' => ['required', 'minLen' => 8, 'maxLen' => 50],
            'email' => ['required', 'email'],
            'firstName' => ['minLen' => 5, 'maxLen' => 30],
            'lastName' => ['minLen' => 5, 'maxLen' => 30]
        );
        $data = $userObj->getAttributes();
        $data['username'] = filter_var($data['username'], FILTER_SANITIZE_STRING);
        $data['password'] = filter_var($data['password'], FILTER_SANITIZE_STRING);
        $data['firstName'] = filter_var($data['firstName'], FILTER_SANITIZE_STRING);
        $data['lastName'] = filter_var($data['lastName'], FILTER_SANITIZE_STRING);

        $validator = new Validator();
        $validator->validate($data, $validatoinRules);

        if ($validator->fail()) {
            return $validator->_errors;
        }

        if ($userObj->checkDublication("email = '" . $data['email'] . "'")) {
            return array('email' => 'This email used before');
        } else if ($userObj->checkDublication("username = '$" . $data['username'] . "'")) {
            return array('username' => 'This username used before');
        }

        $userObj->set(
            null,
            $data['username'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['firstName'],
            $data['lastName'],
            $data['email'],
            $data['ip']
        );

        if ($userObj->save()) {
            session_start();
            $_SESSION['email'] = $data['email'];
            return true;
        } else {
            return false;
        }
    }
}
