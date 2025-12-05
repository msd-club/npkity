<?php
include "database_variables.php";

session_start();

// Database configuration
define('DB_HOST', $host);
define('DB_USER', $username);
define('DB_PASS', $password);
define('DB_NAME', $database);

// Create connection
function getConnection()
{
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

// Check if user is logged in
function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}
