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
    private const ABSOLUTE_URL = 'http:/localhost/';

    public function configure(): void
    {
        $this->useFields(array(
                'title',
                'type',
                'size',
                'filename',
                'description')
        );

        $this->setWidgets(array(
            'title' => new sfWidgetFormInputText(array(), array('autocomplete' => 'off')),
            'description' => new sfWidgetFormTextarea(),
            'file' => new sfWidgetFormInputFile(),
        ));

        $this->setValidators(array(
            'title' => new sfValidatorString(array('max_length' => 45)),
            'description' => new sfValidatorString(array('max_length' => 280)),
            'file' => new sfValidatorFile(array(
                'path' => sfConfig::get('sf_upload_dir'),
                'mime_types' => VideoFileForm::ALLOWED_TYPES,
                'max_size' => VideoFileForm::MAX_SIZE,
            ))
        ));
    }

    public function save($con = null)
    {
        $this->saveFormFile();
        $this->setFormTypeField();
        $this->setFormFilenameField();
        try {
            return parent::save($con);
        } catch (sfValidatorError $e) {
            error_log($e->getMessage());
            return $this->getObject();
        }
    }

    private function saveFormFile()
    {
        /**
         * @var sfValidatedFile $file
         */
        $file = $this->getValue('file');
        try {
            $file->save(sfConfig::get('sf_upload_dir') . '\\' . $file->generateFilename());
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    private function setFormTypeField(): void
    {
        /**
         * @var sfValidatedFile $file
         */
        $file = $this->getValue('file');
        $this->values['type'] = array_search($type = $file->getType(), VideoFileForm::ALLOWED_TYPES);
    }

    private function setFormFilenameField(): void
    {
        /**
         * @var sfValidatedFile $file
         */
        $file = $this->getValue('file');
        $this->values['filename'] = basename($file->getSavedName());
    }

    public static function getMimeType(int $index): string
    {
        return VideoFileForm::ALLOWED_TYPES[$index];
    }

}
