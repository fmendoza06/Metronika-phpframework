<?php

global $saveconfiguration;
global $dir_name;

// This attribute return assoc 
//uppercase field names for tables

//0 = assoc lowercase field names. $rs->fields['orderid']
//1 = assoc uppercase field names. $rs->fields['ORDERID']
//2 = use native-case field names. $rs->fields['OrderID'] -- this is the default since ADOdb 2.90
define('ADODB_ASSOC_CASE', 0);

if ($saveconfiguration != "S")
{
  if ($saveconfiguration == "J")
  {
    require_once "../../../../lib/PEAR/PEAR.php";
    require_once "ASAP.class.php";
    require_once "Services.class.php";
    require_once "Data/Serializer.class.php";
    require_once('../../../../lib/adodb5/adodb.inc.php');
    require_once('../../../../lib/PEAR/Log/Log.php');
  }
  else {     //Es "N"
        require_once "./../../lib/PEAR/PEAR.php";
        require_once "ASAP.class.php";
        require_once "Services.class.php";
        require_once "Data/Serializer.class.php";
        require_once('./../../lib/adodb5/adodb.inc.php');
        require_once('./../../lib/PEAR/Log/Log.php');
  }
}
else       // Es "S"
{
    require_once "../../../lib/PEAR/PEAR.php";
    require_once "ASAP.class.php";
    require_once "Services.class.php";
    require_once "Data/Serializer.class.php";
    require_once('../../../lib/adodb5/adodb.inc.php');
    require_once("../../../lib/PEAR/Log/Log.php");

}
require_once "Web/WebSession.class.php";
class Application {

    function Application($name, $dir_name, $flag = false) {

        // load the configuration file from the directory
        Application :: __loadConfig($dir_name, $flag);

        // set the application name and directory
        Application :: setBaseDirectory($dir_name);
        Application :: setName($name);
        
        // initialize the static variables
        Application :: init();

    }

    public static function &getDataODBC() {
        return Application::__getVar('odbc');
    }


    public static function &getMode() {
        return Application :: __getVar('mode');
    }

    public static function &getLanguage() {
        return Application::__getVar('language');
    }

    public static function &getCharSet() {
        return Application::__getVar('charset');
    }

   public static function &getBaseDirectory() {
        return Application::__getVar('base_dir');
    }
    
    public static function setBaseDirectory($dir_name) {
        Application::__setVar('base_dir', $dir_name);
    }

    public static function &getName() {
        return Application::__getVar('name');
    }

    public static function setName($name) {
        Application::__setVar('name', $name);
    }

    public static function &getDescription() {
        return Application::__getVar('description');
    }

    public static function &getVersion() {
        return Application::__getVar('version');
    }

    public static function &getIncludePath() {
        return Application::__getVar('include_path');
    }

    public static function getCommandsDirectory() {
        return Application::getBaseDirectory() . 
		    Application::__getVar('commands_dir');
    }

    public static function getViewsDirectory() {
        return Application::getBaseDirectory() .
            Application::__getVar('views_dir');
    }
    
    public static function &getPluginsDirectory() {
        return Application::getBaseDirectory() .
            Application::__getVar('plugins_dir');
    }

    public static function &getIconsDirectory() {
        return Application::getBaseDirectory() .
            Application::__getVar('icons_dir');
    }

    public static function &getScriptsDirectory() {
        return Application::getBaseDirectory() .
            Application::__getVar('scripts_dir');
    }

    public static function &getImagesDirectory() {
        return Application::getBaseDirectory() .
            Application::__getVar('images_dir');
    }
    
    public static function &getTemplatesDirectory() {
        return Application::getBaseDirectory() .
            Application::__getVar('templates_dir');
    }

	/**
		Copyright 2006  Spyro Solutions
		
		Load the data language directory
		@return string 
		@author jmendoza <spyrosolutions@yahoo.com>
		@date 10 Agu 2006
		@location Cali-Colombia
	*/

    public static function getLanguageDirectory() {
        return Application::getBaseDirectory() . 
		       Application::__getVar('language_dir');
			   //Application::getBaseDirectory().Application::__getVar('language_dir')
    }
    
	/**
		Copyright 2006  Spyro Solutions
		
		All parameters for date format
		@return string 
		@author jmendoza <spyrosolutions@yahoo.com>
		@date 12 Dic 2006
		@location Cali-Colombia
	*/
	
        
	public static function &getDbfundate() {
		return Application :: __getVar('dbfundate');
	}

	public static function &getDbdateformat() {
		return Application :: __getVar('dbdateformat');
	}

