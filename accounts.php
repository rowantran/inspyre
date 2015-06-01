<?php

require_once "db.php";

// Common account functions

// Constants
    
function createUser($username, $hash, $email) {
    // Create new user
    
    $conn = new mysqli(SERVER_NAME, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        return DB_CONNECTION_ERROR;
    } else {
        $insert = $conn->prepare("INSERT INTO users (username, hash, email) VALUES (?, ?, ?)");
        $insert->bind_param("sss", $username, $hash, $email);
        
        $insert->execute();
        $insert->close();
        $conn->close();
        return DB_SUCCESS;
    }
}

function getIDFromName($username) {
    // Find ID of user based on username
    // Returns -1 on connection error
    // Returns 0 on no matching user
    
    $conn = new mysqli(SERVER_NAME, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        return DB_CONNECTION_ERROR;
    } else {
        $retrieve = $conn->prepare("SELECT u_id FROM users WHERE username=?");
        $retrieve->bind_param("s", $username);
        
        $retrieve->execute();
        $retrieve->store_result();
        $retrieve->bind_result($uid);
        if ($retrieve->fetch()) {
            if ($retrieve->num_rows == 0) {
                return DB_NO_USER_FOUND;
            } else {
                return $uid;
            }
        }
        $retrieve->free_result();
        $retrieve->close();
        $conn->close();
    }
}
?>