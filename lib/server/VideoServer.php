<?php
/**
 * Created by PhpStorm.
 * User: DavidOS
 * Date: 04-Mar-18
 * Time: 4:33 PM
 */

require_once __DIR__ . '/IVideoServer.php';

class VideoServer implements IVideoServer
{
    private const PROTOCOL = 'http';
    private const PORT = '80';
    private const URL = 'localhost';

    public static function getAbsoluteUrl(): string
    {
        return VideoServer::PROTOCOL . ":/" . VideoServer::URL . ":" . VideoServer::PORT;
    }
}
