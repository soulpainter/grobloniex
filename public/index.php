<?php

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
