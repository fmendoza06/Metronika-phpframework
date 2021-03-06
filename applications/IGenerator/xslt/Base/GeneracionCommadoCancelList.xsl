﻿<?xml version='1.0'?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<!-- El modo al que transformará el XSL --> 
<xsl:output method="text"/> 
<!-- Paramatro que contiene el nombre de la tabla -->
<xsl:param name="tabla"/>
<!-- Nombre de la Empresa -->
<xsl:param name = "empresa"/>
<!-- Nombre de la Aplicacion -->
<xsl:param name = "aplicacion"/>

<!-- Abre y cierra el documento PHP -->    
<xsl:template match="/">&lt;?php
/**
 * @package <xsl:value-of select="$aplicacion"/>
 * @subpackage Commands
 */
<xsl:apply-templates/>
?&gt;	
</xsl:template>

<!-- selecciona la tabla que corresponda al parametro 'tabla' -->      
<xsl:template match="database">  
    <xsl:apply-templates select="table[name=$tabla]" />
</xsl:template>

<!-- Abre y cierra la clase -->
<xsl:template match="table">
require_once "Web/WebRequest.class.php";
/**
 * Comando para cancelar la lista de la tabla: <xsl:value-of select="$tabla"/>
 * @author SpyroFrameWork
 * @copyright Spyro Solutions
 */
class <xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdCancelShowList<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template> {
<xsl:apply-templates select="declaration" />
}
</xsl:template>

<!-- Abre y cierra la el metodo execute -->
<xsl:template match="declaration">
	/**
	 * @return boolean 
	 */
	function execute()
    {
        <xsl:apply-templates mode="LlenarRequestConSession" select="field"/>
		<xsl:text>
	    </xsl:text>
        <xsl:apply-templates mode="BorrarSession" select="field"/>
		
        return "success";  
    }
</xsl:template>

<!-- Optiene todos los field de la tabla, por cada field genera un codigo sacar el valor de la SESSION y guardarlo en el REQUEST -->
<xsl:template mode="LlenarRequestConSession" match="field">
        $_REQUEST["<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>"] = WebSession::getProperty("<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>");</xsl:template> 

<!-- Optiene todos los field de la tabla, por cada field genera un codigo para borrarlo de la session-->
<xsl:template mode="BorrarSession" match="field">
        WebSession::unsetProperty("<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>");</xsl:template> 

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
<scenarios ><scenario default="yes" name="Scenario1" userelativepaths="yes" externalpreview="no" url="file://d:\My Documents\Tesis\Metadatos\dbpruebamysql2.xml" htmlbaseurl="" outputurl="" processortype="msxml4" profilemode="0" urlprofilexml="" commandline="" additionalpath="" additionalclasspath="" postprocessortype="none" postprocesscommandline="" postprocessadditionalpath="" postprocessgeneratedext="" ><parameterValue name="tabla" value="'contrato_venta'"/></scenario></scenarios><MapperInfo srcSchemaPath="" srcSchemaRoot="" srcSchemaPathIsRelative="yes" srcSchemaInterpretAsXML="no" destSchemaPath="" destSchemaRoot="" destSchemaPathIsRelative="yes" destSchemaInterpretAsXML="no"/>
</metaInformation>
-->