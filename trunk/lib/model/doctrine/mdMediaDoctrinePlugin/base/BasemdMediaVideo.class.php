<?php

/**
 * BasemdMediaVideo
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $filename
 * @property string $duration
 * @property string $type
 * @property string $description
 * @property string $path
 * @property string $avatar
 * 
 * @method integer      getId()          Returns the current record's "id" value
 * @method string       getName()        Returns the current record's "name" value
 * @method string       getFilename()    Returns the current record's "filename" value
 * @method string       getDuration()    Returns the current record's "duration" value
 * @method string       getType()        Returns the current record's "type" value
 * @method string       getDescription() Returns the current record's "description" value
 * @method string       getPath()        Returns the current record's "path" value
 * @method string       getAvatar()      Returns the current record's "avatar" value
 * @method mdMediaVideo setId()          Sets the current record's "id" value
 * @method mdMediaVideo setName()        Sets the current record's "name" value
 * @method mdMediaVideo setFilename()    Sets the current record's "filename" value
 * @method mdMediaVideo setDuration()    Sets the current record's "duration" value
 * @method mdMediaVideo setType()        Sets the current record's "type" value
 * @method mdMediaVideo setDescription() Sets the current record's "description" value
 * @method mdMediaVideo setPath()        Sets the current record's "path" value
 * @method mdMediaVideo setAvatar()      Sets the current record's "avatar" value
 * 
 * @package    jardin
 * @subpackage model
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasemdMediaVideo extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('md_media_video');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('name', 'string', 64, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 64,
             ));
        $this->hasColumn('filename', 'string', 64, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 64,
             ));
        $this->hasColumn('duration', 'string', 64, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 64,
             ));
        $this->hasColumn('type', 'string', 64, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 64,
             ));
        $this->hasColumn('description', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('path', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('avatar', 'string', 255, array(
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