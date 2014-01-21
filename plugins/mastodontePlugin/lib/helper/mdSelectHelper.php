<?php

/**
 * Devuelve el select armado con las opciones que se le pasa
 *
 *
 * @param array $comboOpciones
 * @param array $form_attributes
 * @return String
 */
function select_combo($comboOpciones, $form_attributes){
    if(is_array($form_attributes)){
        $select = "<select";

        if(array_key_exists('id', $form_attributes)){
            $select .= " id='".$form_attributes['id']."'";
        }

        if(array_key_exists('name', $form_attributes)){
            
            $select .= " name='".$form_attributes['name']."'";
        }

        if(array_key_exists('class', $form_attributes)){
            $select .= " class='".$form_attributes['class']."'";
        }

        $select .= ">";
        
    } else {
        $select = "<select>";
    }

    foreach($comboOpciones as $key => $value):
        $select .= "<option value=\"$key\">$value</option>";
    endforeach;
    $select .= "</select>";

    return $select;
}