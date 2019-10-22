<?php

/*
Backend to add a question to the DB.
Version: beta
Author: Giancarlo Calle
*/

//credentials: (title, prompt, difficulty, topic, sampleIO)
$title = $_POST["title"];
$prompt = $_POST["prompt"]; //ex: "print 'A+' if input is '100'
$difficulty = $_POST["difficulty"]; //ex: "hard"
$topic = $_POST["topic"]; //ex: "loops"

//all inputs and outputs
$in1 = $_POST["in1"];
$out1 = $_POST["out1"];
$in2 = $_POST["in2"];
$out2 = $_POST["out2"];
$in3 = $_POST["in3"];
$out3 = $_POST["out3"];
$in4 = $_POST["in4"];
$out4 = $_POST["out4"];
$in5 = $_POST["in5"];
$out5 = $_POST["out5"];

echo $title . $prompt . $difficulty . $topic . $in1 . $in2 . $in3 . $in4 . $in5 . $out1 . $out2 . $out3 . $out4 . $out5;

//verifies connection to database
$serverName = "sql.njit.edu"; //server name (mysql)
$userName = "gc288"; //giancarlo's ucid
$serverPassword = "camilla56"; //super secret password, avert your eyes!
$dbName = "gc288";
$connection = new mysqli($serverName, $userName, $serverPassword, $dbName); //connects to db
if ($connection->connect_error){
  echo "Could not connect to SQL database. Error: " . $connection -> connect_error;
}

//generates unique exam identifier
$query = "SELECT qid FROM QUESTIONS";

$queryResult = $connection->query($query); //runs query
$max = 0;
if($queryResult->num_rows == 0){
  $qid = "qid0";
}
else{
  while($row = mysqli_fetch_assoc($queryResult)){
    $qidSample = $row["qid"];
    $num = intval(explode("d", $qidSample)[1]); //grabs number from each qid
    if($num > $max){
      $max = $num;
    }
  }
  $max++;
  $qid = "qid{$max}";
}

//inserts into the QUESTIONS table
$query = "INSERT INTO QUESTIONS (qid, qtitle, prompt, difficulty, topic) VALUES (\"{$qid}\", \"{$title}\", \"{$prompt}\", \"{$difficulty}\", \"{$topic}\");";
$queryResult = $connection->query($query); //runs query

//inserts into IO table
$query = "INSERT INTO IO (qid, input, output) VALUES (\"{$qid}\", \"{$in1}\", \"{$out1}\")";
$queryResult = $connection->query($query); //runs query
$query = "INSERT INTO IO (qid, input, output) VALUES (\"{$qid}\", \"{$in2}\", \"{$out2}\")";
$queryResult = $connection->query($query); //runs query
$query = "INSERT INTO IO (qid, input, output) VALUES (\"{$qid}\", \"{$in3}\", \"{$out3}\")";
$queryResult = $connection->query($query); //runs query
$query = "INSERT INTO IO (qid, input, output) VALUES (\"{$qid}\", \"{$in4}\", \"{$out4}\")";
$queryResult = $connection->query($query); //runs query
$query = "INSERT INTO IO (qid, input, output) VALUES (\"{$qid}\", \"{$in5}\", \"{$out5}\")";
$queryResult = $connection->query($query); //runs query

$query = "DELETE FROM IO WHERE input=\"\"";
$queryResult = $connection->query($query);

?>
