<html>
<head>
       <title>Save Configuration File</title>
</head>
<body>
<h2>Save Default Configuration File</h2>
<hr>
<?php

/* Esto es para independizar el pear y el ado del include_path de PHP*/
global $saveconfiguration;
$saveconfiguration="S";

require_once "config.inc.php";
require_once "Data/Serializer.class.php";

$Application_config = array (
    'name' => 'Ingravity',
    'description' => 'Generator for Web Applications',
    'version' => '1.0',
// languaje
    'language' => 'es',
// character encoding
    'charset' => 'utf-8',
// library path
    'include_path' => array (
        dirname(__FILE__).'/../.',
        dirname(__FILE__).'/../php/classes',
        dirname(__FILE__).'/../../../lib',
        dirname(__FILE__).'/../../../lib/MDB_MetaData',
        dirname(__FILE__).'/../../../lib/Smarty-3.1.27/libs',
        dirname(__FILE__).'/../data',
        dirname(__FILE__).'/../../../lib/pear',
        dirname(__FILE__).'/../../../lib/pear/MDB2-2.5.0',
        dirname(__FILE__).'/../../../lib/pear/MDB_MetaData',
        dirname(__FILE__).'/../../../lib/adodb5',
    ),
        
// directories
    'commands_dir' => '/web/commands',
    'views_dir' => '/web/views',
    'templates_dir' => '/web/templates',
    'plugins_dir' => '/web/plugins',
    'icons_dir' => '/icons',
    'images_dir' => '/images',
    'domain_dir' => '/domain',
    'data_dir' => '/data',

    );

echo "<pre>";
print_r($Application_config);
echo "</pre>";

$result = Serializer::save($Application_config, 'application.conf.data');

if (@PEAR::isError($result)) {
    echo "Error creating configuration file";
}

?>
</body>
</html>