	public static function &getDbdateformatseparator() {
		return Application :: __getVar('dbdateformatseparator');
	}

	public static function &getDbusedateformat() {
		return Application :: __getVar('dbusedateformat');
	}
	public static function &getDbdatetsformat() {
		return Application :: __getVar('dbdatetsformat');
	}
	public static function &getDbusedatetsformat() {
		return Application :: __getVar('dbusedatetsformat');
	}

	public static function getSecureFileName() {
		//return Application :: __getVar('securefile');
		return Application :: __getVar('securefile')."_". WebSession::getIAuthProperty("owneid").".json";
	}

	/**
		Copyright 2006  Spyro Solutions
		
		Get type log auth
		@return string 
		@author jmendoza <spyrosolutions@yahoo.com>
		@date 12 Dic 2006
		@location Cali-Colombia
	*/
	public static function &getLog() {
		return Application :: __getVar('log');
	}

	public static function getLogFile() {
		return Application :: __getVar('logfile');
	}
	
	public static function getLogTable() {
		return Application :: __getVar('logtable');
	}
	
	/**
		Copyright 2006  Spyro Solutions
		
		Get type erorlog auth
		@return string 
		@author jmendoza <spyrosolutions@yahoo.com>
		@date 12 Dic 2006
		@location Cali-Colombia
	*/

	public static function getErrorLog() {
		return Application :: __getVar('errorlog');
	}

	function getErrorLogFile() {
		return Application :: __getVar('errorlogfile');
	}
	
	function getErrorLogTable() {
		return Application :: __getVar('errorlogtable');
	}

	/**
		Copyright 2006  Spyro Solutions
		
		Look an feel Template
		@return string 
		@author jmendoza <spyrosolutions@yahoo.com>
		@date 12 Dic 2006
		@location Cali-Colombia
	*/

    public static function &getTemplate() {
          return  Application::__getVar('template');
    }

    public static function &getPathImage($directory) {
        $config = ASAP::getStaticProperty('Application','config');
        return $config[$directory];
    }

    public static function &getAppId() {
	return Application :: __getVar('app_id');
    }
    
    public static function getDataDirectory() {

        return Application ::getBaseDirectory().Application ::__getVar('data_dir');
    }

    public static function &getApplicationClass() {
        return Application::__getVar('app_class');
    }
    
    public static function &getConfigArray() {
        $config = ASAP::getStaticProperty('Application','config');
        return $config;
    }

	/**
		Copyright 2006  Spyro Solutions
		
		Load the prefix for appliactions
		@return integer 
		@author jmendoza <spyrosolutions@yahoo.com>
		@date 10 Agu 2006
		@location Cali-Colombia
	*/

    public static function &getprefix() {
        return Application::__getVar('useprefix');
    }

	/**
		Copyright 2010  Spyro Soflutions
		
		Load the docs templates for appliactions
		@return string 
		@author jmendoza <spyrosolutions@yahoo.com>
		@date 09 Jun 2010
		@location Cali-Colombia
	*/

    public static function &getdocstemplates() {
        return Application::getBaseDirectory().
               Application::__getVar('docstemplates_dir');
    }

	/**
		Copyright 2010  Spyro Soflutions
		
		Load the temporal dir for documents
		@return string 
		@author jmendoza <spyrosolutions@yahoo.com>
		@date 09 Jun 2010
		@location Cali-Colombia
	*/

    public static function &getdocstmp() {
        return Application::getBaseDirectory().
               Application::__getVar('docstmp_dir');
    }



    public static function &getDomainDirectory() {
        return Application::__getVar('domain_dir');
    }

	/**
		Copyright 2006  Spyro Solutions

		Load the path to auth directory
		@return integer 
		@author jmendoza <spyrosolutions@yahoo.com>
		@date 20 Julio 2015
		@location Popayan-Colombia
	*/
    public static function getAuthDirectory() {

        return Application::getBaseDirectory() .
               Application::__getVar('auth_dir');
    }
	
	/**
		Copyright 2006  Spyro Solutions

		Load the path to report directory
		@return integer 
		@author jmendoza <spyrosolutions@yahoo.com>
		@date 22 Dic 2006
		@location Cali-Colombia
	*/
    public static function &getReportDirectory() {

        return Application::getBaseDirectory() .
               Application::__getVar('report_dir');
    }
	
	/**
		Copyright 2013  Spyro Solutions

		Load the path to Cache directory
		@return integer 
		@author jmendoza <spyrosolutions@yahoo.com>
		@date 13 Mar 2013
		@location Cali-Colombia
	*/
    public static function &getCacheDirectory() {

        return Application::getBaseDirectory() .
               Application::__getVar('cache');
    }

	

