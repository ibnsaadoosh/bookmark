<?php

include "validation/Validator.php";
include "models/User.php";

class UserController
{
    public function update($updatedElements)
    {
        $validatoinRules = array(
            'username' => ['minLen' => 8, 'maxLen' => 20],
            'password' => ['minLen' => 8, 'maxLen' => 50],
            'email' => ['required', 'email'],
            'firstName' => ['minLen' => 5, 'maxLen' => 30],
            'lastName' => ['minLen' => 5, 'maxLen' => 30]
        );

        if (isset($updatedElements['username'])) {
            $updatedElements['username'] = filter_var($updatedElements['username'], FILTER_SANITIZE_STRING);
        }
        if (isset($updatedElements['password'])) {
            $updatedElements['password'] = filter_var($updatedElements['password'], FILTER_SANITIZE_STRING);
        }
        if (isset($updatedElements['firstName'])) {
            $updatedElements['firstName'] = filter_var($updatedElements['firstName'], FILTER_SANITIZE_STRING);
        }
        if (isset($updatedElements['lastName'])) {
            $updatedElements['lastName'] = filter_var($updatedElements['lastName'], FILTER_SANITIZE_STRING);
        }

        $validator = new Validator();
        $validator->validate($updatedElements, $validatoinRules);

        if ($validator->fail()) {
            return $validator->_errors;
        }

        if (isset($updatedElements['username'])) {
            if (User::checkDublication("username = '" . $updatedElements['username'] . "'")) {
                return array('username' => 'This username used before');
            }
        }

        if (isset($updatedElements['email'])) {
            if (User::checkDublication("email = '" . $updatedElements['email'] . "'")) {
                return array('email' => 'This email used before');
            }
        }

        if (isset($updatedElements['image'])) {
            $oldImage = User::get('image', 'id', $updatedElements['id']);

            if (!empty($oldImage)) {
                unlink("uploads\images\avatars\\");
            }

            $avatar = rand(0, 10000000000) . '_' . $updatedElements['image']['name'];
            move_uploaded_file($updatedElements['image']['tmp_name'], "uploads\images\avatars\\" . $avatar);
        }

        $id = $updatedElements['id'];
        array_shift($updatedElements);

        return User::update($updatedElements, 'id', $id);
    }
}
