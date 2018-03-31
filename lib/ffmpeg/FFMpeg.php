<?php
/**
 * Created by PhpStorm.
 * User: DavidOS
 * Date: 15-Mar-18
 * Time: 5:05 PM
 */

require_once __DIR__ . '/IFFMpeg.php';

class FFMpeg implements IFFMpeg
{
    private $pathToFile;

    public function __construct(string $pathToFile)
    {
        $this->pathToFile = $pathToFile;
    }

    /**
     * @return float
     * @throws Error
     */
    public function getDuration(): float
    {
        $output = $this->getExec('ffprobe -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 ' . $this->pathToFile);
        $result = (float)array_pop($output);
        if (!$result) {
            throw new Error('FFMpeg getDuration() error');
        }
        return $result;
    }

    private function getExec(string $command): array
    {
        exec($command, $output);
        return $output;
    }

    /**
     * @return int
     * @throws Error
     */
    public function getSize(): int
    {
        $output = $this->getExec('ffprobe -v error -show_entries format=size -of default=noprint_wrappers=1:nokey=1 ' . $this->pathToFile);
        $result = (int)array_pop($output);
        if (!$result) {
            throw new Error('FFMpeg getSize() error');
        }
        return $result;
    }

    /**
     * @param VideoFile $videoFile
     * @throws Error
     * @throws PropelException
     */
    public function generateThumbs(VideoFile $videoFile): void
    {
        $dirName = pathinfo($this->pathToFile)['dirname'];
        $fileName = pathinfo($this->pathToFile)['filename'];
        $pathToThumb = $dirName . DIRECTORY_SEPARATOR . $fileName . '.png';
        $output = $this->getExec('ffmpeg -i ' . $this->pathToFile . ' -ss 00:00:00 -vframes 1 ' . $pathToThumb);
        $result = array_pop($output);
        if ($result) {
            throw new Error('FFMpeg generateThumbs() error: ' . $result);
        }
        $this->createThumbDocument($videoFile, $pathToThumb, $dirName);
    }

    /**
     * @param VideoFile $videoFile
     * @param string $pathToThumb
     * @param string $dirName
     * @throws PropelException
     */
    private function createThumbDocument(VideoFile $videoFile, string $pathToThumb, string $dirName): void
    {
        $thumb = new Thumb();
        $thumb->setFilename(basename($pathToThumb));
        $thumb->setDir(basename($dirName));
        $videoThumb = new VideoThumb();
        $videoThumb->setThumb($thumb);
        $videoThumb->setVideoFile($videoFile);
        $videoFile->addVideoThumb($videoThumb);
        $videoFile->save();
    }
}
