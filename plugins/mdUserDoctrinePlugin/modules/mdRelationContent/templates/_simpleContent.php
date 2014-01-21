<?php

    // Utilizar un helper que me de el partial de cada tipo de contenido concreto a mostrar
    use_helper('mdRelationContent');

    render_relation_content($_MD_Content_Concrete_Owner, $_MD_Content_Configuration);

?>
