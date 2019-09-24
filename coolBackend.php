<?php

/*
Backend for a basic login page.
Version: alpha
Author: Giancarlo Calle
Teammates: Marisa Sigas, Anthony Anderson
*/

$serverName = "sql.njit.edu"; //server name (mysql)
$userName = "gc288"; //giancarlo's ucid
$serverPassword = "auriga26"; //super secret password, avert your eyes!
$dbName = "gc288";

/*collects login info*/
$u = $_POST["u"];
$p = $_POST["p"];
$hashed = hash('sha512', $p);

$connection = new mysqli($serverName, $userName, $serverPassword, $dbName); //connects to db

if ($connection -> connect_error){
  die("Could not connect to SQL database. Error: " . $connection -> connect_error);
}

/*connects to the table that stores usernames and passwords*/
$verifyInfo = "SELECT ucid, password FROM Creds WHERE Creds.ucid=\"" . $u . "\" AND Creds.password=\"" . $hashed . "\"";
$queryResult = $connection->query($verifyInfo); //runs query

if ($queryResult -> num_rows == 0){
  $valid = "n";
}
else{
  $valid = "y";
}

echo $valid;
mysqli_close($connection);

?>
