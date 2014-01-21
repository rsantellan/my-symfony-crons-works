<?php

function render_relation_content($mdContentConcreteOwner, $configuration)
{
    try{        
        $relationManager = call_user_func_array(array($configuration['className'], 'renderRelation'), array($mdContentConcreteOwner, $configuration));
        if(!$relationManager)
        {
            throw new Exception('error', 1);
        }
        echo get_component($relationManager->module, $relationManager->component, $relationManager->parameters);
    }catch(Exception $e)
    {
        throw new Exception($e->getMessage() . ' - Debes implementar el metodo estatico renderRelation en la clase ' . $configuration['className'] . ' y programar el componenete correspondiente', 100);
    }
}