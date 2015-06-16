<?php
require_once __DIR__ . "/../resources/lib/accounts.php";
require_once __DIR__ . "/../resources/lib/auth.php";

$uid = getAndVerifyToken();

if (isset($_GET["username"])) {
    $username = testInput($_GET["username"]);
    $uidFollow = getIDFromName($username);
}

followUser($uid, $uidFollow);
redirectToPage("/profile/" . $username);
?>