<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<!-- Nombre de la Tabla -->
<xsl:param name = "tabla"/>
<!-- Nombre de la Empresa -->
<xsl:param name = "empresa"/>
<!-- Nombre de la Aplicacion -->
<xsl:param name = "aplicacion"/>
<!-- Nombre del estilo-->
<xsl:param name = "style"/>


<xsl:output method="text" />

<xsl:template match = "/">&lt;html&gt;<xsl:apply-templates/>
&lt;/html&gt;
</xsl:template>

<!-- Busca y se ubica en el database del metadato -->
<xsl:template match="database">
<xsl:apply-templates select="table[name=$tabla]"/>
</xsl:template>

<!-- Se crea el encabezado de la pagina -->
<xsl:template match="table">
{loadlabels table_name=<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>&amp;controls[]=CmdAdd&amp;controls[]=CmdUpdate&amp;controls[]=CmdDelete&amp;controls[]=CmdShow&amp;controls[]=CmdClean}
&lt;head&gt;
      &lt;title&gt;{printtitle}&lt;/title&gt;<xsl:call-template name="libreria_calendar"/>
<xsl:call-template name="estilos"/>
{putjsfiles}
&lt;/head&gt;<xsl:apply-templates select="declaration"/>
</xsl:template>
<!-- ******************************************* -->
<xsl:template name="estilos">
	<xsl:if test="$style = 'Parque'">{putstyle style="ParqueSoft.css"}</xsl:if>
	<xsl:if test="$style = 'Global'">{putstyle style="Base.css"}</xsl:if>
</xsl:template>
<!-- ******************************************* -->
<xsl:template name="libreria_calendar">
<xsl:variable name="apos">'</xsl:variable>
  <xsl:variable name="cadScript"><xsl:apply-templates mode="pone_linea" select="declaration/field"/></xsl:variable>
  <xsl:value-of select="substring($cadScript,1,67)"/>   
</xsl:template>
<!-- ******************************************* -->
<xsl:template mode="pone_linea" match="field">
<xsl:if test="type = 'date'">&lt;script language='JavaScript' src='web/js/date-picker.js'&gt;&lt;/script&gt;</xsl:if>
</xsl:template>
<!-- **************************************************************************** -->
<xsl:template match="declaration">
{body onkeydown="return doKeyDown(event)" onload="putFocus();" onunload=""}
&lt;hr&gt;
{form name="frm<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>" method="post"}
&lt;table border="0" align="center" width="60%">
  	&lt;tr&gt;&lt;td class="piedefoto" colspan="3"&gt;&lt;div align="center"&gt;
		{help_context}
  	&lt;/div&gt;&lt;/td&gt;&lt;/tr&gt;
	<tr><th colspan="3">&amp;nbsp;</th></tr>
	&lt;tr&gt;&lt;th colspan="3"&gt;&lt;div align="left"&gt;{printtitle}&lt;/div&gt;&lt;/th&gt;&lt;/tr&gt;
	&lt;tr&gt;&lt;th colspan="3"&gt;&lt;div align="left"&gt;&amp;nbsp;&lt;/div&gt;&lt;/th&gt;&lt;/tr&gt;
<xsl:apply-templates mode="campos_tabla" select="field"/>
	&lt;tr&gt;
		&lt;td colspan="2"&gt;&amp;nbsp;&lt;/td&gt;
		&lt;td class="piedefoto"&gt;&lt;/td&gt;
	&lt;/tr&gt;
	&lt;tr&gt;
    	&lt;td colspan="2"&gt;
    		&lt;div align="center"&gt;
	    		{btn_command type="button" value="Adicionar" id="CmdAdd" name="<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdAdd<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>" form_name="frm<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>"}
				{btn_command type="button" value="Modificar" id="CmdUpdate" name="<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdUpdate<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>" form_name="frm<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>"}
				{btn_delete type="button" value="Eliminar" id="CmdDelete" name="<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdDelete<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>" form_name="frm<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>" table="<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>"}
				{btn_command type="button" value="Limpiar" id="CmdClean"  name="<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdClear<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>" form_name="frm<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>"}
				{btn_command type="button" value="Consultar" id="CmdShow" name="<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdShowList<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>" form_name="frm<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>"}
			&lt;/div&gt;
		&lt;/td&gt;
		&lt;td class="piedefoto"&gt;&lt;/td&gt;
	&lt;/tr&gt;
