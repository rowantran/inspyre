<?php
require_once __DIR__ . "/../accounts.php";
require_once __DIR__ . "/../auth.php";

$uid = getAndVerifyToken();

if (isset($_GET["username"])) {
    $username = testInput($_GET["username"]);
    $uidUnfollow = getIDFromName($username);
}

unfollowUser($uid, $uidUnfollow);
redirectToPage("/profile/" . $username);
?>