<?php /* Smarty version 2.6.0, created on 2010-09-07 10:08:33
         compiled from Form_Informacion_Aplicacion.tpl */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'form', 'Form_Informacion_Aplicacion.tpl', 25, false),array('block', 'fieldset', 'Form_Informacion_Aplicacion.tpl', 69, false),array('function', 'show_list_catalogos', 'Form_Informacion_Aplicacion.tpl', 29, false),array('function', 'textfield', 'Form_Informacion_Aplicacion.tpl', 33, false),array('function', 'select_charset', 'Form_Informacion_Aplicacion.tpl', 41, false),array('function', 'btn_command', 'Form_Informacion_Aplicacion.tpl', 61, false),array('function', 'hidden', 'Form_Informacion_Aplicacion.tpl', 66, false),)), $this); ?>
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

            <?php $_params = $this->_tag_stack[] = array('form', array('name' => 'frm_InfoApplication','method' => 'post')); smarty_block_form($_params[1], null, $this, $_block_repeat=true); unset($_params);while ($_block_repeat) { ob_start(); ?>
            <table border="0" align="center">
               <tr>
                  <td align="right">* Catolog Name :</td>
                  <td><?php echo smarty_function_show_list_catalogos(array('name' => 'catalogo','type' => $this->_tpl_vars['type'],'host' => $this->_tpl_vars['host'],'user' => $this->_tpl_vars['user'],'pass' => $this->_tpl_vars['pass']), $this);?>
</td>
               </tr>
               <tr>
                  <td align="right">* Company Name :</td>
                  <td><?php echo smarty_function_textfield(array('name' => 'name_company','maxlength' => '20','typeData' => 'sin_caracteres_especiales'), $this);?>
</td>
               </tr>
               <tr>
                  <td align="right">* Application Name :</td>
                  <td><?php echo smarty_function_textfield(array('name' => 'name_application','maxlength' => '40','typeData' => 'sin_caracteres_especiales'), $this);?>
</td>
               </tr>
               <tr>
                  <td align="right">* Encoding :</td>
                  <td><?php echo smarty_function_select_charset(array('name' => 'charset'), $this);?>
</td>
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
                    	<td><?php echo smarty_function_btn_command(array('type' => 'button','value' => 'Next','name' => 'CmdDefaultLookAndFeel','form_name' => 'frm_InfoApplication'), $this);?>
</td>
                		<td><?php echo smarty_function_btn_command(array('type' => 'button','value' => 'Cancel','name' => 'CmdBackConexionBD','form_name' => 'frm_InfoApplication'), $this);?>
</td>
                	</tr>
                </table>
            </div>
            <?php echo smarty_function_hidden(array('name' => 'action','value' => ""), $this);?>

            <?php $this->_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_form($this->_tag_stack[count($this->_tag_stack)-1][1], $this->_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
            <div style="position:absolute; left:10px; top:170px; width:500px; height:36px; z-index:2">
            <?php $_params = $this->_tag_stack[] = array('fieldset', array('legend' => 'Result')); smarty_block_fieldset($_params[1], null, $this, $_block_repeat=true); unset($_params);while ($_block_repeat) { ob_start(); ?>
               <?php echo $this->_tpl_vars['cod_message']; ?>

            <?php $this->_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_fieldset($this->_tag_stack[count($this->_tag_stack)-1][1], $this->_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
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