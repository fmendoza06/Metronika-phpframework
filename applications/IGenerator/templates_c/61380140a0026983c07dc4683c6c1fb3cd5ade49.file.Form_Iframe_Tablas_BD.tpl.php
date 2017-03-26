<?php /* Smarty version Smarty-3.1.18, created on 2015-06-29 00:15:14
         compiled from "/home/myhostin/public_html/apps/ingravity/applications/IGenerator/web/templates/Form_Iframe_Tablas_BD.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17199483575590d4621344c0-50336326%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '61380140a0026983c07dc4683c6c1fb3cd5ade49' => 
    array (
      0 => '/home/myhostin/public_html/apps/ingravity/applications/IGenerator/web/templates/Form_Iframe_Tablas_BD.tpl',
      1 => 1435546224,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17199483575590d4621344c0-50336326',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'type' => 0,
    'host' => 0,
    'db_name' => 0,
    'user' => 0,
    'pass' => 0,
    'port' => 0,
    'service_name' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5590d46216cc92_33830825',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5590d46216cc92_33830825')) {function content_5590d46216cc92_33830825($_smarty_tpl) {?><?php if (!is_callable('smarty_block_form')) include '/home/myhostin/public_html/apps/ingravity/applications/IGenerator/web/plugins/block.form.php';
if (!is_callable('smarty_function_show_list_tablas')) include '/home/myhostin/public_html/apps/ingravity/applications/IGenerator/web/plugins/function.show_list_tablas.php';
?><HTML>
<HEAD>
 <title>Tablas</title>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
</HEAD>
<BODY leftmargin="0" topmargin="0">

       <?php $_smarty_tpl->smarty->_tag_stack[] = array('form', array('name'=>"frm_tablas",'method'=>"post")); $_block_repeat=true; echo smarty_block_form(array('name'=>"frm_tablas",'method'=>"post"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

            
       <?php echo smarty_function_show_list_tablas(array('type'=>$_smarty_tpl->tpl_vars['type']->value,'host'=>$_smarty_tpl->tpl_vars['host']->value,'db_name'=>$_smarty_tpl->tpl_vars['db_name']->value,'user'=>$_smarty_tpl->tpl_vars['user']->value,'pass'=>$_smarty_tpl->tpl_vars['pass']->value,'port'=>$_smarty_tpl->tpl_vars['port']->value,'service_name'=>$_smarty_tpl->tpl_vars['service_name']->value,'form_name'=>"frm_tablas"),$_smarty_tpl);?>

            
       <?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_form(array('name'=>"frm_tablas",'method'=>"post"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

 
</BODY>
</HTML>
<?php }} ?>
