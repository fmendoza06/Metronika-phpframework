<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     CopyDataHidden
 * Version:  1.0
 * Date:     Oct 17, 2003
 * Author:	 SpyroFrameWork
 * Purpose:  display calendar en other windows.
 * Input:
 *           name = name of the calendar (required)
 *           form_name = name of the form that content calendar (required)
 *           size = wide of textfield (optional)
 *           icon = file (and path) of image (optional)
 *
 * Examples:  {form name="Frm-fecha" method="post"}
 *
 *
 * Contraint: calendar needs to be within a form
 *            calendar needs library date-picker.js
 * -------------------------------------------------------------
 */

function smarty_function_CopyDataHidden($params, &$smarty)
{

extract($params);

$html_result = "";
$html_result .= "<script>
				 function actualizar(x) {
				    document.forms.".$form_name.".".$hidden_name.".value = x;
				 }
				</script>";

print $html_result;

}
?>




