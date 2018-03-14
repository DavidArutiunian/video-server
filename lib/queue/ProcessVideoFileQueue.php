<?php
/**
 * Created by PhpStorm.
 * User: DavidOS
 * Date: 13-Mar-18
 * Time: 7:14 PM
 */

require_once __DIR__ . '/../../vendor/autoload.php';

use PhpAmqpLib\Message\AMQPMessage;

class ProcessVideoFileQueue
{
    public static function push(int $id): void
    {
        $client = new RabbitMqClient();
        $connection = $client->getConnection();
        $channel = $client->getChannel($connection);
        $client->publish(new AMQPMessage($id), $channel);
        $client->closeConnection($channel, $connection);
    }
}
