<?php
$redis = new Redis();
$connected = $redis->pconnect('127.0.0.1');
$redis->set('foo', 'foo のvalueです');
print_r($redis->get('foo'));
