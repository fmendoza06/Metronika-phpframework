<?xml version="1.0" encoding="utf-8"?>
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

<!-- Busca y se ubica en el database del metadata -->
<xsl:template match="database">
<xsl:apply-templates select="table[name=$tabla]"/>
</xsl:template>

<!-- Se crea el encabezado de la pagina -->
<xsl:template match="table">
{loadlabels table_name=<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>&amp;controls[]=CmdCancel}
&lt;head&gt;
      &lt;title&gt;Consultar <xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>&lt;/title&gt;
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
<xsl:template match="declaration">
{body onkeydown="" onload="" onunload=""}
<!-- &lt;div align="center" class="titulo"&gt;Consultar <xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>&lt;/div&gt; -->
<!-- &lt;hr&gt; -->
{form name="frm<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>Consult" method="get"}
{consult_table table_name="<xsl:value-of select="ancestor::table/name"/>" llaves="<xsl:apply-templates mode="CamposLlavesTabla" select="primary_key/field"/>" form_name="frm<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>Consult" sqlid="" command="<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdShowList<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>"}
&lt;br&gt;
&lt;table border="0" align="center" width="90%"&gt;
	&lt;tr&gt;
    	&lt;td class="piedefoto"&gt;
    		&lt;div align="center"&gt;
				{btn_command type="button" value="Cancelar" id="CmdCancel" name="<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdCancelShowList<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>" form_name="frm<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>Consult"}
			&lt;/div&gt;
		&lt;/td&gt;
	&lt;/tr&gt;
&lt;/table&gt;
{hidden name="action" value=""}
{/form}
{putjsacceskey}
{/body}
</xsl:template>


<xsl:template mode="CamposLlavesTabla" match="primary_key/field">
  <xsl:if test="position() = 1"><xsl:value-of select="name"/></xsl:if>
  <xsl:if test="position() != 1">,<xsl:value-of select="name"/></xsl:if>
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
<scenarios ><scenario default="yes" name="Scenario1" userelativepaths="yes" externalpreview="no" url="file://d:\My Documents\Tesis\Metadatos\dbpruebamysql2.xml" htmlbaseurl="" outputurl="" processortype="internal" profilemode="0" urlprofilexml="" commandline="" additionalpath="" additionalclasspath="" postprocessortype="none" postprocesscommandline="" postprocessadditionalpath="" postprocessgeneratedext="" ><parameterValue name="tabla" value="'ciudad'"/><parameterValue name="empresa" value="'GS'"/><parameterValue name="style" value="'Parque'"/><parameterValue name="aplicacion" value="'Pro'"/></scenario></scenarios><MapperInfo srcSchemaPath="" srcSchemaRoot="" srcSchemaPathIsRelative="yes" srcSchemaInterpretAsXML="no" destSchemaPath="" destSchemaRoot="" destSchemaPathIsRelative="yes" destSchemaInterpretAsXML="no"/>
</metaInformation>
-->