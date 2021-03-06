<?php
/**
 * Smarty plugin
 */
/**
 * Smarty {select_row_table} plugin
 * Type:     function<br>
 * Name:     select_row_table<br>
 * Purpose:  componente que crea un select con los registro de otra tabla<br>
 * Input:<br>
 *      name = is the name of the select (required)
 *      table_name = name of table in data base (required)
 *      value = is the name of the row in the tabla that specifies the value of select (required)
 *      label = is the name of the row in the tabla that specifies the laber of select(optional)
 *      size = this sets the number of visible choices(optional)
 *      is_null = especifica si el 'select_row_table' debe tener el valor nulo.  'true|false' (optional)
 *
 *<pre>
 * Examples: 
 *       {select_row_table name="Mycombo" table_name="dept" value="deptno"}
 *       {select_row_table name="Mycombo" table_name="dept" value="deptno" label="dname" size="5" is_null="true"}
 *</pre>
 *
 * @author   Hemerson Varela <hvarela@parquesoft.com>
 * @version  1.0.0
 * @param array
 * @param Smarty
 * @return string
 * @copyright Global Solutions - Dic 2003  
 */


function smarty_function_select_row_table($params, &$smarty)
{
  extract($params);

  $gateway = Application::getDataGateway("$table_name");
  if (!isset($otherfun))
     
     $v = call_user_func(array($gateway,"getAll$table_name"));
  else
  {
     if (isset($parameters))
     {
           
           $v = call_user_func(array($gateway,"$otherfun"),$parameters);
      }
      else
         $v = call_user_func(array($gateway,$otherfun));
  
  }
  
  if (isset($loadTable))
  {
  	       $parameters=str_replace("CONTID",$contid,$parameters);
		   $parameters=str_replace("ordeserv__ORDECLIE",$_REQUEST['ordeserv__ORDECLIE'],$parameters);
		   
           $v = call_user_func(array($gateway,"$loadTable"),$_REQUEST['ordeserv__ORDECLIE'],$_REQUEST['ordeserv__ORDECOID']); 
  }		   
		   
  $v = BorrarValoresDuplicados($v,$value);

  if(!isset($label)){
      $label[0] = $value;
  } else {
      $label = explode(",",$label);
  }

  if(!isset($size)){
      $size = 1;
  }

  if(isset($class)){
     $style = "class='".$class."'";
  }

  if(isset($onchange)){
     $event = "onchange='".$onchange.";'";
  }


  if(isset($disabled)){
     $disabled = "disabled='".$disabled.";'";
  } 


  $html_result = '';
  $html_result .= "<select name='$name' id='$name'  size='$size' $event $disabled>";
  
  $html_result .= "<option value='-1'> -- Select -- </optional>";

  for($i=0;$i < count($v);$i++)
  {
    $html_result .= "<option value='";
    $html_result .= $v[$i][$value]; 
    if(($_REQUEST[$name] == $v[$i][$value])&&($_REQUEST[$name] != ""))
	{
       $html_result .= "' selected>";
    } else {
       $html_result .= "'>";
    }
    $j = 0;
	do {
		if($j != 0) $html_result .= $glue;
		$html_result .= $v[$i][$label[$j]]; $j++;
	} while($j < count($label));
    $html_result .= "</option>";
  }
  $html_result .= "</select>";

  print $html_result;

}


/*
* Borra los valores duplicados que tenga una vector multidimencional.
*/
function BorrarValoresDuplicados($v,$indice)
{
  $indice_vector_nuevo = 0;
  $nuevo_vector;

  for($i=0;$i < count($v);$i++)
  {
    if(!ExiteRegistro($nuevo_vector,$indice,$v[$i][$indice])){
       $nuevo_vector[$indice_vector_nuevo] = $v[$i];
       $indice_vector_nuevo++;
    }
  }
  return $nuevo_vector;
}


/*
* Busca un registro en el vector,retorna 1 si lo encuentra
* retorna 0 si no lo encuentra.
*/
function ExiteRegistro($nuevo_vector,$indice,$dato_buscar)
{
  for($i=0;$i < count($nuevo_vector);$i++)
  {
    if($nuevo_vector[$i][$indice] == $dato_buscar){
       return 1;
    }
  }
  return 0;
}

?>
