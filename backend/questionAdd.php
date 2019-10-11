<?php

//grabs credentials (title, prompt, difficulty, topic, sampleIO)
$title = "\"" . $_POST["title"] . "\"";
$prompt = "\"" . $_POST["prompt"] . "\""; //ex: "print 'lmao' if input is 'ayy'
$difficulty = "\"" . $_POST["difficulty"] . "\""; //ex: "hard"
$topic = "\"" . $_POST["topic"] . "\""; //ex: "loops"
$sampleIO = $_POST["sampleIO"];

//verifies connection to database
$serverName = "sql.njit.edu"; //server name (mysql)
$userName = "gc288"; //giancarlo's ucid
$serverPassword = "camilla56"; //super secret password, avert your eyes!
$dbName = "gc288";
$connection = new mysqli($serverName, $userName, $serverPassword, $dbName); //connects to db
if ($connection->connect_error){
  die("Could not connect to SQL database. Error: " . $connection -> connect_error);
}

//checks if question is in QUESTION table
//$query = "INSERT INTO QUESTIONS (qid, qtitle, prompt, difficulty, topic) VALUES (" 1, " . $title . ", " . $prompt . ", " . $difficulty . ", " . $topic . ");";
$queryResult = $connection->query($query);
if (!$queryResult){ //runs query and checks if it fails
  echo mysqli_error($connection);
}


$qid = "\"this sql failed if this is returned\"";
/*
$query = "SELECT qid FROM QUESTIONS WHERE qid = (SELECT MAX(qid) FROM QUESTIONS)"; //grabs recent qid inserted
$queryResult = $connection->query($query); //runs query

if (!$queryResult){ //checks if it fails
  echo mysqli_error($connection);
}

$qid = "\"" . "mysqli_fetch_assoc($queryResult)["qid"] . "\""; //grabs the qid of the recently added question
*/


echo "{ \"qid\" : " . $qid . ", \"title\" : " . $title . ", \"prompt\" : " . $prompt . ", \"difficulty\" : " . $difficulty . ", \"topic\" : " . $topic . "}";

?>
