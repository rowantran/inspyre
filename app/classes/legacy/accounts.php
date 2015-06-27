<?php

// Common account functions
    
require_once "common.php";
require_once "db.php";

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

function getEmail($uid) {
    /**
     * Get email stored for given user
     *
     * @param int $uid User to be checked
     *
     * @return string
     */

    $conn = createDatabaseConnection();
    if (!$conn) {
        return "";
    } else {
        $fetch = $conn->prepare("SELECT email FROM users WHERE u_id=?");
        $fetch->bind_param("i", $uid);
        
        $fetch->execute();
        $fetch->bind_result($email);

        while ($fetch->fetch()) {
            return $email;
        }
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

function followingUser($uid, $uidFollowing) {
    /**
     * Check if user 1 is following user 2
     *
     * @param int $uid User invoking function
     * @param int $uidFollowing User to be checked if following
     *
     * @return bool
     */
    
    $conn = createDatabaseConnection();
    if (!$conn) {
        return false;
    } else {
        $retrieve = $conn->prepare("SELECT * FROM following WHERE u_id=? AND u_following=?");
        $retrieve->bind_param("ii", $uid, $uidFollowing);

        $retrieve->execute();
        $retrieve->store_result();
        
        while ($retrieve->fetch()) {
            return true;
        }
        return false;
    }
}

function followUser($uid, $uidFollow) {
    /**
     * Start following user
     *
     * @param int $uid Follower
     * @param int $uidFollow User to be followed
     *
     * @return bool
     */

    $conn = createDatabaseConnection();
    if (!$conn) {
        return false;
    } else {
        $insert = $conn->prepare("INSERT INTO following (u_id, u_following) VALUES (?, ?)");
        $insert->bind_param("ii", $uid, $uidFollow);

        $insert->execute();
        return true;
    }
}

function unfollowUser($uid, $uidUnfollow) {
    /**
     * Stop following user
     *
     * @param int $uid User invoking function
     * @param int $uidUnfollow User to be unfollowed
     *
     * @return bool
     */

    $conn = createDatabaseConnection();
    if (!$conn) {
        return false;
    } else {
        $delete = $conn->prepare("DELETE FROM following WHERE u_id=? AND u_following=?");
        $delete->bind_param("ii", $uid, $uidUnfollow);

        $delete->execute();
        return true;
    }
}

function getFollowing($uid) {
    /**
     * Get list of all users given user is following
     *
     * @param int $uid User to check following for
     *
     * @return array
     */

    $conn = createDatabaseConnection();
    if (!$conn) {
        return array();
    } else {
        $following = array();
        $fetch = $conn->prepare("SELECT u_following FROM following WHERE u_id=?");
        $fetch->bind_param("i", $uid);

        $fetch->execute();
        $rows = $fetch->get_result()->fetch_all(MYSQLI_ASSOC);
        foreach($rows as $row) {
            $following[] = $row["u_following"];
        }
        return $following;
    }
}
?>