<?php
/**
 * Created by PhpStorm.
 * User: DavidOS
 * Date: 14-Mar-18
 * Time: 11:42 AM
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/lib/rabbitmq/RabbitMqClient.php';
require_once __DIR__ . '/web/index.php';

$callback = function ($message) {
    $videoFile = getVideoFile($message->body);
    logVideoFile($videoFile);
    execFFmpeg($videoFile);
    setReadyState($videoFile);
};

$client = new RabbitMqClient();
$connection = $client->getConnection();
$channel = $client->getChannel($connection);
$client->consume($callback, $channel);

while (count($channel->callbacks)) {
    $channel->wait();
}

$client->closeConnection($channel, $connection);

function setReadyState(VideoFile $videoFile): void
{
    $videoFile->setState(array_search('ready', VideoFile::getStates()));
    try {
        $videoFile->save();
    } catch (PropelException $e) {
        error_log($e->getMessage());
    }
    return;
}

function logVideoFile(VideoFile $videoFile): void
{
    error_log('VideoFile to process: ' . $videoFile->getFilename());
    return;
}

function getVideoFile(int $id): VideoFile
{
    return VideoFilePeer::retrieveByPK($id);
}

function execFFmpeg(VideoFile $videoFile): void
{
    $relativePathToFile = $videoFile->getDir() . '/' . $videoFile->getFilename();
    $pathToFile = sfConfig::get('sf_upload_dir') . '/' . $relativePathToFile;
    exec('ffprobe -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 ' . realpath($pathToFile), $durationOutput);
    setDuration($videoFile, array_pop($durationOutput));
    exec('ffprobe -v error -show_entries format=size -of default=noprint_wrappers=1:nokey=1 ' . realpath($pathToFile), $sizeOutput);
    setSize($videoFile, array_pop($sizeOutput));
    generateThumbnails($videoFile, $pathToFile);
    return;
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

function generateThumbnails(VideoFile $videoFile, string $pathToFile): void
{
    $dirName = pathinfo($pathToFile)['dirname'];
    $fileName = pathinfo($pathToFile)['filename'];
    $pathToThumb = $dirName . '/' . $fileName . '.png';
    exec('ffmpeg -i ' . $pathToFile . ' -ss 00:00:00 -vframes 1 ' . $pathToThumb);
    $thumb = new Thumb();
    $thumb->setFilename(basename($pathToThumb));
    $thumb->setDir(basename($dirName));
    try {
        $thumb->save();
    } catch (PropelException $e) {
        error_log($e->getMessage());
    }
    $videoThumb = new VideoThumb();
    $videoThumb->setVideoFileId($videoFile->getId());
    $videoThumb->setThumbId($thumb->getId());
    try {
        $videoThumb->save();
    } catch (PropelException $e) {
        error_log($e->getMessage());
    }
    try {
        $videoFile->addVideoThumb($videoThumb);
        $videoFile->save();
    } catch (PropelException $e) {
        error_log($e->getMessage());
    }
    return;
}
