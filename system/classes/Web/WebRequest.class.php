<?php

class WebRequest {
	
  	/**
	*	Copyright 2006 - Spyro Solutions
	*	
	*	@author Spyro Solutions - Jose Fernando Mendoza
	*	@date 14-Dic-2006 10:43:34
	*	@location Cali-Colombia
	*/	

    public static function setProperty($name="", &$objVar) {
        $params =& ASAP::getStaticProperty('Request', 'parameters');
        if (!isset($params)) {
            $params = array();
        }
        //$params[$name] = $objVar;
		$params[$name] = WebRequest::clear_input($objVar);
    }

    public static function &getProperty($name="") {
        $params =& ASAP::getStaticProperty('Request', 'parameters');
        if (!isset($params)) {
            $params = array();
        }print_r($credacid);
        return $params[$name];
    }

    public static function &getParameterList() {
        $params =& ASAP::getStaticProperty('Request', 'parameters');
        if (!isset($params)) {
            $params = array();
        }
        return $params;
    }
	
    public static function clear_input($data) {
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }	

}

?>
