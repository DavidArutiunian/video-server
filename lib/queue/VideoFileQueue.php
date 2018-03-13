<?php
/**
 * Created by PhpStorm.
 * User: DavidOS
 * Date: 13-Mar-18
 * Time: 7:14 PM
 */

require_once __DIR__ . '\../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class VideoFileQueue
{
    private const HOST = 'localhost';
    private const PORT = 5672;
    private const USER = 'guest';
    private const PASSWORD = 'guest';
    private const QUEUE_NAME = 'video_file';
    private const TIME_TO_SLEEP = 5;

    public static function receive()
    {
        $connection = new AMQPStreamConnection(
            VideoFileQueue::HOST,
            VideoFileQueue::PORT,
            VideoFileQueue::USER,
            VideoFileQueue::PASSWORD
        );
        $channel = $connection->channel();
        $channel->queue_declare(
            VideoFileQueue::QUEUE_NAME,
            false,
            false,
            false,
            false
        );

        $callback = function ($message) {
            sleep(VideoFileQueue::TIME_TO_SLEEP);
            error_log("ID to process: " . $message->body);
        };

        $channel->basic_consume(
            VideoFileQueue::QUEUE_NAME,
            '',
            false,
            true,
            false,
            false,
            $callback
        );

        while (count($channel->callbacks)) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }

    /**
     * @param int $id
     */
    public static function send(int $id)
    {
        $connection = new AMQPStreamConnection(
            VideoFileQueue::HOST,
            VideoFileQueue::PORT,
            VideoFileQueue::USER,
            VideoFileQueue::PASSWORD
        );
        $channel = $connection->channel();
        $channel->queue_declare(
            VideoFileQueue::QUEUE_NAME,
            false,
            false,
            false,
            false
        );

        $message = new AMQPMessage($id);
        $channel->basic_publish($message, '', VideoFileQueue::QUEUE_NAME);
        $channel->close();
        $connection->close();

        VideoFileQueue::receive();
    }
}
