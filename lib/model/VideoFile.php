<?php

class VideoFile extends BaseVideoFile
{
    private const ALLOWED_TYPES = array(
        EVideoFileTypes::MP4,
        EVideoFileTypes::MPEG,
        EVideoFileTypes::WEBM,
    );
    private const STATES = array(
        EVideoFileStates::PROCESSING,
        EVideoFileStates::READY,
        EVideoFileStates::ERROR,
    );
    private const MAX_SIZE = 104857600; // 100 MB
    private const UPLOADS_DIR = '/uploads/';
    private const MAX_TITLE_LENGTH = 45;
    private const MAX_DESCRIPTION_LENGTH = 280;

    public static function getStates(): array
    {
        return VideoFile::STATES;
    }

    public static function getMimeType(int $index): string
    {
        return VideoFile::ALLOWED_TYPES[$index];
    }

    public static function getAllowedTypes(): array
    {
        return VideoFile::ALLOWED_TYPES;
    }

    public static function getMaxSize(): int
    {
        return VideoFile::MAX_SIZE;
    }

    public static function getMaxDescriptionLength(): int
    {
        return VideoFile::MAX_DESCRIPTION_LENGTH;
    }

    public static function getMaxTitleLength(): int
    {
        return VideoFile::MAX_TITLE_LENGTH;
    }

    public function getAbsoluteUrlToFile(): string
    {
        return VideoFile::UPLOADS_DIR . $this->getDir() . '/' . $this->getFilename();
    }
}
