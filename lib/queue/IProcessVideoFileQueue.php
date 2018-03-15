<?php
/**
 * Created by PhpStorm.
 * User: DavidOS
 * Date: 15-Mar-18
 * Time: 5:35 PM
 */

interface IProcessVideoFileQueue
{
    public static function push(int $id): void;
}
