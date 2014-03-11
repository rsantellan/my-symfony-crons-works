<?php
 
class mdCountCacheBehaviorListener extends Doctrine_Record_Listener
{

    protected $_options;

    public function __construct(array $options)
    {
        $this->_options = $options;
    }

    public function postInsert(Doctrine_Event $event)
    {
        $invoker = $event->getInvoker();
        foreach ($this->_options['relations'] as $relation => $options)
        {
            $table = Doctrine::getTable($options['className']);
            $relation = $table->getRelation($options['foreignAlias']);

            $table->createQuery()
                ->update()
                ->set($options['columnName'], $options['columnName'].' + 1')
                ->where($relation['local'].' = ?', $invoker->$relation['foreign'])
                ->execute();
        }
    }

    public function preDelete(Doctrine_Event $event)
    {
        $invoker = $event->getInvoker();
        foreach ($this->_options['relations'] as $relation => $options)
        {
            $table = Doctrine::getTable($options['className']);
            $relation = $table->getRelation($options['foreignAlias']);

            $table->createQuery()
                ->update()
                ->set($options['columnName'], $options['columnName'].' - 1')
                ->where($relation['local'].' = ?', $invoker->$relation['foreign'])
                ->execute();
        }
    }

    /**
     * Se encarga de los borrados masivos realizados con una consulta de tipo DQL.
     *
     * Para invocar el método preDqlDelete() es necesario activar un atributo.
     * El motivo es que los callbacks de DQL están desactivados por defecto porque penalizan ligeramente el rendimiento.
     * Por tanto, para utilizarlos es necesario activarlos: $manager->setAttribute(Doctrine_Core::ATTR_USE_DQL_CALLBACKS, true);
     * 
     * @param Doctrine_Event $event
     */
    public function preDqlDelete(Doctrine_Event $event)
    {
        foreach ($this->_options['relations'] as $relation => $options)
        {
            $table = Doctrine::getTable($options['className']);
            $relation = $table->getRelation($options['foreignAlias']);

            $q = clone $event->getQuery();
            $q->select($relation['foreign']);
            $ids = $q->execute(array(), Doctrine::HYDRATE_NONE);

            foreach ($ids as $id)
            {
                $id = $id[0];

                $table->createQuery()
                    ->update()
                    ->set($options['columnName'], $options['columnName'].' - 1')
                    ->where($relation['local'].' = ?', $id)
                    ->execute();
            }
        }
    }

}
