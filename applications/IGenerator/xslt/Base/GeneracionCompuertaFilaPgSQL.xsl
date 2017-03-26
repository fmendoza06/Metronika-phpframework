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
	<xsl:template match = "/">&lt;?php<xsl:apply-templates/>
?&gt;</xsl:template>
	<!-- Busca y se ubica en el database del metadato -->
	<xsl:template match="database">
		<xsl:apply-templates select="table[name=$tabla]"/>
	</xsl:template>

<xsl:template match="table">
/**
 * @package <xsl:value-of select="$aplicacion"/>
 * @subpackage Data
 */
		
/**
 * Clase que contiene las compuertas basica de la tabla: <xsl:value-of select="$tabla"/>
 * @author SpyroFrameWork
 * @copyright Spyro Solutions 2005
 */
class <xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>Pgsql<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>
{
     /**
     * conexion de bases de datos.
     */
  	var $connection;
	/**
     * recurso de base de datos
     */
  	var $consult;
		<xsl:apply-templates select="declaration"/>
</xsl:template>

<xsl:template match="declaration">
	/**
	* Metodo constructor de la clase
	* @author SpyroFrameWork
	*/
  	function <xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>Pgsql<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>()
  	{
    	$this->connection = Application::getDatabaseConnection();
  	}

	/**
	* Metodo para validar si un registro existe en la tabla: <xsl:value-of select="$tabla"/>
	* @author SpyroFrameWork
	* @return int
	*/  
  	function exist<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>(<xsl:apply-templates mode="LLAVES_PRIMARY_PARAMETROS" select="primary_key/field"/>)
  	{
	    $sql = "SELECT * FROM <xsl:value-of select="ancestor::table/name"/> WHERE <xsl:apply-templates mode="LLAVES_PRIMARY_WHERE" select="primary_key/field"/>";
	    $this->consult = pg_query($this->connection,$sql);
	    return pg_num_rows($this->consult);
  	}
 
 	/**
	* Metodo para adicionar un registro a la tabla: <xsl:value-of select="$tabla"/>
	* @author SpyroFrameWork
	* @return boolean
	*/ 
  	function add<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>(<xsl:apply-templates mode="TODOS_LOS_CAMPOS" select="field"/>)
  	{   
	    $sql="INSERT INTO <xsl:value-of select="ancestor::table/name"/> VALUES(<xsl:apply-templates mode="PARAMETROS_INSERT" select="field"/>)";
	    $this->consult = pg_query($this->connection,$sql);
		return $this->consult;  	
	}
  <xsl:apply-templates mode="VALIDAR_FUNCION_UPDATE" select="field"/>
	/**
 	* Metodo para eliminar un registro de la tabla: <xsl:value-of select="$tabla"/>
	* @author SpyroFrameWork
	* @return boolean
	*/
  	function delete<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>(<xsl:apply-templates mode="LLAVES_PRIMARY_PARAMETROS" select="primary_key/field"/>)
  	{
	    $sql="DELETE FROM <xsl:value-of select="ancestor::table/name"/> WHERE <xsl:apply-templates mode="LLAVES_PRIMARY_WHERE" select="primary_key/field"/>";
	    $this->consult = @pg_query($this->connection,$sql);
		return $this->consult;
  	}

	/**
	* Metodo para consultar por campo(s) clave(s) y obtener un registro de la tabla: <xsl:value-of select="$tabla"/>
	* @author SpyroFrameWork
	* @return array
	*/
  	function getById<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>(<xsl:apply-templates mode="LLAVES_PRIMARY_PARAMETROS" select="primary_key/field"/>)
  	{
	    $sql="SELECT * FROM <xsl:value-of select="ancestor::table/name"/> WHERE <xsl:apply-templates mode="LLAVES_PRIMARY_WHERE" select="primary_key/field"/>";
	    $this->consult = pg_query($this->connection,$sql);
	    return pg_fetch_all($this->consult);
  	}

