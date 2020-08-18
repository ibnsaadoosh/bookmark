<?php

require_once "validation/Validator.php";
require_once "models/Site.php";

class SiteController
{
    public function add($siteObj)
    {
        $validatoinRules = array(
            'title' => ['required', 'minLen' => 2, 'maxLen' => 30],
            'link' => ['required', 'link']
        );

        $data = $siteObj->getAttributes();
        $data['title'] = filter_var($data['title'], FILTER_SANITIZE_STRING);
        $data['link'] = filter_var($data['link'], FILTER_SANITIZE_URL);
        $data['comment_section'] = filter_var($data['comment_section'], FILTER_SANITIZE_STRING);

        $validator = new Validator();
        $validator->validate($data, $validatoinRules);

        if ($validator->fail()) {
            return $validator->_errors;
        }

        $siteObj->set(
            null,
            $data['title'],
            $data['link'],
            $data['comment_section'],
            $data['parent'],
            $data['user_id']
        );

        return $siteObj->save();
    }

    public function update($updatedElements)
    {
        $validatoinRules = array(
            'title' => ['required', 'minLen' => 2, 'maxLen' => 30],
            'link' => ['required', 'link']
        );

        if (isset($updatedElements['title'])) {
            $updatedElements['title'] = filter_var($updatedElements['title'], FILTER_SANITIZE_STRING);
        }
        if (isset($updatedElements['link'])) {
            $updatedElements['link'] = filter_var($updatedElements['link'], FILTER_SANITIZE_URL);
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

        return Site::update($updatedElements, 'id', $id);
    }

    public function delete($where = [], $whereValue = [], $andOr = '')
    {
        return Site::delete($where, $whereValue, $andOr);
    }

    public function get($select, $where = [], $whereValue = [], $andOr = '')
    {
        return Site::get($select, $where, $whereValue, $andOr);
    }
}
