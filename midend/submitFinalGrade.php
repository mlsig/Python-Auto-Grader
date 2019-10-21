<?php
//get data from FE
$j = $_POST['json'];

//send to BE
$url = 'https://web.njit.edu/~gc288/490/instructorSubmitGrade.php';
$q = [
    'json' => $j,
];
$opts = [
    CURLOPT_URL => $url,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $q,
];
$ch = curl_init();
curl_setopt_array($ch,$opts);
curl_exec($ch);
?>
