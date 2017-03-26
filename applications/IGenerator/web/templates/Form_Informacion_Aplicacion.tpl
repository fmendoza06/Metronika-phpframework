<HTML>
<HEAD>
 <title>Informacion Aplicacion</title>
 <script language="JavaScript" src="web/js/disableButtons.js"></script>
 <link href="web/css/estilos.css" rel="stylesheet" type="text/css">
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">  
</HEAD>

<BODY>
<div style="position:absolute; left:186px; top:98px; width:660px; height:20px; z-index:1" >
  <table width="600" height="332" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
     <td width="36" height="38" valign="top"><img src="web/images/topleft.gif" width=35 height=38 alt=""></td>

      <td width="600" rowspan="3">
        <div style="position:absolute; left:65px; top:0px; width:525px; height:8px; z-index:1">
          <table width="100%"  border="0" cellpadding="0" cellspacing="0" background="web/images/top.gif">
       <tr>
         <td><IMG SRC="web/images/usuario_03.gif" WIDTH=5 HEIGHT=6 ALT=""></td>
       </tr>
     </table>
	 </div>
            <div style="position:absolute; left:65px; top:65px; width:525px; height:20px; z-index:1" >

            {form name="frm_InfoApplication" method="post"}
            <table border="0" align="center">
               <tr>
                  <td align="right">* Catolog Name :</td>
                  <td>{show_list_catalogos name="catalogo" type=$type host=$host user=$user pass=$pass }</td>
               </tr>
               <tr>
                  <td align="right">* Company Name :</td>
                  <td>{textfield name="name_company" maxlength="20" typeData = "sin_caracteres_especiales"}</td>
               </tr>
               <tr>
                  <td align="right">* Application Name :</td>
                  <td>{textfield name="name_application" maxlength="40" typeData = "sin_caracteres_especiales"}</td>
               </tr>
               <tr>
                  <td align="right">* Encoding :</td>
                  <td>{select_charset name="charset"}</td>
               </tr>
               
               <tr>
                  <td align="right">* Generation Type :</td>
                  <td>
                      <input name="gen_type" type="radio" value="native"
                       OnClick="frm_InfoApplication.gen_type.value='native'";
                      >Native
                      <input name="gen_type" type="radio" value="adodb" checked
                       OnClick="frm_InfoApplication.gen_type.value='adodb'";
                      > ADODB
                  </td>
               </tr>

            </table>

            <div style="position:absolute; left:356px; top:211px; width:84px; height:36px; z-index:2">
                <table border="0" align="center">
                	<tr>
                    	<td>{btn_command type="button" value="Next" name="CmdDefaultLookAndFeel" form_name="frm_InfoApplication"}</td>
                		<td>{btn_command type="button" value="Cancel" name="CmdBackConexionBD" form_name="frm_InfoApplication"}</td>
                	</tr>
                </table>
            </div>
            {hidden name="action" value=""}
            {/form}
            <div style="position:absolute; left:10px; top:170px; width:500px; height:36px; z-index:2">
            {fieldset legend="Result"}
               {$cod_message}
            {/fieldset}
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
</BODY>
</HTML>