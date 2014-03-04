<?php

require_once dirname(__FILE__).'/../lib/emailsGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/emailsGeneratorHelper.class.php';

/**
 * emails actions.
 *
 * @package    jardin
 * @subpackage emails
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class emailsActions extends autoEmailsActions
{
	public function executeTestNews($request){
		cronFunctions::sendNewsletters();
	}
}
