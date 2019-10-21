<?php
//get data from FE
$n = $_POST['title'];
$p = $_POST['qids'];
$d = $_POST['points'];

//send to BE
$url = 'https://web.njit.edu/~gc288/490/examAddNew.php';
$q = [
    'title' => $n,
    'qIDs' => $p,
    'points' => $d,
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

