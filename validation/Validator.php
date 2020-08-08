<?php

//include '../Database.php';

class Validator
{
    public $_errors = [];
    public function validate($data, $rules = [])
    {
        foreach ($data as $item => $item_value) {
            if (key_exists($item, $rules)) {
                $continue = true;
                foreach ($rules[$item] as $rule => $rule_value) {
                    if (!$continue) break;       //to stop validation if required failed

                    if (is_int($rule))
                        $rule = $rule_value;

                    switch ($rule) {
                        case 'required':
                            if (empty($item_value)) {
                                $this->addError($item, $item . ' required');
                                $continue = false;
                            }
                            break;

                        case 'minLen':
                            if (strlen($item_value) < $rule_value && !empty($item_value))
                                $this->addError($item, $item . ' should be minimum ' . $rule_value . ' characters');
                            break;

                        case 'maxLen':
                            if (strlen($item_value) > $rule_value && !empty($item_value))
                                $this->addError($item, $item . ' should be maximum ' . $rule_value . ' characters');
                            break;

                        case 'email':
                            if (!$this->validEmail($item_value))
                                $this->addError($item, $item . ' is not valid');
                            break;

                        case 'allowedExs':
                            $explodedName = explode('.', $item_value['name']);
                            $ex = strtolower(end($explodedName));
                            if (!empty($item_value['name']) && !in_array($ex, $rule_value))
                                $this->addError($item, "Image extension is not valid");
                            break;

                        case 'imgMaxSize':
                            if ($item_value['size'] > $rule_value)
                                $this->addError($item, "Image can't be larger than " . intval($rule_value / 1000000) . " MB");
                            break;

                        case 'link':
                            if (!filter_var($item_value, FILTER_VALIDATE_URL))
                                $this->addError($item, $item . " not valid");
                            break;
                    }
                }
            }
        }
    }



    private function validEmail($item_value)
    {

        $email = $item_value;
        //Extract domain name from email address
        $domain = substr($email, strpos($email, '@') + 1);

        //check whether the domain defines an MX record
        if (!checkdnsrr($domain, 'MX'))
            return false;

        //check email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }

    public function fail()
    {
        if (empty($this->_errors)) return false;
        return true;
    }

    private function addError($item, $errMessage)
    {
        $this->_errors[$item][] = $errMessage;
    }
}
