<?php

/*
Backend to grab exam taken by student and stores student solution in DB.
Version: beta
Author: Giancarlo Calle
*/

//credentials: ()

//verifies connection to database
$serverName = "sql.njit.edu"; //server name (mysql)
$userName = "gc288"; //giancarlo's ucid
$serverPassword = "camilla56"; //super secret password, avert your eyes!
$dbName = "gc288";
$connection = new mysqli($serverName, $userName, $serverPassword, $dbName); //connects to db
if ($connection->connect_error){
  echo "Could not connect to SQL database. Error: " . $connection -> connect_error;
}



?>