	/**
	* Metodo para consultar todos los registros de la tabla: <xsl:value-of select="$tabla"/>
	* @author SpyroFrameWork
	* @return array
	*/
  	function getAll<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>()
  	{
	    $sql="SELECT * FROM <xsl:value-of select="ancestor::table/name"/>";
	    $this->consult = pg_query($this->connection,$sql);
	    return pg_fetch_all($this->consult);
  	}
  <xsl:apply-templates mode="DETERMINA_LLAVES_FORANEAS" select="ancestor::table/declaration/foreign_key"/>
  <xsl:apply-templates mode="FUNCIONES_GET" select="ancestor::table/declaration/field"/>
} //End of Class <xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>
</xsl:template>
<!-- ************************************************************************************************************ -->
<!-- *** FUNCIONES GET ******************************************************************************************* -->
<xsl:template mode="FUNCIONES_GET" match="field">
	/**
	* Metodo para consultar por el(los) campo(s) llave(s) y obtener la columna <xsl:value-of select="name"/> de la tabla: <xsl:value-of select="$tabla"/>
	* @author SpyroFrameWork
	* @return array
	*/
  	function get<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>(<xsl:apply-templates mode="LLAVES_PRIMARY_PARAMETROS" select="ancestor::declaration/primary_key/field"/>)
  	{
	    $sql="SELECT <xsl:value-of select="name"/> FROM <xsl:value-of select="ancestor::table/name"/> WHERE <xsl:apply-templates mode="LLAVES_PRIMARY_WHERE" select="ancestor::declaration/primary_key/field"/>";
	    $this->consult = pg_query($this->connection,$sql);
	    return pg_fetch_all($this->consult);
  	}  
</xsl:template>
<!-- ///// -->

<!-- ************************************************************************************************************ -->
<!-- *** FOREING  KEY ******************************************************************************************* -->
<!-- Arma la Función de Foreign Key si la tabla tiene Llaves Foraneas --> 
<xsl:template mode="DETERMINA_LLAVES_FORANEAS" match="declaration/foreign_key">  
 <xsl:if test="count(ancestor::declaration/foreign_key) > 0 ">
  <xsl:apply-templates select="ancestor::local_table/field"/>
	/**
	* Metodo para consultar por la llave foranea <xsl:value-of select="name"/> y obtener todas las columnas de la tabla: <xsl:value-of select="$tabla"/>
	* @author SpyroFrameWork
	* @return array
	*/
  	function getBy<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>(<xsl:apply-templates mode="LLAVES_FORANEAS_PARAMETROS" select="local_table/field"/>)
  	{
	   $sql="SELECT * FROM <xsl:value-of select="ancestor::table/name"/> WHERE <xsl:apply-templates mode="LLAVES_FORANEAS_WHERE" select="local_table/field"/>";
	   $this->consult = pg_query($this->connection,$sql);
	   return pg_fetch_all($this->consult);
  	}
</xsl:if>
</xsl:template>
  <!-- Trae todas los Campos del la tabla que pertenecen al Foreign Key para los parametros de la func. getByfk(__,__,__)-->
  <xsl:template mode="LLAVES_FORANEAS_PARAMETROS" match="field">
      <xsl:if test="ancestor::table/declaration/foreign_key/name != name">
	  <xsl:if test="count(ancestor::declaration/foreign_key) > 0 ">
           <xsl:if test="position() != 1">,$<xsl:value-of select="name"/></xsl:if>
	       <xsl:if test="position() = 1">$<xsl:value-of select="name"/></xsl:if>
      </xsl:if>
      </xsl:if>
  </xsl:template>
<!-- Trae todos los Foreign Key para el WHERE de las funciones FK -->
  <xsl:template mode="LLAVES_FORANEAS_WHERE" match="field">
	<xsl:if test="ancestor::declaration/field/name = name">
		<xsl:if test="position() = 1"> 
		      <xsl:apply-templates mode="PRIMERA_FOREIGN_KEY" select="ancestor-or-self::declaration/field"><xsl:with-param name="nameFK" select="name"/></xsl:apply-templates>
        </xsl:if> 
		<xsl:if test="position() != 1"> 
		      <xsl:apply-templates mode="DEMAS_FOREIGN_KEY" select="ancestor-or-self::declaration/field"><xsl:with-param name="nameFK" select="name"/></xsl:apply-templates>
        </xsl:if> 
	 </xsl:if>
  </xsl:template>

