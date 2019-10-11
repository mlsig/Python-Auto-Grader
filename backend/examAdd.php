<?php
/*Adds a question input from an instructor to the database*/

//grabs credentials (title, qids)
$title = $_POST["title"];
$qidJSON = $_POST["qidJSON"]; //of the form: {qid1:"8,4", qid4:"7,4"}

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
  $maxqid = mysqli_fetch_assoc($queryResult)["eid"];
  $numString = explode("d", $maxqid)[1]; //grabs the number from the max eid
  $num = intval($numString) + 1;
  $eid = "eid{$num}";
}

//inserts into the EXAM table
$query = "INSERT INTO EXAMS (eid, etitle) VALUES (\"{$eid}\", \"{$title}\")";
$queryResult = $connection->query($query); //runs query

//inserts all the questions for the exam
$qidList = explode(",", $qids)
foreach ($qidList as &$qid){
  $query = "INSERT INTO EXAM_QUESTIONS (eid, qid) VALUES (\"{$eid}\", \"{$qid}\")";
  $queryResults = $connection->query($query);
}


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
