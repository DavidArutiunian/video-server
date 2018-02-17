<?php

/**
 * Videofile filter form base class.
 *
 * @package    video-server
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseVideofileFormFilter extends BaseFormFilterPropel
{
    public function setup()
    {
        $this->setWidgets(array(
            'type' => new sfWidgetFormFilterInput(),
            'url' => new sfWidgetFormFilterInput(),
            'title' => new sfWidgetFormFilterInput(),
            'description' => new sfWidgetFormFilterInput(array('with_empty' => false)),
            'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
            'updated_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
        ));

        $this->setValidators(array(
            'type' => new sfValidatorPass(array('required' => false)),
            'url' => new sfValidatorPass(array('required' => false)),
            'title' => new sfValidatorPass(array('required' => false)),
            'description' => new sfValidatorPass(array('required' => false)),
            'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
            'updated_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
        ));

        $this->widgetSchema->setNameFormat('videofile_filters[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        parent::setup();
    }

    public function getModelName()
    {
        return 'Videofile';
    }

    public function getFields()
    {
        return array(
            'id' => 'Number',
            'type' => 'Text',
            'url' => 'Text',
            'title' => 'Text',
            'description' => 'Text',
            'created_at' => 'Date',
            'updated_at' => 'Date',
        );
    }
}