&lt;/table&gt;
{hidden name="action" value=""}
{/form}
{putjsacceskey}
{fieldset}
   {message id=$cod_message}
{/fieldset}
&lt;br&gt;
{/body}</xsl:template>
<!-- **************************************************************************** -->
<xsl:template mode="campos_tabla" match="field">
   &lt;tr&gt;
      &lt;td class="celda"&gt;{printlabel name=<xsl:value-of select="name"/>}&lt;/td&gt;
      &lt;td class="celda"&gt;<xsl:call-template name="validar_si_es_fk">
		      <xsl:with-param name="nameFK" select="ancestor::declaration/foreign_key/local_table/field/name"/>
			  <xsl:with-param name="nameField" select="name"/>
			  <xsl:with-param name="tipoField" select="type"/>
			  <xsl:with-param name="nullField" select="null"/>
 	   </xsl:call-template><xsl:if test="null = 'not null'"><xsl:text>*</xsl:text></xsl:if>&lt;/td&gt;
 	   &lt;td class="piedefoto"&gt;{printcoment name=<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>}&lt;/td&gt;
   &lt;/tr&gt;</xsl:template> 
<!--************************************************************************************
*   Valida cada campo de la tabla, el campo es Foreing Key entonces adiciona           * 
*   el tag {select_row_table} al tpl, si el campo no es pone el tag correspondiente    *  
*   al tipo de dato del campo de la tabla.   										   *
*************************************************************************************-->

