 <?php

// Goal-related functions

require_once "accounts.php";
require_once "common.php";
require_once "db.php";

function createGoal($uid, $goalName, $pointsGoal) {
    /**
     * Create new goal
     *
     * @param int $uid User for goal to be created for
     * @param string $goalName Name of new goal
     * @param int $pointsGoal Weekly points target for goal
     *
     * @return bool
     */

    $conn = createDatabaseConnection();
    if (!$conn) {
        return false;
    } else {
        $insert = $conn->prepare("INSERT INTO goals (u_id, g_name, points_goal, points_current) VALUES (?, ?, ?, 0)");
        $insert->bind_param("isi", $uid, $goalName, $pointsGoal);

        $insert->execute();

        $insert->close();
        $conn->close();

       return true;
    }
}

function deleteGoal($uid, $gid) {
    /**
     * Delete goal
     *
     * @param int $uid User to delete goal for (used for authorization)
     * @param int $gid ID of goal to delete
     *
     * @return bool
     */

    $conn = createDatabaseConnection();
    if (!$conn) {
        return false;
    } else {
        $delete = $conn->prepare("DELETE FROM goals WHERE g_id=?");
        $delete->bind_param("i", $gid);

        $delete->execute();
        
        $delete->close();
        $conn->close();

        return true;
    }
}

function rateGoal($uid, $gid, $rating) {
    /**
     * Rate given goal
     *
     * @param int $uid User rating goal
     * @param int $gid Goal to be rated
     * @param int $rating Rating to be given
     *
     * @return bool
     */

    $conn = createDatabaseConnection();
    if (!$conn) {
        return false;
    } else {
        $rate = $conn->prepare("UPDATE goals SET points_current = points_current + ? WHERE g_id=?");

        if ($rating > 2) {$rating = 2;} 
        if ($rating < 0) {$rating = 0;}

        $rate->bind_param("ii", $rating, $gid);
        
        $rate->execute();
        logGoalRate($uid, $gid, $rating);
        
        $rate->close();
        $conn->close();

        return true;
    }
}

function logGoalRate($uid, $gid, $rating) {
    /**
     * Document goal rating in ratings table
     *
     * @param int $uid User rating goal
     * @param int $gid Goal to be rated
     * @param int $rating Goal to be given
     *
     * @return bool
     */

    $conn = createDatabaseConnection();
    if (!$conn) {
        return false;
    } else {
        $store = $conn->prepare("INSERT INTO ratings (g_id, u_from, u_to, rating) VALUES (?, ?, ?, ?)");
        $store->bind_param("iiii", $gid, $uid, $uidOwner, $rating);

        $uidOwner = getGoalOwner($gid);
        $store->execute();
        
        $store->close();
        $conn->close();
        
        emailNotify($gid, $uid, $uidOwner, $rating);

        return true;
    }
}

function emailNotify($gid, $uid, $uidOwner, $rating) {
    /**
     * Notify user that their goal has been rated
     *
     * @param int $gid Goal being rated
     * @param int $uid User rating goal
     * @param int $uidOwner User being rated
     * @param int $rating Rating being given
     *
     * @return bool
     */

    $conn = createDatabaseConnection();
    if (!$conn) {
        return false;
    } else {
        if (receivesNotifications($uidOwner)) {
            $to = getEmail($uidOwner);

            $subject = "Rating received for goal " . getGoalName($gid);

            $headers = "From: no-reply@inspyre.com\r\n";
            $headers .= "Reply-To: no-reply@inspyre.com\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            

            $message = "<html><body>";
            $message .= "<h1>Rating received!</h1>";
            $message .= "<p>Your goal, " . getGoalName($gid) . ", was rated by ";
            $message .= getIDFromName($uid) . ". You got " . $rating . " points.</p>";
            $message .= "</body></html";

            mail($to, $subject, $message, $headers);
        }
    }
}

