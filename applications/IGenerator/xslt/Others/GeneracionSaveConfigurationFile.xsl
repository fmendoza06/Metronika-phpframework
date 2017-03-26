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

<!-- Nombre de la Empresa -->
<xsl:param name = "empresa"/>
<!-- Nombre de la Aplicacion -->
<xsl:param name = "aplicacion"/>

<xsl:template match="/">&lt;html&gt;
&lt;head&gt;
       &lt;title>Save Configuration File&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
&lt;h2&gt;Save Default Configuration File&lt;/h2&gt;
&lt;hr&gt;
&lt;?php

require_once "config.inc.php";
require_once "Data/Serializer.class.php";

$Application_config = array (
    'name' => '<xsl:value-of select="$aplicacion"/>',
    'description' => '<xsl:value-of select="$aplicacion"/> Web Applications',
    'version' => '0.1',
    'app_id' => '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>',
// languaje 
    'language' => 'es',
// library path
    'include_path' => array (
	        dirname(__FILE__).'/../.',
	        dirname(__FILE__).'/../php/classes',
	        dirname(__FILE__).'/../../../lib',
	        dirname(__FILE__).'/../../../lib/Smarty-2.6.0/libs',
	        dirname(__FILE__).'/language',
	        dirname(__FILE__).'/../../../lib/adodb',
	        dirname(__FILE__).'/../../../lib/databases',
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

// database  type = Mysql,Oracle,Pgsql
    'database' => array (
	        'name' => '<xsl:value-of select="$catalogo"/>',
	        'type' => '<xsl:value-of select="$type_db"/>',
	        'host' => '<xsl:value-of select="$host"/>',
	        'user' => '<xsl:value-of select="$user"/>',
	        'password' => '<xsl:value-of select="$pass"/>',
	        'driver' => strtolower('<xsl:value-of select="$type_db"/>'), //For connect by DSN
        ),
    );

echo "&lt;pre&gt;";
print_r($Application_config);
echo "&lt;/pre&gt;";

$result =&amp; Serializer::save($Application_config, 'application.conf.data');

if (PEAR::isError($result)) {
    echo "Error creating configuration file";
}

?&gt;
&lt;/body&gt;
&lt;/html&gt;
</xsl:template>
</xsl:stylesheet><!-- Stylus Studio meta-information - (c)1998-2003. Sonic Software Corporation. All rights reserved.
<metaInformation>
<scenarios ><scenario default="yes" name="Scenario1" userelativepaths="yes" externalpreview="no" url="..\..\..\..\..\..\..\Documents and Settings\Owner\My Documents\Documentos\Tesis\Metadatos\dbpruebamysql.xml" htmlbaseurl="" outputurl="" processortype="msxml4" profilemode="0" urlprofilexml="" commandline="" additionalpath="" additionalclasspath="" postprocessortype="none" postprocesscommandline="" postprocessadditionalpath="" postprocessgeneratedext="" ><parameterValue name="pass" value="'copernico'"/><parameterValue name="host" value="'localhost'"/><parameterValue name="user" value="'Hemerson'"/><parameterValue name="type_db" value="'Mysql'"/><parameterValue name="catalogo" value="'wisdb'"/></scenario></scenarios><MapperInfo srcSchemaPath="" srcSchemaRoot="" srcSchemaPathIsRelative="yes" srcSchemaInterpretAsXML="no" destSchemaPath="" destSchemaRoot="" destSchemaPathIsRelative="yes" destSchemaInterpretAsXML="no"/>
</metaInformation>
-->