<xsl:template name="validar_si_es_fk">
 <xsl:param name="nameFK"/>
 <xsl:param name="nametable"/>
 <xsl:param name="namevalue"/>
 <xsl:param name="nameField"/>
 <xsl:param name="tipoField"/>
 <xsl:param name="nullField"/>
   
 <xsl:if test="$nameFK = $nameField">{select_row_table id="<xsl:value-of select="name"/>" name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" table_name="<xsl:apply-templates mode="determinar_table_reference" select="ancestor::declaration/foreign_key"><xsl:with-param name="nameField" select="$nameField"/></xsl:apply-templates>" value="<xsl:apply-templates mode="determinar_field_reference" select="ancestor::declaration/foreign_key"><xsl:with-param name="nameField" select="$nameField"/></xsl:apply-templates>"<xsl:if test="$nullField = 'null'"> is_null="true"</xsl:if>}</xsl:if>

 <xsl:if test="not($nameFK = $nameField)">
   <xsl:choose>
   	<xsl:when test="$tipoField = 'varchar'">{textfield id="<xsl:value-of select="name"/>" name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" maxlength="<xsl:value-of select="precision"/>"}</xsl:when>
	<xsl:when test="$tipoField = 'varchar2'">{textfield id="<xsl:value-of select="name"/>" name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" maxlength="<xsl:value-of select="precision"/>"}</xsl:when>
	<xsl:when test="$tipoField = 'int'">{textfield id="<xsl:value-of select="name"/>" name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" maxlength="<xsl:value-of select="precision"/>" typeData="int"}</xsl:when>
	<xsl:when test="$tipoField = 'int2'">{textfield id="<xsl:value-of select="name"/>" name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" maxlength="<xsl:value-of select="precision"/>" typeData="int"}</xsl:when>
	<xsl:when test="$tipoField = 'int4'">{textfield id="<xsl:value-of select="name"/>" name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" maxlength="<xsl:value-of select="precision"/>" typeData="int"}</xsl:when>
	<xsl:when test="$tipoField = 'int8'">{textfield id="<xsl:value-of select="name"/>" name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" maxlength="<xsl:value-of select="precision"/>" typeData="int"}</xsl:when>
	<xsl:when test="$tipoField = 'number'">{textfield id="<xsl:value-of select="name"/>" name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" maxlength="<xsl:value-of select="precision"/>" typeData="int"}</xsl:when>
	<xsl:when test="$tipoField = 'tinyint'">{textfield id="<xsl:value-of select="name"/>" name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" maxlength="<xsl:value-of select="precision"/>" typeData="int"}</xsl:when>
	<xsl:when test="$tipoField = 'smallint'">{textfield id="<xsl:value-of select="name"/>" name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" maxlength="<xsl:value-of select="precision"/>" typeData="int"}</xsl:when>
	<xsl:when test="$tipoField = 'mediumint'">{textfield id="<xsl:value-of select="name"/>" name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" maxlength="<xsl:value-of select="precision"/>" typeData="int"}</xsl:when>
	<xsl:when test="$tipoField = 'bigint'">{textfield id="<xsl:value-of select="name"/>" name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" maxlength="<xsl:value-of select="precision"/>" typeData="int"}</xsl:when>
	<xsl:when test="$tipoField = 'double'">{textfield id="<xsl:value-of select="name"/>" name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" maxlength="<xsl:value-of select="number(precision+scale+1)"/>" typeData="double"}</xsl:when>
	<xsl:when test="$tipoField = 'float'">{textfield id="<xsl:value-of select="name"/>" name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" maxlength="<xsl:value-of select="number(precision+scale+1)"/>" typeData="double"}</xsl:when>
	<xsl:when test="$tipoField = 'decimal'">{textfield id="<xsl:value-of select="name"/>" name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" maxlength="<xsl:value-of select="number(precision+scale+1)"/>" typeData="double"}</xsl:when>
	<xsl:when test="$tipoField = 'year'">(sin componente)</xsl:when>
	<xsl:when test="$tipoField = 'char'">{textfield id="<xsl:value-of select="name"/>" name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" maxlength="<xsl:value-of select="precision"/>"}</xsl:when>
	<xsl:when test="$tipoField = 'bpchar'">{textfield id="<xsl:value-of select="name"/>" name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" maxlength="<xsl:value-of select="precision"/>"}</xsl:when>
	<xsl:when test="$tipoField = 'date'">{calendar id="<xsl:value-of select="name"/>" name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" form_name="frm<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>" icon="web/images/calendar.gif"}</xsl:when>
	<xsl:when test="$tipoField = 'time'">(sin componente)</xsl:when>
	<xsl:when test="$tipoField = 'datetime'">(sin componente)</xsl:when>
	<xsl:when test="$tipoField = 'timestamp'">(sin componente)</xsl:when>
	<xsl:when test="$tipoField = 'tinytext'">{textarea id="<xsl:value-of select="name"/>" name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" cols="40" rows="5" wrap="OFF"}{/textarea}</xsl:when>
	<xsl:when test="$tipoField = 'text'">{textarea id="<xsl:value-of select="name"/>" name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" cols="40" rows="5" wrap="OFF"}{/textarea}</xsl:when>
	<xsl:when test="$tipoField = 'long'">{textarea id="<xsl:value-of select="name"/>" name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" cols="40" rows="5" wrap="OFF"}{/textarea}</xsl:when>
	<xsl:when test="$tipoField = 'raw'">{textarea id="<xsl:value-of select="name"/>" name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" cols="40" rows="5" wrap="OFF"}{/textarea}</xsl:when>
	<xsl:when test="$tipoField = 'mediumtext'">{textarea id="<xsl:value-of select="name"/>" name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" cols="40" rows="5" wrap="OFF"}{/textarea}</xsl:when>
	<xsl:when test="$tipoField = 'longtext'">{textarea id="<xsl:value-of select="name"/>" name="textarea" class="campos" cols="40" rows="5" wrap="OFF"}{/textarea}</xsl:when>
	<xsl:when test="$tipoField = 'enum'">
	<xsl:variable name="apos">'</xsl:variable>
			{select id="<xsl:value-of select="name"/>" name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos"}
	   <xsl:call-template name="crear_combo">
	       <xsl:with-param name="cadena" select="translate(precision,$apos,'')"/>
	       <xsl:with-param name="cadenaCorta" select="substring-before(translate(precision,$apos,''),',')"></xsl:with-param>
	   </xsl:call-template>
			{/select}
	</xsl:when>
	<xsl:when test="$tipoField = 'set'">
		<xsl:variable name="apos">'</xsl:variable>
			{select id="<xsl:value-of select="name"/>" name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos"}
	   <xsl:call-template name="crear_combo">
	       <xsl:with-param name="cadena" select="translate(precision,$apos,'')"/>
	       <xsl:with-param name="cadenaCorta" select="substring-before(translate(precision,$apos,''),',')"></xsl:with-param>
	   </xsl:call-template>
			{/select}
	</xsl:when>
	<xsl:when test="$tipoField = 'tinyblob'">(sin componente)</xsl:when>
	<xsl:when test="$tipoField = 'blob'">(sin componente)</xsl:when>
	<xsl:when test="$tipoField = 'mediumblob'">(sin componente)</xsl:when>
	<xsl:when test="$tipoField = 'longblob'">(sin componente)</xsl:when>
	</xsl:choose>
  </xsl:if>

</xsl:template>

<!-- Recorre todas la llaves foraneas   -->
<xsl:template mode="determinar_table_reference" match="foreign_key">
 <xsl:param name="nameField"/>
   <xsl:apply-templates mode="imprimir_table_reference" select="local_table/field">
      <xsl:with-param name="nameField" select="$nameField"/>
   </xsl:apply-templates>
</xsl:template>

<!-- Imprime el nombre de la tabla a la que hace referencia el foreign key -->
<xsl:template mode="imprimir_table_reference" match="field">
 <xsl:param name="nameField"/>
 <xsl:if test="$nameField = name">
    <xsl:value-of select="ancestor::foreign_key/reference_table/name"/> 
 </xsl:if>
</xsl:template>



<xsl:template mode="determinar_field_reference" match="foreign_key">
 <xsl:param name="nameField"/>
   <xsl:apply-templates mode="buscar_campo" select="local_table/field">
      <xsl:with-param name="nameField" select="$nameField"/>
   </xsl:apply-templates>
</xsl:template>


<!-- **Obtiene la posicion del Foreign_key en Local_table y se para en Reference_table ***************************** -->
<xsl:template mode="buscar_campo" match="field">
<xsl:param name="nameField"/>
  <xsl:if test="$nameField = name"> 
     <xsl:apply-templates mode="campo_referido" select="ancestor::foreign_key/reference_table/field">
      	<xsl:with-param name="name_Field_local" select="name"/>
		<xsl:with-param name="name_Field" select="$nameField"/>
		<xsl:with-param name="pos_local" select="position()"/>
	 </xsl:apply-templates>
  </xsl:if>
</xsl:template>
<!--**Valida si corresponde la posicion del field en local_table y el field de reference_table, preguntando si el 
      nombre del Field de la tabla es igual al name de local_table******************************************** -->  
<xsl:template mode="campo_referido" match="field">
  <xsl:param name="name_Field_local"/>
  <xsl:param name="name_Field"/>
  <xsl:param name="pos_local"/>
    <xsl:if test="(position() = $pos_local) ">
       <xsl:if test="($name_Field = $name_Field_local) ">
            <xsl:value-of select="name"/>
       </xsl:if>
    </xsl:if>
</xsl:template>

<!-- *******************************************************
* Separa las opciones de la cadena en shortcad y cada vez 
* la va metiendo al select, corta la cadena original quitando 
* las opciones que ya metio, y vuelve y se llama iteractivamente
* creando el tag {option}x{/option}
*********************************************************-->
<xsl:template name="crear_combo">
	<xsl:param name="cadena"/>
	<xsl:param name="cadenaCorta"/>
	
	<xsl:variable name="cadenaFinal">
	     <xsl:if test="contains($cadena,',')">
			<xsl:variable name="siguiente_cadena_corta">		
			<!-- guarda la siguiente  -->
					<xsl:value-of select="substring($cadena,string-length($cadenaCorta)+2,string-length($cadena))"/>
			</xsl:variable>
			<xsl:value-of select="$siguiente_cadena_corta"/>
		 </xsl:if>
		 <xsl:if test="not(contains($cadena,','))">
			<xsl:value-of select="$cadena"/>
 		 </xsl:if>
	</xsl:variable>
  <xsl:if test="contains($cadena,',')">
{option}<xsl:value-of select="$cadenaCorta"/>{/option}
      <xsl:call-template name="crear_combo">
         <xsl:with-param name="cadena" select="$cadenaFinal"/>
	     <xsl:with-param name="cadenaCorta" select="substring-before($cadenaFinal,',')"/>
      </xsl:call-template>
  </xsl:if>
  <xsl:if test="not(contains($cadena,','))">
{option}<xsl:value-of select="$cadenaFinal"/>{/option}
  </xsl:if>
</xsl:template>

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

</xsl:stylesheet><!-- Stylus Studio meta-information - (c)1998-2003. Sonic Software Corporation. All rights reserved.
<metaInformation>
<scenarios ><scenario default="yes" name="Scenario1" userelativepaths="yes" externalpreview="no" url="..\..\..\..\..\..\..\..\..\Documents and Settings\Owner\My Documents\Documentos\Tesis\Metadatos\dbpruebamysql.xml" htmlbaseurl="" outputurl="" processortype="internal" profilemode="0" urlprofilexml="" commandline="" additionalpath="" additionalclasspath="" postprocessortype="none" postprocesscommandline="" postprocessadditionalpath="" postprocessgeneratedext="" ><parameterValue name="tabla" value="'ciudad'"/><parameterValue name="empresa" value="'Wis'"/><parameterValue name="style" value="'None'"/><parameterValue name="aplicacion" value="'GS'"/></scenario></scenarios><MapperInfo srcSchemaPath="" srcSchemaRoot="" srcSchemaPathIsRelative="yes" srcSchemaInterpretAsXML="no" destSchemaPath="" destSchemaRoot="" destSchemaPathIsRelative="yes" destSchemaInterpretAsXML="no"/>
</metaInformation>
-->