<!-- ****Devuelve el tipo de dato******** -->
<xsl:template mode="PRIMERA_FOREIGN_KEY" match="declaration/field">
 <xsl:param name="nameFK"/>
  <xsl:if test="name = $nameFK">
         <xsl:if test="type = 'varchar' or type = 'date' or type = 'timestamp' or type = 'time' or type = 'char' or type = 'text' or type = 'bpchar'"><xsl:value-of select="name"/>='$<xsl:value-of select="name"/>'</xsl:if>
	     <xsl:if test="type = 'int' or type = 'smallint' or type = 'bigint' or type = 'float' or type = 'double' or type = 'decimal' or type = 'int2' or type = 'int4' or type = 'int8'"><xsl:value-of select="name"/>=$<xsl:value-of select="name"/></xsl:if>
  </xsl:if>
</xsl:template>
<!-- ****Imprime todas las llaves******** -->
<xsl:template mode="DEMAS_FOREIGN_KEY" match="declaration/field">
 <xsl:param name="nameFK"/> 
  <xsl:if test="name = $nameFK">
	     <xsl:if test="type = 'varchar' or type = 'date' or type = 'timestamp' or type = 'time' or type = 'char' or type = 'text' or type ='bpchar'"> AND <xsl:value-of select="name"/>='$<xsl:value-of select="name"/>'</xsl:if>
	     <xsl:if test="type = 'int' or type = 'smallint' or type = 'bigint' or type = 'float' or type = 'double' or type = 'decimal' or type = 'int2' or type = 'int4' or type = 'int8'"> AND <xsl:value-of select="name"/>=$<xsl:value-of select="name"/></xsl:if>
  </xsl:if>
</xsl:template>
<!-- ************************************************************************************************************ -->
  <!-- Valida si la Compuerta debe o no llevar la Función Update -->
  <xsl:template mode="VALIDAR_FUNCION_UPDATE" match="field">
	 <xsl:if test="ancestor::declaration/field/name != name">
		<xsl:if test="count(ancestor::declaration/primary_key/field) != count(ancestor::declaration/field)">
			<xsl:if test="position()=1">
				<xsl:apply-templates mode="FUNCION_UPDATE" select="ancestor::declaration"/>
			</xsl:if>
		</xsl:if>
	 </xsl:if>
	</xsl:template>
<!-- Muestra la Función Update -->
  <xsl:template mode="FUNCION_UPDATE" match="declaration">
 	/**
	* Metodo para actualizar un registro de la tabla: <xsl:value-of select="$tabla"/>
	* @author SpyroFrameWork
	* @return boolean
	*/ 
  	function update<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>(<xsl:apply-templates mode="TODOS_LOS_CAMPOS" select="field"/>)
  	{
	    $sql="UPDATE <xsl:value-of select="ancestor::table/name"/> SET <xsl:apply-templates mode="PARAMETROS_UPDATE" select="ancestor-or-self::declaration"/> WHERE <xsl:apply-templates mode="LLAVES_PRIMARY_WHERE" select="primary_key/field"/>";
	    $this->consult = pg_query($this->connection,$sql);
		return $this->consult;
  	}
  </xsl:template>
