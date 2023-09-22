<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('rmq', 5672, 'root', 'root');
$channel = $connection->channel();
$s = $channel->basic_consume('custom_queue', callback: function (AMQPMessage $msg){
    echo $msg->body;
    $msg->ack();
    echo '<br>';    
});


while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();

// while ($channel->is_open()) {
//     $channel->wait();
// }