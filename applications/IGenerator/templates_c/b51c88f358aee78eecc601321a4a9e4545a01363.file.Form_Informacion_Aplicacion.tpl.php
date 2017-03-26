<?php /* Smarty version Smarty-3.1.18, created on 2015-07-04 05:12:45
         compiled from "F:\Appserver\xampp\htdocs\ingravity\applications\IGenerator\web\templates\Form_Informacion_Aplicacion.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1864455974f2dcd81f7-14660106%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b51c88f358aee78eecc601321a4a9e4545a01363' => 
    array (
      0 => 'F:\\Appserver\\xampp\\htdocs\\ingravity\\applications\\IGenerator\\web\\templates\\Form_Informacion_Aplicacion.tpl',
      1 => 1435978836,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1864455974f2dcd81f7-14660106',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'type' => 0,
    'host' => 0,
    'user' => 0,
    'pass' => 0,
    'cod_message' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_55974f2df259f5_84771068',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55974f2df259f5_84771068')) {function content_55974f2df259f5_84771068($_smarty_tpl) {?><?php if (!is_callable('smarty_block_form')) include 'F:\\Appserver\\xampp\\htdocs\\ingravity\\applications\\IGenerator/web/plugins\\block.form.php';
if (!is_callable('smarty_function_show_list_catalogos')) include 'F:\\Appserver\\xampp\\htdocs\\ingravity\\applications\\IGenerator/web/plugins\\function.show_list_catalogos.php';
if (!is_callable('smarty_function_textfield')) include 'F:\\Appserver\\xampp\\htdocs\\ingravity\\applications\\IGenerator/web/plugins\\function.textfield.php';
if (!is_callable('smarty_function_select_charset')) include 'F:\\Appserver\\xampp\\htdocs\\ingravity\\applications\\IGenerator/web/plugins\\function.select_charset.php';
if (!is_callable('smarty_function_btn_command')) include 'F:\\Appserver\\xampp\\htdocs\\ingravity\\applications\\IGenerator/web/plugins\\function.btn_command.php';
if (!is_callable('smarty_function_hidden')) include 'F:\\Appserver\\xampp\\htdocs\\ingravity\\applications\\IGenerator/web/plugins\\function.hidden.php';
if (!is_callable('smarty_block_fieldset')) include 'F:\\Appserver\\xampp\\htdocs\\ingravity\\applications\\IGenerator/web/plugins\\block.fieldset.php';
?><HTML>
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

            <?php $_smarty_tpl->smarty->_tag_stack[] = array('form', array('name'=>"frm_InfoApplication",'method'=>"post")); $_block_repeat=true; echo smarty_block_form(array('name'=>"frm_InfoApplication",'method'=>"post"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

            <table border="0" align="center">
               <tr>
                  <td align="right">* Catolog Name :</td>
                  <td><?php echo smarty_function_show_list_catalogos(array('name'=>"catalogo",'type'=>$_smarty_tpl->tpl_vars['type']->value,'host'=>$_smarty_tpl->tpl_vars['host']->value,'user'=>$_smarty_tpl->tpl_vars['user']->value,'pass'=>$_smarty_tpl->tpl_vars['pass']->value),$_smarty_tpl);?>
</td>
               </tr>
               <tr>
                  <td align="right">* Company Name :</td>
                  <td><?php echo smarty_function_textfield(array('name'=>"name_company",'maxlength'=>"20",'typeData'=>"sin_caracteres_especiales"),$_smarty_tpl);?>
</td>
               </tr>
               <tr>
                  <td align="right">* Application Name :</td>
                  <td><?php echo smarty_function_textfield(array('name'=>"name_application",'maxlength'=>"40",'typeData'=>"sin_caracteres_especiales"),$_smarty_tpl);?>
</td>
               </tr>
               <tr>
                  <td align="right">* Encoding :</td>
                  <td><?php echo smarty_function_select_charset(array('name'=>"charset"),$_smarty_tpl);?>
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
                    	<td><?php echo smarty_function_btn_command(array('type'=>"button",'value'=>"Next",'name'=>"CmdDefaultLookAndFeel",'form_name'=>"frm_InfoApplication"),$_smarty_tpl);?>
</td>
                		<td><?php echo smarty_function_btn_command(array('type'=>"button",'value'=>"Cancel",'name'=>"CmdBackConexionBD",'form_name'=>"frm_InfoApplication"),$_smarty_tpl);?>
</td>
                	</tr>
                </table>
            </div>
            <?php echo smarty_function_hidden(array('name'=>"action",'value'=>''),$_smarty_tpl);?>

            <?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_form(array('name'=>"frm_InfoApplication",'method'=>"post"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

            <div style="position:absolute; left:10px; top:170px; width:500px; height:36px; z-index:2">
            <?php $_smarty_tpl->smarty->_tag_stack[] = array('fieldset', array('legend'=>"Result")); $_block_repeat=true; echo smarty_block_fieldset(array('legend'=>"Result"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

               <?php echo $_smarty_tpl->tpl_vars['cod_message']->value;?>

            <?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_fieldset(array('legend'=>"Result"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

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
</HTML><?php }} ?>
