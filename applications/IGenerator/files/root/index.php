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

//error_reporting(E_ALL ^ E_NOTICE);

/*
if (!strstr($_SERVER["HTTP_USER_AGENT"], "MSIE"))
  echo "<b>Esta aplicacion solo esta optimizado para Internet Explorer, Intente de Nuevo. <br>This Application only enabled to work with INTERNET EXPLORER, Try Again.</b>";
else
*/
// run the Front Controller
 $_SESSION["_iauthSession"]["userid"] ="2"; 
 $_SESSION["_iauthSession"]["username"] ="admin";
 $_SESSION["_iauthSession"]["reseid"] = 1;
 $_SESSION["_iauthSession"]["usertype"] =  1;
 $_SESSION["_iauthSession"]["resellername"] = "Reseller Admin";
 $_SESSION["_iauthSession"]["indentify"]=1;
 
 
 //Error Manager
require_once "Error.class.php";
$error = new Error();
$errorManager = set_error_handler("errorManager");
 
FrontController::execute();


?>


