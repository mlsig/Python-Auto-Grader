<?php
//get data 
$s = $_POST['difficulty'];
$a = [
    'difficulty' => $s,
];

//untaken
$url = 'https://web.njit.edu/~gc288/490/getQuestionsDiff.php';
$opts = [
    CURLOPT_URL => $url,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $a,
];
$ch = curl_init();
curl_setopt_array($ch,$opts);
curl_exec($ch);


?>

