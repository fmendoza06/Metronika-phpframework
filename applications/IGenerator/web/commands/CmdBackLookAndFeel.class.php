<?php
/**
 * @package SpyroFrameWork
 * @subpackage Commands
 */
 
require_once "Web/WebRequest.class.php";
/**
 * Comando para volver al template donde se selecciona el estilo
 * @author SpyroFrameWork
 * @copyright Spyro Solutions
 */
class CmdBackLookAndFeel {

    function execute()
    {
       $style = WebSession::getProperty('name_style');
       $_REQUEST['name_style'] = $style;

       return "success";
    }
}

?>	
