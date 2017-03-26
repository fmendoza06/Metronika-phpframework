<?php

/*
 * Smarty plugin
 * --------------------------------------------------------------------
 * Type:     function
 * Name:     textfield
 * Version:  1.0
 * Date:     Oct 20, 2003
 * Author:	 SpyroFrameWork
 * Purpose:
 * Input:
 *           name = name of the textfield (optional)
 *           type = define the type of the textfield (required)
 *           id = id of the textfield (optional)
 *           value = puts text inside the textfield (optional)
 *           size = Long of the textfield (optional)
 *           typeData = define the type of data that you can introduce (optional)
 *           readonly = readonly ('true'|'false') (optional)
 *           disabled = disabled the textfield (optional)
 *           onClick =  introduce code javascript (optional)
 *           maxlength = Maximum of characters of the textfield (optional)
 *           uncero = delete the firts cero
 *           decimal = number of decimals
 *
 * Examples : {textfield name="textfield" type="text" size="60" value="LIDIS"}
 *
 *
 *
 * --------------------------------------------------------------------
 */
function smarty_function_textfield($params, &$smarty)
{
    extract($params);
    
    $html_result = '';
    $html_result .= "<input  class='sizeCatalogoInsumo'";
    if (isset($name)){
        $html_result .= " name='".$name."'";
    }
    if (isset($type))
        $html_result .= " type='".$type."'";
    else
        $html_result .= " type='text'";

    if (isset($id)){
        $html_result .= " id='".$id."'";
    }
    if (isset($value)){
        $html_result .= " value='".$value."'";
    }else{
        $html_result .= " value='".$_REQUEST[$name]."'";
    }
    if (isset($size)){
        $html_result .= " size='".$size."'";
    }
    if (isset($maxlength)){
        $html_result .= " maxlength='".$maxlength."'";
    }
    if (isset($disabled)){
        $html_result .= " disabled='".$disabled."'";
    }
    if (isset($readonly)){
        if (($readonly == "true")||($readonly == "True")){
           $html_result .= " readonly";
        }
    }
    if (isset($onClick)){
        $html_result .= " onClick='".$onClick."'";
    }
    
    ////////////////////// INTERNET EXPLORER / OPERA ////////////////////////////
    
    if (strstr($_SERVER["HTTP_USER_AGENT"], "MSIE") or strstr($_SERVER["HTTP_USER_AGENT"], "Opera")) {
     if (isset($typeData)){
        if ($typeData == 'int'){
         $html_result .= " onkeypress=\"";
         if($uncero == 'true'){
           $html_result .= " if(event.keyCode == 48){";
           $html_result .= " if(value.length == 0){";
		   $html_result .= " event.returnValue = false;}}else{";
		 }
         $html_result .= " if (!((event.keyCode>=48) && (event.keyCode<=57)))";
         $html_result .= " event.returnValue = false;";
         if($uncero == 'true'){
           $html_result .= " }";
         }
         $html_result .= " \"";
        }
        if ($typeData == 'double'){
         $html_result .= " onkeypress=\"";
         if($uncero == 'true'){
           $html_result .= " if(event.keyCode == 48){";
           $html_result .= " if(value.length == 0){";
		   $html_result .= " event.returnValue = false;}}else{";
		 }
         $html_result .= " if(event.keyCode != 46){";
         $html_result .= " if(!((event.keyCode>=48) && (event.keyCode<=57))){";
         $html_result .= " event.returnValue = false;}";

         if(isset($decimal)){
          $html_result .= " if(value.indexOf('.') != -1){
						     diferencia = (value.length - 1) - value.indexOf('.');
							 if(diferencia == ".$decimal.")
							    event.returnValue = false;
						   }";
		 }				
         $html_result .= " }else{if((value.indexOf('.') != -1) || (value.length == 0))";
		 $html_result .= " event.returnValue = false;}";
         if($uncero == 'true'){
           $html_result .= " }";
         }
         $html_result .= " \"";
        }
        if($typeData == 'string'){
         $html_result .= " onkeypress=\"if (!(((event.keyCode>=97) && (event.keyCode<=122)) ||";
         $html_result .= " ((event.keyCode>=65) && (event.keyCode<=90)) || (event.keyCode==32)";
         $html_result .= " || (event.keyCode==241) || (event.keyCode==209)))";
         $html_result .= " event.returnValue = false;\"";
        }
        if($typeData == 'sin_caracteres_especiales'){
         $html_result .= " onkeypress=\"if (!(((event.keyCode>=48) && (event.keyCode<=57)) || ";
         $html_result .= "((event.keyCode>=97) && (event.keyCode<=122)) || ((event.keyCode>=65) && ";
         $html_result .= "(event.keyCode<=90)) || (event.keyCode==32) || (event.keyCode==241) || ";
         $html_result .= "(event.keyCode==209)))event.returnValue = false;\"";
        }
     }
    }

    ////////////////////////////NETSCAPE/////////////////////////////

    else{
     if (isset($typeData)){
        if ($typeData == 'int'){
         $html_result .= " onkeypress=\"";
         if($uncero == 'true'){
           $html_result .= " if(event.charCode == 48){";
           $html_result .= " if(value.length == 0){";
		   $html_result .= " event.preventDefault();}}else{";
		 }
         $html_result .= " if (!((event.charCode>=48) && (event.charCode<=57) ||";
         $html_result .= " (event.charCode == 0) || (event.charCode == 8)))";
		 $html_result .= " event.preventDefault();";
		 if($uncero == 'true'){
           $html_result .= " }";
         }
         $html_result .= " \"";
		}
        if ($typeData == 'double'){
         $html_result .= " onkeypress=\"";
         if($uncero == 'true'){
           $html_result .= " if(event.charCode == 48){";
           $html_result .= " if(value.length == 0){";
		   $html_result .= " event.preventDefault();}}else{";
		 }
         $html_result .= " if(event.charCode != 46){";
         $html_result .= " if(!((event.charCode>=48) && (event.charCode<=57) || (event.charCode == 0) ||";
         $html_result .= " (event.charCode == 8))){";
         $html_result .= " event.preventDefault();}";

         if(isset($decimal)){
          $html_result .= " if(value.indexOf('.') != -1){
						     diferencia = (value.length - 1) - value.indexOf('.');
							 if(!((diferencia != ".$decimal.") || (event.charCode == 0) || (event.charCode == 8)))
							    event.preventDefault();
						   }";
         }
         $html_result .= " }else{if((value.indexOf('.') != -1) || (value.length == 0))";
		 $html_result .= " event.preventDefault();}";
         if($uncero == 'true'){
           $html_result .= " }";
         }
         $html_result .= " \"";
        }
        if ($typeData == 'string'){
         $html_result .= " onkeypress=\"if (!(((event.charCode>=97) && (event.charCode<=122)) ||";
         $html_result .= " ((event.charCode>=65) && (event.charCode<=90)) || (event.charCode==32)";
         $html_result .= " || (event.charCode==241) || (event.charCode==209) ||";
         $html_result .= " (event.charCode == 0) || (event.charCode == 8)))";
         $html_result .= " event.preventDefault();\"";
        }
        if($typeData == 'sin_caracteres_especiales'){
         $html_result .= " onkeypress=\"if(!(((event.charCode>=48) && (event.charCode<=57)) || ";
         $html_result .= "((event.charCode>=97) && (event.charCode<=122)) || ((event.charCode>=65) && ";
         $html_result .= "(event.charCode<=90)) || (event.charCode==32) || (event.charCode==241) || ";
         $html_result .= "(event.charCode==209) || (event.charCode == 0) || (event.charCode == 8)))event.preventDefault();\"";
        }
     }
    }
    $html_result .= ">";
    
    print $html_result;

}

?>
