<?php

/**
 * Videofile form.
 *
 * @package    video-server
 * @subpackage form
 * @author     David Aruitunian
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class VideoFileForm extends BaseVideoFileForm
{
    static public $types = array(
        'mp4' => 'mp4',
        'wav' => 'wav',
    );

    public function configure(): void
    {
        $this->useFields(array('type', 'title', 'description'));

        $this->setWidgets(array(
            'type' => new sfWidgetFormChoice(array(
                'choices' => VideoFileForm::$types,
                'expanded' => true,
            )),
            'title' => new sfWidgetFormInputText(),
            'description' => new sfWidgetFormTextarea(),
        ));

        $this->setValidators(array(
            'title' => new sfValidatorString(array('max_length' => 45)),
            'description' => new sfValidatorString(array('max_length' => 280)),
            'type' => new sfValidatorChoice(array('choices' => array_keys(VideoFileForm::$types))),
        ));
    }
}
