<?php
class Database
{
    public static function connect($host = 'localhost', $username = 'root', $password = '', $dbName = 'bookmark')
    {
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        );

        try {
            $link = new PDO("mysql:host=$host;dbname=$dbName", $username, $password, $options); // Possible error
            $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Failed to connect " . $e->getMessage();
        }

        return $link;
    }

    // public static function save($tableName, $attributes, $values)
    // {
    //     $con = self::connect();     
    //     $tmpAttributes = "";
    //     for($i = 0 ; $i < sizeof($attributes) ; $i++)
    //     {
    //         $tmpAttributes += $attributes[i];
    //         if($i < sizeof($attributes) - 1)
    //             $tmpAttributes += ',';
    //     }

    //     $tmpValues = "";
    //     for($i = 0 ; $i < sizeof($tmpValues) ; $i++)
    //     {
    //         $tmpValues += $values[i];
    //         if($i < sizeof($values) - 1)
    //             $tmpValues += ',';
    //     }

    //     $sql = "INSERT INTO $tableName($tmpAttributes) VALUES ($tmpValues)";
    //     mysqli_query($con, $sql);            
    // }

}