function receivesNotifications($uid) {
    /**
     * Check if user has opted to receive email notifications
     *
     * @param int $uid User to be checked
     *
     * @return bool
     */

    $conn = createDatabaseConnection();
    if (!$conn) {
        return false;
    } else {
        $fetch = $conn->prepare("SELECT notifications FROM users WHERE u_id=?");
        $fetch->bind_param("i", $uid);

        $fetch->execute();
        $fetch->bind_result($notifications);

        while ($fetch->fetch()) {
            return $notifications==1 ? true : false;
        }
    }
}

function getGoalName($gid) {
    /**
     * Get name of given goal
     *
     * @param int $gid Goal to be checked
     *
     * @return string
     */
    
    $conn = createDatabaseConnection();
    if (!$conn) {
        return "";
    } else {
        $fetch = $conn->prepare("SELECT g_name FROM goals WHERE g_id=?");
        $fetch->bind_param("i", $gid);

        $fetch->execute();
        $fetch->bind_result($goalName);
        
        while ($fetch->fetch()) {
            return $goalName;
        }
    }
}

function getGoalOwner($gid) {
    /**
     * Get owner of given goal
     *
     * @param int $gid Goal to be queried
     *
     * @return int
     */

    $conn = createDatabaseConnection();
    if (!$conn) {
        return 0;
    } else {
        $fetch = $conn->prepare("SELECT u_id FROM goals WHERE g_id=?");
        $fetch->bind_param("i", $gid);
        
        $fetch->execute();
        $fetch->bind_result($ownerUid);
        while ($fetch->fetch()) {
            return $ownerUid;
        }
    }
}

function ownerOfGoal($uid, $gid) {
    /**
     * Check whether user owns given goal
     *
     * @param int $uid User to be checked
     * @param int $gid Goal to be checked
     *
     * @return bool
     */

    return $uid == getGoalOwner($gid);
}

function fetchGoals($uid, $resultType) {
    /**
     * Get all goals for given user
     *
     * @param int $uid User for goals to be fetched for
     * @param int $resultType MySQLi constant specifying type of array
     *
     * @return mixed[array/bool]
     */

    $conn = createDatabaseConnection();
    if (!$conn) {
        return false;
    } else {
        $retrieve = $conn->prepare("SELECT * FROM goals WHERE u_id=?");
        $retrieve->bind_param("i", $uid);
        
        $retrieve->execute();

        $result = $retrieve->get_result();
        $rows = $result->fetch_all($resultType);

        $result->free();
        $retrieve->close();
        $conn->close();

        return $rows;
    }
}

function getRatings($uid, $resultType) {
    /**
     * Get rating notifications for given user
     *
     * @param int $uid User to fetch ratings for
     * @param int $resultType MySQLi constant specifying type of array
     *
     * @return array
     */

    $conn = createDatabaseConnection();
    if (!$conn) {
        return array();
    } else {
        $fetch = $conn->prepare("SELECT * FROM ratings WHERE u_to=?");
        $fetch->bind_param("i", $uid);

        $fetch->execute();
        
        $result = $fetch->get_result();
        $rows = $result->fetch_all($resultType);

        $result->free();
        $fetch->close();
        $conn->close();

        return $rows;
    }
}

function deleteRatings($uid) {
    /**
     * Clear rating notifications for user
     *
     * @param int $uid User to delete ratings for
     *
     * @return bool
     */

    $conn = createDatabaseConnection();
    if (!$conn) {
        return false;
    } else {
        $delete = $conn->prepare("DELETE FROM ratings WHERE u_to=?");
        $delete->bind_param("i", $uid);

        $delete->execute();
        return true;
    }
}

function mapRatingToText($ratingNum) {
    /**
     * Convert rating integer to plaintext
     *
     * @param int $ratingNum Rating between 0-2
     *
     * @return string
     */

    if ($ratingNum < 0) {$ratingNum=0;}
    if ($ratingNum > 2) {$ratingNum=2;}

    if ($ratingNum == 0) {
        return "Bad";
    } else if ($ratingNum == 1) {
        return "Decent";
    } else {
        return "Good";
    }
}
?>