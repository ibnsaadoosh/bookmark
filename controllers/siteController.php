<?php

include "validation/Validator.php";

class SiteController
{
    public static function add($siteObj)
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
}
