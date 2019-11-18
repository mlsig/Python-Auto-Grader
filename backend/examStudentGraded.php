<?php

/*
Echoes list of graded exams for a specific student.
Version: release candidate
Author: Giancarlo Calle
*/

//verifies connection to database
$serverName = "sql.njit.edu"; //server name (mysql)
$userName = "gc288"; //giancarlo's ucid
$serverPassword = "camilla56"; //super secret password, avert your eyes!
$dbName = "gc288";
$c = new mysqli($serverName, $userName, $serverPassword, $dbName); //connects to db
if ($c->connect_error){
  echo "Could not connect to SQL database. Error: " . $connection -> connect_error;
}

//credentials (ucid)
$ucid = $_POST["ucid"];
$ucid = "gc288";

//grabs eids from graded exams
$q = "SELECT eid, finalGrade FROM EXAM_STATUS WHERE ucid=\"{$ucid}\" AND status=\"Graded\"";
$qResult = $c->query($q);
if($qResult->num_rows === 0){
  exit("[]"); //returns empty list if there are no graded exams
}

//creates json with list of exams to echo for frontend
$json = "[";
while($row = mysqli_fetch_assoc($qResult)){
  $eid = $row["eid"];
  $finalGrade = $row["finalGrade"];

  //grabs title
  $q = "SELECT etitle FROM EXAMS WHERE eid=\"{$eid}\"";
  $r = $c->query($q);
  $etitle = mysqli_fetch_assoc($r)["etitle"];

  $json = $json . "{\"eid\":\"{$eid}\", \"etitle\":\"{$etitle}\", \"finalGrade\":\"{$finalGrade}\"},";
}
$json = substr($json, 0, -1);
$json = $json . "]";
echo $json;

mysqli_close($connection);
//end of file
