<?php

/**
 * BasemdMediaYoutubeVideo
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $src
 * @property string $code
 * @property string $duration
 * @property string $description
 * @property string $path
 * @property string $avatar
 * 
 * @method integer             getId()          Returns the current record's "id" value
 * @method string              getName()        Returns the current record's "name" value
 * @method string              getSrc()         Returns the current record's "src" value
 * @method string              getCode()        Returns the current record's "code" value
 * @method string              getDuration()    Returns the current record's "duration" value
 * @method string              getDescription() Returns the current record's "description" value
 * @method string              getPath()        Returns the current record's "path" value
 * @method string              getAvatar()      Returns the current record's "avatar" value
 * @method mdMediaYoutubeVideo setId()          Sets the current record's "id" value
 * @method mdMediaYoutubeVideo setName()        Sets the current record's "name" value
 * @method mdMediaYoutubeVideo setSrc()         Sets the current record's "src" value
 * @method mdMediaYoutubeVideo setCode()        Sets the current record's "code" value
 * @method mdMediaYoutubeVideo setDuration()    Sets the current record's "duration" value
 * @method mdMediaYoutubeVideo setDescription() Sets the current record's "description" value
 * @method mdMediaYoutubeVideo setPath()        Sets the current record's "path" value
 * @method mdMediaYoutubeVideo setAvatar()      Sets the current record's "avatar" value
 * 
 * @package    jardin
 * @subpackage model
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasemdMediaYoutubeVideo extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('md_media_youtube_video');
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
        $this->hasColumn('src', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('code', 'string', 64, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 64,
             ));
        $this->hasColumn('duration', 'string', 64, array(
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