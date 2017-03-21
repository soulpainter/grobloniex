<?php

$post_data = 'command=returnTradeHistory&currencyPair=BTC_ETH&nonce=1486841187011710&start=1451606400&end=1486841557';
$secret = '402996c4013201f517561c504ada4d2224a0d2ff81dfd55e74048fc1d356b1fc117204f14c0c361aa4388545811145c1c87c70207dd156dc0ef53f8e95a57c35';

$sign = hash_hmac('sha512', $post_data, $secret);
print $sign . "\n";
