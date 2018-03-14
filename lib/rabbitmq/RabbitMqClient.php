<?php
/**
 * Created by PhpStorm.
 * User: DavidOS
 * Date: 14-Mar-18
 * Time: 11:27 AM
 */

require_once __DIR__ . '/../../vendor/autoload.php';

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMqClient
{
    private const HOST = 'localhost';
    private const PORT = 5672;
    private const USER = 'guest';
    private const PASSWORD = 'guest';
    private const QUEUE_NAME = 'video_file';

    public function getConnection(): AMQPStreamConnection
    {
        return new AMQPStreamConnection(
            RabbitMqClient::HOST,
            RabbitMqClient::PORT,
            RabbitMqClient::USER,
            RabbitMqClient::PASSWORD
        );
    }

    public function getChannel(AMQPStreamConnection $connection): AMQPChannel
    {
        $channel = $connection->channel();
        $channel->queue_declare(
            RabbitMqClient::QUEUE_NAME,
            false,
            false,
            false,
            false
        );
        return $channel;
    }

    public function consume(Closure $callback, AMQPChannel $channel): void
    {
        $channel->basic_consume(
            RabbitMqClient::QUEUE_NAME,
            '',
            false,
            true,
            false,
            false,
            $callback
        );
        return;
    }

    public function publish(AMQPMessage $message, AMQPChannel $channel): void
    {
        $channel->basic_publish($message, '', RabbitMqClient::QUEUE_NAME);
        return;
    }

    public function closeConnection(AMQPChannel $channel, AMQPStreamConnection $connection): void
    {
        $channel->close();
        $connection->close();
        return;
    }
}
