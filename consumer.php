<?php
/**
 * Created by PhpStorm.
 * User: DavidOS
 * Date: 14-Mar-18
 * Time: 11:42 AM
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/lib/rabbitmq/RabbitMqClient.php';
require_once __DIR__ . '/lib/ffmpeg/FFMpeg.php';
require_once __DIR__ . '/web/index.php';

$callback = function ($message) {
    $videoFile = getVideoFile($message->body);
    execFFMpeg($videoFile);
    setReadyState($videoFile);
};

/**
 * @var IRabbitMqClient $client
 */
$client = new RabbitMqClient();
$client->consume($callback);

while ($client->getCallbackCount()) {
    $client->wait();
}

$client->closeConnection();

function execFFMpeg(VideoFile $videoFile): void
{
    $relativePathToFile = $videoFile->getDir() . '/' . $videoFile->getFilename();
    $pathToFile = sfConfig::get('sf_upload_dir') . '/' . $relativePathToFile;
    /**
     * @var IFFMpeg $ffmpeg
     */
    $ffmpeg = new FFMpeg($pathToFile);
    try {
        $duration = $ffmpeg->getDuration();
        setDuration($videoFile, $duration);
        $size = $ffmpeg->getSize();
        setSize($videoFile, $size);
        $ffmpeg->generateThumbs($videoFile);
    } catch (Error $e) {
        error_log($e->getMessage());
    }
    return;
}

function setReadyState(VideoFile $videoFile): void
{
    $videoFile->setState(array_search(EVideoFileStates::READY, VideoFile::getStates()));
    try {
        $videoFile->save();
    } catch (PropelException $e) {
        error_log($e->getMessage());
    }
    return;
}

function getVideoFile(int $id): VideoFile
{
    return VideoFilePeer::retrieveByPK($id);
}

function setDuration(VideoFile $videoFile, float $duration): void
{
    $videoFile->setDuration($duration);
    try {
        $videoFile->save();
    } catch (PropelException $e) {
        error_log($e->getMessage());
    }
    return;
}

function setSize(VideoFile $videoFile, int $size): void
{
    $videoFile->setSize($size);
    try {
        $videoFile->save();
    } catch (PropelException $e) {
        error_log($e->getMessage());
    }
    return;
}
