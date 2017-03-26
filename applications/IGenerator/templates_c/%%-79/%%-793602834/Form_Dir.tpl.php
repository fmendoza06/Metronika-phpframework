<?php /* Smarty version 2.6.0, created on 2010-09-07 10:08:53
         compiled from Form_Dir.tpl */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'form', 'Form_Dir.tpl', 27, false),array('block', 'fieldset', 'Form_Dir.tpl', 45, false),array('function', 'ListDir', 'Form_Dir.tpl', 30, false),array('function', 'btn_command', 'Form_Dir.tpl', 36, false),array('function', 'hidden', 'Form_Dir.tpl', 42, false),)), $this); ?>
<HTML>
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

                <?php $_params = $this->_tag_stack[] = array('form', array('name' => 'frm_dir','method' => 'post')); smarty_block_form($_params[1], null, $this, $_block_repeat=true); unset($_params);while ($_block_repeat) { ob_start(); ?>

	        <div style="position:absolute; left:9px; top:-25px; width:498px; height:20px; z-index:1">
			    <?php echo smarty_function_ListDir(array('dir' => "./xslt/"), $this);?>

		</div>

                <div style="position:absolute; left:345px; top:110px; width:84px; height:36px; z-index:2">
                    <table border="0" align="center">
                	<tr>
                	    <td><?php echo smarty_function_btn_command(array('type' => 'button','value' => 'Siguiente','name' => 'CmdDefaultConexionBD','form_name' => 'frm_dir'), $this);?>
</td>
                	    <td><?php echo smarty_function_btn_command(array('type' => 'button','value' => 'Cancelar','name' => 'default','form_name' => 'frm_dir'), $this);?>
</td>
                	</tr>
                    </table>
                </div>

                <?php echo smarty_function_hidden(array('name' => 'action','value' => ""), $this);?>

                <?php $this->_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_form($this->_tag_stack[count($this->_tag_stack)-1][1], $this->_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
                <div style="position:absolute; left:10px; top:70px; width:500px; height:36px; z-index:2">
                     <?php $_params = $this->_tag_stack[] = array('fieldset', array('legend' => 'Result')); smarty_block_fieldset($_params[1], null, $this, $_block_repeat=true); unset($_params);while ($_block_repeat) { ob_start(); ?>

                     <?php $this->_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_fieldset($this->_tag_stack[count($this->_tag_stack)-1][1], $this->_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
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