	/**
		Copyright 2010  Spyro Solutions

		Load the path to report directory
		@return integer 
		@author jmendoza <spyrosolutions@yahoo.com>
		@date 19 Abril 2010
		@location Cali-Colombia
	*/

    public static function &getCaptchaDirectory() {

        return Application::getBaseDirectory().
               Application::__getVar('captcha_dir');
    }

	public static function  &getDomainController($name) {
		$name = Application :: getAppId().$name;
		$filename = Application :: getBaseDirectory().Application :: getDomainDirectory().'/'.$name.'.class.php';
		if (!class_exists($name))
			include_once $filename;

		if (!class_exists($name)) {
			return PEAR :: raiseError('domain controller not found');
		} else {
			$obj =  new $name (); // Se Quito el &
			return $obj;
		}
	}

	public static function &getDataGateway($name) {

		$name_dir = &ASAP :: getStaticProperty('Application', 'config');
		$classname = $name_dir['database']['type'].ucfirst($name);
		$classname = Application :: getAppId().$classname;
		$filename = Application :: getDataDirectory().'/'.$name_dir['database']['type'].'/'.$classname.'.class.php';
		if (!class_exists($classname))
			include_once $filename;
		if (!class_exists($classname)) {
			return PEAR :: raiseError('Gate way not found');
		} else {
			$obj =  new $classname ();  // Se Quito el &

			return $obj;
		}
	}

	/**
		Copyright 2006  Spyro Solutions
		
		Load the path to report obj
		@return integer
		@author jmendoza <spyrosolutions@yahoo.com>
		@date 22 Dic 2006
		@location Cali-Colombia
	*/
	public static function &getReportGateway($type,$name) {
		$name_dir = ASAP :: getStaticProperty('Application', 'config');
		$classname = $type.ucfirst($name);
		$classname = Application :: getAppId().$classname;
		$filename = Application :: getReportDirectory().'/'.$type.'/'.$classname.'.class.php';
		if (!class_exists($classname))
			include_once $filename;
		if (!class_exists($classname)) {
			return PEAR :: raiseError($type.' Class not found');
		} else {
			$obj =  new $classname (); // Se Quito el &

			return $obj;
		}
	}
	
	/**
		Copyright 2006  Spyro Solutions
		
		Load json Auth object
		@return integer
		@author jmendoza <spyrosolutions@yahoo.com>
		@date 22 Dic 2006
		@location Cali-Colombia
	*/
    public static function &getDatabaseAuth() {
		//print_r($authfilename);
		$authfilename = Application :: getAuthDirectory().'/'. Application :: getSecureFileName();
        $authjson = file_get_contents($authfilename);
	    return $authJsonObject;		
	
    }	
	
