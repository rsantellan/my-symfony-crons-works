<?php

/**
 * BasemdNewsLetterGroupSended
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $md_newsletter_group_id
 * @property integer $md_newsletter_contend_sended_id
 * @property mdNewsLetterGroup $mdNewsLetterGroup
 * @property mdNewsletterContentSended $mdNewsletterContentSended
 * 
 * @method integer                   getMdNewsletterGroupId()             Returns the current record's "md_newsletter_group_id" value
 * @method integer                   getMdNewsletterContendSendedId()     Returns the current record's "md_newsletter_contend_sended_id" value
 * @method mdNewsLetterGroup         getMdNewsLetterGroup()               Returns the current record's "mdNewsLetterGroup" value
 * @method mdNewsletterContentSended getMdNewsletterContentSended()       Returns the current record's "mdNewsletterContentSended" value
 * @method mdNewsLetterGroupSended   setMdNewsletterGroupId()             Sets the current record's "md_newsletter_group_id" value
 * @method mdNewsLetterGroupSended   setMdNewsletterContendSendedId()     Sets the current record's "md_newsletter_contend_sended_id" value
 * @method mdNewsLetterGroupSended   setMdNewsLetterGroup()               Sets the current record's "mdNewsLetterGroup" value
 * @method mdNewsLetterGroupSended   setMdNewsletterContentSended()       Sets the current record's "mdNewsletterContentSended" value
 * 
 * @package    jardin
 * @subpackage model
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasemdNewsLetterGroupSended extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('md_news_letter_group_sended');
        $this->hasColumn('md_newsletter_group_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('md_newsletter_contend_sended_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));

        $this->option('symfony', array(
             'form' => false,
             'filter' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('mdNewsLetterGroup', array(
             'local' => 'md_newsletter_group_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('mdNewsletterContentSended', array(
             'local' => 'md_newsletter_contend_sended_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             ));
        $this->actAs($timestampable0);
    }
}