<?php /* Smarty version 2.6.0, created on 2010-09-07 10:08:57
         compiled from Form_Conexion_BD.tpl */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'form', 'Form_Conexion_BD.tpl', 24, false),array('block', 'select', 'Form_Conexion_BD.tpl', 28, false),array('block', 'option', 'Form_Conexion_BD.tpl', 29, false),array('block', 'fieldset', 'Form_Conexion_BD.tpl', 60, false),array('function', 'textfield', 'Form_Conexion_BD.tpl', 37, false),array('function', 'btn_command', 'Form_Conexion_BD.tpl', 52, false),array('function', 'hidden', 'Form_Conexion_BD.tpl', 57, false),)), $this); ?>
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
            <?php $_params = $this->_tag_stack[] = array('form', array('name' => 'frm_Connection_db','method' => 'post')); smarty_block_form($_params[1], null, $this, $_block_repeat=true); unset($_params);while ($_block_repeat) { ob_start(); ?>
            <table border="0" align="center">
               <tr>
                  <td align="right">Data Base Manager System :</td>
                  <td><?php $_params = $this->_tag_stack[] = array('select', array('name' => 'type_db')); smarty_block_select($_params[1], null, $this, $_block_repeat=true); unset($_params);while ($_block_repeat) { ob_start(); ?>
            	           <?php $_params = $this->_tag_stack[] = array('option', array('select_name' => 'type_db','value' => 'mysql')); smarty_block_option($_params[1], null, $this, $_block_repeat=true); unset($_params);while ($_block_repeat) { ob_start(); ?>Mysql<?php $this->_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_option($this->_tag_stack[count($this->_tag_stack)-1][1], $this->_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
                           <?php $_params = $this->_tag_stack[] = array('option', array('select_name' => 'type_db','value' => 'pgsql')); smarty_block_option($_params[1], null, $this, $_block_repeat=true); unset($_params);while ($_block_repeat) { ob_start(); ?>PostgreSQL<?php $this->_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_option($this->_tag_stack[count($this->_tag_stack)-1][1], $this->_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
                           <?php $_params = $this->_tag_stack[] = array('option', array('select_name' => 'type_db','value' => 'oci8')); smarty_block_option($_params[1], null, $this, $_block_repeat=true); unset($_params);while ($_block_repeat) { ob_start(); ?>Oracle<?php $this->_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_option($this->_tag_stack[count($this->_tag_stack)-1][1], $this->_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
               		  <?php $this->_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_select($this->_tag_stack[count($this->_tag_stack)-1][1], $this->_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
            	  </td>
               </tr>
               <tr>
                  <td align="right">Server :</td>
                  <td><?php echo smarty_function_textfield(array('name' => 'server','maxlength' => '60'), $this);?>
 <b>HOST:PORT</b></td>
               </tr>
               <tr>
                  <td align="right">Username :</td>
                  <td><?php echo smarty_function_textfield(array('name' => 'user','maxlength' => '60'), $this);?>
</td>
               </tr>
               <tr>
                  <td align="right">Password :</td>
                  <td><?php echo smarty_function_textfield(array('name' => 'password','type' => 'password','maxlength' => '60'), $this);?>
</td>
               </tr>
            </table>

            <div style="position:absolute; left:356px; top:211px; width:84px; height:36px; z-index:2">
            <table border="0">
            	<tr>
                	<td><?php echo smarty_function_btn_command(array('type' => 'button','value' => 'Next','name' => 'CmdDefaultInformacionAplicacion','form_name' => 'frm_Connection_db'), $this);?>
</td>
            		<td><?php echo smarty_function_btn_command(array('type' => 'button','value' => 'Cancel','name' => 'CmdBackSelectDir','form_name' => 'frm_Connection_db'), $this);?>
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




