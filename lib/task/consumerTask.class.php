<?php

require_once __DIR__ . '/../rabbitmq/RabbitMqClient.php';
require_once __DIR__ . '/../ffmpeg/FFMpeg.php';

class consumerTask extends sfBaseTask
{
    /**
     * @var Closure $callback
     */
    private $callback;

    protected function configure()
    {
        try {
            $this->addOptions(array(
                new sfCommandOption(
                    'connection',
                    null, sfCommandOption::PARAMETER_REQUIRED,
                    'The connection name',
                    'propel'
                ),
            ));
        } catch (sfCommandException $e) {
            error_log($e->getMessage());
        }
        $this->name = 'consumer';
        $this->briefDescription = 'Runs RabbitMQ consumer task';
    }

    protected function execute($arguments = array(), $options = array())
    {
        $databaseManager = new sfDatabaseManager($this->configuration);
        try {
            $name = $options['connection'] ? $options['connection'] : null;
            $databaseManager->getDatabase($name)->getConnection();
        } catch (sfDatabaseException $e) {
            error_log($e->getMessage());
        }
        $this->setCallback();
        $client = new RabbitMqClient();
        $client->consume($this->callback);
        while ($client->getCallbackCount()) {
            echo 'Consuming ' . $client->getCallbackCount() . ' messages...', PHP_EOL;
            $client->wait();
        }
        echo 'Closing connection...', PHP_EOL;
        $client->closeConnection();
    }

    private function setCallback(): void
    {
        $this->callback = function ($message) {
            $videoFile = $this->getVideoFile($message->body);
            $this->execFFMpeg($videoFile);
            $this->setVideoState($videoFile, EVideoFileStates::READY);
        };
    }

    private function execFFMpeg(VideoFile $videoFile): void
    {
        $relativePathToFile = $videoFile->getDir() . '/' . $videoFile->getFilename();
        $pathToFile = sfConfig::get('sf_upload_dir') . '/' . $relativePathToFile;
        /**
         * @var IFFMpeg $ffmpeg
         */
        $ffmpeg = new FFMpeg($pathToFile);
        try {
            $duration = $ffmpeg->getDuration();
            $this->setDuration($videoFile, $duration);
            $size = $ffmpeg->getSize();
            $this->setSize($videoFile, $size);
            $ffmpeg->generateThumbs($videoFile);
        } catch (Error $e) {
            $this->onError($videoFile);
            error_log($e->getMessage());
        } catch (PropelException $e) {
            $this->onError($videoFile);
            error_log($e->getMessage());
        }
        return;
    }

    private function setVideoState(VideoFile $videoFile, string $state = EVideoFileStates::READY): void
    {
        $videoFile->setState(array_search($state, VideoFile::getStates()));
        try {
            $videoFile->save();
        } catch (PropelException $e) {
            $this->onError($videoFile);
            error_log($e->getMessage());
        }
        return;
    }

    private function getVideoFile(int $id): VideoFile
    {
        return VideoFilePeer::retrieveByPK($id);
    }

    private function setDuration(VideoFile $videoFile, float $duration): void
    {
        $videoFile->setDuration($duration);
        try {
            $videoFile->save();
        } catch (PropelException $e) {
            $this->onError($videoFile);
            error_log($e->getMessage());
        }
        return;
    }

    private function setSize(VideoFile $videoFile, int $size): void
    {
        $videoFile->setSize($size);
        try {
            $videoFile->save();
        } catch (PropelException $e) {
            $this->onError($videoFile);
            error_log($e->getMessage());
        }
        return;
    }

    private function onError(VideoFile $videoFile): void
    {
        $this->setVideoState($videoFile, EVideoFileStates::ERROR);
        return;
    }
}
