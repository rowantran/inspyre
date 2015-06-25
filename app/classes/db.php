<?php

// Lowest-level database-related functions

require_once "common.php";
require_once __DIR__ . "/../../config.php";

$dbServerName = $config["dbCredentials"]["SERVER_NAME"];
$dbUsername = $config["dbCredentials"]["USERNAME"];
$dbPassword = $config["dbCredentials"]["PASSWORD"];
$dbName = $config["dbCredentials"]["DB_NAME"];

function createDatabaseConnection() {
    /**
     * Creates mysqli connection to goals database
     * 
     * @return mixed[bool/mysqli]
     */

    global $dbServerName, $dbUsername, $dbPassword, $dbName;

    $conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        return false;
    } else {
        return $conn;
    }
}

function executeDatabaseFunction($callback) {
    /**
     * Create database connection and execute callback if successful
     *
     * @param callable $callback Function to be called
     *
     * @return bool
     */

    $conn = createDatabaseConnection();
    if (!$conn) {
        return false;
    } else {
        return call_user_func($callback, $conn);
    }
}
?>