<?php

include('database.php');

class Validator
{
    private $_errors = [];

    public function validate($data, $rules = [])
    {
        foreach($data as $item => $item_value)
        {
            if(key_exists($item, $rules))
            {
                foreach($rules[$item] as $rule => $rule_value)    
                {
                    if(is_int($rule))      
                        $rule = $rule_value;
                    
                    switch($rule)
                    {
                        case 'required':
                            if(empty($item_value))
                                addError($item, $item. ' required');
                        break;

                        case 'minLen':
                            if(strlen($item_value) < $rule_value)
                                addError($item, $item. ' should be minimum '. $rule_value. 'characters');
                        break;

                        case 'maxLen':
                            if(strlen($item_value > $rule_value))
                                addError($item, $item. ' should be maximum '. $rule_value. 'characters');
                        break;

                        case 'email':
                            if(!validEmail($item_value))
                                addError($item, $item. ' is not valid');                           
                        break;

                        case 'unique':
                        if(checkDuplication($item, $item_value, $rule_value))   //rule_value here is the name of the table in which duplication is being checked.
                            addError($item, $item. 'is not unique');
                        break;
                    }
                }
            }
            
        }
    }

    private function validEmail($email)
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

    private function addError($item, $errMessege)
    {
        $_errors[$item][] = $errMessege;
    }

    public function error()
    {
        if(empty($this->_errors)) return false;
        return $this->_errors;
    }
      
}

?>