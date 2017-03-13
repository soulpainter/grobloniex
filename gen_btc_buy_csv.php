<?php

$dir = 'btc_quotes';

foreach(glob($dir.'/*.*') as $file) {
  $json = file_get_contents($file);
  $array = json_decode($json,1);

  $data = array();
  foreach($array[0] as $k=>$v)
  {
    $data[$k] = (int) $v;
  }

  $str = implode(",", $data);

  $date = date("Y-m-d 00:00:00", $data['date']);
  print $date . ","; 
  print $str."\n";
}



