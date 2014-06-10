<?php

/* This file connects to your MySQL database. */

// Connection constants 
define('DB_HOST',     '8888');
define('DB_USER',     'damarneni');
define('DB_PASSWORD', 'damarneni');
define('DB_DATABASE', 'damarneni');
define('DB_PORT',     3306);

// Error-checking to ensure you have set the values above before trying to run one of the examples
if(DB_USER     === 'REPLACEME' ||
    DB_PASSWORD === 'REPLACEME' ||
    DB_DATABASE === 'REPLACEME')
{
    die("You must set your database connection variables in db_connect.php before viewing this example!");
}

// Connect to the database using PHP's MySQLi object-oriented library
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE, DB_PORT);
if ($mysqli->connect_errno)
{
    die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}

?>
