<?php
/*
 * Smarty plugin
 * --------------------------------------------------------------------
 * Type:     function
 * Name:     ListStyles
 * Version:  1.0
 * Date:     Dic 6, 2004
 * Author:	 SpyroFrameWork
 * Purpose:
 * Input:
 *
 * Examples : {ListStyles }
 *
 *
 * --------------------------------------------------------------------
 */
function smarty_function_ListStyles($params, &$smarty)
{
  extract($params);

  $result =  '';
  $result .= '<fieldset><legend>Look And Feel</legend>';
  $result .= '<br>';
  $result .= '<table  border="0">
              <tr>
                 <td><input name="'.$name.'" type="radio" value="" '.($_REQUEST[$name]==""||!isset($_REQUEST[$name])?"checked":"").'></td>
                 <td>Blank (No Style)</td>
              </tr>
              <tr>
                 <td><input name="'.$name.'" type="radio" value="Spyro" '.($_REQUEST[$name]=="Spyro"?"checked":"").'></td>
                 <td>Spyro Standard</td>
              </tr>
              </table>';
    $result .= '<br>';
    $result .= '<br>';
    $result .= '<br>';
    $result .= '<br>';
    $result .= '<br>';
    $result .= '<br>';
    $result .= "</fieldset>";

  print $result;

}

?>
