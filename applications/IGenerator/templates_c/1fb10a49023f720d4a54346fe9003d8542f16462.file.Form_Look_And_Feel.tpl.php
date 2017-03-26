<?php /* Smarty version Smarty-3.1.18, created on 2015-09-15 23:00:18
         compiled from "F:\Appserver\xampp\htdocs\ingravity\applications\IGeneratorOpenIO\web\templates\Form_Look_And_Feel.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2202055f886e2237068-60937978%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1fb10a49023f720d4a54346fe9003d8542f16462' => 
    array (
      0 => 'F:\\Appserver\\xampp\\htdocs\\ingravity\\applications\\IGeneratorOpenIO\\web\\templates\\Form_Look_And_Feel.tpl',
      1 => 1435978836,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2202055f886e2237068-60937978',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cod_message' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_55f886e2400fd2_96555053',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55f886e2400fd2_96555053')) {function content_55f886e2400fd2_96555053($_smarty_tpl) {?><?php if (!is_callable('smarty_block_form')) include 'F:\\Appserver\\xampp\\htdocs\\ingravity\\applications\\IGeneratorOpenIO/web/plugins\\block.form.php';
if (!is_callable('smarty_function_ListStyles')) include 'F:\\Appserver\\xampp\\htdocs\\ingravity\\applications\\IGeneratorOpenIO/web/plugins\\function.ListStyles.php';
if (!is_callable('smarty_function_btn_command')) include 'F:\\Appserver\\xampp\\htdocs\\ingravity\\applications\\IGeneratorOpenIO/web/plugins\\function.btn_command.php';
if (!is_callable('smarty_function_hidden')) include 'F:\\Appserver\\xampp\\htdocs\\ingravity\\applications\\IGeneratorOpenIO/web/plugins\\function.hidden.php';
if (!is_callable('smarty_block_fieldset')) include 'F:\\Appserver\\xampp\\htdocs\\ingravity\\applications\\IGeneratorOpenIO/web/plugins\\block.fieldset.php';
?><HTML>
<HEAD>
 <title>Tablas</title>
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
         <td><IMG SRC="web/images/usuario_03.gif" WIDTH=5 HEIGHT=6 ALT=""></td>
       </tr>
     </table>
	 </div>
            <div style="position:absolute; left:65px; top:65px; width:525px; height:20px; z-index:1" >

            <?php $_smarty_tpl->smarty->_tag_stack[] = array('form', array('name'=>"frm_tablas",'method'=>"post")); $_block_repeat=true; echo smarty_block_form(array('name'=>"frm_tablas",'method'=>"post"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>


			<div style="position:absolute; left:11px; top:-3px; width:498px; height:20px; z-index:1">
			<?php echo smarty_function_ListStyles(array('name'=>"name_style"),$_smarty_tpl);?>

			</div>  
           
            <div style="position:absolute; left:367px; top:211px; width:84px; height:36px; z-index:2">
                <table border="0" align="center">
                	<tr>
                	    <td><?php echo smarty_function_btn_command(array('type'=>"button",'value'=>"Next",'name'=>"CmdDefaultComponentes",'form_name'=>"frm_tablas"),$_smarty_tpl);?>
</td>
                		<td><?php echo smarty_function_btn_command(array('type'=>"button",'value'=>"Cancel",'name'=>"CmdBackInformacionAplicacion",'form_name'=>"frm_tablas"),$_smarty_tpl);?>
</td>
                	</tr>
                </table>
            </div>

            <?php echo smarty_function_hidden(array('name'=>"action",'value'=>''),$_smarty_tpl);?>

            <?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_form(array('name'=>"frm_tablas",'method'=>"post"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

            <div style="position:absolute; left:10px; top:175px; width:500px; height:36px; z-index:2">
            <?php $_smarty_tpl->smarty->_tag_stack[] = array('fieldset', array('legend'=>"Resultado")); $_block_repeat=true; echo smarty_block_fieldset(array('legend'=>"Resultado"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

               <?php echo $_smarty_tpl->tpl_vars['cod_message']->value;?>

            <?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_fieldset(array('legend'=>"Resultado"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

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
</body>
</html>

<?php }} ?>
