<?php
//get data from FE
$u = $_POST['u'];
$p = $_POST['p'];

//send to BE
$url = 'https://web.njit.edu/~gc288/490/loginBackend.php';
$creds = [
    'u' => $u,
    'p' => $p,
];
$opts = [
    CURLOPT_URL => $url,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $creds,
];
$ch = curl_init();
curl_setopt_array($ch,$opts);
curl_exec($ch);

//output
$output = json_decode(file_get_contents('https://web.njit.edu/~gc288/490/loginBackend.php'), true);

?>

