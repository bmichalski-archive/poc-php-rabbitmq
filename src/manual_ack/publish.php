<?php

require_once __DIR__.'/../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');

$channel = $connection->channel();

$channel->queue_declare('noack_queue', false, true, false, false);

$msg = new AMQPMessage('foobar');

$channel->basic_publish($msg, '', 'noack_queue');

$channel->close();
$connection->close();
