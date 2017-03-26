<?php
/**
 * @package SpyroFrameWork
 * @subpackage Commands
 */
require_once "Web/WebRequest.class.php";

/**
 * Comando para invocar al template donde se realiza la conexion a la base de datos
 * @author SpyroFrameWork
 * @copyright Spyro Solutions
 */
class CmdDefaultConexionBD {

    function execute()
    {
      extract($_REQUEST);

	  //valida que se halla seleccionado un directorio
      if(($dir_name != "") && ($dir_name != NULL)){
          WebSession::setProperty('dir_name', $dir_name);
          return "success";
      }else{
          WebRequest::setProperty('cod_message',$message = "Error: Debe seleccionar un directorio");
          return "fail";
      }
    }
}
?>	
