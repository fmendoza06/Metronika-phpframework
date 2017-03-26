<?php
/*
 * Smarty plugin
 * --------------------------------------------------------------------
 * Type:     function
 * Name:     LoadIframe
 * Version:  1.0
 * Date:     Abril 04, 2004
 * Author:	 SpyroFrameWork
 * Purpose:
 * Input:
 *          type = tipo de base de datos ('Mysql'|'PostgreSQL'|'Oracle')
 *          host = nombre del host.
 *          db_name = nombre del catalogo
 *          user = nombre del usuario en la base de datos.
 *          pass = password en la base del usuario.
 *          cmd = comando que se invoca para llamar el template del iframe
 *
 *
 * Examples : {LoadIframe type=$type host=$host db_name=$db_name user=$user pass=$pass cmd="CmdTablasBbIframe"}
 *
 *
 * --------------------------------------------------------------------
 */
function smarty_function_LoadIframe($params, &$smarty)
{
  extract($params);

  // En caso de que el tipo de base de datos es 'Oracle', separa el 'host' del 'service_name'
  if($type == "oci8"){
     $host_data = explode(":",$host);
     $host = $host_data[0];
     $port = $host_data[1];
     $service_name = $host_data[2];
  }
  
  $result = "<fieldset><legend>".$host."</legend>";
  $result .= "<iframe src='index.php?action=".$cmd."&type_db=".$type."&server=".$host."&catalogo=".$db_name."&user=".$user."&password=".$pass."&service_name=".$service_name."&port=".$port."' width='475px' height='190px' frameborder='0' align='center'>";
  $result .= "</iframe>";
  $result .= "</fieldset>";
  print $result;

}

?>