<!--concatena los fields y luego quita al coma al final de la cadena-->
<xsl:template mode="PARAMETROS_UPDATE" match="declaration">
	<xsl:variable name="cadena"><!-- toma la cadena de los fields con comas -->
	 <xsl:for-each select="field">
	   <xsl:if test="not(ancestor::declaration/primary_key/field/name = name)">
	     <xsl:if test="type = 'varchar' or type = 'timestamp' or type = 'time' or type = 'char' or type = 'text' or type = 'bpchar'"><xsl:value-of select="name"/>='$<xsl:value-of select="name"/>',</xsl:if>  
         <xsl:if test="type = 'date'"><xsl:value-of select="name"/>=TO_DATE('$<xsl:value-of select="name"/>','YYYY-MM-DD'),</xsl:if> 
		 <xsl:if test="type = 'int' or type = 'smallint' or type = 'bigint' or type = 'float' or type = 'double' or type = 'float4' or type = 'float8' or type = 'decimal' or type = 'int2' or type = 'int4' or type = 'int8'"><xsl:value-of select="name"/>=$<xsl:value-of select="name"/>,</xsl:if>
	   </xsl:if>
	 </xsl:for-each>
    </xsl:variable>
	<!-- toma el tamaño de la cadena -->
	<xsl:variable name="long">
      <xsl:value-of select="string-length($cadena)-1"/>
    </xsl:variable>
	<!-- quita la coma al final de la cadena-->
    <xsl:value-of select="substring($cadena,1,$long)"/>
</xsl:template>
<!-- ************************************************************************************************************ -->
  <!-- Trae todos los campos de la tabla -->
  <xsl:template mode="TODOS_LOS_CAMPOS" match="field">
	  <xsl:if test="position() = 1">$<xsl:value-of select="name"/></xsl:if>
	  <xsl:if test="position() != 1">,$<xsl:value-of select="name"/></xsl:if>
  </xsl:template>
  <!-- Trae todas las Primary Key de la tabla para los Parametros de la funcion-->
  <xsl:template mode="LLAVES_PRIMARY_PARAMETROS" match="field"> 
      <xsl:if test="position() = 1">$<xsl:value-of select="name"/></xsl:if>
	  <xsl:if test="position() != 1">,$<xsl:value-of select="name"/></xsl:if>
  </xsl:template>

<!-- Trae el tipo de dato del nombre del campo que le entra como parametro -->
<xsl:template mode="GET_TIPO_DE_DATO" match="field">
<xsl:param name="nombre_campo"/>
  <xsl:if test="name = $nombre_campo">
    <xsl:value-of select="type"/>
 </xsl:if>
</xsl:template>

<!-- Trae todas las Primary Key de la tabla para el WHERE de la funcion -->
<xsl:template mode="LLAVES_PRIMARY_WHERE" match="field"> 
<!-- obtiene el tipo de dato -->
<xsl:variable name="tipo_dato">
  <xsl:apply-templates mode="GET_TIPO_DE_DATO" select="ancestor::declaration/field"><xsl:with-param name="nombre_campo" select="name"/></xsl:apply-templates>  
</xsl:variable>

<xsl:if test="position() = 1">
  <xsl:if test="$tipo_dato = 'varchar' or $tipo_dato = 'date' or $tipo_dato = 'timestamp' or $tipo_dato = 'time' or $tipo_dato = 'char' or $tipo_dato = 'text' or $tipo_dato = 'bpchar'"><xsl:value-of select="name"/>='$<xsl:value-of select="name"/>'</xsl:if>
  <xsl:if test="$tipo_dato = 'int' or $tipo_dato = 'smallint' or $tipo_dato = 'bigint' or $tipo_dato = 'float' or $tipo_dato = 'double' or type = 'float4' or type = 'float8' or $tipo_dato = 'decimal' or $tipo_dato = 'int2' or $tipo_dato = 'int4' or $tipo_dato = 'int8'"><xsl:value-of select="name"/>=$<xsl:value-of select="name"/></xsl:if>
</xsl:if>
   
