<HTML>
<HEAD>
 <title>Conexion Base de Datos</title>
 <link href="web/css/estilos.css" rel="stylesheet" type="text/css">
 <script language="JavaScript" src="web/js/disableButtons.js"></script>
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
         <td><IMG SRC="web/images/top.gif" WIDTH=5 HEIGHT=6 ALT=""></td>
       </tr>
     </table>
	 </div>
            <div style="position:absolute; left:65px; top:65px; width:525px; height:20px; z-index:1" >
            {form name="frm_Connection_db" method="post"}
            <table border="0" align="center">
               <tr>
                  <td align="right">Data Base Manager System :</td>
                  <td>{select name="type_db"}
            	           {option select_name="type_db" value="mysql"}Mysql{/option}
                           {option select_name="type_db" value="pgsql"}PostgreSQL{/option}
                           {option select_name="type_db" value="oci8"}Oracle{/option}
               		  {/select}
            	  </td>
               </tr>
               <tr>
                  <td align="right">Server :</td>
                  <td>{textfield name="server" maxlength="60"} <b>HOST:PORT</b></td>
               </tr>
               <tr>
                  <td align="right">Username :</td>
                  <td>{textfield name="user" maxlength="60"}</td>
               </tr>
               <tr>
                  <td align="right">Password :</td>
                  <td>{textfield name="password" type="password" maxlength="60"}</td>
               </tr>
            </table>

            <div style="position:absolute; left:356px; top:211px; width:84px; height:36px; z-index:2">
            <table border="0">
            	<tr>
                	<td>{btn_command type="button" value="Next" name="CmdDefaultInformacionAplicacion" form_name="frm_Connection_db"}</td>
            		<td>{btn_command type="button" value="Cancel" name="CmdBackSelectDir" form_name="frm_Connection_db"}</td>
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





