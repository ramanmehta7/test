<?php
/**
 * Created by PhpStorm.
 * User: mayank
 * Date: 06/06/19
 * Time: 5:33 AM
 */
class LifeCycleManager
{
    public static $CONST_SCRIPT_NAME = '/var/lib/jenkins/workspace/cases_goa/scrapping_driver.py';
    public static $CONST_SCRIPT_NAME_PARTY_NAME = '/var/lib/jenkins/workspace/cases_goa/partynamesearch.py';
    /**
     * @return bool
     * checks if the dashboard script is running or not.
     */
    public static function checkIfScriptIsRunning()
    {
        //check if a program for updating the queue is already running
        $checkUpdateQueueProgramRunningCommand = "pgrep -f ". LifeCycleManager::$CONST_SCRIPT_NAME;
        $updateQueueProgramRunningCommandResponse = shell_exec($checkUpdateQueueProgramRunningCommand );
        $process = explode("\n",$updateQueueProgramRunningCommandResponse);
        if (sizeof($process) > 2) {
            return "RUNNING CRAWL";
        }
        return "STOPPED";
    }
    /**
     * @return bool
     * executes the script for crawler.
     */
    public static function executeScript()
    {
        //executes the script for crawler.
        $async_command = ("python3 " . self::$CONST_SCRIPT_NAME . " > /dev/null 2>&1 &");
        $output = shell_exec($async_command);
        http_response_code(200);
    }
    public static function executeScriptPartyName($json)
    {
        //executes the script for crawler Party Name.
        $async_command = ("python3 " . self::$CONST_SCRIPT_NAME_PARTY_NAME . " " . $json );
        $output = shell_exec($async_command);
        http_response_code(200);
        return $output;
    }
}