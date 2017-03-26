<?php
		
require_once ("MDB_MetaData.php");
	
class PgsqlDataBase
{
 var $host;
 var $user;
 var $pass;
 var $connection;
 var $consult;
  		
  function PgsqlDataBase($host,$user,$pass)
  {
   $this->host = $host;
   $this->user = $user;
   $this->pass = $pass;

   /*
   print_r($this->host);
   print_r($this->user);
   print_r($this->pass);
   */
   $this->connection = @pg_connect("host=$host dbname='template1' user=$user password=$pass");

   return $this->connection;
  }

  function getDataBases()
  {
   $sql = "select datname from pg_database";
   $this->consult = pg_query($this->connection,$sql);

   $registros_tables = pg_fetch_all($this->consult);
   
   for($i=0;$i < count($registros_tables);$i++){
       $nuevo_vector[$i]["Database"] = $registros_tables[$i]["datname"];
   }
   return $nuevo_vector;
   
  }

  function getTables($dbname)
  {
    $db_type = "pgsql";
    $dsn = "$db_type://".$this->user.":".$this->pass."@".$this->host."/$dbname";

    $obj = new MDB_MetaData();
    $dbMetaData = $obj->connect($dsn);
    $name_db = $dbMetaData->getDataBaseName();
    $tables = $dbMetaData->getTableList();
    
    // Crea un nuevo vector
    for($i=0;$i < count($tables);$i++){
       $nuevo_vector[$i]["Table"] = $tables[$i];
    }
    
    return $nuevo_vector;
  }

  function getError()
  {
    pg_result_error($this->connection);
  }

  function close()
  {
   pg_close($this->connection);
  }

} //End of Class
?>