<xsl:if test="position() != 1">
  <xsl:if test="$tipo_dato = 'varchar' or $tipo_dato = 'date' or $tipo_dato = 'timestamp' or $tipo_dato = 'time' or $tipo_dato = 'char' or $tipo_dato = 'text' or $tipo_dato = 'bpchar'"> AND <xsl:value-of select="name"/>='$<xsl:value-of select="name"/>'</xsl:if>
  <xsl:if test="$tipo_dato = 'int' or $tipo_dato = 'smallint' or $tipo_dato = 'bigint' or $tipo_dato = 'float' or $tipo_dato = 'double' or type = 'float4' or type = 'float8' or $tipo_dato = 'decimal' or $tipo_dato = 'int2' or $tipo_dato = 'int4' or $tipo_dato = 'int8'"> AND <xsl:value-of select="name"/>=$<xsl:value-of select="name"/></xsl:if>
</xsl:if>
</xsl:template>

<!-- Trae todos los campos de una tabla para el INSERT INTO VALUES -->
<xsl:template mode="PARAMETROS_INSERT" match="field"> <!--PARM_SQL-->
     <xsl:choose>
			<xsl:when test="position() = 1">
 				  <xsl:if test="type = 'varchar' or type = 'timestamp' or type = 'time' or type = 'char' or type = 'text' or type = 'bpchar'">'$<xsl:value-of select="name"/>'</xsl:if>
				  <xsl:if test="type = 'date'">TO_DATE('$<xsl:value-of select="name"/>','YYYY-MM-DD')</xsl:if> 
				  <xsl:if test="(type = 'int' or type = 'smallint' or type = 'bigint' or type = 'float' or type = 'double' or type = 'decimal' or type = 'int2' or type = 'int4' or type = 'int8') and not(counter)">$<xsl:value-of select="name"/></xsl:if>
				  <xsl:if test="counter = 'auto_increment'">null</xsl:if>
			</xsl:when>
			<xsl:otherwise>
				<xsl:if test="type = 'varchar' or type = 'timestamp' or type = 'time' or type = 'char' or type = 'text' or type = 'bpchar'">,'$<xsl:value-of select="name"/>'</xsl:if>
				<xsl:if test="type = 'date'">,TO_DATE('$<xsl:value-of select="name"/>','YYYY-MM-DD')</xsl:if> 
				<xsl:if test="(type = 'int' or type = 'smallint' or type = 'bigint' or type = 'float' or type = 'double' or type = 'decimal' or type = 'int2' or type = 'int4' or type = 'int8') and not(counter)">,$<xsl:value-of select="name"/></xsl:if>
				<xsl:if test="counter = 'auto_increment'">,null</xsl:if>
			</xsl:otherwise>
		</xsl:choose>
</xsl:template>
<!-- ************************************************************************************************************ -->
    <!-- The proper case transformation. The presented solution first translates the entire string to 
         lower case, and after that it translate only the first letter of every word to upper case  -->
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
</xsl:stylesheet>
<!-- Stylus Studio meta-information - (c)1998-2003. Sonic Software Corporation. All rights reserved.
<metaInformation>
<scenarios ><scenario default="no" name="Producto" userelativepaths="yes" externalpreview="no" url="metadata_oracle.xml" htmlbaseurl="" outputurl="" processortype="msxml" profilemode="0" urlprofilexml="" commandline="" additionalpath="" additionalclasspath="" postprocessortype="none" postprocesscommandline="" postprocessadditionalpath="" postprocessgeneratedext="" ><parameterValue name="tabla" value="'emp'"/></scenario><scenario default="yes" name="Linea" userelativepaths="yes" externalpreview="no" url="file://d:\My Documents\Tesis\Metadatos\dbpruebamysql2.xml" htmlbaseurl="" outputurl="" processortype="internal" profilemode="0" urlprofilexml="" commandline="" additionalpath="" additionalclasspath="" postprocessortype="none" postprocesscommandline="" postprocessadditionalpath="" postprocessgeneratedext="" ><parameterValue name="tabla" value="'pais'"/></scenario></scenarios><MapperInfo srcSchemaPath="" srcSchemaRoot="" srcSchemaPathIsRelative="yes" srcSchemaInterpretAsXML="no" destSchemaPath="" destSchemaRoot="" destSchemaPathIsRelative="yes" destSchemaInterpretAsXML="no"/>
</metaInformation>
-->