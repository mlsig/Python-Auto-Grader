<?php

/*
Submits grade, comment, and points from instructor.
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

//grabs json from instructor who is submitting final grade
$json = $_POST["json"];
//$json = "{\"eid\":\"eid0\",\"ucid\":\"gc288\",\"questions\":[{\"qid\":\"qid0\",\"finalPoints\":\"30\",\"comment\":\"wrong name\"},{\"qid\":\"qid1\",\"finalPoints\":\"30\",\"comment\":\"perfect\"}]}";
$j = json_decode($json);
$eid = $j->eid;
$ucid = $j->ucid;

$questionList = $j->questions;
$pointsGiven = 0;
foreach($questionList as &$question){
  $qid = $question->qid;
  $points = $question->finalPoints;
  $comment = $question->comment;

  $pointsGiven = $pointsGiven + (int)$points;

  $q = "UPDATE EXAM_POINTS SET finalPoints=\"{$points}\", comment=\"{$comment}\" WHERE eid=\"{$eid}\" AND ucid=\"{$ucid}\" AND qid=\"{$qid}\"";
  $qr = $connection->query($q);
}

$q = "SELECT pointsPossible FROM EXAM_STATUS WHERE eid=\"{$eid}\" AND ucid=\"{$ucid}\"";
$qr = $connection->query($q);
$pointsPossible = mysqli_fetch_assoc($qr)["pointsPossible"];

$finalGrade = "{$pointsGiven}/{$pointsPossible}";
$q = "UPDATE EXAM_STATUS SET status=\"Graded\", finalGrade=\"{$finalGrade}\" WHERE eid=\"{$eid}\" AND ucid=\"{$ucid}\"";
$qr = $connection->query($q);

mysqli_close($connection);
//end of file
