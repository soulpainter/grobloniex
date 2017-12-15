<?php

$post_data = 'command=returnTradeHistory&currencyPair=BTC_ETH&nonce=1486841187011710&start=1451606400&end=1486841557';
$secret = 'ccc';

$sign = hash_hmac('sha512', $post_data, $secret);
print $sign . "\n";
