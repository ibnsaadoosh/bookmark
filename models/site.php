<?php

require_once "database.php";

class Site
{
    private $id;
    private $title;
    private $link;
    private $comment_section;
    private $parent;
    private $user_id;

    public function set($id = null, $title, $link, $comment_section, $parent = 0, $user_id)
    {
        $this->id = $id;
        $this->title = $title;
        $this->link = $link;
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
            'link' => $this->link,
            'comment_section' => $this->comment_section,
            'parent' => $this->parent,
            'user_id' => $this->user_id
        );
    }

    public static function get($select, $where = '', $whereValue = '')
    {
        $con = Database::connect();
        if (empty($where)) {
            $query = "SELECT $select FROM sites";
            $stmt = $con->prepare($query);
            $stmt->execute();
        } else {
            if ($whereValue == null) {
                $query = "SELECT $select FROM sites WHERE $where IS ?";
            } else {
                $query = "SELECT $select FROM sites WHERE $where = ?";
            }
            $stmt = $con->prepare($query);
            $stmt->execute(array($whereValue));
        }

        return $stmt;
    }

    public function save()
    {
        $con = Database::connect();
        $query = "INSERT INTO 
                    sites(title, link, comment_section, parent, user_id)
                    VALUES(?, ?, ?, ?, ?)";
        $stmt = $con->prepare($query);

        if ($stmt->execute(array($this->title, $this->link, $this->comment_section, $this->parent, $this->user_id))) {
            return true;
        }

        return false;
    }

    public static function delete($where, $whereValue)
    {
        $con = Database::connect();
        $query = "DELETE FROM sites WHERE $where = ?";
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
        $query = "UPDATE sites SET $updateStr WHERE $where = ?";
        $stmt = $con->prepare($query);

        if ($stmt->execute(array($whereValue))) {
            return true;
        }

        return false;
    }
}
