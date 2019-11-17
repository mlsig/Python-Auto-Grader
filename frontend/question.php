<?php
header("Content-Type: application/json; charset=UTF-8");
$title = $_POST['title'];
$prompt = $_POST['prompt'];
$difficulty = $_POST['difficulty'];
$topic = $_POST['topic'];
$sampleIO = $_POST['sampleIO'];

$creds = [
    'title'=>$title,
    'prompt'=>$prompt,
    'difficulty'=>$difficulty,
    'topic'=>$topic,
    'sampleIO'=>$sampleIO
];

$url = 'https://web.njit.edu/~ms2437/cs490/rc/addQuestions.php';
$opts = [
    CURLOPT_URL => $url,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $creds,
     CURLOPT_FOLLOWLOCATION => true,
];
$ch = curl_init();
curl_setopt_array($ch,$opts);
$local = json_decode(curl_exec($ch));
?>


