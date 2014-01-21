<?php
 
class mdCountCacheBehavior extends Doctrine_Template
{

    protected $_options = array(
        'relations' => array()
    );

    public function setTableDefinition()
    {
        foreach ($this->_options['relations'] as $relation => $options)
        {
            // si no se dispone del nombre de la columna, se crea
            if (!isset($options['columnName']))
            {
                $this->_options['relations'][$relation]['columnName'] = 'num_'.Doctrine_Inflector::tableize($relation);
            }

            // añadir la columna al modelo relacionado
            $columnName = $this->_options['relations'][$relation]['columnName'];
            $relatedTable = $this->_table->getRelation($relation)->getTable();
            $this->_options['relations'][$relation]['className'] = $relatedTable->getOption('name');
            $relatedTable->setColumn($columnName, 'integer', null, array('default' => 0));
        }

        $this->addListener(new mdCountCacheBehaviorListener($this->_options));
    }

}
