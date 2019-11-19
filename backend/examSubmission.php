<?php

/*
Recieves exam submission from student and sends it to auto-grader and stores the grade and submission in DB
Version: release candidate
Author: Giancarlo Calle
*/

//verifies connection to database
$serverName = "sql.njit.edu"; //server name (mysql)
$userName = "gc288"; //giancarlo's ucid
$serverPassword = "camilla56"; //super secret password, avert your eyes!
$dbName = "gc288";
$connection = new mysqli($serverName, $userName, $serverPassword, $dbName); //connects to db
if ($connection->connect_error){
  echo "Could not connect to SQL database. Error: " . $connection -> connect_error;
}

//credentials: (codeJSON)
$codeJSON = $_POST["codeJSON"];
$codeJSON = "{\"eid\": \"eid0\", \"ucid\":\"gc288\", \"solutions\":[{\"qid\":\"qid0\", \"sol\":\"def returnDouble(num)\n\treturn 4\"},{\"qid\":\"qid1\", \"sol\":\"def returnHalf(num):\\n\\treturn num*.5\"}] }";
$codeJSON = strtr($codeJSON, array("\n" => "\\n",  "\t" => "\\t")); //ensures correct json format by removing newlines and tabs
$decoded = json_decode($codeJSON);
$eid = $decoded->eid;
$ucid = $decoded->ucid;

//inserts inserts code into DB and adds exam info to json for grader
$array = $decoded->solutions;
$json = "[";
foreach($array as &$question){
  $qid = $question->qid;
  $sol = $question->sol;
  $sol = strtr($sol, array("\n" => "\\n",  "\t" => "\\t")); //replaces newline with \n, tab with \t

  //inserts code into db
  $query = "INSERT INTO EXAM_POINTS (eid, ucid, qid, sol) VALUES (\"{$eid}\", \"{$ucid}\", \"{$qid}\", \"{$sol}\")";
  $qResult = $connection->query($query);

  //grabs title
  $query2 = "SELECT qtitle FROM QUESTIONS WHERE qid = \"{$qid}\"";
  $qResult2 = $connection->query($query2);
  $title = mysqli_fetch_assoc($qResult2)["qtitle"];

  //grabs input and output and stores in array
  $io = "[";
  $query3 = "SELECT input, output FROM IO WHERE qid = \"{$qid}\"";
  $qResult3 = $connection->query($query3);
  while($row = mysqli_fetch_assoc($qResult3)){
    $in = $row["input"];
    $out = $row["output"];
    $io = $io . "{\"in\":\"{$in}\",\"out\":\"{$out}\"},";
  }
  $io = substr($io, 0, -1); //removes last comma
  $io = $io . "]";

  //grabs point values for question
  $query4 = "SELECT points FROM EXAM_QUESTIONS WHERE eid = \"{$eid}\" AND qid = \"{$qid}\"";
  $qResult4 = $connection->query($query4);
  $rubric = "\"" . mysqli_fetch_assoc($qResult4)["points"] . "\"";

  //adds code to JSON to send to midend for auto grading
  $json = $json . "{\"qid\":\"{$qid}\", \"title\":\"{$title}\", \"sol\":\"{$sol}\", \"io\":{$io}, \"rubric\":{$rubric}},";
}
$json = substr($json, 0, -1); //removes last comma
$json = $json . "]";

//updates status of exam so student cannot take it again
$query5 = "UPDATE EXAM_STATUS SET status=\"Auto-Graded\" WHERE eid=\"{$eid}\" AND ucid=\"{$ucid}\"";
$qResult5 = $connection->query($query5);

//echo $json;

//sends json to midend to grade
$url = 'https://web.njit.edu/~ms2437/cs490/rc/grade.php';
$creds = ['json' => $json];
$opts = [
  CURLOPT_URL => $url,
  CURLOPT_POST => true,
  CURLOPT_POSTFIELDS => $creds,
  CURLOPT_RETURNTRANSFER => true
];
$ch = curl_init();
curl_setopt_array($ch,$opts);
$autoPoints = curl_exec($ch);

//calculates grade given by auto grader
$j = json_decode($autoPoints);
$totalGrade = $j->total_grade;
$pointsPossible = $j->points_possible;

$autoGrade = "{$totalGrade}/{$pointsPossible}";

$query6 = "UPDATE EXAM_STATUS SET autoGrade=\"{$autoGrade}\", pointsPossible=\"{$pointsPossible}\" WHERE eid=\"{$eid}\" AND ucid=\"{$ucid}\"";
$qResult6 = $connection->query($query6);

//adds grade given by auto grader to the DB
$qidList = $j->qids;
foreach($qidList as &$qidJSON){
  $qid = $qidJSON->qid;
  $deductions = $qidJSON->deductions;
  $autoPoints = $qidJSON->autoPoints;

  $query7 = "UPDATE EXAM_POINTS SET autoPoints=\"{$autoPoints}\" WHERE eid=\"{$eid}\" AND ucid=\"{$ucid}\" AND qid=\"{$qid}\"";
  $qResult7 = $connection->query($query7);

  foreach($deductions as &$deduct){
    $query8 = "INSERT INTO EXAM_DEDUCTIONS VALUES (\"{$eid}\", \"{$ucid}\", \"{$qid}\", \"{$deduct}\")";
    $qResult8 = $connection->query($query8);
  }
}

mysqli_close($connection);
//end of file
