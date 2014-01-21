<?php

/**
 * BasemdMediaVimeoVideo
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $vimeo_url
 * @property string $title
 * @property string $src
 * @property string $duration
 * @property string $description
 * @property string $avatar
 * @property integer $avatar_width
 * @property integer $avatar_height
 * @property string $author_name
 * @property string $author_url
 * 
 * @method integer           getId()            Returns the current record's "id" value
 * @method string            getVimeoUrl()      Returns the current record's "vimeo_url" value
 * @method string            getTitle()         Returns the current record's "title" value
 * @method string            getSrc()           Returns the current record's "src" value
 * @method string            getDuration()      Returns the current record's "duration" value
 * @method string            getDescription()   Returns the current record's "description" value
 * @method string            getAvatar()        Returns the current record's "avatar" value
 * @method integer           getAvatarWidth()   Returns the current record's "avatar_width" value
 * @method integer           getAvatarHeight()  Returns the current record's "avatar_height" value
 * @method string            getAuthorName()    Returns the current record's "author_name" value
 * @method string            getAuthorUrl()     Returns the current record's "author_url" value
 * @method mdMediaVimeoVideo setId()            Sets the current record's "id" value
 * @method mdMediaVimeoVideo setVimeoUrl()      Sets the current record's "vimeo_url" value
 * @method mdMediaVimeoVideo setTitle()         Sets the current record's "title" value
 * @method mdMediaVimeoVideo setSrc()           Sets the current record's "src" value
 * @method mdMediaVimeoVideo setDuration()      Sets the current record's "duration" value
 * @method mdMediaVimeoVideo setDescription()   Sets the current record's "description" value
 * @method mdMediaVimeoVideo setAvatar()        Sets the current record's "avatar" value
 * @method mdMediaVimeoVideo setAvatarWidth()   Sets the current record's "avatar_width" value
 * @method mdMediaVimeoVideo setAvatarHeight()  Sets the current record's "avatar_height" value
 * @method mdMediaVimeoVideo setAuthorName()    Sets the current record's "author_name" value
 * @method mdMediaVimeoVideo setAuthorUrl()     Sets the current record's "author_url" value
 * 
 * @package    jardin
 * @subpackage model
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasemdMediaVimeoVideo extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('md_media_vimeo_video');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('vimeo_url', 'string', 64, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 64,
             ));
        $this->hasColumn('title', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('src', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('duration', 'string', 64, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 64,
             ));
        $this->hasColumn('description', 'string', 512, array(
             'type' => 'string',
             'length' => 512,
             ));
        $this->hasColumn('avatar', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('avatar_width', 'integer', 1, array(
             'type' => 'integer',
             'length' => 1,
             ));
        $this->hasColumn('avatar_height', 'integer', 1, array(
             'type' => 'integer',
             'length' => 1,
             ));
        $this->hasColumn('author_name', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('author_url', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $mdmediacontentbehavior0 = new mdMediaContentBehavior();
        $this->actAs($mdmediacontentbehavior0);
    }
}