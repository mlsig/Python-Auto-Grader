
<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");
if(isset($_POST['ucid']))
{
  $ucid = $_POST['ucid'];
  $pass = $_POST['pass'];
  $_SESSION['UCID'] = $ucid;
  $creds = [
      'u'=>$ucid,
      'p'=>$pass,
  ];
  
  //sending to mid
  $url = 'https://web.njit.edu/~ms2437/cs490/rc/verify.php';
  $opts = [
      CURLOPT_URL => $url,
      CURLOPT_POST => true,
      CURLOPT_POSTFIELDS => $creds,
       CURLOPT_FOLLOWLOCATION => true,
  ];
  $ch = curl_init();
  curl_setopt_array($ch,$opts);
  $local = json_decode(curl_exec($ch));


}
else
{
  echo $_SESSION['UCID'];
}
?>
