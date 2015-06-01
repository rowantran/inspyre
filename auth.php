<?php

require_once "db.php";

// Common authentication functions

function createHash($password) {
    // Hash password using random salt and bcrypt with cost 15
    
    $options = [
        'cost' => 15,
        'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)
    ];
    
    $hash = password_hash($password, PASSWORD_BCRYPT, $options);
    return $hash;
}

function getHash($uid) {
    // Get password hash for user
    
    $conn = new mysqli(SERVER_NAME, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        return DB_CONNECTION_ERROR;
    } else {
        $fetch = $conn->prepare("SELECT hash FROM users WHERE u_id=?");
        $fetch->bind_param("i", $uid);
        
        $fetch->execute();
        $fetch->store_result();
        $fetch->bind_result($hash);
        if ($fetch->fetch()) {
            if ($fetch->num_rows == 0) {
                return DB_NO_USER_FOUND;
            } else {
                return $hash; 
            }
        }
        $fetch->free_result();
        $fetch->close();
        $conn->close();
    }
}

function generateToken() {
    // Generate random 16-character token
    return bin2hex(openssl_random_pseudo_bytes(16));
}

function deleteToken($uid) {
    // Delete current token for user
    
    $conn = new mysqli(SERVER_NAME, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        return DB_CONNECTION_ERROR;
    } else {
        $delete = $conn->prepare("DELETE FROM tokens WHERE u_id=?");
        $delete->bind_param("i", $uid);
        
        $delete->execute();
        $delete->close();
        $conn->close();
        return DB_SUCCESS;
    }
}

function deleteTokenFromTokenVal($token) {
    // Delete token for user based on token value

    $conn = new mysqli(SERVER_NAME, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        return DB_CONNECTION_ERROR;
    } else {
        $delete = $conn->prepare("DELETE FROM tokens WHERE token=?");
        $delete->bind_param("s", $token);
        
        $delete->execute();
        $delete->close();
        $conn->close();
        return DB_SUCCESS;
    }
}

function insertToken($uid, $token) {
    // Insert new token for user. SHOULD NOT BE CALLED BESIDES THROUGH changeToken!
    
    $conn = new mysqli(SERVER_NAME, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        return DB_CONNECTION_ERROR;
    } else {
        $insert = $conn->prepare("INSERT INTO tokens (u_id, token, time_created) VALUES (?, ?, ?)");
        $insert->bind_param("isi", $uid, $token, $time);
        
        $time = time();
        $insert->execute();
        $insert->close();
        return DB_SUCCESS;
    }
}

function updateToken($uid, $token) {
    // Update current token for user, deleting existing one if necessary
    
    deleteToken($uid);
    insertToken($uid, $token);
}

function verifyToken($token) {
    // Verifies that given token is stored in database
    $conn = new mysqli(SERVER_NAME, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        return DB_CONNECTION_ERROR;
    } else {
        $check = $conn->prepare("SELECT * FROM tokens WHERE token=?");
        $check->bind_param("s", $token);
       
        $check->execute();
        $check->store_result();
        if ($check->num_rows == 0) {
            return false;
        } else {
            return true;
        }
        $retrieve->free_result();
        $check->close();
        $conn->close();
    }
}

function getIDFromToken($token) {
    // Get ID of user from token
    $conn = new mysqli(SERVER_NAME, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        return DB_CONNECTION_ERROR;
    } else {
        $fetch = $conn->prepare("SELECT u_id FROM tokens WHERE token=?");
        $fetch->bind_param("s", $token);
        
        $fetch->execute();
        $fetch->store_result();
        $fetch->bind_result($uid);
        if ($fetch->fetch()) {
            return $uid;
        }
        $fetch->free_result();
        $fetch->close();
        $conn->close();
    }
}

function getAndVerifyToken() {
    if (isset($_COOKIE["token"])) {
        $token = $_COOKIE["token"];
        if (!verifyToken($token)) {
            unset($_COOKIE["token"]);
            setcookie("token", "", time()-3600);
            
            $URL = "index.php";
            header('Location: ' . $URL);
            return false;
        } else {
            return getIDFromToken($token);
        }
    } else {
        $URL = "index.php";
        header('Location: ' . $URL);
        return false;
    }
}
?>