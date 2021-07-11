<?php
/**
 * Created by PhpStorm.
 * User: mayank
 * Date: 07/06/19
 * Time: 2:49 PM
 */

include_once $_SERVER['DOCUMENT_ROOT'] . "/CrawlerBoard/utils/JSONConsts.php";

class FileManager
{
    public static function readFile($filename)
    {
        $fileResponse = array();
        try {
            $myfile = fopen($filename, "r");
            $content = fread($myfile, filesize($filename));
            fclose($myfile);
            $fileResponse[JSONConsts::$STATUS] = JSONConsts::$STATUS_SUCCESS;
            $fileResponse[JSONConsts::$DATA] = $content;
        } catch (Exception $e) {
            $fileResponse[JSONConsts::$STATUS] = JSONConsts::$STATUS_FAILURE;
        }
        return $fileResponse;
    }
}