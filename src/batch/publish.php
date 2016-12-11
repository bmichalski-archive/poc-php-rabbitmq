<?php

require_once __DIR__.'/../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');

$channel = $connection->channel();

$channel->queue_declare('hello', false, false, false, false);

$msg = new AMQPMessage('foobar');
$channel->batch_basic_publish($msg, '', 'batch');

$msg2 = new AMQPMessage('bazquz');
$channel->batch_basic_publish($msg2, '', 'batch');

$channel->publish_batch();

$channel->close();
$connection->close();
