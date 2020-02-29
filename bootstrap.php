<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Wire\AMQPTable;

require_once __DIR__ . '/vendor/autoload.php';

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();
$channel->basic_qos(null, 1, null);

// DLQ with exchange
$channel->queue_declare('hello-dlq', false, true, false, false);
$channel->exchange_declare('dlq-exchange', 'direct', false, false, false);
$channel->queue_bind('hello-dlq', 'dlq-exchange', 'hello-dlq');

// queue
$channel->queue_declare('hello', false, true, false, false, false, new AMQPTable([
    'x-dead-letter-exchange' => 'dlq-exchange',
    'x-dead-letter-routing-key' => 'hello-dlq',
]));

return $channel;
