<?php

include "database.php";

class Folder
{
    private $id;
    private $title;
    private $comment_section;
    private $parent;
    private $user_id;

    public function set($id = null, $title, $comment_section, $parent = 0, $user_id)
    {
        $this->id = $id;
        $this->title = $title;
        $this->comment_section = $comment_section;
        $this->parent = $parent;
        $this->user_id = $user_id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getAttributes()
    {
        return array(
            'id' => $this->id,
            'title' => $this->title,
            'comment_section' => $this->comment_section,
            'parent' => $this->parent,
            'user_id' => $this->user_id
        );
    }

    public static function get($select, $where = '', $whereValue = '')
    {
        $con = Database::connect();
        if (empty($where)) {
            $query = "SELECT $select FROM folders";
            $stmt = $con->prepare($query);
            $stmt->execute();
        } else {
            $query = "SELECT $select FROM folders WHERE $where = ?";
            $stmt = $con->prepare($query);
            $stmt->execute(array($whereValue));
        }

        return $stmt;
    }

    public function save()
    {
        $con = Database::connect();
        $query = "INSERT INTO 
                    folders(title, comment_section, parent, user_id)
                    VALUES(?, ?, ?, ?)";
        $stmt = $con->prepare($query);

        if ($stmt->execute(array($this->title, $this->comment_section, $this->parent, $this->user_id))) {
            return true;
        }

        return false;
    }

    public static function delete($where, $whereValue)
    {
        $con = Database::connect();
        $query = "DELETE FROM folders WHERE $where = ?";
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
        $query = "UPDATE folders SET $updateStr WHERE $where = ?";
        $stmt = $con->prepare($query);

        if ($stmt->execute(array($whereValue))) {
            return true;
        }

        return false;
    }
}
