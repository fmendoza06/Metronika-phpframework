<?php
		
/*

*/
		
class MysqlDataBase
{
 var $connection;
 var $consult;
  		
  function MysqlDataBase($host,$user,$pass)
  {
   //$this->connection = @mysql_connect($host, $user, $pass);
   //$this->connection = new PDO("mysql:host=$host;dbname=test", $username, $password);
   //return $this->connection;
   
try {
    $this->connection = new PDO('mysql:host=localhost;', $user, $pass);
   } 
   catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    //die();
   }   
   return $this->connection;
  }

  function getDataBases()
  {  
   //$this->consult = mysql_list_dbs($this->connection); Deprecate 
   $sql = "SHOW DATABASES";
   $this->consult = $this->connection->query($sql);
 
   $i=0;
   $vector=array();
   while( ( $db = $this->consult->fetchColumn( 0 ) ) !== false )
   {
     //echo $db.'<br>';
	 $vector[$i]["Database"]=$db;
	 $i++;
   }

   //return $this->toArray($this->consult);
   return $vector;
  }

  function getTables($dbname)
  {
  
   $sql = "SHOW TABLES FROM $dbname";
   //$this->consult = mysql_query($sql); deprecate
   $this->consult = $this->connection->query($sql);
   
   $i=0;
   $vector=array();   
   while( ( $table = $this->consult->fetchColumn( 0 ) ) !== false )
   {
     //echo $db.'<br>';
	 $vector[$i]["Table"]=$table;
	 $i++;
   }
   

   return $vector;
  }

  function getError()
  {
   //return mysql_error();
   return $this->connection->errorCode();
  }

  function close()
  {
    $ok=0;
    //mysql_close($this->connection);
  }

  function toArray($handle)
  {
	  

    for($i=0;$row = mysql_fetch_array($handle);$i++){
      for ($j = 0; $j < mysql_num_fields($handle); $j++){
         $vector[$i][mysql_field_name($handle, $j)] = $row[$j];
       }
    }
   return($vector);
  }
} //End of Class
?>
