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

<xsl:template match="database">&lt;!DOCTYPE html&gt;
&lt;html lang="en"&gt;

&lt;head&gt;
	&lt;meta charset="utf-8"&gt;
	&lt;meta name="viewport" content="width=device-width, initial-scale=1.0"&gt;
	&lt;title&gt;Inicio | SER - Servicio Electrónico de Recaudo.&lt;/title&gt;


	&lt;!--STYLESHEET--&gt;
	&lt;!--=================================================--&gt;

	&lt;!--Open Sans Font   OPTIONAL   --&gt;
 	&lt;link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&amp;subset=latin" rel="stylesheet"&gt;


	&lt;!--Bootstrap Stylesheet   REQUIRED  --&gt;
	&lt;link href="web/template/css/bootstrap.min.css" rel="stylesheet"&gt;


	&lt;!--Nifty Stylesheet   REQUIRED  --&gt;
	&lt;link href="web/template/css/nifty.min.css" rel="stylesheet"&gt;

	
	&lt;!--Font Awesome   OPTIONAL  --&gt;
	&lt;link href="web/template/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"&gt;


	&lt;!--Switchery   OPTIONAL  --&gt;
	&lt;link href="web/template/plugins/switchery/switchery.min.css" rel="stylesheet"&gt;


	&lt;!--Bootstrap Select   OPTIONAL  --&gt;
	&lt;link href="web/template/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet"&gt;


	&lt;!--FooTable   OPTIONAL  --&gt;
	&lt;link href="web/template/plugins/fooTable/css/footable.core.css" rel="stylesheet"&gt;


	&lt;!--Demo   DEMONSTRATION  --&gt;
	&lt;link href="web/template/css/demo/nifty-demo.min.css" rel="stylesheet"&gt;


	&lt;!--SCRIPT--&gt;
	&lt;!--=================================================--&gt;

	&lt;!--Page Load Progress Bar   OPTIONAL  --&gt;
	&lt;link href="web/template/plugins/pace/pace.min.css" rel="stylesheet"&gt;
	&lt;script src="web/template/plugins/pace/pace.min.js"&gt;&lt;/script&gt;


	
	&lt;!--

	REQUIRED
	You must include this in your project.

	RECOMMENDED
	This category must be included but you may modify which plugins or components which should be included in your project.

	OPTIONAL
	Optional plugins. You may choose whether to include it in your project or not.

	DEMONSTRATION
	This is to be removed, used for demonstration purposes only. This category must not be included in your project.

	SAMPLE
	Some script samples which explain how to initialize plugins or components. This category should not be included in your project.


	Detailed information and more samples can be found in the document.

	--&gt;
		

&lt;/head&gt;

&lt;!--TIPS--&gt;
&lt;!--You may remove all ID or Class names which contain "demo-", they are only used for demonstration. --&gt;

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
				&lt;div id="page-title"&gt;
					&lt;h1 class="page-header text-overflow"&gt;Configuracion de Tipo&lt;/h1&gt;
									&lt;button class="btn btn-default" &gt;&lt;a href="tipo.html"&gt;Adicionar&lt;/a&gt;&lt;/button&gt;
									&lt;button class="btn btn-primary"&gt;Modificar&lt;/button&gt;
									&lt;button class="btn btn-success"&gt;Eliminar&lt;/button&gt;									
									&lt;button class="btn btn-info"&gt;Regresar&lt;/button&gt;
									&lt;button class="btn btn-info"&gt;Ayuda&lt;/button&gt;									
					&lt;!--Searchbox--&gt;
					
					&lt;div class="searchbox"&gt;
						&lt;div class="input-group custom-search-form"&gt;
							&lt;input type="text" class="form-control" placeholder="Search.."&gt;
							&lt;span class="input-group-btn"&gt;
								&lt;button class="text-muted" type="button"&gt;&lt;i class="fa fa-search"&gt;&lt;/i&gt;&lt;/button&gt;
							&lt;/span&gt;
						&lt;/div&gt;
					&lt;/div&gt;
					
					
                     						
				&lt;/div&gt;
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
					{form name="frmMenu" method="get"}

				       {hidden name="action" value=""}
                    {/form}
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

					&lt;!--Menu--&gt;
					&lt;!--================================--&gt;
					&lt;div id="mainnav-menu-wrap"&gt;
						&lt;div class="nano"&gt;
							&lt;div class="nano-content"&gt;
								&lt;ul id="mainnav-menu" class="list-group"&gt;
						
									&lt;!--Category name--&gt;
									&lt;li class="list-header"&gt;Menu de Navegacion&lt;/li&gt;
						
									&lt;!--Menu list item--&gt;
									&lt;li&gt;
										&lt;a href="index.html"&gt;
											&lt;i class="fa fa-dashboard"&gt;&lt;/i&gt;
											&lt;span class="menu-title"&gt;
												&lt;strong&gt;Inicio&lt;/strong&gt;
												&lt;span class="label label-success pull-right"&gt;Top&lt;/span&gt;
											&lt;/span&gt;
										&lt;/a&gt;
									&lt;/li&gt;
						
