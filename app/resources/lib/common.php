<?php

// Common functions used in many pages

function redirectToPage($URL) {
    /**
     * Redirects user to given page
     *
     * @param string $URL URL to be redirected to
     *
     * @return null
     */

    header('Location: ' . $URL);
    die();
}

function testInput($data) {
    /**
     * Sanitizes user input from GET or POST
     *
     * @return string
     */

    $data = htmlspecialchars(stripslashes(trim($data)));
    return $data;
}

?>