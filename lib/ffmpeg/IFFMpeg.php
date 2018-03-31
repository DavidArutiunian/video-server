<?php
/**
 * Created by PhpStorm.
 * User: DavidOS
 * Date: 15-Mar-18
 * Time: 5:34 PM
 */

interface IFFMpeg
{
    /**
     * @return float
     * @throws Exception
     */
    public function getDuration(): float;

    /**
     * @return int
     * @throws Exception
     */
    public function getSize(): int;

    /**
     * @param VideoFile $videoFile
     * @throws Exception
     * @throws PropelException
     */
    public function generateThumbs(VideoFile $videoFile): void;
}
