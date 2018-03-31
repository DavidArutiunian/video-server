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
    private const ALLOWED_PROBE_FORMAT = array('size', 'duration');
    private const THUMB_EXT = '.png';

    private $pathToFile;

    public function __construct(string $pathToFile)
    {
        $this->pathToFile = $pathToFile;
    }

    /**
     * @return float
     * @throws Exception
     */
    public function getDuration(): float
    {
        $command = $this->getFFProbeCommandFormat('duration') . $this->pathToFile;
        $output = $this->getExec($command);
        $result = (float)array_pop($output);
        if (!$result) {
            throw new Exception('FFMpeg getDuration() error');
        }
        return $result;
    }

    /**
     * @param string $format
     * @return string
     * @throws Exception
     */
    private function getFFProbeCommandFormat(string $format): string
    {
        if (!in_array($format, FFMpeg::ALLOWED_PROBE_FORMAT)) {
            throw new Exception("Invalid format type");
        }
        return 'ffprobe -v error -show_entries format=' . $format . ' -of default=noprint_wrappers=1:nokey=1 ';
    }

    private function getFFMpegCommand(string $pathToFile, string $pathToThumb): string
    {
        return 'ffmpeg -i ' . $pathToFile . ' -ss 00:00:00 -vframes 1 ' . $pathToThumb;
    }

    private function getExec(string $command): array
    {
        exec($command, $output);
        return $output;
    }

    /**
     * @return int
     * @throws Exception
     */
    public function getSize(): int
    {
        $command = $this->getFFProbeCommandFormat('size') . $this->pathToFile;
        $output = $this->getExec($command);
        $result = (int)array_pop($output);
        if (!$result) {
            throw new Exception('FFMpeg getSize() error');
        }
        return $result;
    }

    /**
     * @param VideoFile $videoFile
     * @throws PropelException
     * @throws Exception
     */
    public function generateThumbs(VideoFile $videoFile): void
    {
        $pathInfo = pathinfo($this->pathToFile);
        $dirName = $pathInfo['dirname'];
        $fileName = $pathInfo['filename'];
        $pathToThumb = $dirName . DIRECTORY_SEPARATOR . $fileName . FFMpeg::THUMB_EXT;
        $output = $this->getExec($this->getFFMpegCommand($this->pathToFile, $pathToThumb));
        $result = array_pop($output);
        if ($result) {
            throw new Exception('FFMpeg generateThumbs() error: ' . $result);
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
