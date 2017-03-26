<?php
/**
 * Smarty plugin
 */
/**
 * Smarty {message} plugin
 * Type:     function<br>
 * Name:     message<br>
 * Purpose: imprime los mensajes de la retornados por la aplicacion<br>
 * Input:<br>
 *           id = codigo of message (required)
 * <br>
 * Examples:  {messagebox id="5"}
 *
 * @author   Spyro Solutions 
 * @version  1.0.0
 * @param array
 * @param Smarty
 * @return string
 * @copyright Spyro Solutions 
 */

function smarty_function_messagebox($params, &$smarty)
{

// NO BORRRAR !!!!!!!!!!!! 
//echo "++++++++++ Session ++++++++++++++";
//echo "<pre>"; print_r($_SESSION); echo "</pre>";
//echo "++++++++++ Request ++++++++++++++";
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";

 require Application::getLanguageDirectory().'/'.Application::getLanguage()."/Message.lan";


$lang=$Alerts;

extract($params);


$html_result = "";
if ($id > -1)
 {
    $html_result .= $lang[$id];
	/*
    $html= "<script language='JavaScript' >
               alert('".$id.' - '.$html_result."');
            </script>";
	*/
	//var t=nifty.randomInt(0,8),n=function(){return nifty.randomInt(0,5)<4?3e3:0}();
    $html= "<script language='JavaScript' >	
	   var t=1,n=function(){return nifty.randomInt(0,5)<4?3e3:0}();
	   $.niftyNoty
	   (
	     {type:k[t].type,
	      icon:k[t].icon,
		  title:function()
		  {
			 return n>0?'Autoclose Alert':'Sticky Alert Box'
		
	      }(),
		  message:'".$id." - ".$html_result.",
		  timer:n
	   
	     }
	   
	   )	
            </script>";	   
    print $html;
 }

}
?>

