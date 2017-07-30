<?php
include __DIR__ . '/../../../vendor/autoload.php';

$buf = new \Swoole\Buffer(20);

$buf->append('123');
$buf->append('456');

$length = 4;
$data = $buf->read(0, $length);
$left = $buf->read($length, $buf->length - $length);
dump($data, $left);

