<?php

/*
Backend to store student solution in DB.
Version: beta
Author: Giancarlo Calle
*/

//credentials: (codeJSON)
$codeJSON = $_POST["codeJSON"]; //of the form: [{"qid":"qid0", "code":"example code"}, {"qid":"qid1", "code":"sample"}]

$codeJSON = '{"eid": "eid1", "ucid":"gc288", "solutions":[{"qid":"qid0", "sol":"I tried so hard, and got so far"},{"qid":"qid1", "sol":"uwuwuw"}] }';
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
$json = "{";
foreach($array as &$question){
  $qid = $question->qid;
  $sol = $question->sol;

  //inserts code into db
  $q = "INSERT INTO EXAM_POINTS VALUES (\"{$eid}\", \"{$ucid}\", \"{$qid}\", \"{$sol}\")";
  $qResult = $c->query($q);

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
  $rubric = mysqli_fetch_assoc($qResult)["points"];

  //adds code to JSON to send to midend for auto grading
  $json = $json . "\"{$qid}\" :{ \"title\":\"{$title}\", \"sol\":\"{$sol}\", \"io\":{$io}, \"rubric\":{$rubric}},";

}
$json = substr($json, 0, -1); //removes last comma
$json = $json . "}";
echo $json;


//sends json to midend to grade
$url = 'https://web.njit.edu/~ms2437/cs490/beta/grade.php';
$creds = ['json' => $jsonToSend];
$opts = [
  CURLOPT_URL => $url,
  CURLOPT_POST => true,
  CURLOPT_POSTFIELDS => $creds,
  CURLOPT_RETURNTRANSFER => true
];
$ch = curl_init();
curl_setopt_array($ch,$opts);
$autoPoints = curl_exec($ch);
echo $autoPoints;

?>
