<?php

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

/** @var AMQPChannel $channel */
$channel = require_once __DIR__ . '/bootstrap.php';

$msg = new AMQPMessage('hello', [
    'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
]);
$channel->basic_publish($msg, '', 'hello');
