<?xml version='1.0'?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<!-- El modo al que transformará el XSL --> 
<xsl:output method="text"/> 
<!-- Paramatros -->
<xsl:param name="type_db"/>
<xsl:param name="catalogo"/>
<xsl:param name="host"/>
<xsl:param name="user"/>
<xsl:param name="pass"/>
<xsl:param name = "port"/>

<!-- Nombre de la Empresa -->
<xsl:param name = "empresa"/>
<!-- Nombre de la Aplicacion -->
<xsl:param name = "aplicacion"/>
<!-- Sistema de Autenticacion -->
<xsl:param name = "auth"/>
<!-- Document encoding -->
<xsl:param name = "charset"/>

<xsl:template match="/">&lt;html&gt;
&lt;head&gt;
       &lt;title>Save Configuration File&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
&lt;h2&gt;Save Default Configuration File&lt;/h2&gt;
&lt;hr&gt;
&lt;?php

/**
 * Generado por Spyro SpyroFrameWork
 * @author SpyroFrameWork
 * @copyright Spyro Solutions
 */

//Esto es para independizar librerias del include_path de PHP
//Se afecta el Application.class y el Serializer.php
global $saveconfiguration;
$saveconfiguration="S";

require_once "config.inc.php";
require_once "Data/Serializer.class.php";

$Application_config = array (
    'name' => '<xsl:value-of select="$aplicacion"/>',
    'description' => '<xsl:value-of select="$aplicacion"/> Web Applications',
    'version' => '0.1',
    'app_id' => '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>',
// languaje 
    'language' => 'es',
// application mode (development = 0 | production = 1) 
    'mode' => '1',
// authentication system (enabled | disabled )
    "auth" => '<xsl:value-of select="$auth"/>', 
// application autentica (yes = 0 | no = 1) 
	'authentication' => '1', 
	
// application log Managment LOG (sql=>Data Base, file=> File Log , Nothing => Not Log)
    'log' => 'file',
// application log file, only if File Log
    'logfile' => 'c:/tmp/authlogfile.log',

// application log table file , only if  Data Base
// this tables exist in same schema Data Bussines Logi
    'logtable' => 'authlogtable',
    
// application errorlog Managment LOG (file=> File ErrorLog , Nothing => Not ErrorLog)
    'errorlog' => 'file',
// application log file only if  File ErrorLog
    'errorlogfile' => 'c:/tmp/autherrorlogfile.log',

// application log table file
// this tables exist in same schema Data Bussines Logi
    'errorlogtable' => 'authlogtable',

/**
 *
 * CREATE TABLE authlogtable (
 *  id          INT NOT NULL,
 *  logtime     TIMESTAMP NOT NULL,
 *  ident       CHAR(16) NOT NULL,
 *  priority    INT NOT NULL,
 *  message     VARCHAR(200),
 *  PRIMARY KEY (id)
 * );
*/


// URL del sitio dominio ó localhost
   'url' =>'http://www.dominio.com',
// application template for look and feel
    'template' => 'default',

// character encoding
    'charset' => '<xsl:value-of select="$charset"/>',
// use prefix por domain and data (yes = 1 | no = 0) 
    'useprefix' => '1',
// application splash (yes = 0 | no = 1) 
    'splash' => '1',
    
// character encoding
    'charset' => 'utf-8',

// Database date function
    'dbfundate' => 'TO_DATE',
// Database date format  Separator
    'dbdateformatseparator' => '-',
// Database date format
    'dbdateformat' => 'YYYY-MM-DD',
// Database use date format ( yes = 1 | no = 0)
    'dbusedateformat' => '1',
// Database Time Stamp format
    'dbdatetsformat' => 'hh:mi:ss',
// Database use Time Stamp format ( yes = 1 | no = 0 )
    'dbusedatetsformat' => '0',

// library path
    'include_path' => array (
        dirname(__FILE__).'/../.',
        dirname(__FILE__).'/../php/classes',
        dirname(__FILE__).'/../../../lib',
        dirname(__FILE__).'/../../../lib/Smarty-3.1.27/libs',
        dirname(__FILE__).'/../../../lib/DataType',
        dirname(__FILE__).'/../../../lib/PEAR',
        dirname(__FILE__).'/../../../lib/PEAR/MDB2-2.5.0', 
        dirname(__FILE__).'/../../../lib/PEAR/MDB_MetaData',
        dirname(__FILE__).'/../../../lib/adodb5',
        dirname(__FILE__).'/../../../lib/VoipApi',
        dirname(__FILE__).'/../../../lib/mail',
        dirname(__FILE__).'/../../../lib/fpdf',		
		dirname(__FILE__).'/../../../lib/encoder-1.0.0',
		dirname(__FILE__).'/../../../lib/captcha',
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
    'report_dir' => '/report',
    'language_dir' => '/language',
    'docstemplates_dir' => '/web/docstemplates',
    'docstmp_dir' => '/web/docstmp',	


// database  type = Mysql,Oracle,Pgsql,adodb
    'database' => array (
        'name' => '<xsl:value-of select="$catalogo"/>',
        'type' => 'adodb',
        'host' => '<xsl:value-of select="$host"/>',
        'hostport' =>'<xsl:value-of select="$port"/>',
        'user' => '<xsl:value-of select="$user"/>',
        'password' => '<xsl:value-of select="$pass"/>',
        'connection' => 'pdo_<xsl:value-of select="$type_db"/>'  //mysql,oci8,postgres,...
        ),
    );

echo "&lt;pre&gt;";
print_r($Application_config);
echo "&lt;/pre&gt;";

$result = Serializer::save($Application_config, 'application.conf.data');

if (@PEAR::isError($result)) {
    echo "Error creating configuration file";
}

?&gt;
&lt;/body&gt;
&lt;/html&gt;
</xsl:template>
</xsl:stylesheet>