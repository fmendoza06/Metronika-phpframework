<?php
/**
 * @package SpyroFrameWork
 * @subpackage Commands
 */

require_once "Web/WebRequest.class.php";

/**
 * Comando para volver al template donde se seleccionan los componentes a generar
 * @author SpyroFrameWork
 * @copyright Spyro Solutions 
 */
class CmdBackComponentes {

    function execute()
    {
		//obtiene la info de la session y la pone en el request
        $components = WebSession::getProperty('components');

	    if(isset($components["config"]))
		   $_REQUEST["check_conf"] = 1;  
		  		
		if(isset($components["templates"]))
		   $_REQUEST["check_tpls"] = 1;	   	  
	
		if(isset($components["commands"]))
	       $_REQUEST["check_cmds"] = 1;   
		  	
		if(isset($components["domain"]))
	       $_REQUEST["check_domain"] = 1;	  
	
		if(isset($components["data"]))
	       $_REQUEST["check_data"] = 1; 

       return "success";
    }
}

?>	
