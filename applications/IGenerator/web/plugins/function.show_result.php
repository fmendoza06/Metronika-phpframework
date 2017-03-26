<?php

/*
 * Smarty plugin
 * --------------------------------------------------------------------
 * Type:     function
 * Name:     show_list_result
 * Version:  1.0
 * Date:     Apr 27, 2004
 * Author:	 SpyroFrameWork
 * Purpose:
 * Input:
 *            value
 *
 * Examples : {show_result value=$text_result}
 *
 *
 * --------------------------------------------------------------------
 */
 
 
function smarty_function_show_result($params, &$smarty)
{
  extract($params);
  
  $html_result = "";

  $html_result .= "<textarea name='textarea' cols='70' rows='10' class='clase_area'>";
  $html_result .= $value;
  $html_result .= "</textarea>";

  print $html_result;
}

?>
