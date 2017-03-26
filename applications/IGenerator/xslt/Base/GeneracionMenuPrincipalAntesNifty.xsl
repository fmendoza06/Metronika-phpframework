<?xml version='1.0'?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<!-- Nombre de la Empresa -->
<xsl:param name = "empresa"/>
<!-- Nombre de la Aplicacion -->
<xsl:param name = "aplicacion"/>
<!-- Nombre del estilo-->
<xsl:param name = "style"/>

<!-- El modo al que transformará el XSL --> 
<xsl:output method="text"/> 

<xsl:template match="database">&lt;html&gt;
&lt;head&gt;
       &lt;title&gt; Menu Principal&lt;/title&gt;
      

      &lt;script language='JavaScript' src='web/js/disableButtons.js'&gt;&lt;/script&gt;

      &lt;script language='JavaScript' src='web/js/overlib.js'&gt;&lt;/script&gt;

      &lt;script type="text/javascript" src='web/js/jsrsClient.js'&gt;&lt;/script&gt;
	&lt;link href="web/css/Spyrodefault.css.css" rel="stylesheet" type="text/css"&gt;
	&lt;link href="web/css/template_css.css" rel="stylesheet" type="text/css"&gt;	  
	  
	   <xsl:call-template name="estilos"/>
&lt;/head&gt;
&lt;body&gt;

&lt;table width="100%" border="0" cellspacing="0" cellpadding="0" class1=adminlist&gt;
  &lt;tr&gt;
    &lt;td align="center"&gt;
       &lt;table width="1024" border="0" cellspacing="0" cellpadding="0"&gt;
        &lt;tr&gt;
          &lt;td&gt;
               {include file="Form_TopMenu.tpl" }
			   

{form name="frmMenu" method="get"}


   &lt;div class="main"&gt;
		&lt;table class="adminheading"&gt;
		&lt;tr&gt;
			&lt;th class="frontpage" rowspan="2"&gt;
            &lt;img src="web/images/menu/menu.png" &lt;/img&gt;
			Mi Menu <xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>
            &lt;/th&gt;

		&lt;/tr&gt;

		&lt;/table&gt;

  &lt;div&gt;

&lt;table border="0" align="center" width=50% class="adminform">
  		&lt;table class="adminform" width="100%"&gt;

		  &lt;tr&gt;

		    &lt;td width="100%" valign="center"&gt;

			  &lt;div id="cpanel"&gt;
<xsl:apply-templates select="table" mode="EnlaceTabla"/>
			  &lt;/div&gt;

           &lt;/td&gt;

          &lt;/tr&gt;

        &lt;/table&gt;
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
            {include file="Form_FooterMenu.tpl" }

    &lt;td&gt;
  &lt;tr&gt;
&lt;/table&gt;
&lt;/body&gt;
&lt;/html&gt;
</xsl:template>

<!-- ******************************************* -->
<xsl:template name="estilos">
	<xsl:if test="$style = 'Global'">&lt;link href="web/css/Spyrodefault.css.css" rel="stylesheet" type="text/css"&gt;</xsl:if>
	<xsl:if test="$style = 'Global'">&lt;link href="web/css/template_css.css" rel="stylesheet" type="text/css"&gt;</xsl:if>
	
</xsl:template>
<!-- ******************************************* -->

<xsl:template match="table" mode="EnlaceTabla"> 
		                   {btn_image name='<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdShowList<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>'

                                      image="web/images/menu/other.png"

                                      alt="<xsl:value-of select='$empresa'/><xsl:value-of select='$aplicacion'/>"

                                      label="<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>"

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

</xsl:stylesheet><!-- Stylus Studio meta-information - (c)1998-2003. Sonic Software Corporation. All rights reserved.
<metaInformation>
<scenarios ><scenario default="yes" name="Scenario1" userelativepaths="yes" externalpreview="no" url="file://d:\My Documents\Tesis\Metadatos\dbpruebamysql2.xml" htmlbaseurl="" outputurl="" processortype="msxml4" profilemode="0" urlprofilexml="" commandline="" additionalpath="" additionalclasspath="" postprocessortype="none" postprocesscommandline="" postprocessadditionalpath="" postprocessgeneratedext="" ><parameterValue name="style" value="'Global'"/></scenario></scenarios><MapperInfo srcSchemaPath="" srcSchemaRoot="" srcSchemaPathIsRelative="yes" srcSchemaInterpretAsXML="no" destSchemaPath="" destSchemaRoot="" destSchemaPathIsRelative="yes" destSchemaInterpretAsXML="no"/>
</metaInformation>
-->