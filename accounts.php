<?php

require_once "db.php";

// Common account functions

// Constants
    
function createUser($username, $hash, $email, $emailNotifications) {
    /**
     * Create new user in database
     *
     * @param string $username Username for new user
     * @param string $hash Password hash for new user
     * @param string $email Email for new user
     *
     * @return bool
     */
    
    $conn = createDatabaseConnection();
    if (!$conn) {
        return false;
    } else {
        $insert = $conn->prepare("INSERT INTO users (username, hash, email, notifications) VALUES (?, ?, ?, ?)");
        $insert->bind_param("sssi", $username, $hash, $email, $emailNotifications);
        
        $insert->execute();
        $insert->close();
        $conn->close();
        return true;
    }
}

function userExists($username) {
    /**
     * Check if user exists with username
     *
     * @param string $username Username to check for
     *
     * @return bool
     */
    
    $conn = createDatabaseConnection();
    if (!$conn) {
        return false;
    } else {
        $retrieve = $conn->prepare("SELECT * FROM users WHERE username=?");
        $retrieve->bind_param("s", $username);
        
        $retrieve->execute();
        $retrieve->store_result();
        
        while ($retrieve->fetch()) {
            if ($retrieve->num_rows != 0) {
                return true;
            }
        }
        return false;
    }
}

function getIDFromName($username) {
    /**
     * Fetch ID associated with given username
     * 
     * @param string $username Username to fetch ID for
     *
     * @return int
     */
    
    $conn = createDatabaseConnection();
    if (!$conn) {
        return 0;
    } else {
        $retrieve = $conn->prepare("SELECT u_id FROM users WHERE username=?");
        $retrieve->bind_param("s", $username);
        
        $retrieve->execute();
        $retrieve->store_result();
        $retrieve->bind_result($uid);

        while ($retrieve->fetch()) {
            if ($retrieve->num_rows == 0) {
                return DB_NO_USER_FOUND;
            } else {
                return $uid;
            }
        }
    }
}

function getNameFromID($uid) {
    /**
     * Fetch username associated with given ID
     * 
     * @param int $uid ID to fetch username for
     *
     * @return mixed[int/string]
     */

    $conn = createDatabaseConnection();
    if (!$conn) {
        return 0;
    } else {
        $retrieve = $conn->prepare("SELECT username FROM users WHERE u_id=?");
        $retrieve->bind_param("i", $uid);

        $retrieve->execute();
        $retrieve->store_result();
        $retrieve->bind_result($username);

        while ($retrieve->fetch()) {
            return $username;
        }

        return DB_NO_USER_FOUND;
    }
}
?>