<?php

include "Database.php";

class User
{
    private $id;
    private $username;
    private $password;
    private $firstName;
    private $lastName;
    private $email;
    private $image;
    private $token;
    private $active;
    private $ip;

    public function set($id = null, $username, $password, $firstName, $lastName, $email, $image, $token = null, $active = null, $ip = null)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->image = $image;
        $this->token = $token;
        $this->active = $active;
        $this->ip = $ip;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getAttributes()
    {
        return array(
            'id' => $this->id,
            'username' => $this->username,
            'password' => $this->password,
            'email' => $this->email,
            'image' => $this->image,
            'token' => $this->token,
            'active' => $this->active,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'ip' => $this->ip,
        );
    }

    public static function get($select, $where = '', $whereValue = '')
    {
        $con = Database::connect();
        if (empty($where)) {
            $query = "SELECT $select FROM users";
            $stmt = $con->prepare($query);
            $stmt->execute();
        } else {
            $query = "SELECT $select FROM users WHERE $where = ?";
            $stmt = $con->prepare($query);
            $stmt->execute(array($whereValue));
        }

        return $stmt;
    }

    public function save()
    {
        $con = Database::connect();
        $query = "INSERT INTO 
                    users(username, password, firstName, lastName, email, image, token, active, ip)
                    VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($query);

        if ($stmt->execute(array($this->username, $this->password, $this->firstName, $this->lastName, $this->email, $this->image, $this->token, $this->active, $this->ip))) {
            return true;
        }

        return false;
    }

    public static function delete($where, $whereValue)
    {
        $con = Database::connect();
        $query = "DELETE FROM users WHERE $where = ?";
        $stmt = $con->prepare($query);

        if ($stmt->execute(array($whereValue))) {
            return true;
        }

        return false;
    }

    public static function update($assocArr, $where, $whereValue)
    {
        $updateStr = '';

        foreach ($assocArr as $key => $val) {
            $updateStr .= $key . " = '" . $val . "', ";
        }

        $updateStr = substr($updateStr, 0, strlen($updateStr) - 2);

        $con = Database::connect();
        $query = "UPDATE users SET $updateStr WHERE $where = ?";
        $stmt = $con->prepare($query);

        if ($stmt->execute(array($whereValue))) {
            return true;
        }

        return false;
    }

    public static function checkDublication($where)
    {
        $con = Database::connect();
        $query = "SELECT id FROM users WHERE $where";
        $stmt = $con->prepare($query);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}
