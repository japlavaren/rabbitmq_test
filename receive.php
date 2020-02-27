<?php

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

/** @var AMQPChannel $channel */
$channel = require_once __DIR__ . '/bootstrap.php';

$channel->basic_consume(
    'hello',
    '',
    false,
    false,
    false,
    false,
    function (AMQPMessage $msg) {
        /** @var AMQPChannel $channel */
        $channel = $msg->delivery_info['channel'];

        /** @var int $tag */
        $tag = $msg->delivery_info['delivery_tag'];

        $channel->basic_nack($tag);
    });

while ($channel->is_consuming()) {
    $channel->wait();
}
