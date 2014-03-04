<?php

if($is_simple)
{

    include_partial('mdRelationContent/simpleContent', array('_MD_Content_Concrete_Owner' => $_MD_Content_Concrete_Owner, '_MD_Content_Configuration' => $_MD_Content_Configuration));

}
else
{

    include_partial('mdRelationContent/multipleContent', array('_MD_Content_Concrete_Owner' => $_MD_Content_Concrete_Owner, '_MD_Content_Configuration' => $_MD_Content_Configuration));

}

