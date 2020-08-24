<?php

require_once "validation/Validator.php";
require_once "models/User.php";

class UserController
{
    public function update($updatedElements)
    {
        $validatoinRules = array(
            'username' => ['minLen' => 8, 'maxLen' => 20],
            'password' => ['minLen' => 8, 'maxLen' => 50],
            'email' => ['required', 'email'],
            'firstName' => ['minLen' => 2, 'maxLen' => 30],
            'lastName' => ['minLen' => 2, 'maxLen' => 30]
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
        if (isset($updatedElements['image'])) {
            $updatedElements['image']['name'] = filter_var($updatedElements['image']['name'], FILTER_SANITIZE_STRING);
        }

        $validator = new Validator();
        $validator->validate($updatedElements, $validatoinRules);

        if ($validator->fail()) {
            return $validator->_errors;
        }

        if (isset($updatedElements['username'])) {
            if (User::checkDublication("username = '" . $updatedElements['username'] . "' AND id != " . $updatedElements['id'])) {
                return array('username' => 'This username used before');
            }
        }

        if (isset($updatedElements['email'])) {
            if (User::checkDublication("email = '" . $updatedElements['email'] . "' AND id != " . $updatedElements['id'])) {
                return array('email' => 'This email used before');
            }
        }

        if (!empty($updatedElements['image']['name'])) {
            $oldImage = User::get('image', 'id', $updatedElements['id'])->fetch()['image'];

            if (!empty($oldImage) && !filter_var($oldImage, FILTER_VALIDATE_URL)) {
                unlink("uploads\images\avatars\\" . $oldImage);
            }

            $avatar = rand(0, 10000000000) . '_' . $updatedElements['image']['name'];
            move_uploaded_file($updatedElements['image']['tmp_name'], "uploads\images\avatars\\" . $avatar);
            $updatedElements['image'] = $avatar;
        }

        $id = $updatedElements['id'];
        if (isset($updatedElements['password'])) {
            $updatedElements['password'] = password_hash($updatedElements['password'], PASSWORD_DEFAULT);
        }
        array_shift($updatedElements); // to delete id

        if (User::update($updatedElements, 'id', $id) === true) {
            // Updating the session
            if (isset($updatedElements['firstName'])) $_SESSION['user_data']['firstName'] = $updatedElements['firstName'];
            if (isset($updatedElements['lastName'])) $_SESSION['user_data']['lastName'] = $updatedElements['lastName'];
            if (isset($updatedElements['username'])) $_SESSION['user_data']['username'] = $updatedElements['username'];
            if (isset($updatedElements['password'])) $_SESSION['user_data']['password'] = $updatedElements['password'];
            if (isset($updatedElements['email'])) $_SESSION['user_data']['email'] = $updatedElements['email'];
            if (isset($updatedElements['image'])) $_SESSION['user_data']['image'] = $updatedElements['image'];

            return true;
        } else return false;
    }

    public function get($select, $from = '', $where = '')
    {
        return User::get($select, $from, $where);
    }
}
