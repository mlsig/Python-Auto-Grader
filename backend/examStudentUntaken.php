<?php
/*
Backend to echo untaken, pending, and graded exams for a specific student.
Version: beta
Author: Giancarlo Calle
*/

//credentials:
$ucid = $_POST["ucid"];

if(empty($ucid)){
  exit("NO UCID INPUT");
}

//verifies connection to database
$serverName = "sql.njit.edu"; //server name (mysql)
$userName = "gc288"; //giancarlo's ucid
$serverPassword = "camilla56"; //super secret password, avert your eyes!
$dbName = "gc288";
$c = new mysqli($serverName, $userName, $serverPassword, $dbName); //connects to db
if ($c->connect_error){
  echo "Could not connect to SQL database. Error: " . $connection -> connect_error;
}

//grabs data and inserts into json
$q = "SELECT S.eid, E.etitle, S.status FROM EXAM_STATUS S, EXAMS E WHERE S.eid = E.eid AND ucid = \"{$ucid}\"";
$qResult = $c->query($q);

if($qResult->num_rows === 0){
  exit("[]");
}

$json = "[";
while($row = mysqli_fetch_assoc($qResult)){
  $eid = $row["eid"];
  $status = $row["status"];
  $title = $row["etitle"];

  if($status == "No Submission"){
    $json = $json . "{ \"eid\":\"{$eid}\", \"title\":\"{$title}\" },";
  }
}
if($json != "["){
  $json = substr($json, 0, -1); //removes last comma
}
$json = $json . "]";

echo $json;
?>
