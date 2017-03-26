<?php
/**
	Copyright Spyro Solutions
	
	Auth Service for Auth Application
	@author Spyro Solutions
	@date 22-abr-2006 10:31:44
	@location Cali-Colombia
*/

class SpyroAuth {
	
	var $appName;
	var $appDir;
	
	
	function SpyroAuth() {
		//Guarda los datos anteriores
		$this->appDir = Application::getBaseDirectory();
		$this->appName = Application::getName();
				
		//Cambia la configuracion de la aplicació
        $dir_name = dirname(__FILE__)."/../../../applications/auth";
		$name = "auth";

		//Application::Application($name,$dir_name,true);

        // load the configuration file from the directory
        Application :: __loadConfig($dir_name, true);

        // set the application name and directory
        Application :: setBaseDirectory($dir_name);
        Application :: setName($name);
        
        // initialize the static variables
        Application :: init();
	}
	
	
	/**
		Copyright
	
		Cerrar la Aplicacion Auth
		@author Spyro Solutions
		@date 22-abr-2006 10:31:44
		@location Cali-Colombia
		@note NOTA: Este método debe ser ejecutado una vez termine la ejecucion de esta clase
	*/
	function close(){
		//Application::Application($this->appName,$this->appDir,true);	
        // load the configuration file from the directory
        Application :: __loadConfig($this->appDir, true);

        // set the application name and directory
        Application :: setBaseDirectory($this->appDir);
        Application :: setName($this->appName);
        
        // initialize the static variables
        Application :: init();
	}


	/**
		Copyright
		
		Invoke AuthManager Logic
		@param string $command nombre del comando		
		@author Spyro Solutions
		@date 22-abr-2006 10:31:44
		@location Cali-Colombia
	*/
	function validateCommand($cmd){
				
		$auth_manager = Application::getDomainController('AuthManager');
		$result = $auth_manager->validateCommand($cmd);
		$this->close();		
		return $result;
				
	}
	
	
	/**
		Copyright
		
		Return Data Gateway
		@param string $getway name
		@author Spyro Solutions
		@date 06-jan-2007 
		@location Cali-Colombia
	*/
	function getDataGateway($getway){
				
		$getDataGateway = Application::getDataGateway("$getway");
		$this->close();
		return $getDataGateway;
				
	}
	
	
	/**
		Copyright
		
		Return All Childs of Menu
		@param string $menuid
		@author Spyro Solutions
		@date 06-jan-2007
		@location Cali-Colombia
	*/
	function getMenusChilds($menuid)
        {
	 	$menus_manager = Application::getDomainController('MenusManager');
		$result = $menus_manager->getMenusChilds($menuid);
		$this->close();
		return $result;
	}

	/**
		Copyright
		
		Return All Childs of Menu
		@param string $command name
		@author Spyro Solutions
		@date 06-jan-2007
		@location Cali-Colombia
	*/
	function getCommname($command)
        {
		$menus_manager = Application::getDomainController('CommandsManager');
		$result = $menus_manager->getCommname($command);
		$this->close();
		return $result;
	}
	
	/**
		Copyright
		
		Return All Childs of Menu
		@param string $menuid
		@author Spyro Solutions
		@date 06-jan-2007
		@location Cali-Colombia
	*/
	function getByIdMenus($menuid)
        {
		$menus_manager = Application::getDomainController('MenusManager');
		$result = $menus_manager->getByIdMenus($menuid);
		$this->close();
		return $result;
	}


	/**
	* Metodo para consultar todos los datos de la tabla: aplicaciones del SpyroAuth Schema
	* @author Spyro Solutions
	* @return array
	*/
    function getAllAplicaciones()
	{
	 	$aplicaciones_manager = Application::getDomainController('ApplicationsManager');
		$result = $aplicaciones_manager->getAllApplications();
		$this->close();
      	return $result;

    }

	/**
	* Metodo para consultar el nombre de la tabla: aplicaciones
	* @author Spyro Solutions
	* Una vez usado este metodo debe ser cerrado con el metodo close
	* @return string	
	*/
	function getIdPorNombre($nombre)
  	{
		$aplicaciones_manager = Application::getDomainController('AplicacionesManager');
		$result = $aplicaciones_manager->getIdPorNombre($nombre);
		//$this->close();
      	return $result;
	}
	
	/**
	* Metodo para consultar el nombre de la tabla: aplicaciones del SpyroAuth Schema
	* @author Spyro Solutions
	* @return string
	*/
	function getNombreApp($id)
	{
		$aplicaciones_manager = Application::getDomainController('AplicacionesManager');
		$result = $aplicaciones_manager->getNombre($id);
		$this->close();
      	return $result;
	}
	
	/**
	* Metodo para consultar todos los datos de la tabla: modulos del SpyroAuth Schema
	* @author Spyro Solutions
	* @return array
	*/
    function getAllModulosPorApp( $idApp )
	{
	 	$modulos_manager = Application::getDomainController('ModulosManager');
		$result = $modulos_manager->getAllModulosPorApp( $idApp );
		$this->close();
      	return $result;

    }
	
