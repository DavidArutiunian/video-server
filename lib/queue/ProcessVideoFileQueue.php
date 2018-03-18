<?php
/**
 * Created by PhpStorm.
 * User: DavidOS
 * Date: 13-Mar-18
 * Time: 7:14 PM
 */

require_once __DIR__ . '/IProcessVideoFileQueue.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use PhpAmqpLib\Message\AMQPMessage;

class ProcessVideoFileQueue implements IProcessVideoFileQueue
{
    public static function push(int $id): void
    {
        $client = new RabbitMqClient();
        $client->publish(new AMQPMessage($id));
        $client->closeConnection();
    }
}
