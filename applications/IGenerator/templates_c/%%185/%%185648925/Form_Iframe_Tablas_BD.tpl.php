<?php /* Smarty version 2.6.0, created on 2010-09-07 11:07:04
         compiled from Form_Iframe_Tablas_BD.tpl */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'form', 'Form_Iframe_Tablas_BD.tpl', 8, false),array('function', 'show_list_tablas', 'Form_Iframe_Tablas_BD.tpl', 10, false),)), $this); ?>
<HTML>
<HEAD>
 <title>Tablas</title>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
</HEAD>
<BODY leftmargin="0" topmargin="0">

       <?php $_params = $this->_tag_stack[] = array('form', array('name' => 'frm_tablas','method' => 'post')); smarty_block_form($_params[1], null, $this, $_block_repeat=true); unset($_params);while ($_block_repeat) { ob_start(); ?>
            
       <?php echo smarty_function_show_list_tablas(array('type' => $this->_tpl_vars['type'],'host' => $this->_tpl_vars['host'],'db_name' => $this->_tpl_vars['db_name'],'user' => $this->_tpl_vars['user'],'pass' => $this->_tpl_vars['pass'],'port' => $this->_tpl_vars['port'],'service_name' => $this->_tpl_vars['service_name'],'form_name' => 'frm_tablas'), $this);?>

            
       <?php $this->_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_form($this->_tag_stack[count($this->_tag_stack)-1][1], $this->_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
 
</BODY>
</HTML>