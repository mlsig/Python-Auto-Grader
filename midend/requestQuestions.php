<?php
//get data from FE
$q = $_POST['command'];

//send to BE
$url = 'https://web.njit.edu/~gc288/490/getExQuestions.php';
$cmd = [
    'command' => $q,
];
$opts = [
    CURLOPT_URL => $url,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $cmd,
];
$ch = curl_init();
curl_setopt_array($ch,$opts);
curl_exec($ch);

//output
$output = json_decode(file_get_contents('https://web.njit.edu/~gc288/490/getExQuestions.php'), true);

?>

