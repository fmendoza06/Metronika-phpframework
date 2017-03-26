<?php
		
class OracleDataBase
{
 var $host;
 var $user;
 var $pass;
 var $connection;
 var $consult;
  		
  function OracleDataBase($host,$user,$pass)
  {
   $host_data = explode(":",$host);
   
   $this->host = "(DESCRIPTION=
                       (ADDRESS_LIST=
                           (ADDRESS=(PROTOCOL=TCP)
                               (HOST=".$host_data[0].")(PORT=".$host_data[1].")
                            )
                        )
                       (CONNECT_DATA=(SERVICE_NAME=".$host_data[2]."))
                 )";

   $this->user = $user;
   $this->pass = $pass;
   $this->connection = OCILogon($user,$pass,$this->host);
   //print_r($this->connection);
   return $this->connection;
  }

  function getDataBases()
  {

   $sql = "select username from all_users";
   $this->consult = OCIParse($this->connection,$sql);
   OCIExecute($this->consult);
   $registros_tables = $this->toArray($this->consult);
   
    for($i=0;$i < count($registros_tables);$i++){
       $nuevo_vector[$i]["Database"] = $registros_tables[$i]["USERNAME"];
   }
    return $nuevo_vector;

  }

  function getTables($dbname)
  {
   $sql = "select * from cat";
   $this->consult = OCIParse($this->connection,$sql);
   OCIExecute($this->consult);
   $registros_tables = $this->toArray($this->consult);

   // Crea un nuevo vector
   $j=0;
   for($i=0;$i < count($registros_tables);$i++){
       if($registros_tables[$i]["TABLE_TYPE"] == "TABLE"){
          $nuevo_vector[$j]["Table"] = $registros_tables[$i]["TABLE_NAME"];
          $j++;
       }
   }

   return $nuevo_vector;
  }

  function getError()
  {
   $data_error = OCIError();
   return $data_error["message"];
  }

  function close()
  {
    OCILogOff($this->connection);
  }

  function toArray($handle)
  {
    for($i=0;OCIFetchInto($handle,$result);$i++){
      for($j=0;$j < OCINumCols($handle);$j++){
         $vector[$i][OCIColumnName($handle,$j+1)] = $result[$j];
      }
    }
   return($vector);
  }
} //End of Class
?>
