<?php
/*
 * Smarty plugin
 * --------------------------------------------------------------------
 * Type:     function
 * Name:     ListComponents
 * Version:  1.0
 * Date:     Abril 29, 2005
 * Author:	 SpyroFrameWork
 * Purpose:
 * Input:
 *
 * Examples : {ListComponents check_all="true"}
 *
 * --------------------------------------------------------------------
 */
function smarty_function_ListComponents($params, &$smarty)
{
  extract($params);

      $result .= "<fieldset><legend> Components</legend>";
      $result .= '<br>';
	  $result .= '<table border="0">';
				  	
	  $result .= '<tr>';
	  $result .= '<td width="10%">';
				   
				 if(isset($_REQUEST["check_conf"])||$check_all=="true") 
	  				$result .= '<input name="check_conf" type="checkbox" value="1" checked>';
	  			 else
	  				$result .= '<input name="check_conf" type="checkbox" value="1">';	  			

	  $result .= '</td>';
	  $result .= '<td width="90%">Configuration</td>';
	  $result .= '</tr>';
				  	
	  $result .= '<tr>';
	  $result .= '<td>';
				    
				 if(isset($_REQUEST["check_tpls"])||$check_all=="true") 
				    $result .= '<input name="check_tpls" type="checkbox" value="1" checked>';
	  			 else
				    $result .= '<input name="check_tpls" type="checkbox" value="1">';
				    	  
	  $result .= '</td>';
	  $result .= '<td>Templates</td>';
	  $result .= '</tr>';
				  	
	  $result .= '<tr>';
	  $result .= '<td>';
				 if(isset($_REQUEST["check_cmds"])||$check_all=="true") 
				    $result .= '<input name="check_cmds" type="checkbox" value="1" checked>';
				 else
				    $result .= '<input name="check_cmds" type="checkbox" value="1">';				   
	  $result .= '</td>';
	  $result .= '<td>Commands</td>';
	  $result .= '</tr>';
				  	
	  $result .= '<tr>';
	  $result .= '<td>';
				 if(isset($_REQUEST["check_domain"])||$check_all=="true") 
				    $result .= '<input name="check_domain" type="checkbox" value="1" checked>';
			     else		    
				    $result .= '<input name="check_domain" type="checkbox" value="1">';
	  $result .= '</td>';
	  $result .= '<td>Managers</td>';
	  $result .= '</tr>';
				  	
	  $result .= '<tr>';
	  $result .= '<td>';
				 if(isset($_REQUEST["check_data"])||$check_all=="true") 
				    $result .= '<input name="check_data" type="checkbox" value="1" checked>';
	  			 else
				    $result .= '<input name="check_data" type="checkbox" value="1">';
	  $result .= '</td>';
	  $result .= '<td>Gateways</td>';
	  $result .= '</tr>';
	  
	  $result .= '</table>';
	  $result .= '<br>';

      $result .= "</fieldset>";

  print $result;

}

?>