<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "root";
$dbname = "wall_ajax";

$connection = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Impossible to connect to the database');

$select_db = mysql_select_db($dbname, $connection) or die ('Database was not found');

?>