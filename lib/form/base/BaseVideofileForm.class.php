<?php

/**
 * Videofile form base class.
 *
 * @method Videofile getObject() Returns the current form's model object
 *
 * @package    video-server
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseVideofileForm extends BaseFormPropel
{
    public function setup()
    {
        $this->setWidgets(array(
            'id' => new sfWidgetFormInputHidden(),
            'type' => new sfWidgetFormInputText(),
            'url' => new sfWidgetFormInputText(),
            'title' => new sfWidgetFormInputText(),
            'description' => new sfWidgetFormTextarea(),
            'created_at' => new sfWidgetFormDateTime(),
            'updated_at' => new sfWidgetFormDateTime(),
        ));

        $this->setValidators(array(
            'id' => new sfValidatorPropelChoice(array('model' => 'Videofile', 'column' => 'id', 'required' => false)),
            'type' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
            'url' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
            'title' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
            'description' => new sfValidatorString(),
            'created_at' => new sfValidatorDateTime(array('required' => false)),
            'updated_at' => new sfValidatorDateTime(array('required' => false)),
        ));

        $this->widgetSchema->setNameFormat('videofile[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        parent::setup();
    }

    public function getModelName()
    {
        return 'Videofile';
    }


}
