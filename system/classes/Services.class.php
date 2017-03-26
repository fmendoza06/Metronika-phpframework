<?php

/**
	Copyright Spyro Solutions
	
	This class invoke services
	@author Spyro Solutions
	@date 08-dic-2006 10:21:44
	@location Cali-Colombia
*/


global $saveconfiguration;

if ($saveconfiguration != "S")
{
  if ($saveconfiguration == "J")
  {
    require_once "../../../../lib/PEAR/PEAR.php";
    require_once "ASAP.class.php";
    require_once "Data/Serializer.class.php";
  }
  else {     //Es "N"
        require_once "./../../lib/PEAR/PEAR.php";
        require_once "ASAP.class.php";
        require_once "Data/Serializer.class.php";
  }
}
else       // Es "S"
{
    require_once "../../../lib/PEAR/PEAR.php";
    require_once "ASAP.class.php";
    require_once "Data/Serializer.class.php";

}

class Services {

   /**
   * Service.
   */
   var $service;
   var $servicesname;
    function Services($servicename) {

        // initialize the static variables
        Services :: loadService($servicename);
        $this->servicesname=$servicename;
    }


    function getBaseDirectory() {
        return Services::__getVar('base_dir');
    }

    function &__getVar($nom_var) {

        $config = &ASAP::getStaticProperty('Application','config');
        
        // if configuration data is not set
        if (!isset($config)) {
            // load the configuration data
            // filename = <ASAP-dir>/applications/config/application.conf.data
            // @@ use the URL/directory
            $config = &Services::__loadConfig(dirname(__FILE__));
        }
        if (!is_array($config)) {
            return PEAR::raiseError('cannot load the configuration file');
        }
        return $config[$nom_var];
    }
    


	function & __loadConfig($dir_name = "", $flag = false) {
		$config = & ASAP :: getStaticProperty('Application', 'config');
		// if configuration data is not set
		if ($flag == false) {
			if (!isset ($config)) {
				$config = Serializer :: load($dir_name.'/config/application.conf.data');
			}
		} else {
			$config = Serializer :: load($dir_name.'/config/application.conf.data');
		}
		if (!is_array($config)) {
			return PEAR :: raiseError('cannot load the configuration file');
		}
		return $config;
	}

	/**
	Copyright 2006
	
	        Load the Service
		@param string $command command name
		@author Spyro Solutions
		@date 21-agus-2006 13:55:19
		@location Cali-Colombia 	
	*/
	function loadService($servicename) {

		//Valida si el comando es señalado para validacion
		$var = & Services :: __loadNavApp(Services :: getBaseDirectory());

		//Invoca el servicio	
		$this->service = Services :: loadServices("$servicename");
		
		//validad si el usuario tiene permisos para ejecutar este comando
		//return $service->validateCommand($command);
	}


        /**
	*
	*   Load NavigationFile of any application
	*   @author Spyro Solutions
	*   @param string $dir_name
	*   @return array (Arreglo con la configuracion de la aplicacion)
	*   @date 08-dic-2006 11:58:43
	*   @location Cali-Colombia
	*/
	function & __loadNavApp($dir_name = "") {
		$navigation = Serializer :: load($dir_name.'/config/web.conf.data');
		if (!is_array($navigation)) {
			return PEAR :: raiseError('cannot load the Navigation file');
		}
		return $navigation;
	}


	/**
	*	Copyright 2006 - Spyro Solutions
	*	
	*	Load Any Service
	*	@param string $nameService Nombre del servicio
	*	@author Spyro Solutions
	*	@date 08-adic-2006 10:43:34
	*	@location Cali-Colombia
	*/
	function loadServices($nameService) {
		require_once dirname(__FILE__)."/Services/".ucfirst($nameService).".class.php";
		return new $nameService;
	}

}

?>
