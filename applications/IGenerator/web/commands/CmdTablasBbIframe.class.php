<?php

require_once "Web/WebRequest.class.php";

class CmdTablasBbIframe {

    function execute()
    {
       extract($_REQUEST);

       WebRequest::setProperty('type', $type_db);
       WebRequest::setProperty('host', $server);
       WebRequest::setProperty('user', $user);
       WebRequest::setProperty('pass', $password);
       WebRequest::setProperty('db_name', $catalogo);
       WebRequest::setProperty('service_name', $service_name);
       WebRequest::setProperty('port', $port);
       
       return "success";
    }
}

?>	
