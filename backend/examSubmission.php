<?php

/*
Backend to store student solution in DB.
Version: beta
Author: Giancarlo Calle
*/

//credentials: (codeJSON)
$codeJSON = $_POST["codeJSON"]; //of the form: [{"qid":"qid0", "code":"example code"}, {"qid":"qid1", "code":"sample"}]

//$codeJSON = "{\"eid\": \"eid0\", \"ucid\":\"gc288\", \"solutions\":[{\"qid\":\"qid0\", \"sol\":\"def returnDouble(num):\n\treturn num*2\"},{\"qid\":\"qid1\", \"sol\":\"def returnHalf(num):\\n\\treturn num*.5\"}] }";
$codeJSON = strtr($codeJSON, array("\n" => "\\n",  "\t" => "\\t"));
$decoded = json_decode($codeJSON);
$eid = $decoded->eid;
$ucid = $decoded->ucid;

//verifies connection to database
$serverName = "sql.njit.edu"; //server name (mysql)
$userName = "gc288"; //giancarlo's ucid
$serverPassword = "camilla56"; //super secret password, avert your eyes!
$dbName = "gc288";
$c = new mysqli($serverName, $userName, $serverPassword, $dbName); //connects to db
if ($c->connect_error){
  echo "Could not connect to SQL database. Error: " . $connection -> connect_error;
}

//Inserts code from codeJSON into EXAM_POINTS
$array = $decoded->solutions;
$json = "[";
foreach($array as &$question){
  $qid = $question->qid;
  $sol = $question->sol;


  //inserts code into db
  $q = "INSERT INTO EXAM_POINTS (eid, ucid, qid, sol) VALUES (\"{$eid}\", \"{$ucid}\", \"{$qid}\", \"{$sol}\")";
  $qResult = $c->query($q);

  $sol = strtr($sol, array("\n" => "\\n",  "\t" => "\\t")); //replaces newline with \n

  //grabs title
  $q = "SELECT qtitle FROM QUESTIONS WHERE qid = \"{$qid}\"";
  $qResult = $c->query($q);
  $title = mysqli_fetch_assoc($qResult)["qtitle"];

  //grabs input and output and stores in array
  $io = "[";
  $q = "SELECT input, output FROM IO WHERE qid = \"{$qid}\"";
  $qResult = $c->query($q);
  while($row = mysqli_fetch_assoc($qResult)){
    $in = $row["input"];
    $out = $row["output"];
    $io = $io . "\"{$in};{$out}\",";
  }
  $io = substr($io, 0, -1); //removes last comma
  $io = $io . "]";

  //grabs point values for question
  $q = "SELECT points FROM EXAM_QUESTIONS WHERE eid = \"{$eid}\" AND qid = \"{$qid}\"";
  $qResult = $c->query($q);
  $rubric = "[" . mysqli_fetch_assoc($qResult)["points"] . "]";

  //adds code to JSON to send to midend for auto grading
  $json = $json . "{\"qid\":\"{$qid}\", \"title\":\"{$title}\", \"sol\":\"{$sol}\", \"io\":{$io}, \"rubric\":{$rubric}},";

}
$json = substr($json, 0, -1); //removes last comma
$json = $json . "]";

//updates status of exam so student does not take it again
$q = "UPDATE EXAM_STATUS SET status=\"Auto-Graded\" WHERE eid=\"{$eid}\" AND ucid=\"{$ucid}\"";
$r = $c->query($q);


//sends json to midend to grade
$url = 'https://web.njit.edu/~ms2437/cs490/beta/grade.php';
$creds = ['json' => $json];
$opts = [
  CURLOPT_URL => $url,
  CURLOPT_POST => true,
  CURLOPT_POSTFIELDS => $creds,
  CURLOPT_RETURNTRANSFER => true
];
$ch = curl_init();
curl_setopt_array($ch,$opts);
$autoPoints = curl_exec($ch); //of the form: {"points_possible":34, "points_given":24, "qids":[{"qid":"qid1", "points":[3,4,2]},{...}] }


//calculates grade given by auto grader
$j = json_decode($autoPoints);
$pointsGiven = $j->points_given;
$pointsPossible = $j->points_possible;
$autoGrade = "{$pointsGiven}/{$pointsPossible}";
echo $autoGrade;
$q = "UPDATE EXAM_STATUS SET autoGrade=\"{$autoGrade}\" WHERE eid=\"{$eid}\" AND ucid=\"{$ucid}\"";
$r = $c->query($q);

//adds grade given by auto grader to the DB
$qidList = $j->qids;
foreach($qidList as &$qidJSON){
  $qid = $qidJSON->qid;
  $pointList = $qidJSON->points;

  $points = "";
  foreach($pointList as &$point){
    $points = $points . "{$point},";
  }
  $points = substr($points, 0, -1);


  $q = "UPDATE EXAM_POINTS SET autoPoints=\"{$points}\" WHERE eid=\"{$eid}\" AND ucid=\"{$ucid}\" AND qid=\"{$qid}\"";
  $r = $c->query($q);
}

?>
