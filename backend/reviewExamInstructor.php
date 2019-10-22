<?php

/*
Echoes a specific exam for an instructor to review
Version: beta
Author: Giancarlo Calle
*/

$eid = $_POST["eid"];
$ucid = $_POST["ucid"];


$serverName = "sql.njit.edu"; //server name (mysql)
$userName = "gc288"; //giancarlo's ucid
$serverPassword = "camilla56"; //super secret password, avert your eyes!
$dbName = "gc288";
$connection = new mysqli($serverName, $userName, $serverPassword, $dbName); //connects to db
if ($connection->connect_error){
  die("Could not connect to SQL database. Error: " . $connection -> connect_error);
}

$query = "SELECT etitle FROM EXAMS WHERE eid=\"{$eid}\"";
$queryResult = $connection->query($query);
$etitle = mysqli_fetch_assoc($queryResult)["etitle"];

//{"eid":"eid1", "etitle":"Sample", "ucid":"gc288", "questions":[{"qid":"qid1", "qtitle":"getDoubleNum", "rubric":"3,4,5", "autoPoints":"2,4,5"}, {...}, ...] }
$json = "{\"eid\":\"{$eid}\", \"etitle\":\"{$etitle}\", \"ucid\":\"{$ucid}\", \"questions\":[";

$query = "SELECT Q.qid, Q.qtitle, Q.prompt, E.points FROM QUESTIONS Q, EXAM_QUESTIONS E WHERE Q.qid = E.qid AND E.eid = \"{$eid}\"";
$queryResult = $connection->query($query);

while($row = mysqli_fetch_assoc($queryResult)){
  $qid = $row["qid"];
  $qtitle = $row["qtitle"];
  $rubric = $row["points"];
  $prompt = $row["prompt"];

  $q = "SELECT autoPoints, sol FROM EXAM_POINTS WHERE eid=\"{$eid}\" AND qid=\"{$qid}\" AND ucid=\"{$ucid}\"";
  $r = $connection->query($q);
  $row = mysqli_fetch_assoc($r);
  $autoPoints = $row["autoPoints"];
  $sol = $row["sol"];

  $json = $json . "{\"qid\":\"{$qid}\", \"qtitle\":\"{$qtitle}\", \"prompt\":\"{$prompt}\", \"rubric\":\"{$rubric}\", \"autoPoints\":\"{$autoPoints}\", \"sol\":\"{$sol}\"},";
}
$json = substr($json, 0, -1); //removes last comma
$json = $json . " ]}";
$json = strtr($json, array("\n" => "\\n",  "\t" => "\\t"));
echo $json;
?>
