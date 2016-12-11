<?php

require_once __DIR__.'/../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');

$channel = $connection->channel();

$result = $channel->queue_declare('noack_queue', false, true, false, false);

$callback = function($msg) use ($channel) {
    echo " [x] Received ", $msg->body, "\n";

    throw new \Exception('');
};

$channel->basic_consume('noack_queue', '', false, false, false, false, $callback);

while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();
