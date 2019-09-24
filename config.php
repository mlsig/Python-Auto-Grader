<?php
//get data from FE
$u = $_POST['u'];
$p = $_POST['p'];
//send to njit
$url = 'https://aevitepr2.njit.edu/MyHousing/login.cfm';
$creds = [
    'ucid' => $u,
    'pass' => $p,
];

$opts = [
    CURLOPT_URL => $url,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $creds,
    CURLOPT_RETURNTRANSFER => true,
];
$ch = curl_init();
curl_setopt_array($ch,$opts);
curl_exec($ch);

//validate njit
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if ($http_code == 302){
    $njit = "y";
}else{
    $njit = "n";
}

//send to BE
$url = 'https://web.njit.edu/~gc288/coolBackend.php';
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
$local = json_decode(file_get_contents('https://web.njit.edu/~gc288/coolBackend.php'), true);
echo $njit;

?>

