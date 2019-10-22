<?php
/*
Backend to echo untaken, pending, and graded exams for a specific student.
Version: beta
Author: Giancarlo Calle
*/

//credentials:
$ucid = $_POST["ucid"];

//verifies connection to database
$serverName = "sql.njit.edu"; //server name (mysql)
$userName = "gc288"; //giancarlo's ucid
$serverPassword = "camilla56"; //super secret password, avert your eyes!
$dbName = "gc288";
$c = new mysqli($serverName, $userName, $serverPassword, $dbName); //connects to db
if ($c->connect_error){
  echo "Could not connect to SQL database. Error: " . $connection -> connect_error;
}

//grabs eids from graded exams
$q = "SELECT eid, finalGrade FROM EXAM_STATUS WHERE ucid=\"{$ucid}\" AND status=\"Graded\"";
$qResult = $c->query($q);

if($qResult->num_rows === 0){
  exit("[]");
}

$json = "[";
while($row = mysqli_fetch_assoc($qResult)){
  $eid = $row["eid"];
  $finalGrade = $row["finalGrade"];

  //grabs title
  $q = "SELECT etitle FROM EXAMS WHERE eid=\"{$eid}\"";
  $r = $c->query($q);
  $etitle = mysqli_fetch_assoc($r)["etitle"];

  //grabs question info
  $qInfo = "[";
  $q = "SELECT Q.qtitle, Q.prompt, P.sol, P.finalPoints, P.comment FROM QUESTIONS Q, EXAM_POINTS P WHERE Q.qid=P.qid AND P.eid=\"{$eid}\" AND P.ucid=\"{$ucid}\"";
  $r = $c->query($q);


  while($info = mysqli_fetch_assoc($r)){
    $qtitle = $info["qtitle"];
    $prompt = $info["prompt"];
    $sol = $info["sol"];
    $points = $info["finalPoints"];
    $comment = $info["comment"];

    $sol = strtr($sol, array("\n" => "\\n",  "\t" => "\\t"));

    $qInfo = $qInfo . "{\"qtitle\":\"{$qtitle}\", \"prompt\":\"{$prompt}\", \"sol\":\"{$sol}\", \"points\":\"{$points}\", \"comment\":\"{$comment}\"},";
  }
  $qInfo = substr($qInfo, 0, -1); //removes last comma

  $json = $json . "{\"eid\":\"{$eid}\", \"etitle\":\"{$etitle}\", \"finalGrade\":\"{$finalGrade}\", \"questions\":" . $qInfo . "]},";
}
$json = substr($json, 0, -1);
$json = $json . "]";

echo $json;
?>
