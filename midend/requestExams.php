<?php
//get data 
$s = $_POST['ucid'];
$a = [
    'ucid' => $s,
];

//untaken
$url = 'https://web.njit.edu/~gc288/490/examStudentUntaken.php';
$opts = [
    CURLOPT_URL => $url,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $a,
];
$ch = curl_init();
curl_setopt_array($ch,$opts);
curl_exec($ch);


?>

