<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     fieldset
 * Version:  1.0
 * Date:     Oct 15, 2003
 * Author:	 SpyroFrameWork
 * Purpose:  fieldset for HTML
 * Input:
 *           legend = label of fieldset
 *
 *
 * Examples: {fieldset legend = "Note"}
 *            {$message}
 *           {/fieldset}
 * Output:  <fieldset >
 *	           <legend>Note</legend>
 *	           Hello Word!!
 *	        </fieldset>
 * -------------------------------------------------------------
 */
 
 
function smarty_block_fieldset($params, $content, &$smarty)
{
   extract($params);

   if(isset($content)){
       $result = '';
       $result .= "<fieldset>";
       if($legend != ''){
           $result .= "<legend>$legend</legend>";
       }

       $result .= "&nbsp;&nbsp;";
       $result .= $content;
       
       $result .= "</fieldset>";

      print $result;
   }
}
?>

