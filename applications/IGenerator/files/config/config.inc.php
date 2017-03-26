<?php

/**
* config.inc.php
*
* Configuration file for the freestanding configuration
*/

// Configuration data
// In the normal instalation, You will not need to change this lines

// ASAP-root directory
$asap_dir = dirname(__FILE__).'/../../..';

// local application directory
$app_dir = dirname(dirname(__FILE__));

// application name
$app_name = basename(dirname(dirname(__FILE__)));


// Application setup
// NOTE: do not change the following lines
// ----

// include the ASAP System directory
include_path_ini($asap_dir);

// load the Application class
require_once ("Application.class.php");

// set the Application
$app= new Application ($app_name, $app_dir);

/**
* Document::include_path_init()
*
* set the include path for ASAP System class loading
* NOTE: used only for freestanding configuration
*/
function include_path_ini($asap_dir) {

  $include_path = ini_get("include_path");
  $include_path .= (substr(php_uname(), 0, 3) == "Win") ? ";" : ":";
  $include_path .= $asap_dir."/system/classes";
  ini_set("include_path", $include_path);
}

?>
