<?php
/**
 * Smarty plugin
 */
/**
 * Smarty {textfieldcodedesc} function plugin
 * Type:     function
 * Name:     textfield
 * Input:
 *           - name = name of the textfield (optional)
 *           - type = define the type of the textfield (required)
 *           - id = id of the textfield (optional)
 *           - value = puts text inside the textfield (optional)
 *           - size = Long of the textfield (optional)
 *           - typeData = define the type of data that you can introduce (optional)
 *           - readonly = readonly ('true'|'false') (optional)
 *           - disabled = disabled the textfield (optional)
 *           - onClick =  introduce code javascript (optional)
 *           - maxlength = Maximum of characters of the textfield (optional)
 *
 *
 * Examples : {textfieldcodedesc name="textfield" type="text" size="60" value="LIDIS"}
 *
 * @author   Spyro Solutions 
 * @version  1.0.0
 * @param array
 * @param Smarty
 * @return string
 * @copyright Spyro Solutions 
 */
 function smarty_function_textfieldcodedesc($params, &$smarty)
{
    extract($params);
    $contid = WebSession::getIAuthProperty("contid");
    $onFocus="this.className=\"detailedViewTextBoxOn\";";
    $onBlur="this.className=\"detailedViewTextBox\";";
	$id = $name;
    $html_result = '<table>
                      <tr>
                        <td>';
    $html_result .= "     <input";
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
    if (isset($class)){
        $html_result .= " class='".$class."'";
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
    
    if (isset($onFocus)){
        $html_result .= " onFocus='".$onFocus."'";
    }
    if (isset($onBlur)){
        $html_result .= " onBlur='".$onBlur."'";
    }


    if (isset($onChange)){
        $onChange=str_replace("CONTID",$contid,$onChange);
        $html_result .= " onChange=".$onChange.";";
    }

    ////////////////////// INTERNET EXPLORER / OPERA ////////////////////////////
    
    if (strstr($_SERVER["HTTP_USER_AGENT"], "MSIE") or strstr($_SERVER["HTTP_USER_AGENT"], "Opera")) {
     if (isset($typeData)){
        if ($typeData == 'int'){
         $html_result .= " onkeypress=\"if (!((event.keyCode>=48) && (event.keyCode<=57)))";
         $html_result .= " event.returnValue = false;\"";
        }
        if ($typeData == 'double'){
         $html_result .= " onkeypress=\"if(event.keyCode != 45){";
         $html_result .= " if(event.keyCode != 46){";
         $html_result .= " if(!((event.keyCode>=48) && (event.keyCode<=57)))";
         $html_result .= " event.returnValue = false;";
         $html_result .= " }else{if((value.indexOf('.') != -1) || (value == '-') || (value.length == 0))";
		 $html_result .= " event.returnValue = false;}";
         $html_result .= " }else{if(value.length != 0)event.returnValue = false;}\"";
        }
        if ($typeData == 'string'){
         $html_result .= " onkeypress=\"if (!(((event.keyCode>=97) && (event.keyCode<=122)) ||";
         $html_result .= " ((event.keyCode>=65) && (event.keyCode<=90)) || (event.keyCode==32)";
         $html_result .= " || (event.keyCode==241) || (event.keyCode==209)))";
         $html_result .= " event.returnValue = false;\"";
        }
     }
    }

    ////////////////////////////NETSCAPE/////////////////////////////*

    else{
     if (isset($typeData)){
        if ($typeData == 'int'){
         $html_result .= " onkeypress=\"if (!((event.charCode>=48) && (event.charCode<=57) ||";
         $html_result .= " (event.charCode == 0) || (event.charCode == 8)))";
		 $html_result .= " event.preventDefault();\"";
		}
        if ($typeData == 'double'){
         $html_result .= " onkeypress=\"if(event.charCode != 45){";
         $html_result .= " if(event.charCode != 46){";
         $html_result .= " if(!((event.charCode>=48) && (event.charCode<=57) || (event.charCode == 0) ||";
         $html_result .= " (event.charCode == 8)))";
         $html_result .= " event.preventDefault();";
         $html_result .= " }else{if((value.indexOf('.') != -1) || (value == '-') || (value.length == 0))";
		 $html_result .= " event.preventDefault();}";
         $html_result .= " }else{if(value.length != 0)event.preventDefault();}\"";
        }
        if ($typeData == 'string'){
         $html_result .= " onkeypress=\"if (!(((event.charCode>=97) && (event.charCode<=122)) ||";
         $html_result .= " ((event.charCode>=65) && (event.charCode<=90)) || (event.charCode==32)";
         $html_result .= " || (event.charCode==241) || (event.charCode==209) ||";
         $html_result .= " (event.charCode == 0) || (event.charCode == 8)))";
         $html_result .= " event.preventDefault();\"";
        }
     }
    }


    $html_result .= ">";

    if ($showCombo='Y')
    {
      $html_result.= "           <a class='toolbar' href='#' onClick=\"visi('tale__".$name."');".$form_name.".".$name.".focus();\">";
      $html_result.= '           <img title=Lista/List src="./web/images/menubar/help.png"></a>&nbsp';

    }

    //if (isset($showDescription))
    //{
      $html_result .= '&nbsp;&nbsp;<input type="text" id="'.$description.'" name="'.$description.'" size="35" maxlength="100" readonly="true" disabled="true" value="'.$_REQUEST[$description].'">';
    //}
    $html_result .= '  </td>
                      </tr>';
    if ($showCombo='Y')
    {
    $html_result .= ' <tr id="tale__'.$name.'" style="display:none; position:relative">
                       <td>';
       $html_result .=buildDataTable($form_name,$referenceDataGateway,$referenFunction,$referenceparam,$name,$description,$referencekeys);
       //$html_result .= " onChange='".buildDataTable($form_name,$referenceDataGateway,$referenFunction,$referenceparam,$name,$referencekeys)."'";
    $html_result .= '  </td>
                      </tr>';
    }

    $html_result .= '</table>';


    print $html_result;

}

 /*** Keys = TIPOCODI,TIPONOMB -- Los campos de la tabla referencia ****/
 /*** Key  = Campo donde ingresa el valor el usuario ****/
 function buildDataTable($form_name,$referenceDataGateway,$referenFunction,$referenceparam,$name,$description,$referencekeys)
 {
    $html_result='';
    $gatewayReferencia = Application::getDataGateway($referenceDataGateway);
    if ($referenceparam !="")
     $datas = call_user_func(array($gatewayReferencia,"$referenFunction"),$referenceparam);
    else
     $datas = call_user_func(array($gatewayReferencia,"$referenFunction"));
    $referencekeys = explode(",",$referencekeys);
    $html_result.='<table border=2 width=50% class="adminform">';
    $html_result.='  <tr><th colspand="2" align="center">Id.</th>
                         <th align="center">Desc.</th></tr>';
    for ($i=0;$i<count($datas);$i++)
    {
    $html_result.='  <tr>
                       <td>';
    //name=radio__".$datas[$i][$referencekeys[0]]."
    $html_result.=        "<input type='radio'
                                 name='radio__".$name."'
                                 onClick=\"".$form_name.".".$name.".value='".$datas[$i][$referencekeys[0]]."';".$form_name.".".$description.".value='".$datas[$i][$referencekeys[1]]."';blocking('tale__".$name."');\"
                          >";
    $html_result.='    </td> ';
    

     $html_result.='    <td> ';
	 //print_r("<pre>");print_r($datas[$i]);
     $html_result.=$datas[$i][$referencekeys[0]]."&nbsp;&nbsp;".$datas[$i][$referencekeys[1]];
     $html_result.='    </td> ';
     $html_result.='  </tr>';
    }
    $html_result.='</table>';
    //print_r($html_result);
    return $html_result;

 }
 


?>
