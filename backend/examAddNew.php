<?php
/*Adds an exam to the database*/
/*
Backend to grab exam taken by student and stores student solution in DB.
Version: beta
Author: Giancarlo Calle
*/

//credentials: (title, qidJSON)
$eid = $_POST["title"]
$qidJSON = $_POST["qidJSON"]; //of the form: "qid1:[8,4];qid4:[7,4]}"

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
$query = "SELECT eid FROM EXAMS WHERE eid = (SELECT MAX(eid) FROM EXAMS);";
$queryResult = $connection->query($query); //runs query
if($queryResult -> num_rows == 0){ //checks if table is empty
  $eid = "eid0";
}
else{
  $maxeid = mysqli_fetch_assoc($queryResult)["eid"];
  $numString = explode("d", $maxeid)[1]; //grabs the number from the max eid
  $num = intval($numString) + 1;
  $eid = "eid{$num}";
}

//inserts into the EXAM table
$query = "INSERT INTO EXAMS (eid, etitle) VALUES (\"{$eid}\", \"{$title}\")";
$queryResult = $connection->query($query);

//parses $qidJSON for qid and points. Of the form "qid1:[8,4];qid4:[7,4]"
$qidJSON = "qid1:[8,4];qid4:[7,4]";
$split = explode(";", $qidJSON);
foreach ($split as &$val){
  $split2 = explode(":", $val);
  $qid = $split2[0];
  $points = $split2[1];
  $query = "INSERT INTO EXAM_QUESTIONS VALUES (\"{$eid}\", \"{$qid}\", \"{$points}\")"
  $queryResult = $connection->query($query);
}

//echos back to confirm
echo "{ \"qid\" : \"{$qid}\", \"title\" : \"{$title}\", \"prompt\" : \"{$prompt}\", \"difficulty\" : \"{$difficulty}\", \"topic\" : \"{$topic}\", \"sampleIO\" : \"{$sampleIO}\" }";

?>
