<?php

require_once "validation/Validator.php";
require_once "models/Folder.php";

class FolderController
{
    public function add($folderObj)
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

    public function update($updatedElements)
    {
        $validatoinRules = array(
            'title' => ['required', 'minLen' => 2, 'maxLen' => 30]
        );

        if (isset($updatedElements['title'])) {
            $updatedElements['title'] = filter_var($updatedElements['title'], FILTER_SANITIZE_STRING);
        }
        if (isset($updatedElements['comment_section'])) {
            $updatedElements['comment_section'] = filter_var($updatedElements['comment_section'], FILTER_SANITIZE_STRING);
        }

        $validator = new Validator();
        $validator->validate($updatedElements, $validatoinRules);

        if ($validator->fail()) {
            return $validator->_errors;
        }

        $id = $updatedElements['id'];
        array_shift($updatedElements);

        return Folder::update($updatedElements, 'id', $id);
    }

    public function delete($where = [], $whereValue = [], $andOr = '')
    {
        return Folder::delete($where, $whereValue, $andOr);
    }

    public function get($select, $where = [], $whereValue = [], $andOr = '')
    {
        return Folder::get($select, $where, $whereValue, $andOr);
    }
}
