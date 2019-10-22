<?php

/*
Backend to add a new exam created by an instructor to the DB.
Version: beta
Author: Giancarlo Calle
*/

//credentials: (eid, qids)
$title = $_POST["title"];
$qids = $_POST["qIDs"]; //of the form: "qid1,qid2"
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
$query = "SELECT eid FROM EXAMS";
$queryResult = $connection->query($query); //runs query
$max = 0;
if($queryResult->num_rows == 0){
  $eid = "eid0";
}
else{
  while($row = mysqli_fetch_assoc($queryResult)){
    $eidSample = $row["eid"];
    $num = intval(explode("d", $eidSample)[1]); //grabs number from each qid
    if($num > $max){
      $max = $num;
    }
  }
  $max++;
  $eid = "eid{$max}";
}


//inserts into the EXAM table
$query = "INSERT INTO EXAMS (eid, etitle) VALUES (\"{$eid}\", \"{$title}\")";
$queryResult = $connection->query($query);


//parses $qids for qid and points.
$qidList = explode(",", $qids);
$pointList = explode(";", $points);
for ($i = 0; $i < count($qidList); $i++){
  $qid = $qidList[$i];
  $points = $pointList[$i];
  $query = "INSERT INTO EXAM_QUESTIONS VALUES (\"{$eid}\", \"{$qid}\", \"{$points}\")";
  $queryResult = $connection->query($query);
}

//inserts into EXAM_STATUS table to check status of each student for each exam
$q = "SELECT ucid FROM VALIDATION WHERE level=\"s\"";
$qResult = $connection->query($q);

while($ucid = mysqli_fetch_assoc($qResult)["ucid"]){

  $q = "INSERT INTO EXAM_STATUS (eid, ucid, status) VALUES (\"{$eid}\", \"{$ucid}\", \"No Submission\")";
  echo $q;
  $r = $connection->query($q);
}



?>
