<?php /* Smarty version Smarty-3.1.12, created on 2012-11-07 03:13:44
         compiled from "E:\CEO\JoseMendoza\spyro\webserver\xampp\htdocs\ingravity5\applications\IGenerator\web\templates\Form_Dir.tpl" */ ?>
<?php /*%%SmartyHeaderCode:145205099c3d83de0a6-14191445%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b11cf1f01900eced00c4f1d05295d18bb97144c1' => 
    array (
      0 => 'E:\\CEO\\JoseMendoza\\spyro\\webserver\\xampp\\htdocs\\ingravity5\\applications\\IGenerator\\web\\templates\\Form_Dir.tpl',
      1 => 1164700186,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '145205099c3d83de0a6-14191445',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_5099c3d881a637_51389781',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5099c3d881a637_51389781')) {function content_5099c3d881a637_51389781($_smarty_tpl) {?><?php if (!is_callable('smarty_block_form')) include 'E:\\CEO\\JoseMendoza\\spyro\\webserver\\xampp\\htdocs\\ingravity5\\applications\\IGenerator/web/plugins\\block.form.php';
if (!is_callable('smarty_function_ListDir')) include 'E:\\CEO\\JoseMendoza\\spyro\\webserver\\xampp\\htdocs\\ingravity5\\applications\\IGenerator/web/plugins\\function.ListDir.php';
if (!is_callable('smarty_function_btn_command')) include 'E:\\CEO\\JoseMendoza\\spyro\\webserver\\xampp\\htdocs\\ingravity5\\applications\\IGenerator/web/plugins\\function.btn_command.php';
if (!is_callable('smarty_function_hidden')) include 'E:\\CEO\\JoseMendoza\\spyro\\webserver\\xampp\\htdocs\\ingravity5\\applications\\IGenerator/web/plugins\\function.hidden.php';
if (!is_callable('smarty_block_fieldset')) include 'E:\\CEO\\JoseMendoza\\spyro\\webserver\\xampp\\htdocs\\ingravity5\\applications\\IGenerator/web/plugins\\block.fieldset.php';
?><HTML>
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

                <?php $_smarty_tpl->smarty->_tag_stack[] = array('form', array('name'=>"frm_dir",'method'=>"post")); $_block_repeat=true; echo smarty_block_form(array('name'=>"frm_dir",'method'=>"post"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>


	        <div style="position:absolute; left:9px; top:-25px; width:498px; height:20px; z-index:1">
			    <?php echo smarty_function_ListDir(array('dir'=>"./xslt/"),$_smarty_tpl);?>

		</div>

                <div style="position:absolute; left:345px; top:110px; width:84px; height:36px; z-index:2">
                    <table border="0" align="center">
                	<tr>
                	    <td><?php echo smarty_function_btn_command(array('type'=>"button",'value'=>"Siguiente",'name'=>"CmdDefaultConexionBD",'form_name'=>"frm_dir"),$_smarty_tpl);?>
</td>
                	    <td><?php echo smarty_function_btn_command(array('type'=>"button",'value'=>"Cancelar",'name'=>"default",'form_name'=>"frm_dir"),$_smarty_tpl);?>
</td>
                	</tr>
                    </table>
                </div>

                <?php echo smarty_function_hidden(array('name'=>"action",'value'=>''),$_smarty_tpl);?>

                <?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_form(array('name'=>"frm_dir",'method'=>"post"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                <div style="position:absolute; left:10px; top:70px; width:500px; height:36px; z-index:2">
                     <?php $_smarty_tpl->smarty->_tag_stack[] = array('fieldset', array('legend'=>"Result")); $_block_repeat=true; echo smarty_block_fieldset(array('legend'=>"Result"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>


                     <?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_fieldset(array('legend'=>"Result"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

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
<?php }} ?>