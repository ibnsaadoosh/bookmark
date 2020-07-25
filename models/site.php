<?php

include "database.php";

class Site
{
    private $id;
    private $title;
    private $link;
    private $comment_section;
    private $parent;

    public function set($id = null, $title, $link, $comment_section, $parent = 0)
    {
        $this->id = $id;
        $this->title = $title;
        $this->link = $link;
        $this->comment_section = $comment_section;
        $this->parent = $parent;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function save()
    {
        $con = Database::connect();
        $query = "INSERT INTO 
                    sites(title, link, comment_section, parent)
                    VALUES(?, ?, ?, ?)";
        $stmt = $con->prepare($query);

        if ($stmt->execute(array($this->title, $this->link, $this->comment_section, $this->parent))) {
            return true;
        }

        return false;
    }

    public function delete()
    {
        $con = Database::connect();
        $query = "DELETE FROM sites WHERE id = ?";
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
        $query = "UPDATE sites SET $updateStr WHERE id = ?";
        $stmt = $con->prepare($query);

        if ($stmt->execute(array($this->id))) {
            return true;
        }

        return false;
    }
}
