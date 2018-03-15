<?php
/**
 * Created by PhpStorm.
 * User: DavidOS
 * Date: 15-Mar-18
 * Time: 5:33 PM
 */

use PhpAmqpLib\Message\AMQPMessage;

interface IRabbitMqClient
{
    public function consume(Closure $callback): void;

    public function getCallbackCount(): int;

    public function publish(AMQPMessage $message): void;

    public function wait(): void;

    public function closeConnection(): void;
}
