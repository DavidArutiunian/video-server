<?php

class Thumb extends BaseThumb
{
    private const UPLOADS_DIR = '/uploads/';
    private const PLACEHOLDER_URL = 'http://via.placeholder.com/640x360';


    public function getAbsoluteUrlToFile(): string
    {
        return Thumb::UPLOADS_DIR . $this->getDir() . DIRECTORY_SEPARATOR . $this->getFilename();
    }

    public static function getThumbUrl(sfOutputEscaperArrayDecorator $videoThumbs): string
    {
        $videoThumb = $videoThumbs->current();
        if ($videoThumb) {
            $thumb = ThumbPeer::retrieveByPK($videoThumb->getThumbId());
            if ($thumb) {
                return $thumb->getAbsoluteUrlToFile();
            } else {
                return Thumb::PLACEHOLDER_URL;
            }
        } else {
            return Thumb::PLACEHOLDER_URL;
        }
    }
}
