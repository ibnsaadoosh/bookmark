<?php

//Display errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//include '../Database.php';

class Validator
{
    public $_errors = [];
    public function validate($data, $rules = [])
    {
        //echo "hi";
        foreach($data as $item => $item_value)
        {
           // echo "hi";
            if(key_exists($item, $rules))
            {          
                $continue = true;
                foreach($rules[$item] as $rule => $rule_value)    
                {
                    if(!$continue) break;       //to stop validation if required failed

                    if(is_int($rule))      
                        $rule = $rule_value;
                    
                    switch($rule)
                    {
                        case 'required':
                            if(empty($item_value))
                            {
                                $this->addError($item, $item. ' required');
                                $continue = false;
                            }
                        break;

                        case 'minLen':
                            if(strlen($item_value) < $rule_value)
                                $this->addError($item, $item. ' should be minimum '. $rule_value. ' characters');
                        break;

                        case 'maxLen':
                            if(strlen($item_value) > $rule_value) 
                                $this->addError($item, $item. ' should be maximum '. $rule_value. ' characters');
                        break;

                        case 'email':
                            if(!$this->validEmail($item_value))
                                $this->addError($item, $item. ' is not valid');                           
                        break;

                        case 'unique':
                            if($this->checkDuplication($item, $item_value, $rule_value))   //rule_value here is the name of the table in which duplication is being checked.
                                $this->addError($item, $item. 'is not unique');
                        break;
                    }
                }
            }
            
        }
    }
    
  

    private function validEmail($item_value)
    {   
        // Remove all illegal characters from email
        $email = filter_var($item_value, FILTER_SANITIZE_EMAIL);

        //Extract domain name from email address
        $domain = substr($email, strpos($email, '@') + 1);

        //check whether the domain defines an MX record
        if(!checkdnsrr($domain, 'MX'))
            return false;

        //check email format
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            return false;
        }

        return true;
    }

    private function checkDuplication($item, $item_value, $table)
    {
        $con = Database::connect();
        $duplicate = mysqli_query($con, "select * from '$table' where '$item' = '$item_value'");
        if (mysqli_num_rows($duplicate) > 0)
            return false;
    }
    
    public function fail()
    {
        if(empty($this->_errors)) return false;
        return true;
    }

    private function addError($item, $errMessage)
    {
        $this->_errors[$item][] = $errMessage;
    }   
      
}

?>