<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<!-- El modo al que transformará el XSL -->  
	<xsl:output method = "text"/>
	<!-- Nombre de la Tabla -->  
	<xsl:param name = "tabla"/>
	<!-- Nombre de la Empresa -->
	<xsl:param name = "empresa"/>
	<!-- Nombre de la Aplicacion -->
	<xsl:param name = "aplicacion"/>
	<!-- Abre y cierra el documento PHP -->    
	<xsl:template match="/">&lt;?php<xsl:apply-templates/>
?&gt;	
 	</xsl:template>

	<!-- selecciona la tabla que corresponda al parametro 'tabla' -->      
 	<xsl:template match="database">  
    	<xsl:apply-templates select="table[name=$tabla]" />
 	</xsl:template>

<!-- Abre y cierra la clase -->
<xsl:template match="table">		
/**
 * @package <xsl:value-of select="$aplicacion"/>
 * @subpackage Domain
 * @copyright Spyro Solutions
 */

/**
 * Constantes para el manejo de errores
 */
define("ERROR_DATO_EXISTE", 101);
define("ERROR_DATO_NO_EXISTE", 102);
define("EXITO_OPERACION_REALIZADA", 103);
define("ERROR_OPERACION_NO_REALIZADA", 105);
   				
/**
 *
 * Clase manager de la tabla: <xsl:value-of select="$tabla"/>
 * @author SpyroFrameWork
 * @copyright Spyro Solutions
 */
class <xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/><xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>Manager
{
    /**
    * objeto para la instancia de la compuerta
    */
    var $gateway;
    <xsl:apply-templates select="declaration"/>
</xsl:template>
<xsl:template match="declaration">
    /**
    * Metodo constructor de la clase
    * @author SpyroFrameWork 
    */
    function <xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/><xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>Manager()
    {
  	  $this->gateway = Application::getDataGateway("<xsl:value-of select="ancestor::table/name"/>");
    }

    /**
    * Metodo para adicionar datos a la tabla: <xsl:value-of select="$tabla"/>
    * @author SpyroFrameWork
    * @return integer
    */
    function add<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>(<xsl:apply-templates mode="CamposTabla" select="field"/>)
    {
    	if($this->gateway->exist<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>(<xsl:apply-templates mode="CamposLlavesTabla" select="primary_key/field"/>) == 0){
    	        <xsl:apply-templates mode="CamposLlavesTabla" select="primary_key/field"/> = $this->gateway->maxId();
        	$result = $this->gateway->add<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>(<xsl:apply-templates mode="CamposTabla" select="field"/>);
	  	if($result){
    		 	    $this->UnsetRequest();
             	            return EXITO_OPERACION_REALIZADA;
          	}
                else
                {
             	   return ERROR_OPERACION_NO_REALIZADA;
          	}
      	}
        else
        {       return $this->update<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>(<xsl:apply-templates mode="CamposTabla" select="field"/>);
          	//return ERROR_DATO_EXISTE;
      	}
    }

    /**
    * Metodo para actualizar datos de la tabla: <xsl:value-of select="$tabla"/>
    * @author SpyroFrameWork
    * @return integer
    */
    function update<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>(<xsl:apply-templates mode="CamposTabla" select="field"/>)
    {
    	if($this->gateway->exist<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>(<xsl:apply-templates mode="CamposLlavesTabla" select="primary_key/field"/>) == 1){
          	$result = $this->gateway->update<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>(<xsl:apply-templates mode="CamposTabla" select="field"/>);
		if($result){
    		 	    $this->UnsetRequest();
             	            return EXITO_OPERACION_REALIZADA;
          	}
                else
                {
             	   return ERROR_OPERACION_NO_REALIZADA;
          	}	
      	}
        else
        {
           return ERROR_DATO_NO_EXISTE;
      	}
    }
  
    /**
    * Metodo para eliminar datos de la tabla: <xsl:value-of select="$tabla"/>
    * @author SpyroFrameWork
    * @return integer
    */
    function delete<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>(<xsl:apply-templates mode="CamposLlavesTabla" select="primary_key/field"/>)
    {
    	if($this->gateway->exist<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>(<xsl:apply-templates mode="CamposLlavesTabla" select="primary_key/field"/>) == 1){
        	$result = $this->gateway->delete<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>(<xsl:apply-templates mode="CamposLlavesTabla" select="primary_key/field"/>);
		if($result){
    		 	     $this->UnsetRequest();
             	             return EXITO_OPERACION_REALIZADA;
          	}
                else
                {
             	     return ERROR_OPERACION_NO_REALIZADA;
          	}
      	}
        else
        {
           return ERROR_DATO_NO_EXISTE;
      	}
    }
  
