<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/CrawlerBoard/database/dashboard/DbValues.php";

/**
 * Class ConnectionWizard
 * Establishes connection to the database.
 */
class ConnectionWizard
{

    private $conn;
    private $connection_state;

    public function __construct()
    {
        $dsn = "mysql:host=" . DbValues::$db_address . ";dbname=" . DbValues::$db_name . ";charset=utf8mb4";

        $this->connection_state = true;
        try {
            $this->conn = new PDO($dsn, DbValues::$db_username, DbValues::$db_pass);
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