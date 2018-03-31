<?php
/**
 * Created by PhpStorm.
 * User: DavidOS
 * Date: 14-Mar-18
 * Time: 11:27 AM
 */

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/IRabbitMqClient.php';
require_once __DIR__ . '/RabbitMqConfig.php';

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

class RabbitMqClient implements IRabbitMqClient
{
    /**
     * @var AMQPStreamConnection $connection
     */
    private $connection;
    /**
     * @var AMQPChannel $channel
     */
    private $channel;
    /**
     * @var RabbitMqConfig $config
     */
    private $config;

    private const CONFIG_PATH = '/config/rabbitmq.yml';

    public function __construct()
    {
        $this->parseConfig();
        $this->setConnection();
        $this->setChannel();
    }

    private function parseConfig(): void
    {
        $input = sfConfig::get('sf_root_dir') . RabbitMqClient::CONFIG_PATH;
        try {
            $this->config = (object)sfYaml::load($input);
        } catch (InvalidArgumentException $e) {
            error_log($e->getMessage());
        }
    }

    private function setConnection(): void
    {
        $this->connection = new AMQPStreamConnection(
            $this->config->host,
            $this->config->port,
            $this->config->user,
            $this->config->password
        );
        return;
    }

    private function setChannel(): void
    {
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare(
            $this->config->queue_name,
            false,
            false,
            false,
            false,
            false,
            new AMQPTable($this->config->args)
        );
        return;
    }

    public function consume(Closure $callback): void
    {
        $this->channel->basic_consume(
            $this->config->queue_name,
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
        $this->channel->basic_publish($message, '', $this->config->queue_name);
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
