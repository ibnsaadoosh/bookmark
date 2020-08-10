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
            'email' => ['required', 'email']
        );
        $data = $userObj->getAttributes();
        $data['username'] = filter_var($data['username'], FILTER_SANITIZE_STRING);
        $data['password'] = filter_var($data['password'], FILTER_SANITIZE_STRING);
        $data['email'] = filter_var($data['email'], FILTER_SANITIZE_EMAIL);

        $validator = new Validator();
        $validator->validate($data, $validatoinRules);

        if ($validator->fail()) {
            return $validator->_errors;
        }

        if (User::checkDublication("email = '" . $data['email'] . "'")) {
            return array('email' => 'This email used before');
        } else if (User::checkDublication("username = '" . $data['username'] . "'")) {
            return array('username' => 'This username used before');
        }

        $userObj->set(
            null,
            $data['username'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            null,
            null,
            $data['email'],
            null,
            $data['ip']
        );

        return $userObj->save();
    }

    public function registerWithGoogle($userObj)
    {
        $data = $userObj->getAttributes();

        if (User::checkDublication("email = '" . $data['email'] . "'")) {
            return array('email' => 'This email used before');
        }

        return $userObj->save();
    }
}