<xsl:apply-templates select="table" mode="EnlaceTabla"/>								

								&lt;/ul&gt;


								&lt;!--Widget--&gt;
								&lt;!--================================--&gt;
								&lt;div class="mainnav-widget"&gt;

									&lt;!-- Show the button on collapsed navigation --&gt;
									&lt;div class="show-small"&gt;
										&lt;a href="#" data-toggle="menu-widget" data-target="#demo-wg-server"&gt;
											&lt;i class="fa fa-desktop"&gt;&lt;/i&gt;
										&lt;/a&gt;
									&lt;/div&gt;

									&lt;!-- Hide the content on collapsed navigation --&gt;
									&lt;div id="demo-wg-server" class="hide-small mainnav-widget-content"&gt;
										&lt;ul class="list-group"&gt;
											&lt;li class="list-header pad-no pad-ver"&gt;Server Status&lt;/li&gt;
											&lt;li class="mar-btm"&gt;
												&lt;span class="label label-primary pull-right"&gt;15%&lt;/span&gt;
												&lt;p&gt;CPU Usage&lt;/p&gt;
												&lt;div class="progress progress-sm"&gt;
													&lt;div class="progress-bar progress-bar-primary" style="width: 15%;"&gt;
														&lt;span class="sr-only"&gt;15%&lt;/span&gt;
													&lt;/div&gt;
												&lt;/div&gt;
											&lt;/li&gt;
											&lt;li class="mar-btm"&gt;
												&lt;span class="label label-purple pull-right"&gt;75%&lt;/span&gt;
												&lt;p&gt;Bandwidth&lt;/p&gt;
												&lt;div class="progress progress-sm"&gt;
													&lt;div class="progress-bar progress-bar-purple" style="width: 75%;"&gt;
														&lt;span class="sr-only"&gt;75%&lt;/span&gt;
													&lt;/div&gt;
												&lt;/div&gt;
											&lt;/li&gt;
											&lt;li class="pad-ver"&gt;&lt;a href="#" class="btn btn-success btn-bock"&gt;View Details&lt;/a&gt;&lt;/li&gt;
										&lt;/ul&gt;
									&lt;/div&gt;
								&lt;/div&gt;
								&lt;!--================================--&gt;
								&lt;!--End widget--&gt;

							&lt;/div&gt;
						&lt;/div&gt;
					&lt;/div&gt;
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

	&lt;!--JAVASCRIPT--&gt;
	&lt;!--=================================================--&gt;

	&lt;!--jQuery   REQUIRED  --&gt;
	&lt;script src="web/template/js/jquery-2.1.1.min.js"&gt;&lt;/script&gt;


	&lt;!--BootstrapJS   RECOMMENDED  --&gt;
	&lt;script src="web/template/js/bootstrap.min.js"&gt;&lt;/script&gt;


	&lt;!--Fast Click   OPTIONAL  --&gt;
	&lt;script src="web/template/plugins/fast-click/fastclick.min.js"&gt;&lt;/script&gt;

	
	&lt;!--Nifty Admin   RECOMMENDED  --&gt;
	&lt;script src="web/template/js/nifty.min.js"&gt;&lt;/script&gt;


	&lt;!--Switchery   OPTIONAL  --&gt;
	&lt;script src="web/template/plugins/switchery/switchery.min.js"&gt;&lt;/script&gt;


	&lt;!--Bootstrap Select   OPTIONAL  --&gt;
	&lt;script src="web/template/plugins/bootstrap-select/bootstrap-select.min.js"&gt;&lt;/script&gt;


	&lt;!--FooTable   OPTIONAL  --&gt;
	&lt;script src="web/template/plugins/fooTable/dist/footable.all.min.js"&gt;&lt;/script&gt;


	&lt;!--Demo script   DEMONSTRATION  --&gt;
	&lt;script src="web/template/js/demo/nifty-demo.min.js"&gt;&lt;/script&gt;


	&lt;!--FooTable Example   SAMPLE  --&gt;
	&lt;script src="web/template/js/demo/tables-footable.js"&gt;&lt;/script&gt;
	
	
		

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
		                   {menu_item name="<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdShowList<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>"
                                      id="<xsl:value-of select="$empresa"/><xsl:value-of select="$aplicacion"/>CmdShowList<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>"
                                      label="<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>"
                                      divider="OFF"
                                      class="fa-th"
									  icon_size="lg"
                                      image="web/images/menu/other.png"
                                      alt="<xsl:value-of select='$empresa'/><xsl:value-of select='$aplicacion'/>"

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