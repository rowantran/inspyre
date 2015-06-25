<?php
require_once __DIR__ . "/../resources/lib/accounts.php";

if (isset($_GET["username"])) {
    $username = $_GET["username"];
    $userExists = userExists($username);

    echo json_encode(array('userExists' => $userExists));
} else {
    echo "";
}
?>