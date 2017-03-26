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

<!-- Busca y se ubica en el database del metadato -->
<xsl:template match="database">
<xsl:apply-templates select="table[name=$tabla]"/>
</xsl:template>

<xsl:template match = "/">
<!-- Carga el Archivo de lenguaje para este Template -->
{config_load file="Templates.lan" section="<xsl:value-of select="$tabla"/>"}
&lt;html&gt;<xsl:apply-templates/>
&lt;/html&gt;
</xsl:template>



<!-- Se crea el encabezado de la pagina -->
<xsl:template match="table">
&lt;head&gt;
      &lt;title&gt;{#TITLE#}&lt;/title&gt;
      {meta}<xsl:call-template name="libreria_calendar"/>
      &lt;script language='JavaScript' src='web/js/disableButtons.js'&gt;&lt;/script&gt;
      &lt;script language='JavaScript' src='web/js/overlib.js'&gt;&lt;/script&gt;
	  <!--&lt;script language='JavaScript' src='web/js/waitscreen.js'&gt;&lt;/script&gt; -->
	  <xsl:call-template name="estilos"/>
&lt;/head&gt;<xsl:apply-templates select="declaration"/>
</xsl:template>
<!-- ******************************************* -->
<xsl:template name="estilos">
	<xsl:if test="$style = 'Spyro'">&lt;link href="web/css/Spyrodefault.css" rel="stylesheet" type="text/css"&gt;</xsl:if>
	<xsl:if test="$style = 'Global'">&lt;link href="web/css/Otherdefault.css" rel="stylesheet" type="text/css"&gt;</xsl:if>
	<xsl:if test="$style = 'Spyro'">&lt;link href="web/css/template_css.css" rel="stylesheet" type="text/css"&gt;</xsl:if>
</xsl:template>
<!-- ******************************************* -->
<xsl:template name="libreria_calendar">
<xsl:variable name="apos">'</xsl:variable>
  <xsl:variable name="cadScript"><xsl:apply-templates mode="pone_linea" select="declaration/field"/></xsl:variable>
  <xsl:value-of select="substring($cadScript,1,151)"/>   
</xsl:template>
<!-- ******************************************* -->
<xsl:template mode="pone_linea" match="field">
	<xsl:if test="type = 'date'">
	  &lt;script language='JavaScript' src='web/js/libCalendar.js'&gt;&lt;/script&gt;
	  &lt;script language='JavaScript' src='web/js/libCalendarPopupCode.js'&gt;&lt;/script&gt;
	</xsl:if>
</xsl:template>
<!-- **************************************************************************** -->
<xsl:template match="declaration">
&lt;body&gt;
<!-- onLoad="ap_showWaitMessage('waitDiv', 0);" {waitscreen} -->
&lt;table width="100%" border="0" cellspacing="0" cellpadding="0" class1=adminlist&gt;
  &lt;tr&gt;
    &lt;td align="center"&gt;
       &lt;table width="1024" border="0" cellspacing="0" cellpadding="0"&gt;
        &lt;tr&gt;
          &lt;td&gt;
               {include file="Form_TopMenu.tpl" }

{form name="frm<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>" method="post"}

   {tools_barstandardsp type="Button" reference_id =100 
                        form_name="frm<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>"
                        commands="<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdAdd<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>,<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdShowList<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>,<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdHelp<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>"
                        images="save_f2.png,back_f2.png,help_f2.png" 
                        titles="save,back,help"  
   }

   &lt;div class="main"&gt;
		&lt;table class="adminheading"&gt;
		&lt;tr&gt;
			&lt;th class="frontpage" rowspan="2"&gt;
            &lt;img src="./web/images/menu/menu.png" &lt;/img&gt;
			{#TITLE#}
            &lt;/th&gt;

		&lt;/tr&gt;

		&lt;/table&gt;

  &lt;div&gt;

&lt;table border="0" align="center" width=50% class="adminform">



   <xsl:apply-templates mode="campos_tabla" select="field"/>
&lt;/table&gt;



{hidden name="action" value=""}
{hidden name="section_language" value="<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>"}
{/form}

   {messagebox id=$cod_message}

{spyro_info}

&lt;div id="border-bottom"&gt;
    &lt;div&gt;
      &lt;div&gt;
      &lt;/div&gt;
      &lt;/div&gt;
  &lt;/div&gt;

          &lt;/td&gt;
       &lt;/tr&gt;
      &lt;/table&gt;
            {include file="Form_FooterMenu.tpl" }

    &lt;td&gt;
  &lt;tr&gt;
&lt;/table&gt;

&lt;/body&gt;</xsl:template>
<!-- **************************************************************************** -->
<xsl:template mode="campos_tabla" match="field">


   &lt;tr&gt;
      &lt;td class="dvtCellLabel"&gt;{#<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>#}<xsl:if test="null = 'not null'"><xsl:text>(*)</xsl:text></xsl:if>&lt;/td&gt;
      &lt;td class="dvtCellInfo"&gt;<xsl:call-template name="validar_si_es_fk">
		      <xsl:with-param name="nameFK" select="ancestor::declaration/foreign_key/local_table/field/name"/>
			  <xsl:with-param name="nameField" select="name"/>
			  <xsl:with-param name="tipoField" select="type"/>
			  <xsl:with-param name="nullField" select="null"/>
 	   </xsl:call-template>{tooltip code="<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>"}&lt;/td&gt;
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
   
 <xsl:if test="$nameFK = $nameField">{select_row_table name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" table_name="<xsl:apply-templates mode="determinar_table_reference" select="ancestor::declaration/foreign_key"><xsl:with-param name="nameField" select="$nameField"/></xsl:apply-templates>" value="<xsl:apply-templates mode="determinar_field_reference" select="ancestor::declaration/foreign_key"><xsl:with-param name="nameField" select="$nameField"/></xsl:apply-templates>"<xsl:if test="$nullField = 'null'"> is_null="true"</xsl:if>}</xsl:if>

 <xsl:if test="not($nameFK = $nameField)">
   <xsl:choose>
   	<xsl:when test="$tipoField = 'varchar'">{textfield name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" maxlength="<xsl:value-of select="precision"/>"}</xsl:when>
	<xsl:when test="$tipoField = 'varchar2'">{textfield name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" maxlength="<xsl:value-of select="precision"/>"}</xsl:when>
	<xsl:when test="$tipoField = 'int'">{textfield name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" maxlength="<xsl:value-of select="precision"/>" typeData="int"}</xsl:when>
	<xsl:when test="$tipoField = 'int2'">{textfield name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" maxlength="<xsl:value-of select="precision"/>" typeData="int"}</xsl:when>
	<xsl:when test="$tipoField = 'int4'">{textfield name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" maxlength="<xsl:value-of select="precision"/>" typeData="int"}</xsl:when>
	<xsl:when test="$tipoField = 'int8'">{textfield name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" maxlength="<xsl:value-of select="precision"/>" typeData="int"}</xsl:when>
	<xsl:when test="$tipoField = 'number'">{textfield name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" maxlength="<xsl:value-of select="precision"/>" typeData="int"}</xsl:when>
	<xsl:when test="$tipoField = 'numeric'">{textfield name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" maxlength="<xsl:value-of select="precision"/>" typeData="int"}</xsl:when>
	<xsl:when test="$tipoField = 'tinyint'">{textfield name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" maxlength="<xsl:value-of select="precision"/>" typeData="int"}</xsl:when>
	<xsl:when test="$tipoField = 'smallint'">{textfield name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" maxlength="<xsl:value-of select="precision"/>" typeData="int"}</xsl:when>
	<xsl:when test="$tipoField = 'mediumint'">{textfield name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" maxlength="<xsl:value-of select="precision"/>" typeData="int"}</xsl:when>
	<xsl:when test="$tipoField = 'bigint'">{textfield name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" maxlength="<xsl:value-of select="precision"/>" typeData="int"}</xsl:when>
	<xsl:when test="$tipoField = 'double'">{textfield name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" maxlength="<xsl:value-of select="number(precision+scale+1)"/>" typeData="double"}</xsl:when>
	<xsl:when test="$tipoField = 'float'">{textfield name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" maxlength="<xsl:value-of select="number(precision+scale+1)"/>" typeData="double"}</xsl:when>
	<xsl:when test="$tipoField = 'decimal'">{textfield name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" maxlength="<xsl:value-of select="number(precision+scale+1)"/>" typeData="double"}</xsl:when>
	<xsl:when test="$tipoField = 'year'">(sin componente)</xsl:when>
	<xsl:when test="$tipoField = 'char'">{textfield name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" maxlength="<xsl:value-of select="precision"/>"}</xsl:when>
	<xsl:when test="$tipoField = 'bpchar'">{textfield name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" maxlength="<xsl:value-of select="precision"/>"}</xsl:when>
	<xsl:when test="$tipoField = 'date'">{calendar name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" form_name="frm<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>" format_date="YYYY-MM-DD" icon="web/images/"}</xsl:when>
	<xsl:when test="$tipoField = 'time'">{textfield_hour name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos"}</xsl:when>
	<xsl:when test="$tipoField = 'datetime'">{calendar name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" form_name="frm<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>" format_date="YYYY-MM-DD" time_comp="true" icon="web/images/"}</xsl:when>
	<xsl:when test="$tipoField = 'timestamp'">{calendar name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" form_name="frm<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>" format_date="YYYY-MM-DD" time_comp="true" icon="web/images/"}</xsl:when>
	<xsl:when test="$tipoField = 'tinytext'">{textarea name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" cols="40" rows="5" wrap="OFF"}{/textarea}</xsl:when>
	<xsl:when test="$tipoField = 'text'">{textarea name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" cols="40" rows="5" wrap="OFF"}{/textarea}</xsl:when>
	<xsl:when test="$tipoField = 'long'">{textarea name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" cols="40" rows="5" wrap="OFF"}{/textarea}</xsl:when>
	<xsl:when test="$tipoField = 'raw'">{textarea name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" cols="40" rows="5" wrap="OFF"}{/textarea}</xsl:when>
	<xsl:when test="$tipoField = 'mediumtext'">{textarea name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos" cols="40" rows="5" wrap="OFF"}{/textarea}</xsl:when>
	<xsl:when test="$tipoField = 'longtext'">{textarea name="textarea" class="campos" cols="40" rows="5" wrap="OFF"}{/textarea}</xsl:when>
	<xsl:when test="$tipoField = 'enum'">
	<xsl:variable name="apos">'</xsl:variable>
			{select name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos"}
	   <xsl:call-template name="crear_combo">
	       <xsl:with-param name="cadena" select="translate(precision,$apos,'')"/>
	       <xsl:with-param name="cadenaCorta" select="substring-before(translate(precision,$apos,''),',')"></xsl:with-param>
	   </xsl:call-template>
			{/select}
	</xsl:when>
	<xsl:when test="$tipoField = 'set'">
		<xsl:variable name="apos">'</xsl:variable>
			{select name="<xsl:value-of select="ancestor::table/name"/>__<xsl:value-of select="name"/>" class="campos"}
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
<scenarios ><scenario default="yes" name="Scenario1" userelativepaths="yes" externalpreview="no" url="file://d:\My Documents\Tesis\Metadatos\dbpruebamysql2.xml" htmlbaseurl="" outputurl="" processortype="internal" profilemode="0" urlprofilexml="" commandline="" additionalpath="" additionalclasspath="" postprocessortype="none" postprocesscommandline="" postprocessadditionalpath="" postprocessgeneratedext="" ><parameterValue name="tabla" value="'contrato_alquiler'"/><parameterValue name="empresa" value="'Wis'"/><parameterValue name="aplicacion" value="'GS'"/></scenario></scenarios><MapperInfo srcSchemaPath="" srcSchemaRoot="" srcSchemaPathIsRelative="yes" srcSchemaInterpretAsXML="no" destSchemaPath="" destSchemaRoot="" destSchemaPathIsRelative="yes" destSchemaInterpretAsXML="no"/>
</metaInformation>
-->