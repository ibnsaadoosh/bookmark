<?php

include "database.php";

class Folder
{
    private $id;
    private $title;
    private $comment_section;
    private $parent;

    public function set($id = null, $title, $comment_section, $parent = 0)
    {
        $this->id = $id;
        $this->title = $title;
        $this->comment_section = $comment_section;
        $this->parent = $parent;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function get($select, $where = '', $whereValue = '')
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
                    folders(title, comment_section, parent)
                    VALUES(?, ?, ?)";
        $stmt = $con->prepare($query);

        if ($stmt->execute(array($this->title, $this->comment_section, $this->parent))) {
            return true;
        }

        return false;
    }

    public function delete()
    {
        $con = Database::connect();
        $query = "DELETE FROM folders WHERE id = ?";
        $stmt = $con->prepare($query);

        if ($stmt->execute(array($this->id))) {
            return true;
        }

        return false;
    }

    public function update($assocArr)
    {
        $updateStr = '';

        foreach ($assocArr as $key => $val) {
            $updateStr .= $key . " = '" . $val . "', ";
        }

        $updateStr = substr($updateStr, 0, strlen($updateStr) - 2);

        $con = Database::connect();
        $query = "UPDATE folders SET $updateStr WHERE id = ?";
        $stmt = $con->prepare($query);

        if ($stmt->execute(array($this->id))) {
            return true;
        }

        return false;
    }
}
