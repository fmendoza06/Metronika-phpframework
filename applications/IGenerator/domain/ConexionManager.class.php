<?php

include_once('MysqlDataBase.class.php');
include_once('PgsqlDataBase.class.php');
include_once('OracleDataBase.class.php');

class ConexionManager
{
    var $gateway;
    
    function conexionDb($type_db,$server,$user,$password,&$message)
    { //print_r("Tipo->".$type_db);  print_r($server.$user.$password);
      switch ($type_db) {
        case "mysql":
                     $conn = new MysqlDataBase($server,$user,$password); break;
        case "pgsql":{ //print_r("Conectando a postgres.....");
                      $conn = new PgsqlDataBase($server,$user,$password);
                      //print_r($conn->getError());
                      //print_r("Saliendo Conectando a postgres.....");
                      break;
                      }
        case "oci8": 
                     $conn = new OracleDataBase($server,$user,$password); break;
      }      // print_r("Aqui voy...");
       //print_r($conn->connection);
      if($conn->connection == ""){   print_r("No se conecto..");
         $message = "Could not connect: ".$conn->getError();
         return 0;
      }else{  //print_r("Se conecto..");
         $conn->close();
         return 1;
      }
    }
}

?>	
 	
