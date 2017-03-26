<?php

/**
* jsrs.php
*
* remote scripting request broker
* requires the "config.inc.php"
*/
//require_once "../../config/config.inc.php";

//global $saveconfiguration;
$saveconfiguration = "J";
require_once "../../config/config.inc.php";
require_once "ASAP.class.php";
require_once "Application.class.php";
$saveconfiguration = "N" ;
require_once "Services/JsrsServer.class.php";

// require_once "Data/Serializer.class.php";

$invocation = $_REQUEST["F"];

list ($class, $method) = explode("::", $invocation);
 print_r($class);
if ($class != "DataGateway") {
	$obj = Application::getDomainController($class);

        if (Application :: getprefix() == 1){  
            $domain = Application :: getAppId();
            $invocation = $domain.''.$invocation;
        }
	
}

if ($class != "DataGateway" && PEAR::isError($obj)) {
	JsrsServer::sendErrorResponse("Class not found");	
} else {
	JsrsServer::dispatch($invocation);
}

class DataGateway {
	
	function execute() {
		
		// must have a variable number of parameters
		$numargs = func_num_args();
		
		if ($numargs < 2) {
			return PEAR::raiseError("Wrong number of parameters");
		}  else {
						
			$args = func_get_args();
			
			echo "Data Gateway Arguments";
			var_dump($args);
			echo "<hr>";
			
			// get the first parameter
			$table_name = array_shift($args);
			
			$obj = Application::getDataGateway($table_name);

			if (!PEAR::isError($obj)) {
				// get the second parameter
				$method_name = array_shift($args);
			
				// call the function
				$res = call_user_func_array(
					array(&$obj, $method_name),
					$args);

				echo "result";
				var_dump($res);
				echo "<hr>";
								
				return $res; 
				
			}
		}
	}
}


?>
