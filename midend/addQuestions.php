<?php
//get data from FE
$n = $_POST['title'];
$p = $_POST['prompt'];
$d = $_POST['difficulty'];
$t = $_POST['topic'];
$s = $_POST['sampleIO'];

//send to BE
$url = 'https://web.njit.edu/~gc288/490/questionAdd.php';
$q = [
    'title' => $n,
    'prompt' => $p,
    'difficulty' => $d,
    'topic' => $t,
    'sampleIO' => $s,
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
