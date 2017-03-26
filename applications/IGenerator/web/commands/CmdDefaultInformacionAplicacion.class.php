<?php
/**
 * @package SpyroFrameWork
 * @subpackage Commands
 */

require_once "Web/WebRequest.class.php";
/**
 * Comando para invocar al template donde se suministra la infomacion de la aplicacion que se va a generar
 * @author SpyroFrameWork
 * @copyright Spyro Solutions
 */
class CmdDefaultInformacionAplicacion {

    function execute()
    {
        extract($_REQUEST);
        
        //valida que el serviror no esta vacio
        if(($server != NULL) && ($server != "")){
		
            $conexion_manager = Application::getDomainController('ConexionManager');
            $state = $conexion_manager->conexionDb($type_db,$server,$user,$password,$message);
 
            WebRequest::setProperty('cod_message', $message);
            
            // valida que la conexion alla sido exitosa  
            //$state=1;  
            if($state == 1){


               //adiciona la info a la session	
               WebSession::setProperty('type', $type_db);
               WebSession::setProperty('host', $server);
               WebSession::setProperty('user', $user);
               WebSession::setProperty('pass', $password);
               //adiciona la info al request
               WebRequest::setProperty('type', $type_db);
               WebRequest::setProperty('host', $server);
               WebRequest::setProperty('user', $user);
               WebRequest::setProperty('pass', $password);

	       return "success";
            }else{  
               return "fail";}
        }else{
            WebRequest::setProperty('cod_message',$message = "Error: Debe escribir el nombre del Server");
            return "fail";
        }

    }
}

?>	
