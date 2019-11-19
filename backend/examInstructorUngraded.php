<?php

/*
Echoes auto-graded exams for the instructor
Version: release candidate
Author: Giancarlo Calle
*/

//connects to DB
$serverName = "sql.njit.edu"; //server name (mysql)
$userName = "gc288"; //giancarlo's ucid
$serverPassword = "camilla56"; //super secret password, avert your eyes!
$dbName = "gc288";
$connection = new mysqli($serverName, $userName, $serverPassword, $dbName); //connects to db
if ($connection->connect_error){
  die("Could not connect to SQL database. Error: " . $connection -> connect_error);
}

//grabs exams from the DB
$query = "SELECT S.eid, S.ucid, S.autoGrade, E.etitle FROM EXAM_STATUS S, EXAMS E WHERE E.eid = S.eid AND S.status = \"Auto-Graded\"";
$queryResult = $connection->query($query);
if($queryResult->num_rows == 0){
  exit("[]"); //echeos empty list if there are no exams
}

//creates json with list of exams to echo for frontend
$json = "[";
while($row = mysqli_fetch_assoc($queryResult)){
  $eid = $row["eid"];
  $ucid = $row["ucid"];
  $autoGrade = $row["autoGrade"];
  $etitle = $row["etitle"];

  $json = $json . "{\"eid\":\"{$eid}\", \"etitle\":\"{$etitle}\", \"ucid\":\"{$ucid}\", \"autoGrade\":\"{$autoGrade}\"},";
}
$json = substr($json, 0, -1); //removes last comma
$json = $json . " ]";
echo $json;

//end of file
