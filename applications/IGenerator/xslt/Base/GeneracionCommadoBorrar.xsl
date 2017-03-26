<?xml version='1.0'?>
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
 * Constante para el manejo de errores
 */
define("ERROR_CAMPO_OBLIGATORIO", 0);

/**
 * Comando para eliminar un registro de la tabla: <xsl:value-of select="$tabla"/>
 * @author SpyroFrameWork
 * @copyright Spyro Solutions
 */
class <xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdDelete<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template> {
<xsl:apply-templates select="declaration" />
}
</xsl:template>


<xsl:template match="declaration">
	/**
	 * @return boolean 
	 */
	function execute()
    {
		extract($_REQUEST);
        
		if(<xsl:apply-templates select="primary_key"/>){
			$<xsl:value-of select="ancestor::table/name" />_manager = Application::getDomainController('<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>Manager'); 
			$message = $<xsl:value-of select="ancestor::table/name" />_manager->delete<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>(<xsl:apply-templates mode="CamposLlavesTabla" select="primary_key/field"/>);  
			WebRequest::setProperty('cod_message', $message);
			return "success";         
		}else{
			WebRequest::setProperty('cod_message',$message = ERROR_CAMPO_OBLIGATORIO); 
			return "fail";
		}
	}
</xsl:template>


<xsl:template match="primary_key" >
<xsl:apply-templates select="field"/>
</xsl:template>

<xsl:template match="field">
<xsl:if test="position() = 1">($<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name" /> != NULL) &amp;&amp; ($<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name" /> != "")</xsl:if>
<xsl:if test="position() != 1"> &amp;&amp; ($<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name" /> != NULL) &amp;&amp; ($<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name" /> != "")</xsl:if>
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

	<xsl:template mode="CamposLlavesTabla" match="primary_key/field">
       <xsl:if test="position() = 1">$<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/></xsl:if>
	   <xsl:if test="position() != 1">,$<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/></xsl:if>
	</xsl:template>

</xsl:stylesheet><!-- Stylus Studio meta-information - (c)1998-2003. Sonic Software Corporation. All rights reserved.
<metaInformation>
<scenarios ><scenario default="yes" name="Scenario1" userelativepaths="yes" externalpreview="no" url="file://d:\My Documents\Tesis\Metadatos\dbpruebamysql2.xml" htmlbaseurl="" outputurl="" processortype="msxml4" profilemode="0" urlprofilexml="" commandline="" additionalpath="" additionalclasspath="" postprocessortype="none" postprocesscommandline="" postprocessadditionalpath="" postprocessgeneratedext="" ><parameterValue name="tabla" value="'contrato_venta'"/></scenario></scenarios><MapperInfo srcSchemaPath="" srcSchemaRoot="" srcSchemaPathIsRelative="yes" srcSchemaInterpretAsXML="no" destSchemaPath="" destSchemaRoot="" destSchemaPathIsRelative="yes" destSchemaInterpretAsXML="no"/>
</metaInformation>
-->