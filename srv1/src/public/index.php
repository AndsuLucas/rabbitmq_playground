<?php

require_once __DIR__ . '/../vendor/autoload.php';
echo '<title>Srv1</title>';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('rmq', 5672, 'root', 'root');

$channel = $connection->channel();
$channel->exchange_declare('custom', 'fanout');
$channel->queue_declare('custom_queue');
$channel->queue_bind('custom_queue', 'custom');

$message = new AMQPMessage('{"hello2":"world2"}');

try {
    $channel->basic_publish($message, 'custom');
} catch (\Throwable $th) {
    echo'<pre>';var_dump($th);exit;
}

$channel->close();
$connection->close();
echo 'Ok.';
