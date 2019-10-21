<?php
//get data 
$s = $_POST['ucid'];
$e = $_POST['eid'];
$a = [
    'ucid' => $s,
    'eid' => $e,
];

//untaken
$url = 'https://web.njit.edu/~gc288/490/getExam.php';
$opts = [
    CURLOPT_URL => $url,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $a,
];
$ch = curl_init();
curl_setopt_array($ch,$opts);
curl_exec($ch);


?>

