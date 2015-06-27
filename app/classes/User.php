<?php

require_once "Database.php";
require_once "Hash.php";

class User {
    private $username;
    private $hash;
    private $email;
    private $notifications;

    public function __construct() {}

    public function verifyPassword($password) {
        return password_verify($password, $this->hash);
    }

    public function asNew($username, $password, $email, $notifications) {
        $this->username = $username;
        $this->hash = Hash::createHash($password);
        $this->email = $email;
        $this->notifications = $notifications;

        $this->store();

        return $this;
    }

    public function fromDatabase($username) {
        $rows = Database::select("users", "username", $username);
        
        foreach ($rows as $row) {
            $this->username = $row["username"];
            $this->hash = $row["hash"];
            $this->email = $row["email"];
            $this->notifications = $row["notifications"];
            
            return $this;
        }
    }

    public function store() {
        $storeQuery = "INSERT INTO users (username, hash, email, notifications) VALUES (:username, :hash, :email, :notifications)";
        return Database::executeQuery($storeQuery, array(
            ':username' => $this->username, 
            ':hash' => $this->hash, 
            ':email' => $this->email, 
            ':notifications' => $this->notifications
        ));
    }
}

?>