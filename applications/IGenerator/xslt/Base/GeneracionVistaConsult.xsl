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

<xsl:template match = "/">
<!-- Carga el Archivo de lenguaje para este Template -->
{config_load file="Templates.lan" section="<xsl:value-of select="$tabla"/>"}
&lt;!DOCTYPE html&gt;
&lt;html&gt;<xsl:apply-templates/>
&lt;/html&gt;
</xsl:template>

<!-- Busca y se ubica en el database del metadata -->
<xsl:template match="database">
<xsl:apply-templates select="table[name=$tabla]"/>
</xsl:template>

<!-- Se crea el encabezado de la pagina -->
<xsl:template match="table">
&lt;head&gt;
	  &lt;meta name="viewport" content="width=device-width, initial-scale=1.0"&gt;
	  &lt;title&gt;{#TITLE#} | SER - Servicio Electrónico de Recaudo.&lt;/title&gt;

      {meta}
	  
	  <xsl:call-template name="estilos"/>
&lt;/head&gt;<xsl:apply-templates select="declaration"/>
</xsl:template>
<!-- ******************************************* -->
<xsl:template name="estilos">
	{include file="css.tpl"}
</xsl:template>
<!-- ******************************************* -->
<xsl:template match="declaration">
&lt;body&gt;
	&lt;div id="container" class="effect mainnav-lg"&gt;
		
		&lt;!--NAVBAR--&gt;
		&lt;!--===================================================--&gt;
          {include file="nav_bar.tpl"}
		&lt;!--===================================================--&gt;
		&lt;!--END NAVBAR--&gt;

		&lt;div class="boxed"&gt;

			&lt;!--CONTENT CONTAINER--&gt;
			&lt;!--===================================================--&gt;
			&lt;div id="content-container"&gt;
				
				&lt;!--Page Title--&gt;
				&lt;!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~--&gt;
				&lt;!--
				&lt;div id="page-title"&gt;
					&lt;h1 class="page-header text-overflow"&gt;{#TITLECONSULT#}&lt;/h1&gt;
				&lt;/div&gt;
				--&lt;
				&lt;!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~--&gt;
				&lt;!--End page title--&gt;


				&lt;!--Breadcrumb--&gt;
				&lt;!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~--&gt;
				&lt;ol class="breadcrumb"&gt;
					&lt;li&gt;&lt;a href="#"&gt;Inicio&lt;/a&gt;&lt;/li&gt;
					&lt;li class="active"&gt;&lt;a href="#"&gt;Menu&lt;/a&gt;&lt;/li&gt;
				&lt;/ol&gt;
				&lt;!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~--&gt;
				&lt;!--End breadcrumb--&gt;


		

				&lt;!--Page content--&gt; 
				&lt;!--===================================================--&gt;
				&lt;div id="page-content"&gt;
					&lt;div class="row"&gt;		 		

						 &lt;div class="col-lg-12"&gt;
							&lt;div class="panel panel-primary"&gt;
							
								&lt;div class="panel-heading"&gt;
									&lt;h3 class="panel-title"&gt;&lt;i class="fa fa-users fa-lg"&gt;&lt;/i&gt;{#TITLECONSULT#}&lt;/h3&gt;
								&lt;/div&gt;

					           {form name="frm<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>Consult" class='form-horizontal' method="post" id="frm<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>Consult"}
                                          {tools_barstandard type="Button" reference_id =100 
                                             form_name="frm<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>Consult"
                                             commands="<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdDefault<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>,<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdShowById<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>,<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdDelete<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>,default,<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdHelp<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>"
                                             icon_class="fa-file,fa-pencil-square-o,fa-trash,fa-reply,fa-life-ring" 
						                     btn_class ="btn-success,btn-info,btn-danger,btn-warning,btn-mint" 
                                             labels="new,edit,del,back,help"  
                                          }	
									&lt;div class="panel-body"&gt;
					
										&lt;!--NOT EMPTY VALIDATOR--&gt;
										&lt;!--===================================================--&gt;	
										&lt;fieldset&gt;
                                        {consult_table_referenciasp type="LIST" 
                                           table_name="<xsl:value-of select="ancestor::table/name"/>" 
                                           llaves="<xsl:apply-templates mode="CamposLlavesTabla" select="primary_key/field"/>"
                                           form_name="frm<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>Consult"
                                           command="<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdShowList<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>"     
                                           command_showbyid="<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdShowById<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>"
                                           DataGateway="<xsl:value-of select="ancestor::table/name"/>"
                                           filter="<xsl:apply-templates mode="TODOS_LOS_CAMPOS" select="field"/>"
                                           titulos=".,<xsl:apply-templates mode="TODOS_LOS_CAMPOS" select="field"/>"
                                           cantidad_registros=20
                                        }
										&lt;/fieldset&gt;
                                    &lt;/div&gt;
									&lt;div class="panel-footer"&gt;
										&lt;div class="row"&gt;
											&lt;div class="col-sm-7 col-sm-offset-3"&gt;
												
											&lt;/div&gt;
										&lt;/div&gt;
									&lt;/div&gt;
                                      {hidden name="action" value=""}
                                     {hidden name="section_language" value="<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="ancestor::table/name"/></xsl:call-template>"}
                               {/form}
							   {include file="mandatory.tpl" }
							&lt;/div&gt;
						 &lt;/div&gt;



                       {messagebox id=$cod_message}

                       {spyro_info}
					&lt;/div&gt; &lt;!-- Fin de Row --&gt;
					
					
				&lt;/div&gt;
				&lt;!--===================================================--&gt;
				&lt;!--End page content--&gt;


			&lt;/div&gt;
			&lt;!--===================================================--&gt;
			&lt;!--END CONTENT CONTAINER--&gt;


			
			&lt;!--MAIN NAVIGATION--&gt;
			&lt;!--===================================================--&gt;
			&lt;nav id="mainnav-container"&gt;
				&lt;div id="mainnav"&gt;

					&lt;!--Shortcut buttons--&gt;
					&lt;!--================================--&gt;
                      {include file="short_cut.tpl" }
					&lt;!--================================--&gt;
					&lt;!--End shortcut buttons--&gt;

					&lt;!--Menu--&gt;
					&lt;!--================================--&gt;
                      {include file="menu.tpl" }
					&lt;!--================================--&gt;
					&lt;!--End menu--&gt;
					
					&lt;!--================================--&gt;
					&lt;!--End menu--&gt;

				&lt;/div&gt;
			&lt;/nav&gt;
			&lt;!--===================================================--&gt;
			&lt;!--END MAIN NAVIGATION--&gt;
			
			&lt;!--ASIDE--&gt;
			&lt;!--===================================================--&gt;
                       {include file="aside.tpl" }
			&lt;!--===================================================--&gt;
			&lt;!--END ASIDE--&gt;

		&lt;/div&gt;

		

		&lt;!-- FOOTER --&gt;
		&lt;!--===================================================--&gt;
         {include file="footer_page.tpl" }
		&lt;!--===================================================--&gt;
		&lt;!-- END FOOTER --&gt;


		&lt;!-- SCROLL TOP BUTTON --&gt;
		&lt;!--===================================================--&gt;
		&lt;button id="scroll-top" class="btn"&gt;&lt;i class="fa fa-chevron-up"&gt;&lt;/i&gt;&lt;/button&gt;
		&lt;!--===================================================--&gt;



	&lt;/div&gt;
	&lt;!--===================================================--&gt;
	&lt;!-- END OF CONTAINER --&gt;
	
	&lt;!-- SETTINGS --&gt;
	&lt;!--===================================================--&gt;
           {include file="settings.tpl" }
	&lt;!--===================================================--&gt;
	&lt;!-- END SETTINGS --&gt;	

	&lt;!--JAVASCRIPT--&gt;
	&lt;!--=================================================--&gt;
           {include file="javascript.tpl" }
	&lt;!--===================================================--&gt;
	&lt;!-- END JAVASCRIPT --&gt;	
	
	
		

&lt;/body&gt;
</xsl:template>

<xsl:template mode="CamposLlavesTabla" match="primary_key/field">
  <xsl:if test="position() = 1"><xsl:value-of select="name"/></xsl:if>
  <xsl:if test="position() != 1">,<xsl:value-of select="name"/></xsl:if>
</xsl:template>

  <!-- Trae todos los campos de la tabla -->
  <xsl:template mode="TODOS_LOS_CAMPOS" match="field">
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