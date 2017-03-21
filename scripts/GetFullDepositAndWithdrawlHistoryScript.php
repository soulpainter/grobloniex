<?php

require_once '../poloniex-api-wrapper.php';

$key = '51EENPG1-4J5JMNE3-9EFR9ZJ5-KP1X2T1X';
$secret = '402996c4013201f517561c504ada4d2224a0d2ff81dfd55e74048fc1d356b1fc117204f14c0c361aa4388545811145c1c87c70207dd156dc0ef53f8e95a57c35';

$polo = new poloniex($key, $secret);

    $history = $polo->get_my_deposits_withdraws();
    foreach($history as $key=>$line)
    {
      if($key =='withdrawals')
      {
        print_r($line);
      }
      else
      {
        #deposits
      }
    }

exit;

$balances = $polo->get_balances();

print "currency,currentAmount,globalTradeID,tradeID,date,rate,amount,total,fee,orderNumber,type,category\n";

foreach ($balances as $currency=>$value)
{
  if ($value > 0)
  {
    if($currency == 'BTC')
    {
      continue;
    }
 
    $history = $polo->get_my_trade_history('btc_' . $currency);
    foreach($history as $line)
    {
      print $currency . ',' . $value . ",";
      if(is_array($line))
      {
        print implode(',',$line);
      }
      else
      {
        print $line;
      }

      print "\n";
    }
  }
}
