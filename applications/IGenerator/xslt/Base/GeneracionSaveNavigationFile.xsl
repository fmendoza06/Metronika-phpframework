<?xml version='1.0'?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<!-- El modo al que transformará el XSL --> 
<xsl:output method="text"/> 

<!-- Nombre de la Empresa -->
<xsl:param name = "empresa"/>
<!-- Nombre de la Aplicacion -->
<xsl:param name = "aplicacion"/>

<xsl:template match="database">
&lt;html&gt;
&lt;head&gt;
       &lt;title&gt;Save Navigation Configuration File&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
&lt;h2&gt;Save Navigation Configuration File&lt;/h2&gt;
&lt;hr&gt;
&lt;?php


//Esto es para independizar librerias del include_path de PHP
//Se afecta el Application.class y el Serializer.php
global $saveconfiguration;
$saveconfiguration="S";

require_once "config.inc.php";
require_once "Data/Serializer.class.php";

$Navigation_config = array (
    'default_action' =&gt; 'default',
    'error_view' =&gt; 'error',
    'login_view' =&gt; 'Login',
    'commands' =&gt; array (
        'default' =&gt; array(
            'class' =&gt; 'DefaultCommand',
			'validated' =&gt; 'false',
            'views' =&gt; array (
                'success' =&gt; array(
					'view' =&gt; '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>Form_Menu',
					'redirect' =&gt; 0
				    )
				)
			),<xsl:apply-templates select="table" mode="ComandosTabla"/>
 	    ),
	'views' => array(
        '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>Form_Menu'=> array (
            'template' => '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>Form_Menu.tpl'
            ),<xsl:apply-templates select="table" mode="VistasTabla"/>
        )
    );

echo "&lt;pre&gt;";
print_r($Navigation_config);
echo "&lt;/pre&gt;";

$result = Serializer::save($Navigation_config, 'web.conf.data');

if (@PEAR::isError($result)) {
    echo "Error creating configuration file";
}

?&gt;
&lt;/body&gt;
&lt;/html&gt;
</xsl:template>

<xsl:template match="table" mode="ComandosTabla">
           '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdDefault<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>' => array(
                'class' => '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdDefault<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>',
				'validated' => 'false',
				'desc' => 'Cargar Forma <xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>',
                'views' => array (
                    'success' => array(
                        'view' => '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>Form_<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>',
                        'redirect' => 0
                        )
                      )
                ),
            '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdAdd<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>' => array(
                'class' => '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdAdd<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>',
				'validated' => 'false',
				'desc' => 'Adicionar <xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>',
                'views' => array (
                    'success' => array(
                       'view' => '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>Form_<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>',
                       'redirect' => 0
                       ),
                    'fail' => array(
                       'view' => '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>Form_<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>',
                       'redirect' => 0
                       )
                    )
			    ),
            '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdUpdate<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>' => array(
                'class' => '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdUpdate<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>',
				'validated' => 'false',
				'desc' => 'Modificar <xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>',
                'views' => array (
                    'success' => array(
                       'view' => '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>Form_<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>',
                       'redirect' => 0
                       ),
                    'fail' => array(
                       'view' => '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>Form_<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>',
                       'redirect' => 0
                       )
                    )
                ),
            '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdDelete<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>' => array(
                'class' => '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdDelete<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>',
				'validated' => 'false',
				'desc' => 'Eliminar <xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>',
                'views' => array (
                    'success' => array(
                       'view' => '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>Form_<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>',
                       'redirect' => 0
                       ),
                    'fail' => array(
                       'view' => '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>Form_<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>',
                       'redirect' => 0
                       )
                    )
                ),
           '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdClear<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>' => array(
                'class' => '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdClear<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>',
				'validated' => 'false',
				'desc' => 'Limpiar formulario <xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>',
                'views' => array (
                    'success' => array(
                        'view' => '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>Form_<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>',
                        'redirect' => 0
                        )
                      )
                ),
            '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdShowList<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>' => array(
                'class' => '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdShowList<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>',
				'validated' => 'false',
				'desc' => 'Consultar <xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>',
                'views' => array (
                    'success' => array(
                       'view' => '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>Form_<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>_Consult',
                       'redirect' => 0
                       )
                    )
                ),
            '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdShowById<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>' => array(
                'class' => '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdShowById<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>',
				'validated' => 'false',
				'desc' => 'Seleccionar <xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>',
                'views' => array (
                    'success' => array(
                       'view' => '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>Form_<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>',
                       'redirect' => 0
                       )
                    )
                ),
            '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdCancelShowList<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>' => array(
                'class' => '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdCancelShowList<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>',
				'validated' => 'false',
				'desc' => 'Cancelar Seleccion <xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>',
                'views' => array (
                    'success' => array(
                       'view' => '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>Form_<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>',
                       'redirect' => 0
                       )
                    )
                )<xsl:if test="position() != last()">,</xsl:if>
