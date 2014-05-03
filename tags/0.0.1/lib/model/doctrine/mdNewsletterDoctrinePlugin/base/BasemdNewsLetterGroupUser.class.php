<?php

/**
 * BasemdNewsLetterGroupUser
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $md_newsletter_group_id
 * @property integer $md_newsletter_user_id
 * @property mdNewsLetterGroup $mdNewsLetterGroup
 * @property mdNewsLetterUser $mdNewsLetterUser
 * 
 * @method integer               getMdNewsletterGroupId()    Returns the current record's "md_newsletter_group_id" value
 * @method integer               getMdNewsletterUserId()     Returns the current record's "md_newsletter_user_id" value
 * @method mdNewsLetterGroup     getMdNewsLetterGroup()      Returns the current record's "mdNewsLetterGroup" value
 * @method mdNewsLetterUser      getMdNewsLetterUser()       Returns the current record's "mdNewsLetterUser" value
 * @method mdNewsLetterGroupUser setMdNewsletterGroupId()    Sets the current record's "md_newsletter_group_id" value
 * @method mdNewsLetterGroupUser setMdNewsletterUserId()     Sets the current record's "md_newsletter_user_id" value
 * @method mdNewsLetterGroupUser setMdNewsLetterGroup()      Sets the current record's "mdNewsLetterGroup" value
 * @method mdNewsLetterGroupUser setMdNewsLetterUser()       Sets the current record's "mdNewsLetterUser" value
 * 
 * @package    jardin
 * @subpackage model
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasemdNewsLetterGroupUser extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('md_news_letter_group_user');
        $this->hasColumn('md_newsletter_group_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('md_newsletter_user_id', 'integer', 4, array(
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

        $this->hasOne('mdNewsLetterUser', array(
             'local' => 'md_newsletter_user_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             ));
        $this->actAs($timestampable0);
    }
}