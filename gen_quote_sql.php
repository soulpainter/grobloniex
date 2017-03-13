<?php
$url = 'https://poloniex.com/public?command=returnTicker';
$json = file_get_contents($url);

$data = json_decode($json,true);

foreach($data as $pair=>$info)
{
  print "$pair = $info[last]\n";
}

