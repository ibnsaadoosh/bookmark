<?php

include "validation/Validator.php";

class FolderController
{
    public static function add($folderObj)
    {
        $validatoinRules = array(
            'title' => ['required', 'minLen' => 2, 'maxLen' => 30]
        );

        $data = $folderObj->getAttributes();
        $data['title'] = filter_var($data['title'], FILTER_SANITIZE_STRING);
        $data['comment_section'] = filter_var($data['comment_section'], FILTER_SANITIZE_STRING);

        $validator = new Validator();
        $validator->validate($data, $validatoinRules);

        if ($validator->fail()) {
            return $validator->_errors;
        }

        $folderObj->set(
            null,
            $data['title'],
            $data['comment_section'],
            $data['parent'],
            $data['user_id']
        );

        return $folderObj->save();
    }
}
