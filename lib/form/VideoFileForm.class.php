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
    private const ALLOWED_TYPES = array(
        'video/mp4',
        'video/mpeg',
        'video/webm'
    );
    private const MAX_SIZE = 104857600; // 100 MB

    private $uploadPath;

    public function __construct($object = null, array $options = array(), $CSRFSecret = null)
    {
        try {
            parent::__construct($object, $options, $CSRFSecret);
        } catch (sfException $e) {
            error_log($e->getMessage());
        }
        $this->uploadPath = sfConfig::get('sf_upload_dir') . './files';
    }


    public function configure(): void
    {
        $this->useFields(array('title', 'description'));

        $this->setWidgets(array(
            'title' => new sfWidgetFormInputText(array(), array('autocomplete' => 'off')),
            'description' => new sfWidgetFormTextarea(),
            'file' => new sfWidgetFormInputFile(),
        ));

        $this->setValidators(array(
            'title' => new sfValidatorString(array('max_length' => 45)),
            'description' => new sfValidatorString(array('max_length' => 280)),
            'file' => new sfValidatorFile(array(
                'path' => $this->uploadPath,
                'mime_types' => VideoFileForm::ALLOWED_TYPES,
                'max_size' => VideoFileForm::MAX_SIZE,
            ))
        ));
    }


}
