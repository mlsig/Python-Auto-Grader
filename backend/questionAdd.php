<?php
/*Adds a question input from an instructor to the database*/
/*
Backend to grab exam taken by student and stores student solution in DB.
Version: beta
Author: Giancarlo Calle
*/

//credentials: (title, prompt, difficulty, topic, sampleIO)
$title = $_POST["title"];
$prompt = $_POST["prompt"]; //ex: "print 'A+' if input is '100'
$difficulty = $_POST["difficulty"]; //ex: "hard"
$topic = $_POST["topic"]; //ex: "loops"
$sampleIO = $_POST["sampleIO"];

//verifies connection to database
$serverName = "sql.njit.edu"; //server name (mysql)
$userName = "gc288"; //giancarlo's ucid
$serverPassword = "camilla56"; //super secret password, avert your eyes!
$dbName = "gc288";
$connection = new mysqli($serverName, $userName, $serverPassword, $dbName); //connects to db
if ($connection->connect_error){
  echo "Could not connect to SQL database. Error: " . $connection -> connect_error;
}

//generates unique question identifier
$query = "SELECT qid FROM QUESTIONS WHERE qid = (SELECT MAX(qid) FROM QUESTIONS);";
$queryResult = $connection->query($query); //runs query
if($queryResult -> num_rows == 0){ //checks if table is empty
  $qid = "qid0";
}
else{
  $maxqid = mysqli_fetch_assoc($queryResult)["qid"];
  $numString = explode("d", $maxqid)[1]; //grabs the number from the max qid
  $num = intval($numString) + 1;
  $qid = "qid{$num}";
}

//inserts into the QUESTIONS table
$query = "INSERT INTO QUESTIONS (qid, qtitle, prompt, difficulty, topic) VALUES (\"{$qid}\", \"{$title}\", \"{$prompt}\", \"{$difficulty}\", \"{$topic}\");";
$queryResult = $connection->query($query); //runs query

//separates input and output and inserts into IO table
$split = explode(";", $sampleIO);
foreach ($split as &$val){
  $io = explode(",", $val);
  $in = $io[0];
  $out = $io[1];
  $query = "INSERT INTO IO (qid, input, output) VALUES (\"{$qid}\", \"{$in}\", \"{$out}\");";
  $queryResult = $connection->query($query); //runs query
}

echo "{ \"qid\" : \"{$qid}\", \"title\" : \"{$title}\", \"prompt\" : \"{$prompt}\", \"difficulty\" : \"{$difficulty}\", \"topic\" : \"{$topic}\", \"sampleIO\" : \"{$sampleIO}\" }";

?>
