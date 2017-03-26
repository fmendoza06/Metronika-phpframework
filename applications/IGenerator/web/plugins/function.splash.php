<?php
/**
 * Smarty plugin
 */
/**
 * Smarty {load_app} plugin
 * Type:     function<br>
 * Name:     load_app<br>
 * Purpose:  redireccionar a la aplicacion elegida
 * 
 *
 *<pre>
 * Examples: 
 *       {load_app}      
 *</pre>
 *
 * @author   Danny Rodriguez <dannymira@hotmail.com>
 * @version  1.0.0
 * @param array
 * @param Smarty
 * @return string  
 */

function smarty_function_splash($params, &$smarty)
{
   
   print "<meta http-equiv='refresh' content='3;url=\"index.php?action=CmdSelectDir\"'>";  

}

?>