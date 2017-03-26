<?php
/**
 * @package SpyroFrameWork
 * @subpackage Commands
 */

require_once "Web/WebRequest.class.php";
/**
 * Comando volver al template donde se suministra la infomacion de la aplicacion que se va a generar
 * @author SpyroFrameWork
 * @copyright Spyro Solutions
 */
class CmdBackInformacionAplicacion {

    function execute()
    {
        extract($_REQUEST);

		//obtiene la info de la session y la pone en el request
        $catalogo = WebSession::getProperty('db_name');
	$name_application = WebSession::getProperty('name_application');
	$name_company = WebSession::getProperty('name_company');
	$charset = WebSession::getProperty('charset');
	$type_db = WebSession::getProperty('type');
        $server = WebSession::getProperty('host');
   	$user = WebSession::getProperty('user'); 
      	$password = WebSession::getProperty('pass');

        $_REQUEST['catalogo'] = $catalogo;
        $_REQUEST['name_company'] = $name_company;
        $_REQUEST['name_application'] = $name_application;
        $_REQUEST['charset'] = $charset;
        
        WebRequest::setProperty('type', $type_db);
        WebRequest::setProperty('host', $server);
        WebRequest::setProperty('user', $user);
        WebRequest::setProperty('pass', $password);
             
   	    return "success";
    }
}

?>	
