<?php /* Smarty version Smarty-3.1.18, created on 2015-06-28 22:13:52
         compiled from "/home/myhostin/public_html/apps/ingravity/applications/IGenerator/web/templates/Form_Conexion_BD.tpl" */ ?>
<?php /*%%SmartyHeaderCode:366167205590b7f0987719-06159864%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b02a306f1dad163a18202bcaddd3fc69e8a945d8' => 
    array (
      0 => '/home/myhostin/public_html/apps/ingravity/applications/IGenerator/web/templates/Form_Conexion_BD.tpl',
      1 => 1435546223,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '366167205590b7f0987719-06159864',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cod_message' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5590b7f09da3e2_48993920',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5590b7f09da3e2_48993920')) {function content_5590b7f09da3e2_48993920($_smarty_tpl) {?><?php if (!is_callable('smarty_block_form')) include '/home/myhostin/public_html/apps/ingravity/applications/IGenerator/web/plugins/block.form.php';
if (!is_callable('smarty_block_select')) include '/home/myhostin/public_html/apps/ingravity/applications/IGenerator/web/plugins/block.select.php';
if (!is_callable('smarty_block_option')) include '/home/myhostin/public_html/apps/ingravity/applications/IGenerator/web/plugins/block.option.php';
if (!is_callable('smarty_function_textfield')) include '/home/myhostin/public_html/apps/ingravity/applications/IGenerator/web/plugins/function.textfield.php';
if (!is_callable('smarty_function_btn_command')) include '/home/myhostin/public_html/apps/ingravity/applications/IGenerator/web/plugins/function.btn_command.php';
if (!is_callable('smarty_function_hidden')) include '/home/myhostin/public_html/apps/ingravity/applications/IGenerator/web/plugins/function.hidden.php';
if (!is_callable('smarty_block_fieldset')) include '/home/myhostin/public_html/apps/ingravity/applications/IGenerator/web/plugins/block.fieldset.php';
?><HTML>
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
            <?php $_smarty_tpl->smarty->_tag_stack[] = array('form', array('name'=>"frm_Connection_db",'method'=>"post")); $_block_repeat=true; echo smarty_block_form(array('name'=>"frm_Connection_db",'method'=>"post"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

            <table border="0" align="center">
               <tr>
                  <td align="right">Data Base Manager System :</td>
                  <td><?php $_smarty_tpl->smarty->_tag_stack[] = array('select', array('name'=>"type_db")); $_block_repeat=true; echo smarty_block_select(array('name'=>"type_db"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

            	           <?php $_smarty_tpl->smarty->_tag_stack[] = array('option', array('select_name'=>"type_db",'value'=>"mysql")); $_block_repeat=true; echo smarty_block_option(array('select_name'=>"type_db",'value'=>"mysql"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Mysql<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_option(array('select_name'=>"type_db",'value'=>"mysql"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                           <?php $_smarty_tpl->smarty->_tag_stack[] = array('option', array('select_name'=>"type_db",'value'=>"pgsql")); $_block_repeat=true; echo smarty_block_option(array('select_name'=>"type_db",'value'=>"pgsql"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
PostgreSQL<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_option(array('select_name'=>"type_db",'value'=>"pgsql"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                           <?php $_smarty_tpl->smarty->_tag_stack[] = array('option', array('select_name'=>"type_db",'value'=>"oci8")); $_block_repeat=true; echo smarty_block_option(array('select_name'=>"type_db",'value'=>"oci8"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Oracle<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_option(array('select_name'=>"type_db",'value'=>"oci8"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

               		  <?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_select(array('name'=>"type_db"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

            	  </td>
               </tr>
               <tr>
                  <td align="right">Server :</td>
                  <td><?php echo smarty_function_textfield(array('name'=>"server",'maxlength'=>"60"),$_smarty_tpl);?>
 <b>HOST:PORT</b></td>
               </tr>
               <tr>
                  <td align="right">Username :</td>
                  <td><?php echo smarty_function_textfield(array('name'=>"user",'maxlength'=>"60"),$_smarty_tpl);?>
</td>
               </tr>
               <tr>
                  <td align="right">Password :</td>
                  <td><?php echo smarty_function_textfield(array('name'=>"password",'type'=>"password",'maxlength'=>"60"),$_smarty_tpl);?>
</td>
               </tr>
            </table>

            <div style="position:absolute; left:356px; top:211px; width:84px; height:36px; z-index:2">
            <table border="0">
            	<tr>
                	<td><?php echo smarty_function_btn_command(array('type'=>"button",'value'=>"Next",'name'=>"CmdDefaultInformacionAplicacion",'form_name'=>"frm_Connection_db"),$_smarty_tpl);?>
</td>
            		<td><?php echo smarty_function_btn_command(array('type'=>"button",'value'=>"Cancel",'name'=>"CmdBackSelectDir",'form_name'=>"frm_Connection_db"),$_smarty_tpl);?>
</td>
            	</tr>
            </table>
            </div>
            <?php echo smarty_function_hidden(array('name'=>"action",'value'=>''),$_smarty_tpl);?>

            <?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_form(array('name'=>"frm_Connection_db",'method'=>"post"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

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
</HTML>





<?php }} ?>
