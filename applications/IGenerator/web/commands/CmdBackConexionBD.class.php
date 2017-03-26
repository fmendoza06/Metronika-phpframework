<?php
/**
 * @package SpyroFrameWork
 * @subpackage Commands
 */
require_once "Web/WebRequest.class.php";

/**
 * Comando para volver al template donde se realiza la conexion a la base de datos
 * @author SpyroFrameWork
 * @copyright SpyroSolutions
 */
class CmdBackConexionBD {

    function execute()
    {
 	//obtiene la info de la session y la pone en el request    	
	$_REQUEST['type_db'] = WebSession::getProperty('type');
        $_REQUEST['server'] = WebSession::getProperty('host');
   	$_REQUEST['user'] = WebSession::getProperty('user');
      	$_REQUEST['password'] = WebSession::getProperty('pass');

    	return "success";
    }
}
?>	
