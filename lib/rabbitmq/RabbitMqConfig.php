<?php
/**
 * Created by PhpStorm.
 * User: DavidOS
 * Date: 18-Mar-18
 * Time: 4:05 PM
 */

abstract class RabbitMqConfig
{
    /**
     * @var string $host
     */
    public $host;
    /**
     * @var int $port
     */
    public $port;
    /**
     * @var string $user
     */
    public $user;
    /**
     * @var string $password
     */
    public $password;
    /**
     * @var string $queue_name
     */
    public $queue_name;
    /**
     * @var array $args
     */
    public $args;
}
