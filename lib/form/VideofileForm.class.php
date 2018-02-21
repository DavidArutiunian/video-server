<?php

/**
 * VideoFile form.
 *
 * @package    video-server
 * @subpackage form
 * @author     David Aruitunian
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class VideoFileForm extends BaseVideoFileForm
{
    static private $allowedTypes = array('video/mp4', 'video/mpeg', 'video/webm');

    static private $maxSize = 104857600;

    public function configure(): void
    {
        $this->useFields(array('title', 'description'));

        $this->setWidgets(array(
            'title' => new sfWidgetFormInputText(),
            'description' => new sfWidgetFormTextarea(),
            'file' => new sfWidgetFormInputFile(),
        ));

        $this->setValidators(array(
            'title' => new sfValidatorString(array('max_length' => 45)),
            'description' => new sfValidatorString(array('max_length' => 280)),
            'file' => new sfValidatorFile(array(
                'path' => sfConfig::get('sf_upload_dir') . './files',
                'mime_types' => VideoFileForm::$allowedTypes,
                'max_size' => VideoFileForm::$maxSize,
            ))
        ));
    }
}
