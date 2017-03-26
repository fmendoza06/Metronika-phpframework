<?php
/*
 * Smarty plugin
 * --------------------------------------------------------------------
 * Type:     function
 * Name:     select_charset
 * Version:  1.0
 * Date:     Mayo 2, 2005
 * Author:	 SpyroFrameWork
 * Purpose:
 * Input:
 *
 * Examples : {select_charset name='char1'}
 *
 * --------------------------------------------------------------------
 */
function smarty_function_select_charset($params, &$smarty)
{
  extract($params);

  $result = '';

  $result .= '<select name="'.$name.'">';
      $result .= '<option value="utf-8"'.($_REQUEST[$name]=="utf-8"?" selected":"").'>UTF-8(Unicode)</option>';
      $result .= '<option value="iso-8859-1"'.($_REQUEST[$name]=="iso-8859-1"?" selected":"").'>Western(Latin1)</option>';
      $result .= '<option value="iso-8859-2"'.($_REQUEST[$name]=="iso-8859-2"?" selected":"").'>Central European(ISO-8859-2)</option>';	
      $result .= '<option value="windows-1252"'.($_REQUEST[$name]=="windows-1252"?" selected":"").'>Windows 1252</option>';
  $result .= '</select>';

  print $result;

}

?>