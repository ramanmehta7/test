<?php
/**
 * Created by PhpStorm.
 * User: mayank
 * Date: 07/06/19
 * Time: 2:39 PM
 */

include_once $_SERVER['DOCUMENT_ROOT'] . "/CrawlerBoard/database/settings/SettingsManager.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/CrawlerBoard/GlobalConstants.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/CrawlerBoard/utils/FileManager.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/CrawlerBoard/api/SessionManager.php";

class LogManager
{

    public static function getOutputLogs()
    {
        if (SessionManager::isSessionAlive()) {
            $logDir = SettingsManager::getSettingFor(GlobalConstants::$SETTING_ID_LOG_DIR);
            $dirSep = SettingsManager::getSettingFor(GlobalConstants::$SETTING_ID_DIR_SEPARATOR);
            $sout = SettingsManager::getSettingFor(GlobalConstants::$SETTING_ID_SYSOUT_LOG_FILENAME);
            $extension = SettingsManager::getSettingFor(GlobalConstants::$SETTING_ID_LOG_FILE_EXTENSION);

            $logOutFilePath = ($logDir . $dirSep . $sout . $extension);

            $logOutContent = FileManager::readFile($logOutFilePath);

            return $logOutContent;
        }
        http_response_code(403);
        return '';
    }

    public static function getErrorLogs()
    {
        if (SessionManager::isSessionAlive()) {

            $logDir = SettingsManager::getSettingFor(GlobalConstants::$SETTING_ID_LOG_DIR);
            $dirSep = SettingsManager::getSettingFor(GlobalConstants::$SETTING_ID_DIR_SEPARATOR);
            $serr = SettingsManager::getSettingFor(GlobalConstants::$SETTING_ID_SYSERR_LOG_FILENAME);
            $extension = SettingsManager::getSettingFor(GlobalConstants::$SETTING_ID_LOG_FILE_EXTENSION);

            $logErrFilePath = $logDir . $dirSep . $serr . $extension;

            $logErrContent = FileManager::readFile($logErrFilePath);

            return $logErrContent;
        }
        http_response_code(403);
        return '';
    }
}