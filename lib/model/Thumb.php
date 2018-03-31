<?php

class Thumb extends BaseThumb
{
    private const UPLOADS_DIR = '/uploads/';


    public function getAbsoluteUrlToFile(): string
    {
        return Thumb::UPLOADS_DIR . $this->getDir() . DIRECTORY_SEPARATOR . $this->getFilename();
    }
}
