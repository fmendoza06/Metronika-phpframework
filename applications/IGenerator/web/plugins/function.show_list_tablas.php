<?php

include_once('MysqlDataBase.class.php');
include_once('PgsqlDataBase.class.php');
include_once('OracleDataBase.class.php');

/*
 * Smarty plugin
 * --------------------------------------------------------------------
 * Type:     function
 * Name:     show_list_tablas
 * Version:  1.0
 * Date:     Feb 09, 2004
 * Author:	SpyroFrameWork
 * Purpose:
 * Input:
 *          type = tipo de base de datos ('Mysql'|'PostgreSQL'|'Oracle')
 *          host = nombre del host.
 *          db_name = nombre del catalogo
 *          user = nombre del usuario en la base de datos.
 *          pass = password en la base del usuario.
 *          form_name = nombre del formulario que contiene el plugin
 *
 * Examples : {show_list_tablas type=$type host=$host db_name=$db_name user=$user pass=$pass}
 *
 *
 * --------------------------------------------------------------------
 */
 
 
function smarty_function_show_list_tablas($params, &$smarty)
{
  extract($params); 

  switch ($type) {
        case "mysql":
                     $conn = new MysqlDataBase($host,$user,$pass); break;
        case "pgsql":
                     $conn = new PgsqlDataBase($host,$user,$pass); break;
        case "oci8":
                     $host = $host.":".$port.":".$service_name;
                     $conn = new OracleDataBase($host,$user,$pass);
                     break;
  }

  $registros = $conn->getTables($db_name);
  //print_r("Tablas->");  print_r($registros);
  $html_result .= "";
  
  if(is_array($registros)){
  
 	 $html_result .= "<script language=\"javascript\" >
		function CrearCadena(){
			var cadena_tablas;
			cadena_tablas = '';
			  with(document.".$form_name."){
			    for(var i=0;i<elements.length;i++){
					if(elements[i].type == 'checkbox'){
					    if(elements[i].name != 'checkall'){
					       if(elements[i].checked == true){
						      if(cadena_tablas == ''){
							     cadena_tablas = elements[i].value;
							  }else{
							     cadena_tablas += ',' + elements[i].value;
							  }
						   }
  						}
					}
				}
			  }
			parent.actualizar(cadena_tablas);
		}
	 </script>";

     $html_result .= "<table width='450' border='1'  bordercolor='#000000'>";
	 $html_result .= "<th colspan='2' bgcolor='#CCCCCC'>".$type." / ".$db_name."</th>";
	 $html_result .= "<td bgcolor='#CCCCCC'><input type='checkbox' name='checkall' onClick=\"with(document.".$form_name."){for(var i=0;i<elements.length;i++){if(elements[i].type == 'checkbox'){if(this.checked == true)elements[i].checked = true;else elements[i].checked = false;}}}CrearCadena();\"></td>";

     for($i=0;$i < count($registros);$i++)
	 {
	   $html_result .= "<tr>";
	   $html_result .= "<th width='35' bgcolor='#CCCCCC'>".($i+1)."</th>";
	   $html_result .= "<td>".$registros[$i]["Table"]."</td>";
	   $html_result .= "<td width='20'><input type='checkbox' name='table".$i."' value=".$registros[$i]["Table"]." onClick=\"CrearCadena();\"></td>";
	   $html_result .= "</tr>";
	  }

	  $html_result .= "</table>";
  
  }else{
      $html_result .= "<br><br><br><br><center><h3>El Catalogo '".$db_name."' no tiene tablas</h3></center>";
  }

  $conn->close();

  print $html_result;

}

?>
