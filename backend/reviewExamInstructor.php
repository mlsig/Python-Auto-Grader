<?php

/*
Echoes a specific exam for an instructor to review
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

//grabs post vars
$eid = $_POST["eid"];
$ucid = $_POST["ucid"];

$query = "SELECT etitle FROM EXAMS WHERE eid=\"{$eid}\"";
$queryResult = $connection->query($query);
$etitle = mysqli_fetch_assoc($queryResult)["etitle"];

$query = "SELECT autoGrade from EXAM_STATUS WHERE eid=\"{$eid}\" AND ucid=\"{$ucid}\"";
$queryResult = $connection->query($query);
$autoGrade = mysqli_fetch_assoc($queryResult)["autoGrade"];

$json = "{\"eid\":\"{$eid}\", \"etitle\":\"{$etitle}\", \"ucid\":\"{$ucid}\", \"autoGrade\":\"{$autoGrade}\", \"questions\":[";

$query = "SELECT Q.qid, Q.qtitle, Q.prompt, E.points FROM QUESTIONS Q, EXAM_QUESTIONS E WHERE Q.qid = E.qid AND E.eid = \"{$eid}\"";
$queryResult = $connection->query($query);

//grabs info for each question
while($row = mysqli_fetch_assoc($queryResult)){
  $qid = $row["qid"];
  $qtitle = $row["qtitle"];
  $points = $row["points"];
  $prompt = $row["prompt"];

  //grabs auto-graded points and user solution
  $q = "SELECT autoPoints, sol FROM EXAM_POINTS WHERE eid=\"{$eid}\" AND qid=\"{$qid}\" AND ucid=\"{$ucid}\"";
  $qr = $connection->query($q);
  $r = mysqli_fetch_assoc($qr);
  $autoPoints = $r["autoPoints"];
  $sol = $r["sol"];

  //grabs all point deductions and their comments
  $deductions = "";
  $q = "SELECT deduction FROM EXAM_DEDUCTIONS WHERE eid=\"{$eid}\" AND ucid=\"{$ucid}\" AND qid=\"{$qid}\"";
  $qr = $connection->query($q);
  while($r = mysqli_fetch_assoc($qr)["deduction"]){
    $deductions = $deductions . "\"{$r}\",";
  }
  if($deductions != ""){
    $deductions = substr($deductions, 0, -1); //removes last comma
  }

  $json = $json . "{\"qid\":\"{$qid}\", \"qtitle\":\"{$qtitle}\", \"prompt\":\"{$prompt}\", \"sol\":\"{$sol}\", \"autoPoints\":\"{$autoPoints}\", \"pointsPossible\":\"{$points}\", \"deductions\":[$deductions]},";
}
$json = substr($json, 0, -1); //removes last comma
$json = $json . " ]}";
$json = strtr($json, array("\n" => "\\n",  "\t" => "\\t"));
echo $json;

mysqli_close($connection);
//end of file
