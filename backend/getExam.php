<?php

/*
Backend to echo back a specific exam to a student with exam status, submitted code if any, points given if any, etc.
Version: beta
Author: Giancarlo Calle
*/

//credentials:
$eid = $_POST["eid"];

//verifies connection to database
$serverName = "sql.njit.edu"; //server name (mysql)
$userName = "gc288"; //giancarlo's ucid
$serverPassword = "camilla56"; //super secret password, avert your eyes!
$dbName = "gc288";
$c = new mysqli($serverName, $userName, $serverPassword, $dbName); //connects to db
if ($c->connect_error){
  echo "Could not connect to SQL database. Error: " . $connection -> connect_error;
}

//grabs title
$q = "SELECT etitle FROM EXAMS WHERE eid = \"{$eid}\"";
$qResult = $c->query($q);
$etitle = mysqli_fetch_assoc($qResult)["etitle"];
$json = "{\"eid\":\"{$eid}\", \"etitle\":\"{$etitle}\", \"qids\":[";

//grabs questions and adds to json
$q = "SELECT Q.qid, Q.qtitle, Q.prompt, E.points FROM EXAM_QUESTIONS E, QUESTIONS Q WHERE E.qid = Q.qid AND E.eid = \"{$eid}\"";
$qResult = $c->query($q);

while($row = mysqli_fetch_assoc($qResult)){
  $qid = $row["qid"];
  $qtitle = $row["qtitle"];
  $prompt = $row["prompt"];

  $toAdd = "{\"qid\":\"{$qid}\", \"qtitle\":\"{$qtitle}\", \"prompt\":\"{$prompt}\", \"points\":\"{$points}\"},";
  $json = $json . $toAdd;
}
$json = substr($json, 0, -1); //removes last comma
$json = $json . "]}";
echo $json;

?>
