<?php
    class Database
    {        
        public static function connect($host='localhost', $username='root', $password='14921400', $dbName='bookmark')
        {
            $mysqli = new mysqli($host, $username, $password, $dbName); // Check connection
            if ($mysqli -> connect_errno) 
            { 
                echo "Failed to connect to MySQL: " . $mysqli -> connect_error; 
                exit(); 
            } 
        }
        public static function save($tableName, $attributes, $values)
        {
            $con = self::connect();     
            $tmpAttributes = "";
            for($i = 0 ; $i < sizeof($attributes) ; $i++)
            {
                $tmpAttributes += $attributes[i];
                if($i < sizeof($attributes) - 1)
                    $tmpAttributes += ',';
            }

            $tmpValues = "";
            for($i = 0 ; $i < sizeof($tmpValues) ; $i++)
            {
                $tmpValues += $values[i];
                if($i < sizeof($values) - 1)
                    $tmpValues += ',';
            }
            
            $sql = "INSERT INTO $tableName($tmpAttributes) VALUES ($tmpValues)";
            mysqli_query($con, $sql);            
        }
       
    }
?>