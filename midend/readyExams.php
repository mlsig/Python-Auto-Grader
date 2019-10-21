<?php
//get data 
$s = $_POST['ucid'];
$a = [
    'ucid' => $s,
];

//graded
$url = 'https://web.njit.edu/~gc288/490/examStudentGraded.php';
$opts = [
    CURLOPT_URL => $url,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $q,
];
$ch = curl_init();
curl_setopt_array($ch,$opts);
curl_exec($ch);

?>

