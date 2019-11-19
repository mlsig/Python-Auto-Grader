<?php

/*
Backend to log in user to student or instructor portal.
Version: release candidate
Author: Giancarlo Calle
*/

$serverName = "sql.njit.edu"; //server name (mysql)
$userName = "gc288"; //giancarlo's ucid
$serverPassword = "camilla56"; //super secret password, avert your eyes!
$dbName = "gc288";
$connection = new mysqli($serverName, $userName, $serverPassword, $dbName); //connects to db
if ($connection -> connect_error){
  die("Could not connect to SQL database. Error: " . $connection -> connect_error);
}

//collects credentials (username and password)
$u = $_POST["u"];
$p = $_POST["p"];

//hashes password for security
$hashed = hash('sha512', $p);

//connects to the table that stores usernames and passwords
$verifyInfo = "SELECT ucid, password FROM VALIDATION WHERE ucid=\"" . $u . "\" AND password=\"" . $hashed . "\"";
$queryResult = $connection->query($verifyInfo);

if ($queryResult -> num_rows == 0){
  echo "{ \"level\" : \"n\" }";
}
else{
  $verifyLevel = "SELECT level FROM VALIDATION WHERE ucid = \"" . $u . "\"";
  $queryResult = $connection->query($verifyLevel);
  $level = mysqli_fetch_assoc($queryResult)["level"]; //grabs "i" or "s"

  echo "{ \"level\" : \"" . $level . "\" }";
}

mysqli_close($connection);
//end of file
