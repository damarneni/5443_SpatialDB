<?php

/* This file connects to your MySQL database. */

// Connection constants 
define('DB_HOST',     'localhost');
define('DB_USER',     'YOURUSERNAME');
define('DB_PASSWORD', 'YOURDBPASSWORD');
define('DB_DATABASE', 'YOURDBNAME');
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
Create a file called functions.php and place the following code in it:

<?php

/**
 * This function converts a WKT string into a PHP array of polygonal coordinate pairs.
 * @param string $wkt_str is the Well-Known-Text string representing one or more polygons
 * @return array Returns an array of polygons with sub arrays of coordinate pairs
 */ 

function convert_wkt_to_poly_arr($wkt_str)
{
  $ret_arr = array();
  $matches = array();

  preg_match('/\)\s*,\s*\(/', $wkt_str, $matches);

  if(empty($matches))
  {  
      $polys = array(trim($wkt_str));
  }
  else
  {
      $polys = explode($matches[0], trim($wkt_str));
  }
  foreach($polys as $poly)
  {
      $ret_arr[] = str_replace('(','',str_replace(')','',substr($poly, stripos($poly,'(')+2, stripos($poly,')')-2))); 
  }

  return $ret_arr;

}
