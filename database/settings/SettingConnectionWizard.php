<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/CrawlerBoard/database/settings/SettingsDbValues.php";

/**
 * Class SettingConnectionWizard
 * Establishes connection to the database.
 */
class SettingConnectionWizard
{

    private $conn;
    private $connection_state;

    public function __construct()
    {
        $dsn = "mysql:host=" . SettingsDbValues::$db_setting_address . ";dbname=" . SettingsDbValues::$db_setting_name . ";charset=utf8mb4";

        $this->connection_state = true;
        try {
            $this->conn = new PDO($dsn, SettingsDbValues::$db_setting_username, SettingsDbValues::$db_setting_pass);
        } catch (Exception $e) {
            $this->connection_state = false;
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function closeConnection()
    {
        $this->conn = null;
    }

    public function checkConnection()
    {
        if ($this->conn != null && $this->connection_state)
            return true;
        else
            return false;
    }
}


?>