<?php

/*
Backend to add grade given and reviewd by instructor to DB.
Version: beta
Author: Giancarlo Calle
*/

//credentials:
$json = $_POST["json"]; //of the form {"eid": "eid1", "qids":"qid0,qid4", "points":"2,3,1;4,3,2", "finalGrade":45}

$j = json_decode($json);
$eid = $j->eid;
$qidString = $j->qids;
$qidList = explode(",", $qidString);
$pointString = $j->points;
$pointList = explode(";", $pointString);

//verifies connection to database
$serverName = "sql.njit.edu"; //server name (mysql)
$userName = "gc288"; //giancarlo's ucid
$serverPassword = "camilla56"; //super secret password, avert your eyes!
$dbName = "gc288";
$c = new mysqli($serverName, $userName, $serverPassword, $dbName); //connects to db
if ($c->connect_error){
  echo "Could not connect to SQL database. Error: " . $connection -> connect_error;
}

//puts rubric in database
for($i = 0; $i < count($qidList), $i++){
  $qid = $qidList[$i];
  $rubric = $pointList[$i];

  $q = "UPDATE EXAM_QUESTIONS_GRADE SET "
}

?>
