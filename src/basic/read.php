<?php

require_once __DIR__.'/../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');

$channel = $connection->channel();

$channel->queue_declare('basic', false, false, false, false);

$callback = function($msg) {
    echo " [x] Received ", $msg->body, "\n";
};

/**
 * As per the documentation, when no_ack is set to true,
 * the server does not expect any acknowledgment from the client.
 * See http://www.rabbitmq.com/amqp-0-9-1-reference.html#domain.no-ack.
 */
$channel->basic_consume('basic', '', false, true, false, false, $callback);

while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();
