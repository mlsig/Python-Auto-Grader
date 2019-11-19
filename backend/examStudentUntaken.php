<?php

/*
Echoes untaken exams for a specific student.
Version: release candidate
Author: Giancarlo Calle
*/

//verifies connection to database
$serverName = "sql.njit.edu"; //server name (mysql)
$userName = "gc288"; //giancarlo's ucid
$serverPassword = "camilla56"; //super secret password, avert your eyes!
$dbName = "gc288";
$connection = new mysqli($serverName, $userName, $serverPassword, $dbName); //connects to db
if ($connection->connect_error){
  echo "Could not connect to SQL database. Error: " . $connection -> connect_error;
}

//credentials (ucid)
$ucid = $_POST["ucid"];

//grabs data and inserts into json
$query = "SELECT S.eid, E.etitle, S.status FROM EXAM_STATUS S, EXAMS E WHERE S.eid = E.eid AND ucid = \"{$ucid}\"";
$queryResult = $connection->query($query);
if($queryResult->num_rows === 0){
  exit("[]"); //echoes empty list if there are no exams to take for the student
}

//creates list of untaken exams to echo for frontend
$json = "[";
while($row = mysqli_fetch_assoc($queryResult)){
  $eid = $row["eid"];
  $status = $row["status"];
  $title = $row["etitle"];

  if($status == "No Submission"){
    $json = $json . "{ \"eid\":\"{$eid}\", \"title\":\"{$title}\" },";
  }
}
$json = substr($json, 0, -1); //removes last comma
$json = $json . "]";
echo $json;

mysqli_close($connection);
//end of file
