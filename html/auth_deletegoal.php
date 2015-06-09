<?php
require_once __DIR__ . "/../auth.php";
require_once __DIR__ . "/../goals.php";

$uid = getAndVerifyToken();
if (!$uid) {
    redirectToPage("/login");
}

if (isset($_GET["goalID"])) {
    $gid = testInput($_GET["goalID"]);
    if (ownerOfGoal($uid, $gid)) {
        if (deleteGoal($uid, $gid)) {
            redirectToPage("/auth/index");
        }
    } else {
        redirectToPage("/auth/index");
    }
}
?>