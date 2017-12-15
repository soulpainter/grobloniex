<?php

$file = 'buy_dates.log';
$contents = file($file);

$interval = 86400;

$url = 'https://poloniex.com/public?command=returnChartData&currencyPair=USDT_BTC&start=__START__&end=__END__&period=86400';

foreach($contents as $line)
{
  print trim($line) . "\n";

  $startTs = strtotime(trim($line));
  $endTs = $startTs + $interval;

  $apiUrl = str_replace(['__START__','__END__'],[$startTs,$endTs],$url);
  #print $apiUrl."\n";
  $result = file_get_contents($apiUrl);
  #print $result;
  
  $myfile = fopen("btc_quotes/" . trim($line) . ".txt", "w") or die("Unable to open file!");
  fwrite($myfile, $result);
  fclose($myfile);

  #exit;
}

exit;

require_once 'poloniex-api-wrapper.php';

$key = 'xxx';
$secret = 'ccc';

$polo = new poloniex($key, $secret);

$balances = $polo->get_balances();

print "currency,currentAmount,globalTradeID,tradeID,date,rate,amount,total,fee,orderNumber,type,category\n";

foreach ($balances as $currency=>$value)
{
  if ($value > 0)
  {
    $history = $polo->get_my_trade_history('btc_' . $currency);
    foreach($history as $line)
    {
      print $currency . ',' . $value . ",";
      print implode(',',$line);
      print "\n";
    }
  }
}