    public static function &getDatabaseConnection() {
        $config = ASAP::getStaticProperty('Application','config');
        //print_r($config);
        if (!isset($config['dbConn']) ) {
               //print_r("Type->".$config['database']['type']);
            switch($config['database']['type']) {
                case 'Mysql':
                    $config['dbConn'] = mysql_pconnect($config['database']['host'],
                        $config['database']['user'],
                        $config['database']['password']);
                    if (!$config['dbConn']) {
                        return PEAR::raiseError('error connecting to the database');
                    }
                    // select database name
                    if(!mysql_select_db($config['database']['name'], $config['dbConn'])){
                        return PEAR::raiseError('database name not found');
                    }

                    break;
                case 'Oracle':
                    $config['dbConn'] = OCIPLogon($config['database']['user'],
                    $config['database']['password'],$config['database']['host']);

                    if (!$config['dbConn']) {
                        return PEAR::raiseError('error connecting to the database');
                    }

                    break;
                case 'Pgsql':
                    $config['dbConn'] = pg_pconnect("host='".$config['database']['host']."'
                    dbname='".$config['database']['name']."'
                    user='".$config['database']['user']."' password='".$config['database']['password']."'");

                    if (!$config['dbConn']) {
                        return PEAR::raiseError('error connecting to the database');
                    }

                    break;
                 case 'adodb':   //Use ADODB
				    if (strncmp($config['database']['connection'],'pdo',3) == 0)  //Is Use ADODB with PDO fucntions JFMI 26-Oct-2014 connection=pdo_mysql or pdo_postgres
					{ 
				         $sch = explode('_',$config['database']['connection']);
				         if (sizeof($sch)>1) 
						 {
                           $config['dbConn'] = ADONewConnection($sch[0]); //pdo
						   $host= $sch[1].":host=".$config['database']['host'];
                           if (!$config['dbConn']->Connect($host, $config['database']['user'], $config['database']['password'], $config['database']['name'])) 
					       {
                             //trigger_error("Error Connect",E_WARNING);
                    	     die('error connecting to the database');
                    	     return NULL;
                           }  
                           //$config['dbConn']->query("SET NAMES 'utf8';"); // Se respetan las tildes almacenadas en la bd
		                   //$config['dbConn']->execute();						   
				         }
			        }					
					else
					{
                     $config['dbConn'] = ADONewConnection($config['database']['connection']);
                     if (!$config['dbConn']->Connect($config['database']['host'], $config['database']['user'], $config['database']['password'], $config['database']['name'])) 
					 {
                          //trigger_error("Error Connect",E_WARNING);
                    	  die('error connecting to the database');
                    	return NULL;
                     }					
					}
                    break;
				
                default:
                    return PEAR::raiseError('database not supported');
            }
            //return connetion
            return $config['dbConn'];
        } else {
            return $config['dbConn'];
        }
    }
	
	public static function ADOBeginTrans()
	{
	  $config = ASAP::getStaticProperty('Application','config');
	  if (isset($config['dbConn']) ) 
	  {
	     print_r($config['dbConn']);
	     $conn = $config['dbConn']; //->BeginTrans();
		 $conn->BeginTrans();
	  }	 
	}

	public static function ADOCommitTrans()
	{
	  $config = ASAP::getStaticProperty('Application','config');
	  if (isset($config['dbConn']) ) 
	  {
	  
	     $conn = $config['dbConn'];//->CommitTrans();
		 $conn->CommitTrans();
	  }	 
	}
	
	public static function ADORollbackTrans()
	{
	  $config = ASAP::getStaticProperty('Application','config');
	  if (isset($config['dbConn']) ) 
	  {
	  
	     $conn = $config['dbConn'];//->RollbackTrans();
		 $conn->RollbackTrans();
	  }	 
	}	

	
	
	

    public static function init() {

        $include_path = ini_get('include_path');
        if ($include_path == "") {
            $include_path= ".";
        }
        foreach (Application::getIncludePath() as $dir) {
            $include_path .= (substr(php_uname(), 0, 3) == "Win") ? ";" : ":";
            $include_path .= $dir;
        }

        ini_set('include_path', $include_path);
    }

    public static function &__getVar($nom_var) {

        $config = &ASAP::getStaticProperty('Application','config');
        
        // if configuration data is not set
        if (!isset($config)) {
            // load the configuration data
            // filename = <ASAP-dir>/applications/config/application.conf.data
            // @@ use the URL/directory
            $config = &Application::__loadConfig(dirname(__FILE__));
        }
        if (!is_array($config)) {
            return PEAR::raiseError('cannot load the configuration file');
        }
        return $config[$nom_var];
    }
    
    public static function __setVar($name="", &$objVar) {
        $obj =& ASAP::getStaticProperty('Application', 'config');
        $obj[$name] = $objVar;
    }
    
    public static function & __loadConfig($dir_name = "", $flag = false) 
    {
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
		/*
		print_r("<pr>");
		print_r($config);
		print_r("<pr>");		
		*/
		return $config;
     }

	/**
	Copyright 2006
	
	    Valid the command 
		@param string $command command name
		@author Spyro Solutions
		@date 21-agus-2006 13:55:19
		@location Cali-Colombia 	
	*/
	public static function validateProfiles($command) {

		//Valida si la aplicacion tiene activada la opcion para el sistema de autenticacion
		$var = Application :: __getVar("auth");
       
		if ($var != "enabled")
			return true;

		//Valida si el comando es señalado para validacion
				
		$var = Application :: __loadNavApp(Application :: getBaseDirectory());
		$rcCommand = $var["commands"][$command];
		
		//print_r($rcCommand);
		//$rcCommand["validated"]=true;
		if ($rcCommand["validated"] != "true")
			return true;

        //print_r("Auth=".$var);
        //Invoca el servicio
        if (!WebSession::issetPropertyAuth("commands"))
        {
           return false;
        // $service = Application :: loadServices("spyroAuth");
        // return $service->validateCommand($command);
        }
        else
        {
         $commands = WebSession::getIAuthProperty("commands");
        /*
        if ($command=="spcitriumCmdDefaultBackup")
        {
          echo "Voy a Evaluar...".$command;
          print_r("<pre>");
          print_r ($commands);
          print_r("</pre>->");
          print_r(in_array($command,$commands));
        }
        */
         return in_array($command,$commands);

        }
		//return in_array($command,$commands);
		//validad si el usuario tiene permisos para ejecutar este comando
		//return $service->validateCommand($command);
	}
	



	/**
	Copyright 2006 - Spyro Solutions
	
	    Change the Password 
		@param string $command nombre del comando
		@author Jose Fernando Mendoza <spyrosolutions@yahoo.com>
		@date 19-agus-2006 
		@location Cali-Colombia 	
	*/
	function changepassword($password,$newpassword) {
		//Invoca el servicio	
		$service = Application :: loadServices("spyroAuth");
		
		//validad si el usuario tiene permisos para ejecutar este comando
		return $service->updatePassword($password,$newpassword);
	}

	/**
	*
	*   Load NavigationFile of any application
	*   @author Spyro Solutions
	*   @param string $dir_name
	*   @return array (Arreglo con la configuracion de la aplicacion)
	*   @date 10-ago-2006 11:58:43
	*   @location Cali-Colombia
	*/
	public static function  __loadNavApp($dir_name = "") {
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
	*	@date 25-ago-2006 10:43:34
	*	@location Cali-Colombia
	*/
	public static function loadServices($nameService) {

		require_once dirname(__FILE__)."/Services/".ucfirst($nameService).".class.php";
        //        $service= new Services ("$nameService");
        //        return  $service->service;
		return new $nameService;
	}


	/**
	*	Copyright 2006 - Spyro Solutions
	*
	*	Generate Log, use Pear Log Library
	*	@author Spyro Solutions
	*	@date 14-Dic-2006 10:43:34
	*	@location Cali-Colombia
	*/
    public static function generatelog(){

        $config = ASAP::getStaticProperty('Application','config');
        $userCurrent = WebSession::getCurrentUserName();
        if ($userCurrent=="")
            $userCurrent="LOGINUSER";

        $realIP = '[IPADDRESS] '.$_SERVER['REMOTE_ADDR'];
        $appName = ' [APPNAME] '. Application::getAppId();
        //$ref    = '[REFERER] '.$_SERVER["HTTP_REFERER"];
        if (isset ($_REQUEST['action'])){
            $commandCurrent =$_REQUEST['action'];

            switch(Application::getlog()) {
                    case 'sql':
                            $table = Application::getLogTable();
                            $name = $config['database']['name'];
                            $type = $config['database']['connection'];
                            $user =$config['database']['user'];
                            $pass = $config['database']['password'];
                            $host = $config['database']['host'];
                            $hostport = $config['database']['hostport'];
                            $db = $config['database']['name'];
                            $connection = $config['database']['connection'];
                            $commandCurrent =$_REQUEST['action'];
                            // Data Source Name: This is the universal connection string
                            //$dsn = "$type://$user:$pass@$host:$hostport/$db";

                            /*  This conection string is resolved in pear/DB/oic8.php
                            if ($connection=="oci8")
                              $dsn ="(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=".$host
					.")(PORT=$hostport))(CONNECT_DATA=(SERVICE_NAME=$name)))";

                              $dsn ="(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=".$host
					.")(PORT=$hostport))(CONNECT_DATA=(SID=$name)))";
                            */
                            $conf = array('dsn'=>"$type://$user:$pass@$host:$hostport/$db");
                            $log  = &Log::singleton('sql', $table,$userCurrent,$conf,1);
                            $log->log($commandCurrent.' '.$realIP.' '.$appName, 1);
                            $log->close();
                    break;

                    case 'file':

                            $file = Application::getLogFile();
                            $conf = array('mode' => 0600,'timeFormat' => '%X %x');
                            $log  = Log::factory('file', $file, $userCurrent, $conf);
                            //$log->open();
                            $log->log($commandCurrent.' '.$realIP);
                            $log->close();

                    break;

            }//switch
        }// if (isset...)
    }//function generatelog()

	/**
	*	Copyright 2006 - Spyro Solutions
	*
	*	Load ASAP File with content
	*	@author Spyro Solutions
	*	@date 27-Sep-2006 18:36:40
	*	@location Cali-Colombia
	*/
    function loadfileAsap($filename) {
        $fp = @fopen($filename, "r");
        if (!$fp) {
            return PEAR::raiseError("cannot open file $filename");
        }

        $read =  @fread ( $fp, filesize ($filename));
        if(!$read) {
            return PEAR::raiseError("error reading file $filename");
        }

        $close = fclose ( $fp);
        if(!$close) {
            return PEAR::raiseError("error closing the file $filename");
        }

        return $obj;
    }

}

?>
