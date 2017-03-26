<?php

include_once('MysqlDataBase.class.php');
include_once('PgsqlDataBase.class.php');
include_once('OracleDataBase.class.php');

/*
 * Smarty plugin
 * --------------------------------------------------------------------
 * Type:     function
 * Name:     show_list_catalogos
 * Version:  1.0
 * Date:     Feb 09, 2004
 * Author:	 SpyroFrameWork
 * Purpose:
 * Input:
 *
 *
 * Examples : name="catalogo" type=$type host=$host user=$user pass=$pass
 *
 *
 * --------------------------------------------------------------------
 */
 
 
function smarty_function_show_list_catalogos($params, &$smarty)
{
  extract($params);

  
  $html_result = "";
  $html_result .= "<select name='".$name."'>";

  switch ($type) {
        case "mysql":
                     $conn = new MysqldataBase($host,$user,$pass);
                      break;
        case "pgsql":
                     $conn = new PgsqlDataBase($host,$user,$pass);
                     break;
        case "oci8":
                     $conn = new OracleDataBase($host,$user,$pass);
                     break;
  }

  $registros = $conn->getDataBases();
  
  for($i=0;$i < count($registros);$i++)
  {
    $html_result .= "<option value='";
    $html_result .= $registros[$i]["Database"];
    $html_result .= "'>";
    $html_result .= $registros[$i]["Database"];
    $html_result .="</option>";
  }

  $conn->close();

  $html_result .= "</select>";

  print $html_result;

}

?>
