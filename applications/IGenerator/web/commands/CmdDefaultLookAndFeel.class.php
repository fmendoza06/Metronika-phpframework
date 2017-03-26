<?php
/**
 * @package SpyroFrameWork
 * @subpackage Commands
 */
 
require_once "Web/WebRequest.class.php";
/**
 * Comando para invocar al template donde se selecciona el estilo
 * @author SpyroFrameWork
 * @copyright Spyro Solutions
 */
class CmdDefaultLookAndFeel {

    function execute()
    {

       extract($_REQUEST);

      
       if(($name_company != NULL) && ($name_company != "") && ($name_application != NULL) && ($name_application != "")){
           //valida que el directorio no exista
           if(!is_dir("../".$name_application)){ print_r("Entte<br>");
           	  //adiciona la info a la session	
              WebSession::setProperty('db_name', $catalogo);
              WebSession::setProperty('name_company', $name_company);
              WebSession::setProperty('name_application', $name_application);
              WebSession::setProperty('charset', $charset);
              WebSession::setProperty('gen_type', $gen_type);
              

              return "success";
           }else{

		      $type_db = WebSession::getProperty('type');
		      $server = WebSession::getProperty('host');
		      $user = WebSession::getProperty('user');
		      $password = WebSession::getProperty('pass');

		      WebRequest::setProperty('type', $type_db);
		      WebRequest::setProperty('host', $server);
		      WebRequest::setProperty('user', $user);
		      WebRequest::setProperty('pass', $password);

              WebRequest::setProperty('cod_message',$message = "Error: La Aplicacion ya existe!");
              return "fail";
           }
       }else{
	      	$type_db = WebSession::getProperty('type');
	   	$server = WebSession::getProperty('host');
	   	$user = WebSession::getProperty('user');
	      	$password = WebSession::getProperty('pass');

	      	WebRequest::setProperty('type', $type_db);
	        WebRequest::setProperty('host', $server);
	        WebRequest::setProperty('user', $user);
	        WebRequest::setProperty('pass', $password);

            WebRequest::setProperty('cod_message',$message = "Error: Los campos con (*) son obligatorios!");
            return "fail";
       }
    }
}

?>	
