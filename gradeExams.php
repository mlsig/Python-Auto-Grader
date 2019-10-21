<?php
//send to BE
$url = 'https://web.njit.edu/~gc288/490/examInstructorUngraded.php';
$opts = [
    CURLOPT_URL => $url,
    CURLOPT_POST => true,
];
$ch = curl_init();
curl_setopt_array($ch,$opts);
curl_exec($ch);
?>
