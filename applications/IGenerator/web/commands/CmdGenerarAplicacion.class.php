<?php

require_once "Web/WebRequest.class.php";

class CmdGenerarAplicacion {

    function execute()
    {
       extract($_REQUEST);  
       /*	   
        print_r("<pre>");
        print_r($_REQUEST);
        print_r("</pre>");
		*/
	   //si '$selected_tables' esta vacia es porque no se seleciono ninguna tabla
       if(($selected_tables != "") && ($selected_tables != NULL)){
       	
	      //obtiene la info de la session     	
     	  $dir_name = WebSession::getProperty('dir_name');
       	  $type_db = WebSession::getProperty('type');
       	  $server = WebSession::getProperty('host');
       	  $user = WebSession::getProperty('user'); 
          $password = WebSession::getProperty('pass');
          $catalogo = WebSession::getProperty('db_name');
	  $name_application = WebSession::getProperty('name_application');
	  $name_company = WebSession::getProperty('name_company');
	  $charset = WebSession::getProperty('charset');
	  $name_style = WebSession::getProperty('name_style');
       	  $components = WebSession::getProperty('components');
	  $tables = explode(",",$selected_tables);
          $gen_type= WebSession::getProperty('gen_type');
          $generador_manager = Application::getDomainController('GeneradorManager');
          $result = $generador_manager->generarAplicacion($dir_name,$type_db,$server,$user,$password,$catalogo,$name_application,$name_company,$charset,$name_style,$components,$tables,$gen_type);
          WebRequest::setProperty('text_result', $result);
          return "success";
       }else{

       	  $type_db = WebSession::getProperty('type');
       	  $server = WebSession::getProperty('host');
       	  $user = WebSession::getProperty('user'); 
          $password = WebSession::getProperty('pass');
          $catalogo = WebSession::getProperty('db_name');

          WebRequest::setProperty('type', $type_db);
          WebRequest::setProperty('host', $server);
          WebRequest::setProperty('db_name', $catalogo);
          WebRequest::setProperty('user', $user);
          WebRequest::setProperty('pass', $password);
          WebRequest::setProperty('cod_message',$message = "Error: Debe Seleccionar por lo menos una Tabla");
          return "fail";
       }
    }
}

?>