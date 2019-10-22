<?php

/*
Submits grade, comment, and points from instructor.
Version: beta
Author: Giancarlo Calle
*/

//{"eid":"eid1", "ucid":"gc288", "pointsPossible":45, "pointsGiven":40, "questions":[{"qid":"qid0", "points":"3,4,5", "comment":"good looks bro"}, {...}, ...]}
$json = $_POST["json"];
//$json = "{\"eid\":\"eid0\",\"ucid\":\"gc288\",\"questions\":[{\"qid\":\"qid0\",\"points\":\"1,3,2\",\"comment\":\"wrong name\"},{\"qid\":\"qid1\",\"points\":\"1,4\",\"comment\":\"perfect\"}]}";

$serverName = "sql.njit.edu"; //server name (mysql)
$userName = "gc288"; //giancarlo's ucid
$serverPassword = "camilla56"; //super secret password, avert your eyes!
$dbName = "gc288";
$connection = new mysqli($serverName, $userName, $serverPassword, $dbName); //connects to db
if ($connection->connect_error){
  die("Could not connect to SQL database. Error: " . $connection -> connect_error);
}

$j = json_decode($json);
$eid = $j->eid;
$ucid = $j->ucid;

$questionList = $j->questions;
/*
//calculates and stores final grade in DB along with comment
$finalGrade = "{$pointsGiven}/{$pointsPossible}";*/
$q = "UPDATE EXAM_STATUS SET status=\"Graded\" WHERE eid=\"{$eid}\" AND ucid=\"{$ucid}\"";
$r = $connection->query($q);


$pointsGiven = 0;
$pointsPossible = 0;
//stores point values for each question and comment in DB
foreach($questionList as &$question){
  $qid = $question->qid;
  $points = $question->points;
  $comment = $question->comment;

  $pointList = explode(",", $points);
  foreach($pointList as &$p){
    $pointsGiven = $pointsGiven + intval($p);
  }

  $q = "SELECT points FROM EXAM_QUESTIONS WHERE eid=\"{$eid}\" AND qid=\"{$qid}\"";
  $r = $connection->query($q);
  $rubric = mysqli_fetch_assoc($r)["points"];
  $pointList = explode(",", $rubric);
  foreach($pointList as &$p){
    $pointsPossible = $pointsPossible + intval($p);
  }

  $q = "UPDATE EXAM_POINTS SET finalPoints=\"{$points}\", comment=\"{$comment}\" WHERE eid=\"{$eid}\" AND ucid=\"{$ucid}\" AND qid=\"{$qid}\"";
  $r = $connection->query($q);
}

$finalGrade = "{$pointsGiven}/{$pointsPossible}";
$q = "UPDATE EXAM_STATUS SET finalGrade=\"{$finalGrade}\" WHERE eid=\"{$eid}\" AND ucid=\"{$ucid}\"";
$r = $connection->query($q);
?>
