<?php

require_once __DIR__ . "/../config.php";

$dbServerName = $config["dbCredentials"]["SERVER_NAME"];
$dbUsername = $config["dbCredentials"]["USERNAME"];
$dbPassword = $config["dbCredentials"]["PASSWORD"];
$dbName = $config["dbCredentials"]["DB_NAME"];

class Database {
    private function __construct() {}

    public static function select($table, $tableColumn, $colValue) {
        return self::connectAndExecute(function($conn) use($table, $tableColumn, $colValue) {
            $selectQuery = $conn->prepare("SELECT * FROM " . $table . " WHERE " . $tableColumn . "=:colValue");

            $selectQuery->execute(array(
                ':colValue' => $colValue
            ));

            return $selectQuery->fetchAll(PDO::FETCH_ASSOC);
        });
    }

    public static function executeQuery($query, $params) {
        return self::connectAndExecute(function($conn) use($query, $params) {
            $insertQuery = $conn->prepare($query);
            $insertQuery->execute($params);

            return true;
        });
    }

    private static function connectAndExecute($callback) {
        $conn = self::connect();
        if ($conn) {
            return call_user_func($callback, $conn);
        } else {
            return false;
        }
    }

    private static function connect() {
        global $dbServerName, $dbUsername, $dbPassword, $dbName;

        $dsn = "mysql:host=$dbServerName;dbname=$dbName";
        
        try {
            $conn = new PDO($dsn, $dbUsername, $dbPassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            return $conn;
        } catch (PDOException $error) {
            return false;
        }
    }
}

?>