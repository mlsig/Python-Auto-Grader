<?php

/*
Sends list of questions from DB to frontend that relate to a specific topic
Version: release candidate
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

$topic = $_POST["topic"];

$query = "SELECT * FROM QUESTIONS WHERE topic=\"{$topic}\";";
$queryResult = $connection->query($query);

$json = "[";
while($row = mysqli_fetch_assoc($queryResult)){
  $qid = $row["qid"];
  $title = $row["qtitle"];
  $prompt = $row["prompt"];
  $diff = $row["difficulty"];
  $topic = $row["topic"];

  $q = "SELECT * FROM IO WHERE qid = \"{$qid}\"";
  $qResult = $connection->query($q);
  $ioNum = $qResult->num_rows + 1;

  $json = $json . "{\"qid\":\"{$qid}\", \"title\":\"{$title}\", \"prompt\":\"{$prompt}\", \"difficulty\":\"{$diff}\", \"topic\":\"{$topic}\", \"#ios\":\"{$ioNum}\"},";
}
$json = substr($json, 0, -1); //removes last comma
$json = $json . " ]";

echo $json;
//end of file
