<?php

require_once "db.php";

// Common authentication functions

function createHash($password) {
    /**
     * Get hash for password using bcrypt and random salt
     *
     * @param string $password Password to be hashed
     *
     * @return string
     */
    
    $options = [
        'cost' => 15,
        'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)
    ];
    
    $hash = password_hash($password, PASSWORD_BCRYPT, $options);
    return $hash;
}

function getHash($uid) {
    /**
     * Retrieve stored password hash for given user
     *
     * @param int $uid ID of user for hash to fetched for
     *
     * @return mixed[int/string]
     */
    
    $conn = createDatabaseConnection();
    if (!$conn) {
        return 0;
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
    }
}

function generateToken() {
    /**
     * Generate random 32-character token
     *
     * @return string
     */

    return bin2hex(openssl_random_pseudo_bytes(16));
}

function deleteToken($uid) {
    /**
     * Delete currently stored token for given user
     * @param int $uid ID for user
     *
     * @return bool
     */
    
    $conn = createDatabaseConnection();
    if (!$conn) {
        return false;
    } else {
        $delete = $conn->prepare("DELETE FROM tokens WHERE u_id=?");
        $delete->bind_param("i", $uid);
        
        $delete->execute();

        $delete->close();
        $conn->close();

        return true;
    }
}

function deleteTokenFromTokenVal($token) {
    /**
     * Delete all instances of given token
     *
     * @param string $token Token to be deleted
     *
     * @return bool
     */

    $conn = createDatabaseConnection();
    if (!$conn) {
        return false;
    } else {
        $delete = $conn->prepare("DELETE FROM tokens WHERE token=?");
        $delete->bind_param("s", $token);
        
        $delete->execute();

        $delete->close();
        $conn->close();

        return true;
    }
}

function insertToken($uid, $token) {
    /**
     * Insert new token for given user. Should not be called directly
     *
     * @param int $uid ID of user token is being inserted for
     * @param string $token Token to be inserted
     *
     * @return bool
     */
    
    $conn = createDatabaseConnection();
    if (!$conn) {
        return false;
    } else {
        $insert = $conn->prepare("INSERT INTO tokens (u_id, token, time_created) VALUES (?, ?, ?)");
        $insert->bind_param("isi", $uid, $token, $time);
        
        $time = time();
        $insert->execute();

        $insert->close();
        $conn->close();

        return true;
    }
}

function updateToken($uid, $token) {
    /**
     * Delete all tokens for given user and then insert a new one
     *
     * @param int $uid ID of user token is being inserted for
     * @param string $token Token to be inserted
     *
     * @return bool
     */
    
    if (deleteToken($uid)) {
        return insertToken($uid, $token);
    } else {
        return false;
    }
}

function verifyToken($token) {
    /**
     * Verify that given token is stored in database
     *
     * @param token $token Token to be verified
     *
     * @return bool
     */

    $conn = createDatabaseConnection();
    if (!$conn) {
        return false;
    } else {
        $check = $conn->prepare("SELECT * FROM tokens WHERE token=?");
        $check->bind_param("s", $token);
       
        $check->execute();
        $check->store_result();

        $rows = $check->num_rows;

        $check->free_result();
        $check->close();
        $conn->close();

        return !$rows == 0;
    }
}

function getIDFromToken($token) {
    /**
     * Get user ID associated with given token
     *
     * @param token Token to be used as identifier
     *
     * @return int
     */

    $conn = createDatabaseConnection();
    if (!$conn) {
        return 0;
    } else {
        $fetch = $conn->prepare("SELECT u_id FROM tokens WHERE token=?");
        $fetch->bind_param("s", $token);
        
        $fetch->execute();
        $fetch->store_result();
        $fetch->bind_result($uid);

        while ($fetch->fetch()) {
            return $uid;
        }
    }
}

function getToken() {
    /**
     * Get token currently stored on client
     *
     * @return string
     */

    if (isset($_COOKIE["token"])) {
        return $_COOKIE["token"];
    } else {
        return "";
    }
}

function getAndVerifyToken() {
    /**
     * Retrieve and verify token stored on client
     * 
     * @return int
     */

    if ($token = getToken()) {
        if (!verifyToken($token)) {
            deleteToken();
            
            redirectToPage("/login");
            return 0;
        } else {
            return getIDFromToken($token);
        }
    } else {
        redirectToPage("/login");
        return 0;
    }
}

function deleteTokenCookie() {
    /**
     * Delete token stored on client
     *
     * @return bool
     */

    unset($_COOKIE["token"]);
    setcookie("token", "", time()-3600);
}
?>