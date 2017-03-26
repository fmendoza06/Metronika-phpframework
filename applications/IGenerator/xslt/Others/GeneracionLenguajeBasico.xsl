<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<!-- El modo al que transformará el XSL --> 
<xsl:output  method="text"/>

<!-- Paramatro que contiene el nombre de la tabla -->
<xsl:param name="tabla"/>
<!-- Abre y cierra el documento PHP -->    
<xsl:template match="/">&lt;?php
<xsl:apply-templates/>
?&gt;	
</xsl:template>
<!-- selecciona la tabla que corresponda al parametro 'tabla' -->      
<xsl:template match="database">  
    <xsl:apply-templates select="table[name=$tabla]" />
</xsl:template>
<xsl:template match="table">
/*
 This is the language's file to the  <xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template> table
*/
$rcMsg = array("delete" => "Seguro desea eliminar el registro?",
			   "active" => "Activo",
			   "inactive" => "Inactivo");
$rclabels = array("title"=>"<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>",
				  "consulttitle"=>"<xsl:call-template name="convertpropercase"><xsl:with-param name="toconvert" select="name"/></xsl:call-template>",
				  "context_help"=>"",
<xsl:apply-templates select="declaration" />);
</xsl:template>
<xsl:template match="declaration">
<xsl:apply-templates mode="CamposTabla" select="field"/>
</xsl:template>
<!-- Optiene todos los field de la tabla, para armar el resto del arreglo' --> 
<xsl:template mode="CamposTabla" match="field">"<xsl:value-of select="name"/>"=>array("label"=>"<xsl:value-of select="name"/>","accesskey"=>true,"commentary"=>""),
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

</xsl:stylesheet>