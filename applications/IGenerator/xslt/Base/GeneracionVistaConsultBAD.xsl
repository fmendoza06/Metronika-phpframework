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
&lt;head&gt;
      &lt;title&gt;Consultar <xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>&lt;/title&gt;
	  {meta}
	  &lt;script language='JavaScript' src='web/js/disableButtons.js'&gt;&lt;/script&gt;
          &lt;script language='JavaScript' src='web/js/overlib.js''&gt;&lt;/script&gt;

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
<xsl:template match="declaration">
&lt;body&gt;
&lt;table width="100%" border="0" cellspacing="0" cellpadding="0" class1=adminlist&gt;
  &lt;tr&gt;
    &lt;td align="center"&gt;
       &lt;table width="1024" border="0" cellspacing="0" cellpadding="0"&gt;
        &lt;tr&gt;
          &lt;td&gt;
               {include file="Form_TopMenu.tpl" }
               &lt;div class="clr"&gt;&lt;/div&gt;



{form name="frm<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>Consult" method="get"}

   {tools_barstandardsp type="Button" reference_id =100 
                        form_name="frm<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/>"
                        commands="<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdDefault<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>,<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdShowById<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>,                            <xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdDelete<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>,default,<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdHelp<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>"
                        images="new_f2.png,edit_f2.png,cancel_f2.png,back_f2.png,help_f2.png" 
                        titles="Nuevo,Editar,Eliminar,Volver,Ayuda"  
   }

   &lt;div class="main"&gt;
		&lt;table class="adminheading"&gt;
		&lt;tr&gt;
			&lt;th class="frontpage" rowspan="2"&gt;
            &lt;img src="./web/images/menu/<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>.png" &lt;/img&gt;
			Configuracion de Tabla
            &lt;/th&gt;

		&lt;/tr&gt;

		&lt;/table&gt;

  &lt;div&gt;


&lt;table border=0  cellpadding=0 align="center" class=adminlist width=100%&gt;
        &lt;tr align="right" colspan=2&gt;
           &lt;th colspan1=8 class="detailedViewHeader"&gt;
             &lt;b&gt; {usuario} &lt;/b&gt;
        &lt;/tr&gt;
	&lt;tr&gt;
		&lt;td&gt;{consult_table_referenciasp type="LIST" 
                                        table_name="<xsl:value-of select="ancestor::table/name"/>"
                                        llaves="<xsl:apply-templates mode="CamposLlavesTabla" select="primary_key/field"/>,<xsl:apply-templates mode="CamposLlavesTabla" select="primary_key/field"/>"
                                        form_name="frm<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>Consult"
                                        command="<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdShowList<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>"     
                                        command_showbyid="<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdShowById<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>"
                                        DataGateway="<xsl:value-of select="ancestor::table/name"/>"
                                        filter=ID,Id,DESC,Descripcion
                                        titulos=".,Id,Descripcion"
                                        cantidad_registros=20
                     }
        &lt;/td&gt;
	&lt;/tr&gt;

&lt;/table&gt;






{hidden name="action" value=""}
{/form}
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
               {include file="footer.tpl" }


    &lt;td&gt;
  &lt;tr&gt;
&lt;/table&gt;

&lt;/body&gt;</xsl:template>

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
<scenarios ><scenario default="yes" name="Scenario1" userelativepaths="yes" externalpreview="no" url="file://d:\My Documents\Tesis\Metadatos\dbpruebamysql2.xml" htmlbaseurl="" outputurl="" processortype="internal" profilemode="0" urlprofilexml="" commandline="" additionalpath="" additionalclasspath="" postprocessortype="none" postprocesscommandline="" postprocessadditionalpath="" postprocessgeneratedext="" ><parameterValue name="tabla" value="'ciudad'"/><parameterValue name="empresa" value="'GS'"/><parameterValue name="aplicacion" value="'Pro'"/></scenario></scenarios><MapperInfo srcSchemaPath="" srcSchemaRoot="" srcSchemaPathIsRelative="yes" srcSchemaInterpretAsXML="no" destSchemaPath="" destSchemaRoot="" destSchemaPathIsRelative="yes" destSchemaInterpretAsXML="no"/>
</metaInformation>
-->