<?php
require_once "Web/WebSession.class.php";

class WebRegistry
{
  
  	/**
	*	Copyright 2006 - Spyro Solutions
	*	
	*	Generate Log use Pear Log Library
	*	@author Spyro Solutions - Jose Fernando Mendoza
	*	@date 14-Dic-2006 10:43:34
	*	@location Cali-Colombia
	*/
    public static function setLog()
    {
        $log = Application::generatelog();
        if ($log){
            return $log;
        }
    }
    public static function getWebCommand() {

        // set the action name
        $action_name = isset($_REQUEST["action"]) ?
            $_REQUEST["action"]:
            WebRegistry::getDefaultAction();

        //Se hace la valicion de permisos
		
        $security = Application::validateProfiles($action_name);

        //valida si el perfil tiene permiso para ejecutar la accion
		
        if($security == false){
           //obtiene el comando para los errores
           $action_name = WebRegistry::getErrorView();

  	     }
		 
        //Valido si la session aun esta activa
		
		$exception_validate_commnads = array("default",
		              "oiCmdDefaultLogin",
					  "oiCmdLogin",
					  "oiCmdDefaultLogout",
					  "oiCmdChangePassword",
					  "oiCmdDefaultError",
					  "oiCmdDefaultRemember",
					  "oiCmdRemember");
					  
		if (!WebSession::issetPropertyAuth("indentify") && 
		    (!in_array($action_name, $exception_validate_commnads))
		   ) 
		{  		   
           $action_name = WebRegistry::getErrorView();
		   //print_r($action_name);
        }
        
        // get the command class name
        $action_class_name = WebRegistry::getCommandClassName($action_name);
		//print_r($action_class_name);
        // get the command object
        $filename = Application::getCommandsDirectory(). '/'
            . $action_class_name . '.class.php';
        //print_r($filename);
			@include $filename;
        
        if (!class_exists($action_class_name)) {
            return @PEAR::raiseError($action_name. ': Command not found');
        } else {
          
            /**
	    *	Copyright 2006 - Spyro Solutions
	    *
	    *	Valid if generated Log Auth
	    *	@author Spyro Solutions
	    *	@date 14-Dic-2006 10:43:34
	    *	@location Cali-Colombia
	    */

            if (Application::getlog()!="Nothing")
                 WebRegistry::setLog();

            return new $action_class_name();
        }
    }
    
    public static function getWebCommandView($view_name) {

        // set the action name
        $action_name = isset($_REQUEST["action"]) ?
            $_REQUEST["action"]:
            WebRegistry::getDefaultAction();


        //Se hace la valicion de permisos
        $security = Application::validateProfiles($action_name);

        //valida si el perfil tiene permiso para ejecutar la accion
        if($security == false){
           //obtiene el comando para los errores
           $action_name = WebRegistry::getErrorView();
  	    }

        
		
        //Valido si la session aun esta activa
		
		$exception_validate_commnads = array("default",
		              "oiCmdDefaultLogin",
					  "oiCmdLogin",
					  "oiCmdDefaultLogout",
					  "oiCmdChangePassword",
					  "oiCmdDefaultError",
					  "oiCmdDefaultRemember",
					  "oiCmdRemember");
					  
		if (!WebSession::issetPropertyAuth("indentify") && 
		    (!in_array($action_name, $exception_validate_commnads))
		   ) 
		{  		   
           $action_name = WebRegistry::getErrorView();
		   //print_r($action_name);
        }

	    //// get the view name
        $action_class_name = WebRegistry::getViewName($action_name, $view_name);

        return $action_class_name;

    }
    
    public static function getDefaultAction() {
        return WebRegistry::__getVar('default_action');
    }

    public static function getErrorView() {
        return WebRegistry::__getVar('error_view');
    }
    
    public static function getLoginView() {
        return WebRegistry::__getVar('login_view');
    }
    
    public static function getCommandClassName($action) {
	
        // get the configuration array
        $config = WebRegistry::getConfig();
        // an error ??
        if (@PEAR::isError($config)) {
            return $config;
        } 
        return $config['commands'][$action]['class'];
    }
    
    public static function getViewName($action, $view) {

        // get the configuration array
        $config = WebRegistry::getConfig();

        // an error ??
        if (@PEAR::isError($config)) {
            return $config;
        }

        return $config['commands'][$action]['views'][$view]['view'];
    }
    
    public static function getWebView($view) {
        
        // get the configuration array
        $config = WebRegistry::getConfig();

       // an error ??
        if (@PEAR::isError($config)) {

            return $config;
            
        }
        // there is a class defined for that view ??
        if (isset($config['views'][$view]['class'])) {

            return $config['views'][$view]['class'];
   

        // there is a template for that view ??
        } else if (isset($config['views'][$view]['template'])) {
            include 'Web/TemplateView.class.php';
            return new TemplateView($config['views'][$view]['template']);
            
        // there is a xsl for that view ??
        } else if (isset($config['views'][$view]['xsl'])) {
            include 'Web/XslTransformView.class.php';

            return new XslTransformView($config['views'][$view]['xsl']);
        }
    }
    
    public static function &__getVar($nom_var) {

        // get the configuration array
        $config = WebRegistry::getConfig();

        // an error ??
        if (@PEAR::isError($config)) {
            return $config;
        }

        // return the variable
        return $config[$nom_var];
    }

    public static function __setVar($name="", &$objVar) {
        $obj =	 &ASAP::getStaticProperty('Web', 'config');
        $obj[$name] = $objVar;
    }

    public static function getConfig() {
        $config = ASAP::getStaticProperty('Web','config');
        // if configuration data is not set
        if (!isset($config)) {
            // load the configuration data
            $config = Serializer::load(Application::getBaseDirectory().'/config/web.conf.data');
			//print_r(Application::getBaseDirectory().'/config/web.conf.data');
        }
        if (!is_array($config)) {
            return @PEAR::raiseError('cannot load the configuration file');
        }
        return $config;
    }

}

?>
