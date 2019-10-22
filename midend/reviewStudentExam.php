<?php
//get data from FE
$u = $_POST['ucid'];
$e = $_POST['eid'];

//send to BE
$url = 'https://web.njit.edu/~gc288/490/reviewExamInstructor.php';
$q = [
    'ucid' => $u,
    'eid' => $e
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
