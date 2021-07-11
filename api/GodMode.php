<?php

/**
 * Created by PhpStorm.
 * User: Mayank
 * Date: 08-09-2017
 * Time: 07:22
 */
class GodMode
{
    public static function authenticate($username, $password) {
        include_once $_SERVER['DOCUMENT_ROOT'] . "/CrawlerBoard/utils/JSONConsts.php";
        include_once $_SERVER['DOCUMENT_ROOT'] . "/CrawlerBoard/utils/GenUtils.php";
        include_once $_SERVER['DOCUMENT_ROOT'] . "/CrawlerBoard/api/SessionManager.php";

        $json = array();
        $json[JSONConsts::$STATUS] = JSONConsts::$STATUS_FAILURE;
        if($username == 'mayank' && $password == 'f6f8b75c4b478327261a007d295d09cb528f3b705adf0ad228fbefe0dec81f346f0184aaf400bf3df9c9e3a56add7e568b74b0d00dd1af7035d985149ccc0a0e') {
            $json[JSONConsts::$STATUS] = JSONConsts::$STATUS_SUCCESS;
            $auth_token = GenUtils::generateHash(GenUtils::genRand(10));
            SessionManager::beginSession('WEB', $auth_token);
            http_response_code(200);
        } else {
            http_response_code(403);
        }
        return json_encode($json);
    }
}