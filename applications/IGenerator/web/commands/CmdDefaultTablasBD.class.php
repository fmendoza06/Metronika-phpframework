<?php
/**
 * @package SpyroFrameWork
 * @subpackage Commands
 */
 
require_once "Web/WebRequest.class.php";
/**
 * Comando para invocar al template donde se seleccionan las tablas que se van a generar
 * @author SpyroFrameWork
 * @copyright Spyro Solutions
 */
class CmdDefaultTablasBD {

    function execute()
    {
	  extract($_REQUEST);

	  //valida que se seleccine por lo menos un componentes 
	  if(isset($check_conf)||isset($check_tpls)||isset($check_cmds)||isset($check_domain)||isset($check_data)){	

	       if(isset($check_conf))
			 $components["config"] = 1;  
		  		
		   if(isset($check_tpls))
			 $components["templates"] = 1;	   	  
	
		   if(isset($check_cmds))
	         $components["commands"] = 1;   
		  	
		   if(isset($check_domain))
	         $components["domain"] = 1;	  
	
		   if(isset($check_data))
	         $components["data"] = 1;  	   
	
	       //adiciona que componentes se van a generar a la session	       
	       WebSession::setProperty('components', $components);

		   //obtiene la info de la base de datos de la session
		   $type_db = WebSession::getProperty('type');
	       $server = WebSession::getProperty('host');
	       $user = WebSession::getProperty('user'); 
	       $password = WebSession::getProperty('pass');
	       $catalogo = WebSession::getProperty('db_name');
	       
	       //adiciona la info de la base de datos al request
	       WebRequest::setProperty('type', $type_db);
	       WebRequest::setProperty('host', $server);
	       WebRequest::setProperty('user', $user);
	       WebRequest::setProperty('pass', $password);
	       WebRequest::setProperty('db_name', $catalogo);
	
	       return "success";
	       
	  }else{
           WebRequest::setProperty('cod_message',$message = "Error: Debe Seleccionar por lo menos un componente");
           return "fail";	 
	  }     
    }
}
?>	
