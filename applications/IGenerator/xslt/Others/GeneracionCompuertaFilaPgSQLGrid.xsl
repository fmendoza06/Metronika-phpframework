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
	<!-- **************** -->
	<!-- Abre y cierra el PHP -->
	<xsl:template match = "/">&lt;?php
//Paquete de conexion a bases de datos
include_once("pkdatabases.php");

/**
* @Copyright 2005 Parquesoft
*
* Clase que contiene la compuerta grid para ejecutar las consultas de los listados
* @author Ingravity 0.0.9
* @location Cali - Colombia
*/

class <xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>PgsqlGrid{
	var $consult;
	var $objdb;

	/**
	* @Copyright 2005 Parquesoft
	*
	* Metodo constructor de la clase <xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>PgsqlGrid
	* @author Ingravity 0.0.9
	* @location Cali - Colombia
	*/
	function <xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>PgsqlGrid(){
		$config = &amp;ASAP :: getStaticProperty('Application', 'config');
		$this->objdb = new databases();
		$this->objdb->fncadoconn($config['database']);
	}

	/**
	* @Copyright 2005 Parquesoft
	*
	* Metodo que genera el sql y le adiona el order by
	* @author Ingravity 0.0.9
	* @location Cali - Colombia
	*/
	function fncexecpage($table, $viewfields, $sborder = '', $curr_page = 1,$numRows=20,$cache=true) {
		if (!$table || !$viewfields)
			return null;
		if ($sborder)
			$sborder = "ORDER BY $sborder";
		$sbsql = "SELECT $viewfields FROM $table $sborder";
		return $this->objdb->fncadoPageExecute($sbsql, $curr_page,$numRows,$cache);
	}

	/**
	* @Copyright 2005 Parquesoft
	*
	* Metodo que ejecuta el sql pasdo como parametro
	* @author Ingravity 0.0.9
	* @location Cali - Colombia
	*/
	function fncexecsql($sbsql, $viewfields, $sborder = '', $curr_page = 1, $numRows = 10,$cache=true) {
		if ($sborder)
			$sbsql .= " ORDER BY $sborder";
		$sbsql;
		return $this->objdb->fncadoPageExecute($sbsql, $curr_page, $numRows,$cache);
	}
} //End of Class 	
?&gt;
</xsl:template>
</xsl:stylesheet>
<!-- Stylus Studio meta-information - (c)1998-2003. Sonic Software Corporation. All rights reserved.
<metaInformation>
<scenarios ><scenario default="no" name="Producto" userelativepaths="yes" externalpreview="no" url="metadata_oracle.xml" htmlbaseurl="" outputurl="" processortype="msxml" profilemode="0" urlprofilexml="" commandline="" additionalpath="" additionalclasspath="" postprocessortype="none" postprocesscommandline="" postprocessadditionalpath="" postprocessgeneratedext="" ><parameterValue name="tabla" value="'emp'"/></scenario><scenario default="yes" name="Linea" userelativepaths="yes" externalpreview="no" url="..\..\..\..\..\..\..\Documents and Settings\Owner\My Documents\Documentos\Tesis\Metadatos\dbpruebapgsql.xml" htmlbaseurl="" outputurl="" processortype="internal" profilemode="0" urlprofilexml="" commandline="" additionalpath="" additionalclasspath="" postprocessortype="none" postprocesscommandline="" postprocessadditionalpath="" postprocessgeneratedext="" ><parameterValue name="tabla" value="'pais'"/></scenario></scenarios><MapperInfo srcSchemaPath="" srcSchemaRoot="" srcSchemaPathIsRelative="yes" srcSchemaInterpretAsXML="no" destSchemaPath="" destSchemaRoot="" destSchemaPathIsRelative="yes" destSchemaInterpretAsXML="no"/>
</metaInformation>
-->