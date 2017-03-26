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
	/* */
    $html= "<script language='JavaScript' >
               alert('".$id.' - '.$html_result."');
            </script>";
			
    $html= '

<script>
                 alertify.success("'.$id.' - '.$html_result.'");
		     </script>	';		
	//var t=nifty.randomInt(0,8),n=function(){return nifty.randomInt(0,5)<4?3e3:0}();
/*	
    $html= "<script language='JavaScript' >

    
    // Grab your button (based on your posted html)
    $(document).load(function(){
		$('#demo-preview-alert-2').demo-preview-alert('show');

    });


            </script>";	
     	
	$html= "<script language='JavaScript' >
             $(document).onload(function(){
               $('#demo-alert-page')
                   // Set up the click event
                  .on('click', function(){ alert('you clicked #hellothere'); })
                  // Trigger the click event
                  .trigger('click');
            });			
            </script>";	
   	

	$html= "<script language='JavaScript' >
	         var prevAlert = $('.demo-preview-alert');
             prevAlert.show();			
            </script>";	
	 */
    print $html;
 }

}
?>


