<?php

/*
Backend to add a new exam created by an instructor to the DB.
Version: beta
Author: Giancarlo Calle
*/

//credentials: (eid, qids)
$title = $_POST["title"];
$qids = $_POST["qids"]; //of the form: "qid1,qid2"
$points = $_POST["points"]; //of the form: "4,2;2,3"

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


//parses $qids for qid and points. Of the form "qid0:[8,4];qid1:[7,4]"
$qidList = explode(",", $qids);
$pointList = explode(";", $points);
for ($i = 0; $i < count($qidList); $i++){
  $qid = $qidList[$i];
  $points = $pointList[$i];
  $query = "INSERT INTO EXAM_QUESTIONS VALUES (\"{$eid}\", \"{$qid}\", \"{$points}\")";
  $queryResult = $connection->query($query);
}

//inserts into EXAM_STATUS table to check status of each student for each exam
$q = "SELECT ucid FROM VALIDATION WHERE level = \"s\"";
$qResult = $connection->query($q);
while($ucid = mysqli_fetch_assoc($qResult)["ucid"]){
  $q = "INSERT INTO EXAM_STATUS (eid, ucid, status) VALUES (\"{$eid}\", \"{$ucid}\", \"No Submission\")";
  $qResult = $connection->query($q);
}

//echos back to confirm
echo "{ \"eid\" : \"{$eid}\", \"title\" : \"{$title}\" }";

?>
