<?php
/**
 * Created by PhpStorm.
 * User: DavidOS
 * Date: 04-Mar-18
 * Time: 4:33 PM
 */

class VideoServer
{
    private const PROTOCOL = 'http';
    private const PORT = '80';
    private const URL = 'localhost';

    public static function getAbsoluteUrl(): string
    {
        return VideoServer::PROTOCOL . ":/" . VideoServer::URL . ":" . VideoServer::PORT;
    }
}
