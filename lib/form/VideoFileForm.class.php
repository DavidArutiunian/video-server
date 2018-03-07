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
    public function configure(): void
    {
        $this->useFields(array(
            'title',
            'type',
            'size',
            'filename',
            'description'
        ));

        $this->setWidgets(array(
            'title' => new sfWidgetFormInputText(array(), array(
                'autocomplete' => 'off'
            )),
            'description' => new sfWidgetFormTextarea(),
            'file' => new sfWidgetFormInputFile(),
        ));

        $this->setValidators(array(
            'title' => new sfValidatorString(array(
                'max_length' => VideoFile::getMaxTitleLength()
            )),
            'description' => new sfValidatorString(array(
                'max_length' => VideoFile::getMaxDescriptionLength()
            )),
            'file' => new sfValidatorFile(array(
                'path' => sfConfig::get('sf_upload_dir'),
                'mime_types' => VideoFile::getAllowedTypes(),
                'max_size' => VideoFile::getMaxSize(),
            ))
        ));
    }

    public function save($con = null)
    {
        try {
            $dirName = $this->saveFormFile();
            $this->setFormTypeField();
            $this->setFormFilenameField($dirName);
            return parent::save($con);
        } catch (sfValidatorError $e) {
            error_log($e->getMessage());
            return $this->getObject();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return $this->getObject();
        }
    }

    /**
     * @return string
     * @throws Exception
     */
    private function saveFormFile(): string
    {
        /**
         * @var sfValidatedFile $file
         */
        $file = $this->getValue('file');
        $dirName = uniqid('', true);
        mkdir(sfConfig::get('sf_upload_dir') . '/' . $dirName);
        $relativePathToFile = $dirName . '/' . $file->generateFilename();
        $pathToFile = sfConfig::get('sf_upload_dir') . '/' . $relativePathToFile;
        $file->save($pathToFile);
        return $dirName;
    }

    private function setFormTypeField(): void
    {
        /**
         * @var sfValidatedFile $file
         */
        $file = $this->getValue('file');
        $this->values['type'] = array_search($file->getType(), VideoFile::getAllowedTypes());
    }

    private function setFormFilenameField(string $dirName): void
    {
        /**
         * @var sfValidatedFile $file
         */
        $file = $this->getValue('file');
        $this->values['filename'] = $dirName . '/' . basename($file->getSavedName());
    }
}
