<?php
//get data from FE
$n = $_POST['title'];
$p = $_POST['prompt'];
$d = $_POST['difficulty'];
$t = $_POST['topic'];
$i1 = $_POST['in1'];
$o1 = $_POST['out1'];
$i2 = $_POST['in2'];
$o2 = $_POST['out2'];
$i3 = $_POST['in3'];
$o3 = $_POST['out3'];
$i4 = $_POST['in4'];
$o4 = $_POST['out4'];
$i5 = $_POST['in5'];
$o5 = $_POST['out5'];
$i6 = $_POST['in6'];
$o6 = $_POST['out6'];

//send to BE
$url = 'https://web.njit.edu/~gc288/490/questionAdd.php';
$q = [
    'title' => $n,
    'prompt' => $p,
    'difficulty' => $d,
    'topic' => $t,
    'sampleIO' => $s,
    'in1' => $i1,
    'out1' => $o1,
    'in2' => $i2,
    'out2' => $o2,
    'in3' => $i3,
    'out3' => $o3,
    'in4' => $i4,
    'out4' => $o4,
    'in5' => $i5,
    'out5' => $o5,
	'in6' => $i6,
	'out6' => $o6,
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

