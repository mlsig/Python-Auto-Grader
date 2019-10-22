<?php

/*
Echoes all exams that have been auto-graded but need a final grade.
Version: beta
Author: Giancarlo Calle
*/

$serverName = "sql.njit.edu"; //server name (mysql)
$userName = "gc288"; //giancarlo's ucid
$serverPassword = "camilla56"; //super secret password, avert your eyes!
$dbName = "gc288";
$connection = new mysqli($serverName, $userName, $serverPassword, $dbName); //connects to db
if ($connection->connect_error){
  die("Could not connect to SQL database. Error: " . $connection -> connect_error);
}

$json = "["; //of the form: [{"eid":"eid1", "etitle":"Sample", "ucid":"gc288", "autoGrade": "49/50"}, {...}, ...]

$query = "SELECT S.eid, S.ucid, S.autoGrade, E.etitle FROM EXAM_STATUS S, EXAMS E WHERE E.eid = S.eid AND S.status = \"Auto-Graded\"";
$queryResult = $connection->query($query);

if($queryResult->num_rows == 0){
  exit("[]");
}
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
?>
