<?php
/**
 * Created by PhpStorm.
 * User: mayank
 * Date: 08/06/19
 * Time: 2:13 PM
 */

include_once $_SERVER['DOCUMENT_ROOT'] . "/CrawlerBoard/api/LogManager.php";

$response = LogManager::getOutputLogs();
if(isset($response) && isset($response[JSONConsts::$DATA])) {
    echo $response[JSONConsts::$DATA];
}