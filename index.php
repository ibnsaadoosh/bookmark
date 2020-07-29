<?php

require_once "validation/Validator.php";

$data = [
    "username" => "",
];

$rules = [
    "username" => [
        "minLen" => 6, "maxLen" => 50
    ],
];

$validator = new Validator();
$validator->validate($data, $rules);

if ($validator->fail()) {
    echo "<pre>";
    print_r($validator->_errors);
    echo "</pre>";
} else {
    echo "Validated successfully";
}