	/**
	* Metodo para adicionar datos a la tabla: perfiles del SpyroAuth Schema
	* @author Spyro Solutions
	* @return integer
	*/
   	function addPerfiles($idApp,$nombre,$estado,$observaciones)
	{
		$perfiles_manager = Application::getDomainController('PerfilesManager');
		$id = $perfiles_manager->getConsecutivo($idApp);
		$result = $perfiles_manager->addPerfiles($id,$idApp,$nombre,$estado,$observaciones);
		$this->close();
      	return $result;
	}
	
	
	/**
	* Metodo para actualizar datos de la tabla: perfiles del SpyroAuth Schema
	* @author Spyro Solutions
	* @return integer
	*/
    function updatePerfiles($id,$idApp,$nombre,$estado,$observaciones)
	{
		$perfiles_manager = Application::getDomainController('PerfilesManager');
		$result = $perfiles_manager->updatePerfiles($id,$idApp,$nombre,$estado,$observaciones);
		$this->close();
      	return $result;
    }
	
	/**
	* Metodo para eliminar datos de la tabla: perfiles del SpyroAuth Schema
	* @author Spyro Solutions
	* @return integer
	*/
    function deletePerfiles($id,$idApp)
	{
		$perfiles_manager = Application::getDomainController('PerfilesManager');
		$result = $perfiles_manager->deletePerfiles($id,$idApp);
		$this->close();
      	return $result;
	}
	
	/**
	* Metodo para consultar todos los datos de la tabla: perfiles del SpyroAuth Schema
	* @author Spyro Solutions
	* @return array
	*/
    function getAllPerfiles()
	{
		$perfiles_manager = Application::getDomainController('PerfilesManager');
		$result = $perfiles_manager->getAllPerfiles();
		$this->close();
      	return $result;
	}	
	
	/**
	* Metodo para consultar todos los datos de la tabla: perfiles por aplicacion del SpyroAuth Schema
	* @author Spyro Solutions
	* @return int
	*/
	function getAllPerfilesPorApp( $idApp )
	{	
		$perfiles_manager = Application::getDomainController('PerfilesManager');
		$result = $perfiles_manager->getAllPerfilesPorApp( $idApp );
		$this->close();
      	return $result;
	}
	
	/**
	* Metodo para consultar el nombre de la tabla: aplicaciones del SpyroAuth Schema
	* @author Spyro Solutions
	* @return string
	*/
	function getNombrePer($id,$idApp)
	{
		$perfiles_manager = Application::getDomainController('PerfilesManager');
		$result = $perfiles_manager->getNombre($id,$idApp);
		$this->close();
      	return $result;
	}
	/**
	* Metodo para consultar los datos por la llave primaria de la tabla: perfiles
	* @author Spyro Solutions
	* @return array
	*/
    function getByIdPerfiles($id,$idApp)
	{
		$perfiles_manager = Application::getDomainController('PerfilesManager');
		$result = $perfiles_manager->getByIdPerfiles($id,$idApp);
		$this->close();
      	return $result;
	}
	
	/**
	* Metodo para consultar todos los datos de la tabla: comandos por aplicacion del SpyroAuth Schema
	* @author Spyro Solutions
	* @return array
	*/
	function getAllComandosPorApp( $idApp )
	{	
		$comandos_manager = Application::getDomainController('ComandosManager');
		$result = $comandos_manager->getAllComandosPorApp( $idApp );
		$this->close();
      	return $result;
	}
	
	/**
	* Metodo para consultar todos los datos de la tabla: comandos por aplicacion del SpyroAuth Schema
	* @author Spyro Solutions
	* @return array
	*/
	function getAllComandosPorAppMod( $idApp, $idmod, $idper )
	{	
		$comandos_manager = Application::getDomainController('ComandosManager');
		$result = $comandos_manager->getComandosPorAppMod2( $idApp, $idmod, $idper );
		$this->close();
      	return $result;
	}
	
	/**
	* Metodo para adicionar datos a la tabla: usuarios del SpyroAuth Schema
	* @author Spyro Solutions
	* @return integer
	*/
   	function addUsuarios($login,$idApp,$idPerApp,$idPer,$password,$nombre,$apellidos,$correo,$telefono,$estado)
	{
		$usuarios_manager = Application::getDomainController('UsuariosManager');
		$result = $usuarios_manager->addUsuarios($login,$idApp,$idPerApp,$idPer,$password,$nombre,$apellidos,$correo,$telefono,$estado);
		$this->close();
      	return $result;
	}
	
	/**
	* Metodo para actualizar datos de la tabla: usuarios del SpyroAuth Schema
	* @author Spyro Solutions
	* @return integer
	*/
    function updateUsuarios($login,$idApp,$idPerApp,$idPer,$password,$nombre,$apellidos,$correo,$telefono,$estado)
	{
		$usuarios_manager = Application::getDomainController('UsuariosManager');
		$result = $usuarios_manager->updateUsuarios($login,$idApp,$idPerApp,$idPer,$password,$nombre,$apellidos,$correo,$telefono,$estado);
		$this->close();
      	return $result;
	}
	
