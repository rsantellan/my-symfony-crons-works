<?php

/**
 * PluginmdMediaFile form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginmdMediaFileForm extends BasemdMediaFileForm
{
    public function setup()
    {
        parent::setup();
        
        unset ($this['filename'], $this['filetype'], $this['path']);

        $this->widgetSchema['description'] = new sfWidgetFormTextarea();
        $this->validatorSchema['description'] = new sfValidatorString(array('max_length' => 2048, 'required' => false));
    }
}
