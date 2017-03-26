<?php /* Smarty version 2.6.0, created on 2010-09-07 10:06:58
         compiled from Form_Look_And_Feel.tpl */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'form', 'Form_Look_And_Feel.tpl', 25, false),array('block', 'fieldset', 'Form_Look_And_Feel.tpl', 43, false),array('function', 'ListStyles', 'Form_Look_And_Feel.tpl', 28, false),array('function', 'btn_command', 'Form_Look_And_Feel.tpl', 34, false),array('function', 'hidden', 'Form_Look_And_Feel.tpl', 40, false),)), $this); ?>
<HTML>
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

            <?php $_params = $this->_tag_stack[] = array('form', array('name' => 'frm_tablas','method' => 'post')); smarty_block_form($_params[1], null, $this, $_block_repeat=true); unset($_params);while ($_block_repeat) { ob_start(); ?>

			<div style="position:absolute; left:11px; top:-3px; width:498px; height:20px; z-index:1">
			<?php echo smarty_function_ListStyles(array('name' => 'name_style'), $this);?>

			</div>  
           
            <div style="position:absolute; left:367px; top:211px; width:84px; height:36px; z-index:2">
                <table border="0" align="center">
                	<tr>
                	    <td><?php echo smarty_function_btn_command(array('type' => 'button','value' => 'Next','name' => 'CmdDefaultComponentes','form_name' => 'frm_tablas'), $this);?>
</td>
                		<td><?php echo smarty_function_btn_command(array('type' => 'button','value' => 'Cancel','name' => 'CmdBackInformacionAplicacion','form_name' => 'frm_tablas'), $this);?>
</td>
                	</tr>
                </table>
            </div>

            <?php echo smarty_function_hidden(array('name' => 'action','value' => ""), $this);?>

            <?php $this->_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_form($this->_tag_stack[count($this->_tag_stack)-1][1], $this->_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
            <div style="position:absolute; left:10px; top:175px; width:500px; height:36px; z-index:2">
            <?php $_params = $this->_tag_stack[] = array('fieldset', array('legend' => 'Resultado')); smarty_block_fieldset($_params[1], null, $this, $_block_repeat=true); unset($_params);while ($_block_repeat) { ob_start(); ?>
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
</body>
</html>