	/**
	* Metodo para actualizar el password de la tabla: usuarios del SpyroAuth Schema
	* @author Spyro Solutions
	* @return integer
	*/
    function updatePassword($password,$newpassword)
	{
		$usuarios_manager = Application::getDomainController('UsersManager');
		$result = $usuarios_manager->updatePassword($password,$newpassword);
		$this->close();
      	return $result;
	}
	
	/**
	* Metodo para eliminar datos de la tabla: usuarios del SpyroAuth Schema
	* @author Spyro Solutions
	* @return integer
	*/
    function deleteUsuarios($login,$idApp)
	{
		$usuarios_manager = Application::getDomainController('UsuariosManager');
		$result = $usuarios_manager->deleteUsuarios($login,$idApp);
		$this->close();
      	return $result;
	}
	
	/**
	* Metodo para consultar todos los datos de la tabla: usuarios del SpyroAuth Schema
	* @author Spyro Solutions
	* @return array
	*/
    function getAllUsuarios()
	{
		$usuarios_manager = Application::getDomainController('UsuariosManager');
		$result = $usuarios_manager->getAllUsuarios();
		$this->close();
      	return $result;
	}
	
	/**
	* Metodo para consultar todos los datos de la tabla: usuarios del SpyroAuth Schema por App
	* @author Spyro Solutions
	* @return array
	*/
    function getAllUsuariosPorApp($idApp)
	{
		$usuarios_manager = Application::getDomainController('UsuariosManager');
		$result = $usuarios_manager->getAllUsuariosPorApp($idApp);
		$this->close();
      	return $result;
	}
	
	/**
	* Metodo para consultar los datos por la llave primaria de la tabla: usuarios
	* @author Spyro Solutions
	* @return array
	*/
    function getByIdUsuarios($login,$idApp)
	{
		$usuarios_manager = Application::getDomainController('UsuariosManager');
		$result = $usuarios_manager->getByIdUsuarios($login,$idApp);
		$this->close();
      	return $result;
	}

	/**
	* Metodo para consultar el nombre de la tabla: aplicaciones del SpyroAuth Schema
	* @author Spyro Solutions
	* @return string
	*/
	function getNombreUser($login,$idApp)
	{
		$usuarios_manager = Application::getDomainController('UsuariosManager');
		$result = $usuarios_manager->getNombre($login,$idApp);
		$this->close();
      	return $result;
	}
	/**
	* Metodo para consultar todos los datos de la tabla: comandos por aplicacion del SpyroAuth Schema
	* @author Spyro Solutions
	* @return int
	*/
	function getComandosPorApp($idApp)
	{
		$comandos_manager = Application::getDomainController('ComandosManager');
		$result = $comandos_manager->getComandosPorApp($idApp);
		$this->close();
      	return $result;
	}
	
	/**
	* Metodo para adicionar datos a la tabla: permisos del SpyroAuth Schema
	* @author Spyro Solutions
	* @return integer
	*/
   	function loadPermisos($idCmdModApp,$idPer,$comandosA,$comandosD)
	{
		$permisos_manager = Application::getDomainController('PermisosManager');
		$result = $permisos_manager->loadPermisos($idCmdModApp,$idPer,$comandosA,$comandosD);
		$this->close();
      	return $result;
	}
	
	/**
	* Metodo para consultar datos a la tabla: permisos del SpyroAuth Schema
	* @author Spyro Solutions
	* @return integer
	*/
   	function getPermisosPorPerMod($idCmdModApp,$idMod,$idPer)
	{
		$permisos_manager = Application::getDomainController('PermisosManager');
		$result = $permisos_manager->getPermisosPorPerMod($idCmdModApp,$idMod,$idPer);
		$this->close();
      	return $result;
	}
	
	/**
	* Metodo para consultar los datos por la llave primaria de la tabla: permisos del SpyroAuth Schema
	* @author Spyro Solutions
	* @return array
	*/
    function getByIdPermisos($idCmdMod,$idCmdModApp,$idPer,$idPerApp,$nombreComando)
	{
		$permisos_manager = Application::getDomainController('PermisosManager');
		$result = $permisos_manager->getByIdPermisos($idCmdMod,$idCmdModApp,$idPer,$idPerApp,$nombreComando);
		$this->close();
      	return $result;
	}
	
	/**
	* Metodo para consultar todos los datos de la tabla: permisos del SpyroAuth Schema
	* @author Spyro Solutions
	* @return array
	*/
    function getAllPermisos()
	{
		$permisos_manager = Application::getDomainController('PermisosManager');
		$result = $permisos_manager->getAllPermisos();
		$this->close();
      	return $result;
	}
	
}

?>