    /**
    * Metodo para consultar los datos por la llave primaria de la tabla: <xsl:value-of select="$tabla"/>
    * @author SpyroFrameWork
    * @return array
    */
    function getById<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>(<xsl:apply-templates mode="CamposLlavesTabla" select="primary_key/field"/>)
    {
	$data_<xsl:value-of select="ancestor::table/name"/> = $this->gateway->getById<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>(<xsl:apply-templates mode="CamposLlavesTabla" select="primary_key/field"/>);
      	return $data_<xsl:value-of select="ancestor::table/name"/>;
    }

    /**
    * Metodo para consultar todos los datos de la tabla: <xsl:value-of select="$tabla"/>
    * @author SpyroFrameWork
    * @return array
    */
    function getAll<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>()
    {
	$data_<xsl:value-of select="ancestor::table/name"/> = $this->gateway->getAll<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>();
      	return $data_<xsl:value-of select="ancestor::table/name"/>;

    }
<!--   <xsl:apply-templates mode="DETERMINA_LLAVES_FORANEAS" select="ancestor::table/declaration/foreign_key"/>   -->
    /**
    * Metodo para limpiar los datos del _REQUEST de la tabla: <xsl:value-of select="$tabla"/>
    * @author SpyroFrameWork
    * @return void
    */
    function UnsetRequest()
    {
     <xsl:apply-templates mode="BorrarRequest" select="field"/>
    }
}
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
       <xsl:if test="position() = 1">$<xsl:value-of select="name"/></xsl:if>
	   <xsl:if test="position() != 1">,$<xsl:value-of select="name"/></xsl:if>
	</xsl:template>
    
	<!-- Optiene todas la llaves de una tabla, le antepone el simbolo '$' y le pospone el simbolo ',' -->
	<xsl:template mode="CamposLlavesTabla" match="primary_key/field">
       <xsl:if test="position() = 1">$<xsl:value-of select="name"/></xsl:if>
	   <xsl:if test="position() != 1">,$<xsl:value-of select="name"/></xsl:if>
	</xsl:template>

<!--
    <xsl:template mode="DETERMINA_LLAVES_FORANEAS" match="declaration/foreign_key">  
    function getBy<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>(<xsl:apply-templates mode="LLAVES_FORANEAS_PARAMETROS" select="local_table/field"/>)
    {
     //$this->gateway->
    }
   </xsl:template>
-->

  <!-- Trae todas los Campos del la tabla que pertenecen al Foreign Key para los parametros de la func. getByfk()-->
  <xsl:template mode="LLAVES_FORANEAS_PARAMETROS" match="local_table/field">
      <xsl:if test="ancestor::table/declaration/foreign_key/name != name">
	  <xsl:if test="count(ancestor::declaration/foreign_key) > 0 ">
           <xsl:if test="position() != 1">,$<xsl:value-of select="name"/></xsl:if>
	       <xsl:if test="position() = 1">$<xsl:value-of select="name"/></xsl:if>
      </xsl:if>
      </xsl:if>
  </xsl:template>

  <xsl:template mode="BorrarRequest" match="field">
     	unset($_REQUEST["<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>"]);</xsl:template> 


</xsl:stylesheet><!-- Stylus Studio meta-information - (c)1998-2003. Sonic Software Corporation. All rights reserved.
<metaInformation>
<scenarios ><scenario default="yes" name="producto" userelativepaths="yes" externalpreview="no" url="..\..\..\..\..\..\..\My Documents\Tesis\Metadatos\dbpruebamysql2.xml" htmlbaseurl="" outputurl="" processortype="internal" profilemode="0" urlprofilexml="" commandline="" additionalpath="" additionalclasspath="" postprocessortype="none" postprocesscommandline="" postprocessadditionalpath="" postprocessgeneratedext="" ><parameterValue name="tabla" value="'contrato_venta'"/></scenario><scenario default="no" name="cliente" userelativepaths="yes" externalpreview="no" url="metadata.xml" htmlbaseurl="" outputurl="" processortype="msxml4" profilemode="0" urlprofilexml="" commandline="" additionalpath="" additionalclasspath="" postprocessortype="none" postprocesscommandline="" postprocessadditionalpath="" postprocessgeneratedext="" ><parameterValue name="tabla" value="'cliente'"/><parameterValue name="servidor" value="'host'"/></scenario></scenarios><MapperInfo srcSchemaPath="" srcSchemaRoot="" srcSchemaPathIsRelative="yes" srcSchemaInterpretAsXML="no" destSchemaPath="" destSchemaRoot="" destSchemaPathIsRelative="yes" destSchemaInterpretAsXML="no"/>
</metaInformation>
-->