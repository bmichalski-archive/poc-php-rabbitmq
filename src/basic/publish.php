<?php

require_once __DIR__.'/../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');

$channel = $connection->channel();

$channel->queue_declare('basic', false, false, false, false);

$msg = new AMQPMessage('foobar');

$channel->basic_publish($msg, '', 'basic');

$channel->close();
$connection->close();
