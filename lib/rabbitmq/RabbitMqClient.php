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

class RabbitMqClient implements IRabbitMqClient
{
    private const HOST = 'localhost';
    private const PORT = 5672;
    private const USER = 'guest';
    private const PASSWORD = 'guest';
    private const QUEUE_NAME = 'video_file';

    /**
     * @var AMQPStreamConnection $connection
     */
    private $connection;
    /**
     * @var AMQPChannel $channel
     */
    private $channel;

    public function __construct()
    {
        $this->setConnection();
        $this->setChannel();
    }

    private function setConnection(): void
    {
        $this->connection = new  AMQPStreamConnection(
            RabbitMqClient::HOST,
            RabbitMqClient::PORT,
            RabbitMqClient::USER,
            RabbitMqClient::PASSWORD
        );
        return;
    }

    private function setChannel(): void
    {
        $this->channel->queue_declare(
            RabbitMqClient::QUEUE_NAME,
            false,
            false,
            false,
            false
        );
        return;
    }

    public function consume(Closure $callback): void
    {
        $this->setConnection();
        $this->setChannel();
        $this->channel->basic_consume(
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

    public function getCallbackCount(): int
    {
        return count($this->channel->callbacks);
    }

    public function publish(AMQPMessage $message): void
    {
        $this->channel->basic_publish($message, '', RabbitMqClient::QUEUE_NAME);
        return;
    }

    public function wait(): void
    {
        $this->channel->wait();
        return;
    }

    public function closeConnection(): void
    {
        $this->channel->close();
        $this->connection->close();
        return;
    }
}
