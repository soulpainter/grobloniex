<?php

/*

$BOUGHT = 6.001050000000001 DASH
check

$BOUGHT_PRICE_PER_COIN = 0.01635616266666666 BTC
check

$BOUGHT_BTC_TO_USD_QUOTE = $903
check

$CURRENT_PRICE_PER_COIN = 0.03680007 BTC

$CURRENT_BTC_TO_USD_QUOTE = $1268.11

*/

require_once('BtcPurchaseSnapshotPDO.php');
require_once('TradingHistoryPDO.php');

$BtcPurchaseSnapshotPDO = new BtcPurchaseSnapshotPDO();
$TradingHistoryPDO = new TradingHistoryPDO();

$currencies = $TradingHistoryPDO->fetchAllOwnedCurrencies();

print "currency,total_owned,avg_purchase_rate,average_btc_price,purchase_total_btc,purchase_total_usd,current_rate,current_btc_price,current_total_btc,current_total_usd\n";

foreach ($currencies as $currency)
{
  # THIS GETS ME THE TOTAL AMOUNT I OWN FOR A CURRENCY AND PRICE PER COIN I PAID
  $owned = $TradingHistoryPDO->fetchTotalOwnedByCurrency($currency);
  #print "I currently own $owned[totalPurchased] of $currency.\n";
  #print "I made $owned[totalPurchases] total buys at an avg of $owned[avgPurchaseRate] $currency/BTC per buy.\n";

  # THIS GETS ME THE DAYS I BOUGHT THE COIN
  $daysBought = $TradingHistoryPDO->fetchDaysBoughtByCurrency($currency);
  $multiDayBtcPrice = $BtcPurchaseSnapshotPDO->fetchAverageBtcByMultipleDates($daysBought);
  #print 'The avg BTC/USD price when I bought ' . $currency . ' was $' . (int) $multiDayBtcPrice['averageBtcPrice'] . ".\n";

  $purchase = computeUsdPerCoin($owned['totalPurchased'], $owned['avgPurchaseRate'], $multiDayBtcPrice['averageBtcPrice']);

  $currentQuote = getCurrentQuote($currency);
  #print 'The current ' . $currency . '/BTC price is ' . $currentQuote['last'] . "\n";

  $btcQuote = getCurrentBtcQuote();
  #print 'The current BTC/USD price is ' . $btcQuote['last'] . "\n";

  $current = computeUsdPerCoin($owned['totalPurchased'], $currentQuote['last'], $btcQuote['last']);

  #print "\n-------------------------\n\n";

  print "$currency,$owned[totalPurchased],$owned[avgPurchaseRate],$multiDayBtcPrice[averageBtcPrice],$purchase[totalSpent],$purchase[totalUsdSpent],$currentQuote[last],$btcQuote[last],$current[totalSpent],$current[totalUsdSpent]\n";
  #exit;

}

function getCurrentQuote($currency)
{
  $url = 'https://poloniex.com/public?command=returnTicker';
  $json = file_get_contents($url);

  $data = json_decode($json,true);

  foreach($data as $pair=>$info)
  {
    if($pair == 'BTC_' . $currency)
    {
      return $info;
    }
  }
}

function getCurrentBtcQuote()
{
  $url = 'https://poloniex.com/public?command=returnTicker';
  $json = file_get_contents($url);

  $data = json_decode($json,true);

  foreach($data as $pair=>$info)
  {
    if($pair == 'USDT_BTC')
    {
      return $info;
    }
  }
}

function computeUsdPerCoin($amount, $pricePerCoin, $btcPrice)
{
  $result = [];

  #print "Computing $amount, $pricePerCoin, $btcPrice\n";
  $result['totalSpent'] = $amount * $pricePerCoin;
  $result['totalUsdSpent'] = $amount * $pricePerCoin * $btcPrice;
  return $result;
}

?>
