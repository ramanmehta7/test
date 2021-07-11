<?php
/**
 * Created by PhpStorm.
 * User: mayank
 * Date: 03/06/19
 * Time: 6:59 AM
 */

include_once $_SERVER['DOCUMENT_ROOT'] . "/CrawlerBoard/database/settings/SettingsDbValues.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/CrawlerBoard/database/settings/SettingConnectionWizard.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/CrawlerBoard/utils/JSONConsts.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/CrawlerBoard/utils/GenUtils.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/CrawlerBoard/GlobalConstants.php";

class SettingsManager
{
    public static $CONST_COUNT = 'count';

    /**
     * @return array
     * Responds the setting in JSON format.
     */
    public static function getSettings()
    {
        $conn = new SettingConnectionWizard();
        $connection = $conn->getConnection();

        $sql = "SELECT `" . SettingsDbValues::$FIELD_NAME_ID . "`, `" . SettingsDbValues::$FIELD_NAME_VALUE . "` FROM `" . SettingsDbValues::$TABLE_NAME_SETTINGS . "`";

        $settingsData = array();
        if ($stmt = $connection->prepare($sql)) {
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $queryResponse = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($queryResponse as $response) {
                    $currentSetting = [];
                    if (isset($response) && isset($response[SettingsDbValues::$FIELD_NAME_ID]) && isset($response[SettingsDbValues::$FIELD_NAME_VALUE])) {
                        $currentSetting[SettingsDbValues::$FIELD_NAME_ID] = $response[SettingsDbValues::$FIELD_NAME_ID];
                        $currentSetting[SettingsDbValues::$FIELD_NAME_VALUE] = $response[SettingsDbValues::$FIELD_NAME_VALUE];
                    }
                    array_push($settingsData, $currentSetting);
                }
                http_response_code(200);
            } else {
                http_response_code(200);
            }
            $stmt = null;
        } else {
            http_response_code(500);
        }
        $conn->closeConnection();
        $fields = [SettingsDbValues::$FIELD_NAME_ID, SettingsDbValues::$FIELD_NAME_VALUE];
        $settingsResponse = array();
        $settingsResponse[JSONConsts::$FIELDS] = $fields;
        $settingsResponse[JSONConsts::$DATA] = $settingsData;
        $settingsResponse[JSONConsts::$SCRIPT_ID] = GlobalConstants::$SCRIPT_ID;
        return $settingsResponse;
    }

    /**
     * @param $inputJSON
     * @return array
     */
    public static function updateSettings($inputJSON)
    {
        $insertCount = 0;
        $notAdded = array();
        if (isset($inputJSON)) {
            $json = json_decode($inputJSON, true);
            $fields = $json[JSONConsts::$FIELDS];
            $data = $json[JSONConsts::$DATA];
            $conn = new SettingConnectionWizard();
            $connection = $conn->getConnection();
            foreach ($data as $currentRow) {
                $statementAppendKeys = GenUtils::concatArray(array_keys($currentRow), ',', '`', '`');
                //This is not the real values for the keys, these are just the keys placed in the statement before preparing.
                $statementAppendValues = GenUtils::concatArray(array_keys($currentRow), ',', ':', '');

                $sql = "INSERT INTO `" . SettingsDbValues::$TABLE_NAME_SETTINGS . "`" .
                    "(" . $statementAppendKeys . ") VALUES " .
                    "(" . $statementAppendValues . ") ON DUPLICATE KEY UPDATE `" . SettingsDbValues::$FIELD_NAME_VALUE . "` = " .
                    ":" . SettingsDbValues::$FIELD_NAME_VALUE;

                if ($stmt = $connection->prepare($sql)) {
                    foreach (array_keys($currentRow) as $key) {
                        $stmt->bindParam($key, $currentRow[$key]);
                    }
                    if ($stmt->execute()) {
                        $insertCount++;
                    } else {
                        array_push($notAdded, $currentRow);
                    }
                    $stmt = null;
                }
            }
            $conn->closeConnection();
        } else {
            http_response_code(500);
        }
        $responseJSON = array("not_added" => $notAdded, "added" => $insertCount);
        return $responseJSON;
    }

    /**
     * @param $id
     * @return null
     */
    public static function getSettingFor($id)
    {
        $conn = new SettingConnectionWizard();
        $connection = $conn->getConnection();

        $sql = "SELECT `" . SettingsDbValues::$FIELD_NAME_VALUE . "` FROM `" . SettingsDbValues::$TABLE_NAME_SETTINGS . "` WHERE `" . SettingsDbValues::$FIELD_NAME_ID . "` = '" . $id . "'";

        $settingValue = null;
        if ($stmt = $connection->prepare($sql)) {
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $queryResponse = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (isset($queryResponse) && sizeof($queryResponse) > 0 && isset($queryResponse[0][SettingsDbValues::$FIELD_NAME_VALUE])) {
                    $settingValue = $queryResponse[0][SettingsDbValues::$FIELD_NAME_VALUE];
                }
                http_response_code(200);
            } else {
                http_response_code(200);
            }
            $stmt = null;
        } else {
            http_response_code(500);
        }
        $conn->closeConnection();
        return $settingValue;
    }
}