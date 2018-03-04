<?php

class VideoFile extends BaseVideoFile
{
    private const ALLOWED_TYPES = array(
        'video/mp4',
        'video/mpeg',
        'video/webm'
    );
    private const MAX_SIZE = 104857600; // 100 MB
    private const UPLOADS_DIR = '/uploads/';
    private const MAX_TITLE_LENGTH = 45;
    private const MAX_DESCRIPTION_LENGTH = 280;

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
        return VideoServer::getAbsoluteUrl() . VideoFile::UPLOADS_DIR . $this->getFilename();
    }
}