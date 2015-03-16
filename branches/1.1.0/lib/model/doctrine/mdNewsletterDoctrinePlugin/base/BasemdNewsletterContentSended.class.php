<?php

/**
 * BasemdNewsletterContentSended
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $subject
 * @property blob $body
 * @property integer $send_counter
 * @property timestamp $sending_date
 * @property boolean $sended
 * @property integer $for_status
 * @property integer $md_newsletter_content_id
 * @property mdNewsletterContent $mdNewsletterContent
 * @property Doctrine_Collection $mdNewsletterSend
 * @property Doctrine_Collection $mdNewsLetterGroupSended
 * 
 * @method integer                   getId()                       Returns the current record's "id" value
 * @method string                    getSubject()                  Returns the current record's "subject" value
 * @method blob                      getBody()                     Returns the current record's "body" value
 * @method integer                   getSendCounter()              Returns the current record's "send_counter" value
 * @method timestamp                 getSendingDate()              Returns the current record's "sending_date" value
 * @method boolean                   getSended()                   Returns the current record's "sended" value
 * @method integer                   getForStatus()                Returns the current record's "for_status" value
 * @method integer                   getMdNewsletterContentId()    Returns the current record's "md_newsletter_content_id" value
 * @method mdNewsletterContent       getMdNewsletterContent()      Returns the current record's "mdNewsletterContent" value
 * @method Doctrine_Collection       getMdNewsletterSend()         Returns the current record's "mdNewsletterSend" collection
 * @method Doctrine_Collection       getMdNewsLetterGroupSended()  Returns the current record's "mdNewsLetterGroupSended" collection
 * @method mdNewsletterContentSended setId()                       Sets the current record's "id" value
 * @method mdNewsletterContentSended setSubject()                  Sets the current record's "subject" value
 * @method mdNewsletterContentSended setBody()                     Sets the current record's "body" value
 * @method mdNewsletterContentSended setSendCounter()              Sets the current record's "send_counter" value
 * @method mdNewsletterContentSended setSendingDate()              Sets the current record's "sending_date" value
 * @method mdNewsletterContentSended setSended()                   Sets the current record's "sended" value
 * @method mdNewsletterContentSended setForStatus()                Sets the current record's "for_status" value
 * @method mdNewsletterContentSended setMdNewsletterContentId()    Sets the current record's "md_newsletter_content_id" value
 * @method mdNewsletterContentSended setMdNewsletterContent()      Sets the current record's "mdNewsletterContent" value
 * @method mdNewsletterContentSended setMdNewsletterSend()         Sets the current record's "mdNewsletterSend" collection
 * @method mdNewsletterContentSended setMdNewsLetterGroupSended()  Sets the current record's "mdNewsLetterGroupSended" collection
 * 
 * @package    jardin
 * @subpackage model
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasemdNewsletterContentSended extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('md_newsletter_content_sended');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('subject', 'string', 256, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 256,
             ));
        $this->hasColumn('body', 'blob', null, array(
             'type' => 'blob',
             'notnull' => true,
             ));
        $this->hasColumn('send_counter', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('sending_date', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('sended', 'boolean', null, array(
             'type' => 'boolean',
             'default' => 0,
             ));
        $this->hasColumn('for_status', 'integer', 2, array(
             'type' => 'integer',
             'default' => 0,
             'length' => 2,
             ));
        $this->hasColumn('md_newsletter_content_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));

        $this->option('symfony', array(
             'filter' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('mdNewsletterContent', array(
             'local' => 'md_newsletter_content_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('mdNewsletterSend', array(
             'local' => 'id',
             'foreign' => 'md_newsletter_content_sended_id'));

        $this->hasMany('mdNewsLetterGroupSended', array(
             'local' => 'id',
             'foreign' => 'md_newsletter_contend_sended_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}