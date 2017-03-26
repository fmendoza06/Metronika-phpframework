<?php

/**
* index.php
*
* standalone receiver
* freestanding code to load the FrontController
* requires the "config.inc.php"
*/

require_once "config/config.inc.php";
require_once "ASAP.class.php";
require_once "Web/FrontController.class.php";

 //Error Manager
//require_once "Error.class.php";
//$error = new Error();
//$errorManager = set_error_handler("errorManager");

ini_set('display_errors','Off');
//ini_set('error_log','Igenerator_error.log');

// run the Front Controller
FrontController::execute();

?>


