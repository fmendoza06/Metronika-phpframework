<?php
/**
 * @package SpyroFrameWork
 * @subpackage Commands
 */

require_once "Web/WebRequest.class.php";

/**
 * Comando para invocar al template donde se seleccionan los componentes a generar
 * @author SpyroFrameWork
 * @copyright Spyro Solutions
 */
class CmdDefaultComponentes {

    function execute()
    {
       extract($_REQUEST);
          	
       //adiciona la info del estilo a la session	       
       WebSession::setProperty('name_style', $name_style);

	   //Selecciona todos los check box por defecto
	   WebRequest::setProperty('checkall', $checkall = "true");

       return "success";
    }
}
?>	
