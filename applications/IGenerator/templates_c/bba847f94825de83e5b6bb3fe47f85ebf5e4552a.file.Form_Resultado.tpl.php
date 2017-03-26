<?php /* Smarty version Smarty-3.1.18, created on 2015-09-15 23:00:48
         compiled from "F:\Appserver\xampp\htdocs\ingravity\applications\IGeneratorOpenIO\web\templates\Form_Resultado.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2773555f88700ec6894-48918182%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bba847f94825de83e5b6bb3fe47f85ebf5e4552a' => 
    array (
      0 => 'F:\\Appserver\\xampp\\htdocs\\ingravity\\applications\\IGeneratorOpenIO\\web\\templates\\Form_Resultado.tpl',
      1 => 1435978835,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2773555f88700ec6894-48918182',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'text_result' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_55f887011f4021_22217415',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55f887011f4021_22217415')) {function content_55f887011f4021_22217415($_smarty_tpl) {?><?php if (!is_callable('smarty_block_form')) include 'F:\\Appserver\\xampp\\htdocs\\ingravity\\applications\\IGeneratorOpenIO/web/plugins\\block.form.php';
if (!is_callable('smarty_function_btn_command')) include 'F:\\Appserver\\xampp\\htdocs\\ingravity\\applications\\IGeneratorOpenIO/web/plugins\\function.btn_command.php';
if (!is_callable('smarty_function_hidden')) include 'F:\\Appserver\\xampp\\htdocs\\ingravity\\applications\\IGeneratorOpenIO/web/plugins\\function.hidden.php';
if (!is_callable('smarty_function_show_result')) include 'F:\\Appserver\\xampp\\htdocs\\ingravity\\applications\\IGeneratorOpenIO/web/plugins\\function.show_result.php';
?><html>
<head>
      <title>Resultado</title>
	  <link href="web/css/estilo_textarea.css"  rel="stylesheet" type="text/css">
	  <script language="JavaScript" src="web/js/disableButtons.js"></script>
 	  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
</head>
<body>
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

            <?php $_smarty_tpl->smarty->_tag_stack[] = array('form', array('name'=>"frm_resultado",'method'=>"post")); $_block_repeat=true; echo smarty_block_form(array('name'=>"frm_resultado",'method'=>"post"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

           
            <div style="position:absolute; left:411px; top:195px; width:84px; height:36px; z-index:2">
                <table border="0" align="center">
                	<tr>
                	    <td><?php echo smarty_function_btn_command(array('type'=>"button",'value'=>"Return..",'name'=>"CmdBackInformacionAplicacion",'form_name'=>"frm_resultado"),$_smarty_tpl);?>
</td>
                	</tr>
                </table>
            </div>
			
			<?php echo smarty_function_hidden(array('name'=>"action",'value'=>''),$_smarty_tpl);?>

            <?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_form(array('name'=>"frm_resultado",'method'=>"post"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

            <div style="position:absolute; left:32px; top:-41px; width:437px; height:189px; z-index:2">
			  <fieldset>
				<legend>Result</legend>
				 <?php echo smarty_function_show_result(array('value'=>$_smarty_tpl->tpl_vars['text_result']->value),$_smarty_tpl);?>

		      </fieldset> 
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

<div style="position:absolute; left:287px; top:350px; width:122px; height:28px; z-index:1"><img src="web/images/logopdf.jpg" width="147" height="49"></div>

</html>
<?php }} ?>