</xsl:template>

<xsl:template match="table" mode="VistasTabla">
        '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>Form_<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>' => array (
            'template' => '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>Form_<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>.tpl'
            ),
        '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>Form_<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>_Consult' => array (
            'template' => '<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>Form_<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>_Consult.tpl'
            )<xsl:if test="position() != last()">,</xsl:if>
</xsl:template>

<!-- The proper case transformation. The presented solution first 
     translates the entire string to lower case, and after that it 
	 translate only the first letter of every word to upper case  -->

	<xsl:template name="convertpropercase">
		<xsl:param name="toconvert"/>

		<xsl:if test="string-length($toconvert) &gt; 0">
			<xsl:variable name="f" select="substring($toconvert, 1, 1)"/>
			<xsl:variable name="s" select="substring($toconvert, 2)"/>

			<xsl:call-template name="convertcase">
				<xsl:with-param name="toconvert" select="$f"/>
				<xsl:with-param name="conversion">upper</xsl:with-param>
			</xsl:call-template>

			<xsl:choose>
				<xsl:when test="contains($s,' ')">
					<xsl:value-of select="substring-before($s,&quot; &quot;)"/>&#160;

					<xsl:call-template name="convertpropercase">
						<xsl:with-param name="toconvert" select="substring-after($s,&quot; &quot;)"/>
					</xsl:call-template>
				</xsl:when>
				<xsl:otherwise>
					<xsl:value-of select="$s"/>
				</xsl:otherwise>
			</xsl:choose>
		</xsl:if>
	</xsl:template>

	<xsl:template name="convertcase">
 	 <xsl:param name="toconvert"/>
	 <xsl:param name="conversion"/>
     <xsl:variable name="letrasMin">abcdefghijklmnopqrstuvwxyz</xsl:variable>
	 <xsl:variable name="letrasMay">ABCDEFGHIJKLMNOPQRSTUVWXYZ</xsl:variable>
	
		<xsl:choose>
			<xsl:when test="$conversion=&quot;lower&quot;">
				<xsl:value-of select="translate($toconvert,$letrasMay,$letrasMin)"/>
			</xsl:when>
			<xsl:when test="$conversion=&quot;upper&quot;">
				<xsl:value-of select="translate($toconvert,$letrasMin,$letrasMay)"/>
			</xsl:when>
			<xsl:when test="$conversion=&quot;proper&quot;">
				<xsl:call-template name="convertpropercase">
					<xsl:with-param name="toconvert">
						<xsl:value-of select="translate($toconvert,$letrasMay,$letrasMin)"/>
					</xsl:with-param>
				</xsl:call-template>
			</xsl:when>
			<xsl:otherwise>
				<xsl:value-of select="$toconvert"/>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

</xsl:stylesheet><!-- Stylus Studio meta-information - (c)1998-2003. Sonic Software Corporation. All rights reserved.
<metaInformation>
<scenarios ><scenario default="yes" name="Scenario1" userelativepaths="yes" externalpreview="no" url="..\..\..\..\..\..\..\Documents and Settings\Owner\My Documents\Documentos\Tesis\Metadatos\dbpruebamysql.xml" htmlbaseurl="" outputurl="" processortype="msxml4" profilemode="0" urlprofilexml="" commandline="" additionalpath="" additionalclasspath="" postprocessortype="none" postprocesscommandline="" postprocessadditionalpath="" postprocessgeneratedext="" ><parameterValue name="pass" value="'copernico'"/><parameterValue name="host" value="'localhost'"/><parameterValue name="user" value="'Hemerson'"/><parameterValue name="type_db" value="'Mysql'"/><parameterValue name="catalogo" value="'wisdb'"/></scenario></scenarios><MapperInfo srcSchemaPath="" srcSchemaRoot="" srcSchemaPathIsRelative="yes" srcSchemaInterpretAsXML="no" destSchemaPath="" destSchemaRoot="" destSchemaPathIsRelative="yes" destSchemaInterpretAsXML="no"/>
</metaInformation>
-->