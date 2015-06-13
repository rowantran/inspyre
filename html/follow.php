<?php
require_once __DIR__ . "/../accounts.php";
require_once __DIR__ . "/../auth.php";

$uid = getAndVerifyToken();

if (isset($_GET["username"])) {
    $username = testInput($_GET["username"]);
    $uidFollow = getIDFromName($username);
}

followUser($uid, $uidFollow);
redirectToPage("/profile/" . $username);
?>