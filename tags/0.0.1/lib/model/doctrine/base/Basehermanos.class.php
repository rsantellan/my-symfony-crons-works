<?php

/**
 * Basehermanos
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $usuario_from
 * @property integer $usuario_to
 * @property usuario $userFrom
 * @property usuario $userTo
 * 
 * @method integer  getUsuarioFrom()  Returns the current record's "usuario_from" value
 * @method integer  getUsuarioTo()    Returns the current record's "usuario_to" value
 * @method usuario  getUserFrom()     Returns the current record's "userFrom" value
 * @method usuario  getUserTo()       Returns the current record's "userTo" value
 * @method hermanos setUsuarioFrom()  Sets the current record's "usuario_from" value
 * @method hermanos setUsuarioTo()    Sets the current record's "usuario_to" value
 * @method hermanos setUserFrom()     Sets the current record's "userFrom" value
 * @method hermanos setUserTo()       Sets the current record's "userTo" value
 * 
 * @package    jardin
 * @subpackage model
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Basehermanos extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('hermanos');
        $this->hasColumn('usuario_from', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('usuario_to', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('usuario as userFrom', array(
             'local' => 'usuario_from',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('usuario as userTo', array(
             'local' => 'usuario_to',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}