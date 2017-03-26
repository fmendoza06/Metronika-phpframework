<?xml version="1.0" encoding="UTF-8"?>
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
require_once("Data_type.class.php");

/**
 * Constantes para el manejo de errores
 */
define("ERROR_CAMPO_OBLIGATORIO", 0);
define("ERROR_ENTRADA_NO_VALIDA", 4);

/**
 * Comando para actualizar un registro de la tabla: <xsl:value-of select="$tabla"/>
 * @author SpyroFrameWork
 * @copyright Spyro Solutions
 */
class <xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdUpdate<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template> {
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
		extract($_REQUEST);

		//valida que los campos obligatorios no esten vacios
		if(<xsl:apply-templates mode="fields_not_null" select="ancestor-or-self::declaration"/>){
			$obj_datatype = new Data_type();
			//Hace la validacion de formato (Caracteres no permitidos) de la llave primaria<xsl:apply-templates mode="fields_primary" select="primary_key"/>
			//Hace la validacion de campos numericos y formateo de campos cadena<xsl:apply-templates mode="fields_null" select="field"/>
			$<xsl:value-of select="ancestor::table/name" />_manager = Application::getDomainController('<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>Manager'); 
			$message = $<xsl:value-of select="ancestor::table/name" />_manager->update<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>(<xsl:apply-templates mode="CamposTabla" select="field"/>); 
			WebRequest::setProperty('cod_message', $message);
			return "success";       
		}else{
			WebRequest::setProperty('cod_message',$message = ERROR_CAMPO_OBLIGATORIO);
			return "fail";
		}
	}</xsl:template>
<!-- 
	hace la validacion de formato de las llaves primarias,
	que sean que cadena
-->
<xsl:template mode="fields_primary" match="primary_key">
			if($obj_datatype->formatPrimaryKey($<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="field/name"/>) == false){
				WebRequest::setProperty('cod_message',$message = ERROR_ENTRADA_NO_VALIDA);
				return "fail";
			}
</xsl:template>

<!-- 
	Recorre todos los campos de la tabla, imprime una condiciona para los 'field'
	nulos y que son int int,tinyint,smallint,mediumint,bigint,float,double,decimal 
-->
<xsl:template mode="fields_null" match="field">
	<xsl:if test="null = 'null' and (type = 'int' or type = 'tinyint' or type = 'smallint' or type = 'mediumint' or type = 'bigint' or type = 'float' or type = 'float4' or type = 'float8' or type = 'double' or type = 'decimal' or type = 'int2' or type = 'int4' or type = 'int8' or type = 'number' or type = 'numeric')">
            if($<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/> == ""){
               $<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/> = "NULL";
            }
	</xsl:if>
	<xsl:if test="(type = 'int' or type = 'tinyint' or type = 'smallint' or type = 'mediumint' or type = 'bigint' or type = 'int2' or type = 'int4' or type = 'int8' or type = 'number' or type = 'numeric')">
			if($obj_datatype->isInteger($<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>) == false){
				WebRequest::setProperty('cod_message',$message = ERROR_ENTRADA_NO_VALIDA);
				return "fail";
			}
	</xsl:if>	
	<xsl:if test="null = 'null' and (type = 'varchar' or type = 'text')">
			$<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/> = $obj_datatype->formatString($<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>);
	</xsl:if>	
</xsl:template>

<!-- 
  	Recorre todos los fields de la tabla, por cada no nulo de la tabla genera dos 
	condiciones. Ejemplo: ($NombreTabla__NombreCampo != NULL) && ($NombreTabla__NombreCampo != "")
 -->
<xsl:template mode="fields_not_null" match="declaration">
   <xsl:variable name="cadena"> <!-- toma la cadena de los fields con && -->
	 <xsl:for-each select="field">
  		<xsl:if test="null = 'not null'">($<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name" /> != NULL) &amp;&amp; ($<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name" /> != "") &amp;&amp; </xsl:if>
	 </xsl:for-each>
   </xsl:variable>
	<!-- toma el tamaño de la cadena -->
	<xsl:variable name="long">
      <xsl:value-of select="string-length($cadena)-4"/>
    </xsl:variable>
	<!-- quita la coma al final de la cadena-->
    <xsl:value-of select="substring($cadena,1,$long)"/>
</xsl:template>

<!-- Optiene todos los field de la tabla, le antepone el simbolo '$' y le pospone el simbolo ',' --> 
<xsl:template mode="CamposTabla" match="field">
   <xsl:if test="position() = 1">$<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/></xsl:if>
   <xsl:if test="position() != 1">,$<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/></xsl:if>
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
    
	<!-- Optiene todos los field de la tabla, le antepone el simbolo '$' y le pospone el simbolo ',' --> 
	<xsl:template mode="CamposTabla" match="field">
       <xsl:if test="position() = 1">$<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/></xsl:if>
	   <xsl:if test="position() != 1">,$<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/></xsl:if>
	</xsl:template>


<xsl:template match="NewTemplate">
	
</xsl:template>
</xsl:stylesheet><!-- Stylus Studio meta-information - (c)1998-2003. Sonic Software Corporation. All rights reserved.
<metaInformation>
<scenarios ><scenario default="yes" name="Scenario1" userelativepaths="yes" externalpreview="no" url="file://d:\My Documents\Tesis\Metadatos\dbpruebamysql2.xml" htmlbaseurl="" outputurl="" processortype="internal" profilemode="0" urlprofilexml="" commandline="" additionalpath="" additionalclasspath="" postprocessortype="none" postprocesscommandline="" postprocessadditionalpath="" postprocessgeneratedext="" ><parameterValue name="tabla" value="'contrato_venta'"/></scenario></scenarios><MapperInfo srcSchemaPath="" srcSchemaRoot="" srcSchemaPathIsRelative="yes" srcSchemaInterpretAsXML="no" destSchemaPath="" destSchemaRoot="" destSchemaPathIsRelative="yes" destSchemaInterpretAsXML="no"/>
</metaInformation>
-->