<?php

// Database credentials

const SERVER_NAME = "localhost";
const DB_USERNAME = "goals";
const DB_PASSWORD = "wGSGc3eGhbwRCQka";
const DB_NAME = "goals";

// Database-related constants
const DB_NO_USER_FOUND = -1;

// Lowest-level database-related functions

function createDatabaseConnection() {
    /**
     * Creates mysqli connection to goals database
     * 
     * @return mixed[bool/mysqli]
     */

    $conn = new mysqli(SERVER_NAME, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        return false;
    } else {
        return $conn;
    }
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

// Redirection function to be commonly included

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

?>