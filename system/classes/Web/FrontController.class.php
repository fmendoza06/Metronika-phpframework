<?php

require_once "Web/WebRegistry.class.php";
require_once "Web/WebSession.class.php";

set_time_limit(0);

class FrontController {

    public static function execute() {
        
        WebSession::checkSession(1800); //30 minutos
        $command =WebRegistry::getWebCommand();
            
        if (@PEAR::isError($command)) {
            echo "command not found :".$_REQUEST["action"];
        }

        $result = $command->execute();
        if (@PEAR::isError($result)) {
            echo $result->getMessage();
        } else {
            
            $view_name = WebRegistry::getWebCommandView($result);
            if (@PEAR::isError($view_name)) 
			{
                echo $view_name->getMessage();
                
            } else 
			{
                $view = WebRegistry::getWebView($view_name);
                
                if (@PEAR::isError($view))
				{
                    echo $view->getMessage();
                } 
				else 
				{
                    WebRequest::setProperty("template",Application::getTemplate());
										
                    $view->show();
                }
            }
        }

    }

}

?>

