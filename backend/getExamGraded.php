<?php

/*
Echoes one graded exam for a specific student.
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
$eid = $_POST["eid"];

//grabs eids from graded exams
$q = "SELECT finalGrade FROM EXAM_STATUS WHERE ucid=\"{$ucid}\" AND eid=\"{$eid}\"";
$qResult = $c->query($q);
$finalGrade = mysqli_fetch_assoc($qResult)["finalGrade"];

//grabs title
$q = "SELECT etitle FROM EXAMS WHERE eid=\"{$eid}\"";
$r = $c->query($q);
$etitle = mysqli_fetch_assoc($r)["etitle"];

//grabs question info
$qInfo = "[";
$q = "SELECT Q.qtitle, Q.prompt, P.sol, P.finalPoints, P.comment FROM QUESTIONS Q, EXAM_POINTS P WHERE Q.qid=P.qid AND P.eid=\"{$eid}\" AND P.ucid=\"{$ucid}\"";
$r = $c->query($q);

while($info = mysqli_fetch_assoc($r)){
  $qtitle = $info["qtitle"];
  $prompt = $info["prompt"];
  $sol = $info["sol"];
  $points = $info["finalPoints"];
  $comment = $info["comment"];

  $sol = strtr($sol, array("\n" => "\\n",  "\t" => "\\t"));

  $qInfo = $qInfo . "{\"qtitle\":\"{$qtitle}\", \"prompt\":\"{$prompt}\", \"sol\":\"{$sol}\", \"points\":\"{$points}\", \"comment\":\"{$comment}\"},";
}
$qInfo = substr($qInfo, 0, -1); //removes last comma
$qInfo = $qInfo . "]";
$json = "{\"eid\":\"{$eid}\", \"etitle\":\"{$etitle}\", \"finalGrade\":\"{$finalGrade}\", \"questions\":" . $qInfo . "}";
echo $json;

mysqli_close($c);
//end of file
