<html>
<head>
      <title>Resultado</title>
	  <link href="web/css/estilo_textarea.css"  rel="stylesheet" type="text/css">
	  <script language="JavaScript" src="web/js/disableButtons.js"></script>
 	  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
</head>
<body>
<div style="position:absolute; left:186px; top:98px; width:660px; height:20px; z-index:1" >
  <table width="600" height="332" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
     <td width="36" height="38" valign="top"><img src="web/images/topleft.gif" width=35 height=38 alt=""></td>

      <td width="600" rowspan="3">
        <div style="position:absolute; left:65px; top:0px; width:525px; height:8px; z-index:1">
          <table width="100%"  border="0" cellpadding="0" cellspacing="0" background="web/images/top.gif">
       <tr>
         <td><IMG SRC="web/images/top.gif" WIDTH=5 HEIGHT=6 ALT=""></td>
       </tr>
     </table>
	 </div>
            <div style="position:absolute; left:65px; top:65px; width:525px; height:20px; z-index:1" >

            {form name="frm_resultado" method="post"}
           
            <div style="position:absolute; left:411px; top:195px; width:84px; height:36px; z-index:2">
                <table border="0" align="center">
                	<tr>
                	    <td>{btn_command type="button" value="Return.." name="CmdBackInformacionAplicacion" form_name="frm_resultado"}</td>
                	</tr>
                </table>
            </div>
			
			{hidden name="action" value=""}
            {/form}
            <div style="position:absolute; left:32px; top:-41px; width:437px; height:189px; z-index:2">
			  <fieldset>
				<legend>Result</legend>
				 {show_result value=$text_result}
		      </fieldset> 
            </div>
            </div>
        <div style="position:absolute; left:65px; top:314px; width:525px; height:20px; z-index:1" >
          <table width="100%"  border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td background="web/images/down.gif"><IMG SRC="web/images/down.gif" WIDTH=8 HEIGHT=18 ALT=""></td>
         </tr>
       </table>
      </div>
      </td>
     <td width="40" valign="top"><img src="web/images/topright.gif" width=39 height=38 alt=""></td>
   </tr>
   <tr>
      <td width="2" background="web/images/left.gif">&nbsp;</td>
     <td background="web/images/right.gif">&nbsp;</td>
   </tr>
   <tr>
     <td height="48" valign="top"><img src="web/images/downleft.gif" width=36 height=48 alt=""></td>
     <td valign="top"><img src="web/images/downright.gif" width=39 height=48 alt=""></td>
   </tr>
 </table>
</div>

<div style="position:absolute; left:287px; top:350px; width:122px; height:28px; z-index:1"><img src="web/images/logopdf.jpg" width="147" height="49"></div>

</html>
