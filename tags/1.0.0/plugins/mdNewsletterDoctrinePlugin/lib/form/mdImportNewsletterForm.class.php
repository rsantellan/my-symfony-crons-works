<?php
class mdImportNewsletterForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
        'archivo'    => new sfWidgetFormInputFile()
    ));

    $this->setValidators(array(
        'archivo'    => new sfValidatorFile()
    ));

    $this->widgetSchema->setNameFormat('import_news_letter[%s]');

  }  
}
