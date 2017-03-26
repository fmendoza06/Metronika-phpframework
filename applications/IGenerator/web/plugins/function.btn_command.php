<?php
/*
 * Smarty plugin
 * --------------------------------------------------------------------
 * Type:     function
 * Name:     btn_command
 * Version:  1.0
 * Date:     Oct 20, 2003
 * Author:	SpyroFrameWork
 * Purpose:
 * Input:
 *           name = name of btn_command (optional)
 *           id = id of btn_command (optional)
 *           type = define the type of the btn_command ('button'|'submit')(required)
 *           disabled = disable the btn_command (optional)
 *           onClick = To introduce code javascript (optional)
 *           value = define the label of the btn_command (optional)
 *           form_name = nombre de la forma que contiene el btn_command
 *                      (SI type = 'button' entonces form_name es requerido)
 *
 *
 * Examples : {btn_command type="button" form_name="frmPais" value="Modificar" name="CmdUpdatePais" onClick="alert('click al button');"}
 *            {btn_command type="submit" value="Adicionar" name="CmdAddPais" onClick="alert('click al submit');"}
 *
 *
 * --------------------------------------------------------------------
 */

function smarty_function_btn_command($params, &$smarty)
{
    extract($params);
    $html_result = '';
    $html_result .= "<input class=boton";

    if (isset($name)){
        $html_result .= " name='".$name."'";
    }
    if (isset($type)){
        $html_result .= " type='".$type."'";
    }
    if (isset($id)){
        $html_result .= " id='".$id."'";
    }
    if (isset($value)){
        $html_result .= " value='".$value."'";
    }
    if (isset($disabled)){
        $html_result .= " disabled='".$disabled."'";
    }

    $html_result .= " onClick=\"disableButtons();";
    
    if (isset($onClick)){
        $html_result .= $onClick;
    }
    
    if (($type == "Button")||($type == "button")){
        $html_result .= "action.value = '".$name."';".$form_name.".submit();";
    }

    if (($type == "Submit")||($type == "submit")){
        $html_result .= "action.value = '".$name."';";
    }

    //cierra la doble comilla del onClick
    $html_result .= "\"";

    $html_result .= ">";
    
    print $html_result;

}

?>
