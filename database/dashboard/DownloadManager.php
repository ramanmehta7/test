<?php
/**
 * Created by PhpStorm.
 * User: mayank
 * Date: 03/06/19
 * Time: 6:59 AM
 */
include_once $_SERVER['DOCUMENT_ROOT'] . "/CrawlerBoard/database/dashboard/DbValues.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/CrawlerBoard/database/dashboard/ConnectionWizard.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/CrawlerBoard/utils/JSONConsts.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/CrawlerBoard/utils/GenUtils.php";
class DownloadManager
{
    public static $CONST_COUNT = 'count';
    /**
     * @return array
     * Responds the count of various statuses in the database. It is used in showing the number of success, failures and pending.
     */
    public static function getOverview()
    {
        $conn = new ConnectionWizard();
        $connection = $conn->getConnection();
        $sql = "SELECT `" . DbValues::$FIELD_NAME_DOWNLOAD_STATUS . "`, COUNT(*) AS `" . DownloadManager::$CONST_COUNT . "` FROM `" . DbValues::$TABLE_NAME_DOWNLOAD_MANAGER . "` GROUP BY `" . DbValues::$FIELD_NAME_DOWNLOAD_STATUS . "`";
        $status = array();
        if ($stmt = $connection->prepare($sql)) {
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $queryResponse = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($queryResponse as $response) {
                    if (isset($response) && isset($response[DbValues::$FIELD_NAME_DOWNLOAD_STATUS]) && isset($response[DownloadManager::$CONST_COUNT])) {
                        $status[$response[DbValues::$FIELD_NAME_DOWNLOAD_STATUS]] = $response[DownloadManager::$CONST_COUNT];
                    }
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
        return $status;
    }
    /**
     * @param $rangeStart
     * @param $rangeEnd
     * @param string $prefix
     * @param string $suffix
     * @return int
     */
    public static function insertRange($rangeStart, $rangeEnd, $prefix = '', $suffix = '')
    {
        $insertCount = 0;
        if (isset($rangeStart) && isset($rangeEnd)) {
            $conn = new ConnectionWizard();
            $connection = $conn->getConnection();
            for ($markID = $rangeStart; $markID <= $rangeEnd; $markID++) {
                date_default_timezone_set("Asia/Kolkata");
                $currentTimestamp = time();
                $formattedTimestamp = date('Y-m-d H:i:s', $currentTimestamp);
                $sql = "INSERT INTO `" . DbValues::$TABLE_NAME_DOWNLOAD_MANAGER .
                    "`(`" . DbValues::$FIELD_NAME_MARK_ID . "`, `" . DbValues::$FIELD_NAME_DOWNLOAD_STATUS . "`, `" . DbValues::$FIELD_NAME_ERROR . "`, `" . DbValues::$FIELD_NAME_LAST_UPDATE_TIME . "`) VALUES " .
                    "(:" . DbValues::$FIELD_NAME_MARK_ID . ", :" . DbValues::$FIELD_NAME_DOWNLOAD_STATUS . ", :" . DbValues::$FIELD_NAME_ERROR . ", :" . DbValues::$FIELD_NAME_LAST_UPDATE_TIME . ")";
                if ($stmt = $connection->prepare($sql)) {
                    $markID = ($prefix . $markID . $suffix);
                    $stmt->bindParam(DbValues::$FIELD_NAME_MARK_ID, $markID);
                    $stmt->bindParam(DbValues::$FIELD_NAME_DOWNLOAD_STATUS, DbValues::$CONST_STATUS_PENDING);
                    $stmt->bindParam(DbValues::$FIELD_NAME_ERROR, DbValues::$CONST_NULL);
                    $stmt->bindParam(DbValues::$FIELD_NAME_LAST_UPDATE_TIME, $formattedTimestamp);
                    if ($stmt->execute()) {
                        $insertCount++;
                    }
                    $stmt = null;
                } else {
                    http_response_code(500);
                }
            }
            $conn->closeConnection();
        } else {
            http_response_code(500);
        }
        return $insertCount;
    }
    /**
     * @param $inputJSON
     * @return int
     */
    public static function insertPortion($inputJSON)
    {
        $insertCount = 0;
        $notAdded = array();
        if (isset($inputJSON)) {
            $json = json_decode($inputJSON, true);
            $fields = $json[JSONConsts::$FIELDS];
            $data = $json[JSONConsts::$DATA];
            $conn = new ConnectionWizard();
            $connection = $conn->getConnection();
            foreach ($data as $currentRow) {
                date_default_timezone_set("Asia/Kolkata");
                $currentTimestamp = time();
                $formattedTimestamp = date('Y-m-d H:i:s', $currentTimestamp);
                $statementAppendKeys = GenUtils::concatArray(array_keys($currentRow), ',', '`', '`');
                //This is not the real values for the keys, these are just the keys placed in the statement before preparing.
                $statementAppendValues = GenUtils::concatArray(array_keys($currentRow), ',', ':', '');
                $sql = "INSERT INTO `" . DbValues::$TABLE_NAME_DOWNLOAD_MANAGER . "`" .
                    "(" . $statementAppendKeys . ") VALUES " .
                    "(" . $statementAppendValues . ")";
                    
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
}