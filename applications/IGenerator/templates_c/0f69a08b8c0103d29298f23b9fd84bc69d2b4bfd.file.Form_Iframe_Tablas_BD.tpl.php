<?php /* Smarty version Smarty-3.1.12, created on 2013-02-14 16:24:25
         compiled from "D:\CEO\JoseMendoza\spyro\webserver\xampp\htdocs\ingravity5\applications\IGenerator\web\templates\Form_Iframe_Tablas_BD.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10740511d01a9c42124-71261375%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0f69a08b8c0103d29298f23b9fd84bc69d2b4bfd' => 
    array (
      0 => 'D:\\CEO\\JoseMendoza\\spyro\\webserver\\xampp\\htdocs\\ingravity5\\applications\\IGenerator\\web\\templates\\Form_Iframe_Tablas_BD.tpl',
      1 => 1145315066,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10740511d01a9c42124-71261375',
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
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_511d01a9d4cd89_44746555',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_511d01a9d4cd89_44746555')) {function content_511d01a9d4cd89_44746555($_smarty_tpl) {?><?php if (!is_callable('smarty_block_form')) include 'D:\\CEO\\JoseMendoza\\spyro\\webserver\\xampp\\htdocs\\ingravity5\\applications\\IGenerator/web/plugins\\block.form.php';
if (!is_callable('smarty_function_show_list_tablas')) include 'D:\\CEO\\JoseMendoza\\spyro\\webserver\\xampp\\htdocs\\ingravity5\\applications\\IGenerator/web/plugins\\function.show_list_tablas.php';
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