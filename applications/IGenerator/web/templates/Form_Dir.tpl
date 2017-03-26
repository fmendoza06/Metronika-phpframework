<HTML>
<HEAD>
 <title>Dir</title>
 <script language="JavaScript" src="web/js/disableButtons.js"></script>
 <link href="web/css/estilos.css" rel="stylesheet" type="text/css">
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
</HEAD>

<BODY>
<div style="position:absolute; left:186px; top:98px; width:660px; height:20px; z-index:1" >
  <table width="600" height="200" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
     <td width="36" height="38" valign="top"><img src="web/images/topleft.gif" width=35 height=38 alt=""></td>

      <td width="600" rowspan="3">
        <div style="position:absolute; left:65px; top:0px; width:525px; height:8px; z-index:1">
          <table width="100%"  border="0" cellpadding="0" cellspacing="0" background="web/images/top.gif">
            <tr>
               <td><IMG SRC="images/top.gif" WIDTH=5 HEIGHT=6 ALT=""></td>
            </tr>
          </table>
	</div>
	<div style="position:absolute; left:65px; top:65px; width:525px; height:20px; z-index:1" >

         <div style="position:absolute; left:9px; top:-25px; width:498px; height:20px; z-index:1">

                {form name="frm_dir" method="post"}

	        <div style="position:absolute; left:9px; top:-25px; width:498px; height:20px; z-index:1">
			    {ListDir dir="./xslt/"}
		</div>

                <div style="position:absolute; left:345px; top:110px; width:84px; height:36px; z-index:2">
                    <table border="0" align="center">
                	<tr>
                	    <td>{btn_command type="button" value="Siguiente" name="CmdDefaultConexionBD" form_name="frm_dir"}</td>
                	    <td>{btn_command type="button" value="Cancelar" name="default" form_name="frm_dir"}</td>
                	</tr>
                    </table>
                </div>

                {hidden name="action" value=""}
                {/form}
                <div style="position:absolute; left:10px; top:70px; width:500px; height:36px; z-index:2">
                     {fieldset legend="Result"}

                     {/fieldset}
                </div>
        </div>
        <div style="position:absolute; left:0px; top:117px; width:525px; height:20px; z-index:1" >
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
</body>
</html>
