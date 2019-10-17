<?php
//get data from FE
$e = $_POST['exID'];
$s = $_POST['sID'];

//get question ID's from gc
$url = 'https://web.njit.edu/~gc288/490/getExQuestions.php';
$exam = [
    'exID' => $e,
    'sID' => $s,
];
$opts = [
    CURLOPT_URL => $url,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $exam,
];
$ch = curl_init();
curl_setopt_array($ch,$opts);
curl_exec($ch);

//save array of questions (need: qid, title, user solution, I/O, rubric)
//above will be whats returned in each item of the questions array, with an updated rubric array
$questions = json_decode(file_get_contents('https://web.njit.edu/~gc288/490/getExQuestions'), true);

//create array to save new question data
foreach ($quesions as &$q) {
    //get q info
    $func = $q[1];
    $sol = $q[2];
    $out = $q[3];
    $rubric = $q[4]
    //rubric should be an array
    //do the grading
    $command = escapeshellcmd("python3 grade.py " . $func . " " . $out . " " . $sol . " " . $rubric)
    $output = shell_exec($command);
    //create array for the new question data
    //save the grade into some question object in an array
    echo $output;
}    
    
//send final array to gc
$url = 'https://web.njit.edu/~gc288/490/examAddAutoGrade.php';
$out = [
    //exam id
    //array of new quesions
];
$opts = [
    CURLOPT_URL => $url,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $out,
];
$ch = curl_init();
curl_setopt_array($ch,$opts);
curl_exec($ch);

    
//output confirmation
$output = json_decode(file_get_contents('https://web.njit.edu/~gc288/490/examAddAutoGrade.php'), true);

?>

