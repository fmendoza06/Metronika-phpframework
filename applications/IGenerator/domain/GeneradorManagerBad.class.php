<?php

require_once("MDB_MetaData.php");

class GeneradorManager
{

    function generarAplicacion($dir_name,$type_db,$server,$user,$password,$catalogo,$name_application,$name_company,$charset,$name_style,$components,$tables,$gen_type)
    {
	/*
   $dir_name='Base';
   $type_db ='mysql';
   $gen_type ='adodb';
   $server="localhost:3308";
   $user='root';
   $password='admin';
   $catalogo='mamut';
   $name_application ='mamut';
   $name_style = '';
   $name_company = 'sp';
   $name_style ='Spyro';
   $charset ='utf-8';
   */
   $name_company="";
    if($type_db == "oci8"){
       $host_data = explode(":",$server);
       $server = "(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(HOST=".$host_data[0].")(PORT=".$host_data[1].")))(CONNECT_DATA=(SERVICE_NAME=".$host_data[2].")))";
	   //print_r($server);
    }
	

	// Report all errors except E_NOTICE 
	// This is the default value set in php.ini 
	error_reporting (E_ALL); 
	
    $process_result = "";

    $array_metadata = $this->getMetadata($type_db,$server,$catalogo,$user,$password,$tables);
	echo "<pre>jj"; print_r($array_metadata); echo "</pre>";
	$document_xml = $this->getXML($type_db,$array_metadata);

/*	  
    echo "======================= Parametros ==============================<BR>";
    echo "tipo BD: ".$type_db."<BR>";
    echo "servidor:".$server."<BR>";
    echo "usuario: ".$user."<BR>";
    echo "password: ".$password."<BR>";
    echo "catalogo: ".$catalogo."<BR>";
    echo "Nombre Empresa: ".$name_company;
    echo "Nombre Aplicacion: ".$name_application."<BR>";
    echo "Estilo :".$name_style."<BR>";
    echo "=======================  Components  ==============================<BR>";	
    echo "<pre>"; print_r($components); echo "</pre>";	
    echo "gen_type :".$gen_type."<BR>";	
    echo "=======================  Tablas  ==============================<BR>";		
    echo "<pre>"; print_r($tables); echo "</pre><BR>";
    echo "=======================  Metadata  ==============================<BR>";
    echo "<pre>"; print_r($array_metadata); echo "</pre>";
    echo "==========================  XML  ==============================<BR>";
    echo "<textarea cols=500>".$document_xml."</textarea>";	
    echo "<pre>jj"; print_r($array_metadata); echo "</pre>";
   */

	
    //echo "<textarea cols=500>".$array_metadata."</textarea>";
	/**/
    //$process_result .= $this->CreateStructDirectory($name_application,$components,$type_db);

    //$process_result .= $this->CopyFiles($name_application,$components);
	
	//$process_result .= $this->generatelanguagefile($name_application,$array_metadata);


	
    //$process_result .= $this->GenerateFiles($name_application,$type_db,$tables,$server,$user,$password,$catalogo,$dir_name,$name_company,$charset,$name_style,$components,$gen_type);
    

    return $process_result;
	
	//return $process_result;

    }

    /*
    * Metodo que obtiene la Metadata de la base de datos, retorna
    * un Array Asociativo.
    */
    function getMetadata($db_type,$host,$db_name,$user,$pass,$tables)
    {

      $dsn = "$db_type://$user:$pass@$host/$db_name";
	  

      $obj = new MDB_MetaData();
      //print_r($dsn);
      $dbMetaData = $obj->connect($db_type,$host, $user, $pass, $db_name);

      //$name_db = $db_name ;
	  $name_db = $dbMetaData->getDataBaseName();
	  
      if(isset($table) && isset($column)) {
         $results = $dbMetaData->getColumnList($table);
          $results = $dbMetaData->getColumnData($table, $column);
          $results = $dbMetaData->getPrimaryKeyTable($table);
          $results = $dbMetaData->getForeignKeyTable($table);
          $results = $dbMetaData->MetaIndexes($table);
      }else {
          if (isset($table)) {
              $results = $dbMetaData->getColumnList($table);
              $results = $dbMetaData->getColumnData($table, '');
              $results = $dbMetaData->getPrimaryKeyTable($table);
              $results = $dbMetaData->getForeignKeyTable($table);
              $results = $obj->MetaIndexes($table);
          }else {
              foreach($tables as $table) {
			      
                  $results = $dbMetaData->getColumnList($table);
                  $results = $dbMetaData->getColumnData($table, '');
                  $results = $dbMetaData->getPrimaryKeyTable($table);
                  $results = $dbMetaData->getForeignKeyTable($table);
                  $results = $dbMetaData->getIndex($table);



              }
          }
      }

				  
	  //print_r($result);
      //$results = $dbMetaData->getSequence( );
      $structure_db = $dbMetaData->getDataBase();
      
      $structure_db['tables']['list'] = $tables;

      return $structure_db;

    }

    /*
    * Metodo que genera el documento XML a partir del Array con los
    * metadatos. retorna una cadena que contiene el Xml que define los metadatos.
    */
    function getXML($db_type,$structure_db)
    {
		  

     $dom = new DomDocument('1.0', 'utf-8'); //new DOMDocument('1.0'); //domxml_new_doc('1.0'); //
	 

     // Create elements
     $raizElement = $dom->createElement('database');
     $namedbElement = $dom->createElement('name');
     $namedbTextElement = $dom->createTextNode($structure_db['name_db']);

     //optionals
     $namedbElement->appendChild($namedbTextElement);
     $raizElement->appendChild($namedbElement);

     $num_tables = count($structure_db['tables']['list']);

     //tables
     for($j = 0; $j < $num_tables; $j++){
         $tableElement= $dom->createElement('table');
         $nametableElement = $dom->createElement('name');
         $name_table=$structure_db['tables']['list'][$j];

         $nametableTextElement = $dom->createTextNode($name_table);
         $nametableElement->appendChild($nametableTextElement);
         $tableElement->appendChild($nametableElement);
         $raizElement->appendChild($tableElement);
         $declaretableElement= $dom->createElement('declaration');
         $num_field = count($structure_db['tables'][$name_table]['columns']['list']);
         for($i = 0; $i < $num_field; $i++) {
             $name_column=$structure_db['tables'][$name_table]['columns']['list'][$i];
             $column=$structure_db['tables'][$name_table]['columns'][$name_column];
			 
             $fieldtableElement = $dom->createElement('field');
             $namefieldElement = $dom->createElement('name');
             $namefieldTextElement = $dom->createTextNode($column['name']);
             $typefieldElement = $dom->createElement('type');
             $typefieldTextElement = $dom->createTextNode(strtolower($column['type']));
             $notnullfieldElement = $dom->createElement('null');
             $notnullfieldTextElement = $dom->createTextNode(strtolower($column['null']));

             $namefieldElement->appendChild($namefieldTextElement);
             $typefieldElement->appendChild($typefieldTextElement);
             $notnullfieldElement->appendChild($notnullfieldTextElement);
             $fieldtableElement->appendChild($namefieldElement);
             $fieldtableElement->appendChild($typefieldElement);

             if($column['precision']!='null'){
                $precisionfieldElement = $dom->createElement('precision');
                $precisionfieldTextElement = $dom->createTextNode($column['precision']);
                $precisionfieldElement->appendChild($precisionfieldTextElement);
                $fieldtableElement->appendChild($precisionfieldElement);
             }
             if($column['scale']!='null'){
                $scalefieldElement = $dom->createElement('scale');
                $scalefieldTextElement = $dom->createTextNode($column['scale']);
                $scalefieldElement->appendChild($scalefieldTextElement);
                $fieldtableElement->appendChild($scalefieldElement);
             }
             $fieldtableElement->appendChild($notnullfieldElement);
             if($column['default']!='null'){
                $defaultfieldElement = $dom->createElement('default');
                $defaultfieldTextElement = $dom->createTextNode($column['default']);
                $defaultfieldElement->appendChild($defaultfieldTextElement);
                $fieldtableElement->appendChild($defaultfieldElement);
             }
             if($column['counter']!='null'){
                $counterfieldElement = $dom->createElement('counter');
                $counterfieldTextElement = $dom->createTextNode($column['counter']);
                $counterfieldElement->appendChild($counterfieldTextElement);
                $fieldtableElement->appendChild($counterfieldElement);
             }
             $declaretableElement->appendChild($fieldtableElement);
         } //End for

         //primary-key
        $num_prim = count($structure_db['tables'][$name_table]['primary_key']);

        $primary=$structure_db['tables'][$name_table]['primary_key'];
        $primaryElement= $dom->createElement('primary_key');

        for($m = 0; $m < $num_prim; $m++) { 
            $fieldprimaryElement = $dom->createElement('field');
            $namepriElement = $dom->createElement('name');
            $namepriTextElement = $dom->createTextNode($primary[$m]);

            $namepriElement->appendChild($namepriTextElement);
            $fieldprimaryElement->appendChild($namepriElement);
            $primaryElement->appendChild($fieldprimaryElement);
        }//end for primary-key

        $declaretableElement->appendChild($primaryElement);

        //foreign-key
        for($varhemer=0;$varhemer < count($structure_db['tables'][$name_table]['foreign_key']);$varhemer++){
            $foreign=$structure_db['tables'][$name_table]['foreign_key'][$varhemer];
            if ($foreign != ''){
                $foreignElement= $dom->createElement('foreign_key');
                $nameforElement = $dom->createElement('name');
                $nameforTextElement = $dom->createTextNode($foreign['name']);
                $nameforElement->appendChild($nameforTextElement);
                $foreignElement->appendChild($nameforElement);

                //local-table
                $localtableElement = $dom->createElement('local_table');

                $num_field_for = count($structure_db['tables'][$name_table]['foreign_key'][$varhemer]['local_table_columns']);

                for($n = 0; $n < $num_field_for; $n++) {
                    $fieldfor=$structure_db['tables'][$name_table]['foreign_key'][$varhemer]['local_table_columns'];

                    $fieldforElement =$dom->createElement('field');
                    $namefieldforElement=$dom->createElement('name');
                    $namefieldforTextElement = $dom->createTextNode($fieldfor[$n]);

                    $namefieldforElement->appendChild($namefieldforTextElement);
                    $fieldforElement->appendChild($namefieldforElement);
                    $localtableElement->appendChild($fieldforElement);
                    $foreignElement->appendChild($localtableElement);
                }// End for local-table

                //reference-table
                $refertableElement = $dom->createElement('reference_table');

                $num_field_ref = count($structure_db['tables'][$name_table]['foreign_key'][$varhemer]['reference_table_columns']);

                $namerefElement = $dom->createElement('name');
                $namerefTextElement = $dom->createTextNode($foreign['reference_table']);
                $namerefElement->appendChild($namerefTextElement);
                $refertableElement->appendChild($namerefElement);

                for($p = 0; $p < $num_field_ref; $p++) {
                    $fieldref=$structure_db['tables'][$name_table]['foreign_key'][$varhemer]['reference_table_columns'];
                    $fieldrefElement =$dom->createElement('field');
                    $namefieldrefElement=$dom->createElement('name');
                    $namefieldrefTextElement = $dom->createTextNode($fieldref[$p]);

                    $namefieldrefElement->appendChild($namefieldrefTextElement);
                    $fieldrefElement->appendChild($namefieldrefElement);
                    $refertableElement->appendChild($fieldrefElement);
                    $foreignElement->appendChild($refertableElement);
                }//End for reference-table
                $declaretableElement->appendChild($foreignElement);
            }//end if foreign-key
        }// end for foreign-key

        $tableElement->appendChild($declaretableElement);

        //index
        $numindex = count($structure_db['tables'][$name_table]['index']);
		
		
        $getindex=$structure_db['tables'][$name_table]['index'];

        if ($getindex != ''){
            for($t = 0; $t < $numindex; $t++) {
                $index=$getindex[$t];

                $indextableElement= $dom->createElement('index');
                $nameindexElement = $dom->createElement('name');
                $nameindexTextElement = $dom->createTextNode($index['name']);
                $typeindexElement = $dom->createElement('type');
                $typeindexTextElement = $dom->createTextNode($index['type']);
                $accessindexElement = $dom->createElement('access_method');
                $accessindexTextElement = $dom->createTextNode($index['access_method']);
                $collationindexElement = $dom->createElement('collation');
                $collationindexTextElement = $dom->createTextNode($index['collation']);

                $nameindexElement->appendChild($nameindexTextElement);
                $typeindexElement->appendChild($typeindexTextElement);
                $accessindexElement->appendChild($accessindexTextElement);
                $collationindexElement->appendChild($collationindexTextElement);

                $indextableElement->appendChild($nameindexElement);
                $indextableElement->appendChild($typeindexElement);
                $indextableElement->appendChild($accessindexElement);
                $indextableElement->appendChild($collationindexElement);

                //field index
                $numfieldindex = count($structure_db['tables'][$name_table]['index'][$t]['columns_name']);

                for($q=0; $q<$numfieldindex; $q++) {
                    $fieldindex=$structure_db['tables'][$name_table]['index'][$t]['columns_name'];
                    $fieldindexElement = $dom->createElement('field');
                    $namefieldindexElement=$dom->createElement('name');
                    $namefieldindexTextElement = $dom->createTextNode($fieldindex[$q]);

                    $namefieldindexElement->appendChild($namefieldindexTextElement);
                    $fieldindexElement->appendChild($namefieldindexElement);
                    $indextableElement->appendChild($fieldindexElement);
                }// End for field index

                $declaretableElement->appendChild($indextableElement);
            }//End for index
        }//End if index
     }//End for tables

     //Sequences

     if ($db_type != "mysql"){
         $num_sequence = count($structure_db['sequences']['list']);
         for($k = 0; $k < $num_sequence; $k++){
             $name_sequence=$structure_db['sequences']['list'][$k];
             $attsequence=$structure_db['sequences'][$name_sequence];

             $sequenceElement= $dom->createElement('sequence');
             $nameseqElement = $dom->createElement('name');
             $nameseqTextElement = $dom->createTextNode($name_sequence);
             $startseqElement = $dom->createElement('start');
             $startseqTextElement = $dom->createTextNode($attsequence['Start']);
             $incrementvalueseqElement = $dom->createElement('increment');
             $incrementvalueseqTextElement = $dom->createTextNode($attsequence['Increment']);
             $minvalueseqElement = $dom->createElement('min_value');
             $minvalueseqTextElement = $dom->createTextNode($attsequence['Min_value']);
             $maxvalueseqElement = $dom->createElement('max_value');
             $maxvalueseqTextElement = $dom->createTextNode($attsequence['Max_value']);
             $cycleseqElement = $dom->createElement('cycle');
             $cycleseqTextElement = $dom->createTextNode($attsequence['Cycle']);
             $cacheseqElement = $dom->createElement('cache');
             $cacheseqTextElement = $dom->createTextNode($attsequence['Cache']);

             $nameseqElement->appendChild($nameseqTextElement);
             $startseqElement->appendChild($startseqTextElement);
             $incrementvalueseqElement->appendChild($incrementvalueseqTextElement);
             $minvalueseqElement->appendChild($minvalueseqTextElement);
             $maxvalueseqElement->appendChild($maxvalueseqTextElement);
             $cycleseqElement->appendChild($cycleseqTextElement);
             $cacheseqElement->appendChild($cacheseqTextElement);

             $sequenceElement->appendChild($nameseqElement);
             $sequenceElement->appendChild($startseqElement);
             $sequenceElement->appendChild($incrementvalueseqElement);
             $sequenceElement->appendChild($minvalueseqElement);
             $sequenceElement->appendChild($maxvalueseqElement);
             $sequenceElement->appendChild($cycleseqElement);
             $sequenceElement->appendChild($cacheseqElement);
             $raizElement->appendChild($sequenceElement);
         }//end for sequence
     }//end if sequence
	 
	// Add the root element to the document
    $dom->appendChild($raizElement);
   

	$xml_file = 'dom_example.xml';
    if(!$dom->save($xml_file)) 
	   echo 'Error: unable to write dom_example.xml';	
    
	return $dom->saveXML();
    }// end metodo getXML
    
    //Metodo que crea toda la estructura de directorios para la aplicacion
    //generada.
    function CreateStructDirectory($name_application,$components,$type_db)
    {
	 $string_result = "";

	 $string_result .= "================Directorios Creados================\n";
     mkdir ("../".$name_application, 0700);
     $string_result .= "../".$name_application."\n";

     //valida si se deben generar la configuracion
	 if(isset($components["config"])){	
	     mkdir ("../".$name_application."/config", 0700);
	     $string_result .= "../".$name_application."/config\n";
		 mkdir ("../".$name_application."/language", 0700);
		 $string_result .= "../".$name_application."/language\n";
		 mkdir ("../".$name_application."/language/es", 0700);
		 $string_result .= "../".$name_application."/language/es\n";
		 mkdir ("../".$name_application."/report", 0700);
		 $string_result .= "../".$name_application."/report\n";
	 }

     //valida si se seleccionaron todos los componentes para generar
	 if( isset($components["config"]) && isset($components["templates"]) && isset($components["commands"]) && isset($components["domain"]) && isset($components["data"]) ){
	     mkdir ("../".$name_application."/templates_c", 0700);
	     $string_result .= "../".$name_application."/templates_c\n";
	 }

	 if( isset($components["commands"]) || isset($components["templates"]) ){
	     mkdir ("../".$name_application."/web", 0700);
	     $string_result .="../".$name_application."/web\n";
	 }

     //valida si se deben generar los templates
	 if(isset($components["templates"])){	
	     mkdir ("../".$name_application."/web/plugins", 0700);
	     $string_result .= "../".$name_application."/web/plugins\n";
	     mkdir ("../".$name_application."/web/templates", 0700);
	     $string_result .= "../".$name_application."/web/templates\n";
	     mkdir ("../".$name_application."/web/js", 0700);
	     $string_result .= "../".$name_application."/web/js\n";
	     mkdir ("../".$name_application."/web/images", 0700);
	     $string_result .= "../".$name_application."/web/images\n";
	     mkdir ("../".$name_application."/web/images/default", 0700);
	     $string_result .= "../".$name_application."/web/images/default\n";
	     mkdir ("../".$name_application."/web/images/menu", 0700);
	     $string_result .= "../".$name_application."/web/images/menu\n";
	     mkdir ("../".$name_application."/web/images/menubar", 0700);
	     $string_result .= "../".$name_application."/web/images/menubar\n";		 
	     mkdir ("../".$name_application."/web/images/default/tools_bar_page", 0700);
	     $string_result .= "../".$name_application."/web/images/default/tools_bar_page\n";
	     mkdir ("../".$name_application."/web/css", 0700);
	     $string_result .= "../".$name_application."/web/css\n";
	     mkdir ("../".$name_application."/web/rs", 0700);
	     $string_result .= "../".$name_application."/web/rs\n";
	 }

     //valida si se deben generar los comandos
	 if(isset($components["commands"])){	
	     mkdir ("../".$name_application."/web/commands", 0700);
	     $string_result .= "../".$name_application."/web/commands\n";
	 }

     //valida si se deben generar los manager
	 if(isset($components["domain"])){	
	     mkdir ("../".$name_application."/domain", 0700);
	     $string_result .= "../".$name_application."/domain\n";
	 }

      //valida si se deben generar las compuertas
	 if(isset($components["data"])){
           

	  mkdir ("../".$name_application."/data", 0700);
	  $string_result .="../".$name_application."/data\n";
	  if ($gen_type=="native") //Generation with native
          {
           switch ($db_type) {
	     case "mysql":{
	                    mkdir ("../".$name_application."/data/Mysql", 0700);
	                    $string_result .= "../".$name_application."/data/Mysql\n";
	                    break;
	                  }
	     case "pgsql":{
	                    mkdir ("../".$name_application."/data/Pgsql", 0700);
	                    $string_result .= "../".$name_application."/data/Pgsql\n";
	                    break;
	                  }
	     case "oci8":{
	                    mkdir ("../".$name_application."/data/Oracle", 0700);
	                    $string_result .= "../".$name_application."/data/Oracle\n";
	                    break;
	                  }
            }//End switch
           }
	   else
           {
	                    mkdir ("../".$name_application."/data/adodb", 0700);
	                    $string_result .= "../".$name_application."/data/adodb\n";
	   }

	 }

	 return $string_result;
    }

    function CopyFiles($name_application,$components)
    {
	 error_reporting(E_ERROR | E_WARNING);
     $string_result = "";

	 $string_result .= "=================Archivos Copiados================\n";

     //valida si se seleccionaron todos los componentes para generar
	 if( isset($components["config"]) && isset($components["templates"]) && isset($components["commands"]) && isset($components["domain"]) && isset($components["data"]) ){
	     //indice
	     copy("files/root/index.php","../".$name_application."/index.php");
		 $string_result .= "../".$name_application."/index.php\n";
	 }

     //valida si se deben generar la configuracion
	 if(isset($components["config"])){	
	     //archivos de configuracion
	     copy("files/config/web.conf.data","../".$name_application."/config/web.conf.data");
		 $string_result .= "../".$name_application."/config/web.conf.data\n";
	     copy("files/config/application.conf.data","../".$name_application."/config/application.conf.data");
		 $string_result .= "../".$name_application."/config/application.conf.data\n";
	     copy("files/config/config.inc.php","../".$name_application."/config/config.inc.php");
		 $string_result .= "../".$name_application."/config/config.inc.php\n";
	     copy("files/language/es/Message.lan","../".$name_application."/language/es/Message.lan");
		 $string_result .= "../".$name_application."/language/es/Message.lan\n";		 
	 }

     //valida si se deben generar los comandos
	 if(isset($components["commands"])){			
	     //comando por defect
	     copy("files/commands/DefaultCommand.class.php","../".$name_application."/web/commands/DefaultCommand.class.php");
		 $string_result .= "../".$name_application."/web/commands/DefaultCommand.class.php\n";
	 }

     //valida si se deben generar los templates
	 if(isset($components["templates"])){			
	     // librerias en JavaScript
	    $handle=opendir("files/js/");
		 while (false !== ($file = readdir($handle))){
		 	   if(!preg_match("/^\./", $file)){
			  	  copy("files/js/$file","../".$name_application."/web/js/$file");
				  $string_result .= "../".$name_application."/web/js/$file\n";
			   }
		 }
	
	     // imagenes
		 /*
	    $handle=opendir("files/images/");
		 while (false !== ($file = readdir($handle))){
		 	   if(!preg_match("/^\./",$file) && ($file!=='default')){ 
			  	  copy("files/images/$file","../".$name_application."/web/images/$file");
				  //$this->rcopy("files/images/$file","../".$name_application."/web/images/$file");
				  $string_result .= "../".$name_application."/web/images/$file\n";
			   }
		 }
		 */
	     // imagenes
	    $handle=opendir("files/images/default/tools_bar_page/");
		 while (false !== ($file = readdir($handle))){
		 	   if(!preg_match("/^\./", $file)){
			  	  copy("files/images/default/tools_bar_page/$file","../".$name_application."/web/images/default/tools_bar_page/$file");
				  $string_result .= "../".$name_application."/web/images/default/tools_bar_page/$file\n";
			   }
		 }

	     // imagenes
	    $handle=opendir("files/images/menu/");
		 while (false !== ($file = readdir($handle))){
		 	   if(!preg_match("/^\./", $file)){
			  	  copy("files/images/menu/$file","../".$name_application."/web/images/menu/$file");
				  $string_result .= "../".$name_application."/web/images/menu/$file\n";
			   }
		 }

	     // imagenes
	    $handle=opendir("files/images/menubar/");
		 while (false !== ($file = readdir($handle))){
		 	   if(!preg_match("/^\./", $file)){
			  	  copy("files/images/menubar/$file","../".$name_application."/web/images/menubar/$file");
				  $string_result .= "../".$name_application."/web/images/menubar/$file\n";
			   }
		 }		 
	
	     // plugins
	     //Modificacion para que copie cualquier plugin dentro de la carpeta
	     $handle=opendir("files/plugins/");
	 	 while (false !== ($file = readdir($handle))){
			 if(!preg_match("/^\./", $file)){
				copy("files/plugins/$file","../".$name_application."/web/plugins/$file");
				$string_result .= "../".$name_application."/web/plugins/$file\n";
			 }
		 }
	
	     // hojas de estilo
	    $handle=opendir("files/css/");
		 while (false !== ($file = readdir($handle))){
		 	   if(!preg_match("/^\./", $file)){
			  	  copy("files/css/$file","../".$name_application."/web/css/$file");
				  $string_result .= "../".$name_application."/web/css/$file\n";
			   }
		 }
	     // Remote Scripting
	    $handle=opendir("files/rs/");
		 while (false !== ($file = readdir($handle))){
		 	   if(!preg_match("/^\./", $file)){
			  	  copy("files/rs/$file","../".$name_application."/web/rs/$file");
				  $string_result .= "../".$name_application."/web/rs/$file\n";
			   }
		 }

	     // Templates Base
	    $handle=opendir("files/templates/");
		 while (false !== ($file = readdir($handle))){
		 	   if(!preg_match("/^\./", $file)){
			  	  copy("files/templates/$file","../".$name_application."/web/templates/$file");
				  $string_result .= "../".$name_application."/web/rs/$file\n";
			   }
		 }		 
	 }
	 	
     return $string_result;
    }


    function GenerateFiles($name_application,$db_type,$tables,$server,$user,$password,$catalogo,$dir_name,$name_company,$charset,$name_style,$components,$gen_type)
    {
	
	$string_result = "";
		
    //Cro un XSLTProcesor  para convertir todoslo XSL en cada funcion
    $xh =new XSLTProcessor();
	 
     $path = Application::getBaseDirectory()."/";

     $arguments="";

     //valida si se deben generar las compuertas
	 if(isset($components["data"])){
		 
	    $string_result .= "=============Compuertas de Fila Generadas============\n";
            if ($gen_type=="native") //Generation with native
            {
	     switch ($db_type) {
	        case "mysql":
	                     $string_result .= $this->GenerateDataGatewayMysql($xh,$tables,$arguments,$name_application,$dir_name,$name_company);
	                     break;
	        case "pgsql":
	                     $string_result .= $this->GenerateDataGatewayPgsql($xh,$tables,$arguments,$name_application,$dir_name,$name_company);
	                     break;
	        case "oci8":
	                     $string_result .= $this->GenerateDataGatewayOci8($xh,$tables,$arguments,$name_application,$dir_name,$name_company);
	                     break;
	     }
           }
           else //Generation with ADODB
		   {
             $string_result .= $this->GenerateDataGatewayADODB($xh,$tables,$arguments,$name_application,$dir_name,$name_company);

		   }	 
	 }

	 //valida si se deben generar la configuracion
	 if(isset($components["config"])){
		 $string_result .= "===========Archivos de Configuracion Generados=========\n";
	     $string_result .= $this->GenerateSaveConfigurationFile($xh,$arguments,$name_application,$db_type,$server,$user,$password,$catalogo,$dir_name,$name_company,$charset);
	     $string_result .= $this->GenerateSaveNavigationFile($xh,$arguments,$name_application,$dir_name,$name_company);
	 }

     //valida si se deben generar los manager
	 if(isset($components["domain"])){
	     $string_result .= "===============Controladores Generados=============\n";
	     $string_result .= $this->GenerateManager($xh,$tables,$arguments,$name_application,$dir_name,$name_company);
	 }
	 
     //valida si se deben generar los comandos
	 if(isset($components["commands"])){	
		 $string_result .= "================Comandos Generados==============\n";
	     $string_result .= $this->GenerateDefaultCommand($xh,$tables,$arguments,$name_application,$dir_name,$name_company);
	     $string_result .= $this->GenerateAddCommand($xh,$tables,$arguments,$name_application,$dir_name,$name_company);
	     $string_result .= $this->GenerateUpdateCommand($xh,$tables,$arguments,$name_application,$dir_name,$name_company);
	     $string_result .= $this->GenerateDeleteCommand($xh,$tables,$arguments,$name_application,$dir_name,$name_company);
	     $string_result .= $this->GenerateClearCommand($xh,$tables,$arguments,$name_application,$dir_name,$name_company);
	     $string_result .= $this->GenerateShowListCommand($xh,$tables,$arguments,$name_application,$dir_name,$name_company);
	     $string_result .= $this->GenerateShowByIdCommand($xh,$tables,$arguments,$name_application,$dir_name,$name_company);
	     $string_result .= $this->GenerateCancelShowListCommand($xh,$tables,$arguments,$name_application,$dir_name,$name_company);
	 }
	 
     //valida si se deben generar los templates
	 if(isset($components["templates"])){		 
		 $string_result .= "=================Templates Generados==============\n";
	     $string_result .= $this->GenerateTemplate($xh,$tables,$arguments,$name_application,$dir_name,$name_company,$name_style);
	     $string_result .= $this->GenerateTemplateConsult($xh,$tables,$arguments,$name_application,$dir_name,$name_company,$name_style);
	     $string_result .= $this->GenerateMainMenu($xh,$arguments,$name_application,$dir_name,$name_company,$name_style);
	 }
	 
	 
	 return $string_result;
    }
    
    /*
    * Metodo que genera las compuertas de fila para Mysql
    */
    function GenerateDataGatewayMysql($xh,$tables,$arguments,$name_application,$dir_name,$name_company)
    {
       $string_result = "";
       $xsl = new DOMDocument("1.0");	
	   $xml = new DOMDocument("1.0");
	   
	   $xml->load( 'dom_example.xml');	   
  
	   $xsl->load( "xslt/".$dir_name."/GeneracionCompuertaFilaMysql.xsl");
	   $xh->importStyleSheet($xsl);
       $string_result = "";
       for($i=0;$i<count($tables);$i++){
	   
           //contruye el nombre del archivo
           $file_name = $name_company . $name_application . "Mysql" . ucfirst($tables[$i]) . ".class.php";
		   
		   $xh->setParameter('','tabla',$tables[$i]);
		   $xh->setParameter('','empresa',$name_company);
		   $xh->setParameter('','aplicacion',$name_application);
		   
		   $out=$xh->transformToXML($xml);
           $result =$this->SaveFile("../".$name_application."/data/Mysql/".$file_name,$out);		   
	   	   
	       if(!$result)
	          print "<font color='#FF0000'><strong>Error: ".$xh->error()."</strong></font>";
	       else
		      $string_result .= $file_name."\n" ;
       }
       return $string_result;
	   
    }
    
    /*
    * Metodo que genera las compuertas de fila para PostgreSQL
    */
    function GenerateDataGatewayPgsql($xh,$tables,$arguments,$name_application,$dir_name,$name_company)
    {
       $string_result = "";
       $xsl = new DOMDocument("1.0");	
	   $xml = new DOMDocument("1.0");
	   
	   $xml->load( 'dom_example.xml');	   
  
	   $xsl->load( "xslt/".$dir_name."/GeneracionCompuertaFilaPgSQL.xsl");
	   $xh->importStyleSheet($xsl);
       $string_result = "";
       for($i=0;$i<count($tables);$i++){
	   
           //contruye el nombre del archivo
           $file_name = $name_company . $name_application . "Pgsql" . ucfirst($tables[$i]) . ".class.php";
		   
		   $xh->setParameter('','tabla',$tables[$i]);
		   $xh->setParameter('','empresa',$name_company);
		   $xh->setParameter('','aplicacion',$name_application);
		   
		   $out=$xh->transformToXML($xml);
           $result =$this->SaveFile("../".$name_application."/data/Pgsql/".$file_name,$out);		   
	   	   
	       if(!$result)
	          print "<font color='#FF0000'><strong>Error: ".$xh->error()."</strong></font>";
	       else
		      $string_result .= $file_name."\n" ;
       }
       return $string_result;	   
    }

    /*
    * Metodo que genera las compuertas de fila para Oracle 8i
    */
    function GenerateDataGatewayOci8($xh,$tables,$arguments,$name_application,$dir_name,$name_company)
    {
	   $string_result = "";
       $xsl = new DOMDocument("1.0");	
	   $xml = new DOMDocument("1.0");
	   
	   $xml->load( 'dom_example.xml');	   
  
	   $xsl->load( "xslt/".$dir_name."/GeneracionCompuertaFilaOracle.xsl");
	   $xh->importStyleSheet($xsl);
       $string_result = "";
       for($i=0;$i<count($tables);$i++){
	   
           //contruye el nombre del archivo
           $file_name = $name_company . $name_application . "Oracle" . ucfirst($tables[$i]) . ".class.php";
		   
		   $xh->setParameter('','tabla',$tables[$i]);
		   $xh->setParameter('','empresa',$name_company);
		   $xh->setParameter('','aplicacion',$name_application);
		   
		   $out=$xh->transformToXML($xml);
           $result =$this->SaveFile("../".$name_application."/data/Oracle/".$file_name,$out);		   
	   	   
	       if(!$result)
	          print "<font color='#FF0000'><strong>Error: ".$xh->error()."</strong></font>";
	       else
		      $string_result .= $file_name."\n" ;
       }
       return $string_result;
	   
    }
    
    /*
    * Metodo que genera las compuertas de fila para Oracle 8i
    */
    function GenerateDataGatewayADODB($xh,$tables,$arguments,$name_application,$dir_name,$name_company)
    {   
	print_r("<pre>");
	print_r("Entre....");
	print_r("</pre>");	
	
	   $string_result = "";
       $xsl = new DOMDocument("1.0");	
	   $xml = new DOMDocument("1.0");
	   
	   $xml->load( 'dom_example.xml');	   
  
	   $xsl->load( "xslt/".$dir_name."/GeneracionCompuertaFilaADODB.xsl");
	   $xh->importStyleSheet($xsl);

	
       for($i=0;$i<count($tables);$i++){
	   
           //contruye el nombre del archivo
           $file_name = $name_company . $name_application . "adodb" . ucfirst($tables[$i]) . ".class.php";
		   
		   $xh->setParameter('','tabla',$tables[$i]);
		   $xh->setParameter('','empresa',$name_company);
		   $xh->setParameter('','aplicacion',$name_application);
	       print_r("<pre>");
	       print_r($tables[$i]);
	       print_r("</pre>");			   
		   $out=$xh->transformToXML($xml);
           $result =$this->SaveFile("../".$name_application."/data/adodb/".$file_name,$out);		   
	   	   
	       if(!$result)
	          print "<font color='#FF0000'><strong>Error: ".$xh->error()."</strong></font>";
	       else
		      $string_result .= $file_name."\n" ;
       }
       return $string_result;
    }

    /*
    * Metodo que genera los controladores
    */
    function GenerateManager($xh,$tables,$arguments,$name_application,$dir_name,$name_company)
    {
	
	   $string_result = "";
       $xsl = new DOMDocument("1.0");	
	   $xml = new DOMDocument("1.0");
	   
	   $xml->load( 'dom_example.xml');	   
  
	   $xsl->load( "xslt/".$dir_name."/GeneracionControl.xsl");
	   $xh->importStyleSheet($xsl);
       for($i=0;$i<count($tables);$i++){
	   
           //contruye el nombre del archivo
           $file_name = $name_company . $name_application . ucfirst($tables[$i]) . "Manager.class.php";
		   
		   $xh->setParameter('','tabla',$tables[$i]);
		   $xh->setParameter('','empresa',$name_company);
		   $xh->setParameter('','aplicacion',$name_application);
		   
		   $out=$xh->transformToXML($xml);
		   $result =$this->SaveFile("../".$name_application."/domain/".$file_name,$out);
	   	   
	       if(!$result)
	          print "<font color='#FF0000'><strong>Error: ".$xh->error()."</strong></font>";
	       else
		      $string_result .= $file_name."\n" ;
       }
       return $string_result;
	   

    }

    /*
    * Metodo que genera el comando por default de cada forma.
    */
    function GenerateDefaultCommand($xh,$tables,$arguments,$name_application,$dir_name,$name_company)
    {
	
       $string_result = "";
       $xsl = new DOMDocument("1.0");	
	   $xml = new DOMDocument("1.0");
	   
	   $xml->load( 'dom_example.xml');	   
  
	   $xsl->load( "xslt/".$dir_name."/GeneracionCommadoDefault.xsl");
	   $xh->importStyleSheet($xsl);
       $string_result = "";
       for($i=0;$i<count($tables);$i++){
	   
           //contruye el nombre del archivo
           $file_name = $name_company . $name_application . "CmdDefault". ucfirst($tables[$i]) . ".class.php";
		   
		   $xh->setParameter('','tabla',$tables[$i]);
		   $xh->setParameter('','empresa',$name_company);
		   $xh->setParameter('','aplicacion',$name_application);
		   
		   $out=$xh->transformToXML($xml);
           $result =$this->SaveFile("../".$name_application."/web/commands/".$file_name,$out);		   
	   	   
	       if(!$result)
	          print "<font color='#FF0000'><strong>Error: ".$xh->error()."</strong></font>";
	       else
		      $string_result .= $file_name."\n" ;
       }
       return $string_result;	
	
	
    }

    /*
    * Metodo que genera el comando adicionar
    */
    function GenerateAddCommand($xh,$tables,$arguments,$name_application,$dir_name,$name_company)
    {
	
	
       $string_result = "";
       $xsl = new DOMDocument("1.0");	
	   $xml = new DOMDocument("1.0");
	   
	   $xml->load( 'dom_example.xml');	   
  
	   $xsl->load( "xslt/".$dir_name."/GeneracionCommadoAdicionar.xsl");
	   $xh->importStyleSheet($xsl);
       $string_result = "";
       for($i=0;$i<count($tables);$i++){
	   
           //contruye el nombre del archivo
           $file_name = $name_company . $name_application . "CmdAdd". ucfirst($tables[$i]) . ".class.php";
		   
		   $xh->setParameter('','tabla',$tables[$i]);
		   $xh->setParameter('','empresa',$name_company);
		   $xh->setParameter('','aplicacion',$name_application);
		   
		   $out=$xh->transformToXML($xml);
           $result =$this->SaveFile("../".$name_application."/web/commands/".$file_name,$out);		   
	   	   
	       if(!$result)
	          print "<font color='#FF0000'><strong>Error: ".$xh->error()."</strong></font>";
	       else
		      $string_result .= $file_name."\n" ;
       }
       return $string_result;
    }

    /*
    * Metodo que genera el comando modificar
    */
    function GenerateUpdateCommand($xh,$tables,$arguments,$name_application,$dir_name,$name_company)
    {

       $string_result = "";
       $xsl = new DOMDocument("1.0");	
	   $xml = new DOMDocument("1.0");
	   
	   $xml->load( 'dom_example.xml');	   
  
	   $xsl->load( "xslt/".$dir_name."/GeneracionCommadoModificar.xsl");
	   $xh->importStyleSheet($xsl);
       $string_result = "";
       for($i=0;$i<count($tables);$i++){
	   
           //contruye el nombre del archivo
           $file_name = $name_company . $name_application . "CmdUpdate". ucfirst($tables[$i]) . ".class.php";
		   
		   $xh->setParameter('','tabla',$tables[$i]);
		   $xh->setParameter('','empresa',$name_company);
		   $xh->setParameter('','aplicacion',$name_application);
		   
		   $out=$xh->transformToXML($xml);
           $result =$this->SaveFile("../".$name_application."/web/commands/".$file_name,$out);		   
	   	   
	       if(!$result)
	          print "<font color='#FF0000'><strong>Error: ".$xh->error()."</strong></font>";
	       else
		      $string_result .= $file_name."\n" ;
       }
       return $string_result;
	
    }
    
    /*
    * Metodo que genera el comando eliminar
    */
    function GenerateDeleteCommand($xh,$tables,$arguments,$name_application,$dir_name,$name_company)
    {
	
       $string_result = "";
       $xsl = new DOMDocument("1.0");	
	   $xml = new DOMDocument("1.0");
	   
	   $xml->load( 'dom_example.xml');	   
  
	   $xsl->load( "xslt/".$dir_name."/GeneracionCommadoBorrar.xsl");
	   $xh->importStyleSheet($xsl);
       $string_result = "";
       for($i=0;$i<count($tables);$i++){
	   
           //contruye el nombre del archivo
           $file_name = $name_company . $name_application . "CmdDelete". ucfirst($tables[$i]) . ".class.php";
		   
		   $xh->setParameter('','tabla',$tables[$i]);
		   $xh->setParameter('','empresa',$name_company);
		   $xh->setParameter('','aplicacion',$name_application);
		   
		   $out=$xh->transformToXML($xml);
           $result =$this->SaveFile("../".$name_application."/web/commands/".$file_name,$out);		   
	   	   
	       if(!$result)
	          print "<font color='#FF0000'><strong>Error: ".$xh->error()."</strong></font>";
	       else
		      $string_result .= $file_name."\n" ;
       }
       return $string_result;
	   

    }

    /*
    * Metodo que genera el comando limpiar de cada forma.
    */
    function GenerateClearCommand($xh,$tables,$arguments,$name_application,$dir_name,$name_company)
    {
	
       $string_result = "";
       $xsl = new DOMDocument("1.0");	
	   $xml = new DOMDocument("1.0");
	   
	   $xml->load( 'dom_example.xml');	   
  
	   $xsl->load( "xslt/".$dir_name."/GeneracionCommadoClear.xsl");
	   $xh->importStyleSheet($xsl);
       $string_result = "";
       for($i=0;$i<count($tables);$i++){
	   
           //contruye el nombre del archivo
           $file_name = $name_company . $name_application . "CmdClear". ucfirst($tables[$i]) . ".class.php";
		   
		   $xh->setParameter('','tabla',$tables[$i]);
		   $xh->setParameter('','empresa',$name_company);
		   $xh->setParameter('','aplicacion',$name_application);
		   
		   $out=$xh->transformToXML($xml);
           $result =$this->SaveFile("../".$name_application."/web/commands/".$file_name,$out);		   
	   	   
	       if(!$result)
	          print "<font color='#FF0000'><strong>Error: ".$xh->error()."</strong></font>";
	       else
		      $string_result .= $file_name."\n" ;
       }
       return $string_result;
	   

    }

    /*
    * Metodo que genera el comando consultar todo
    */
    function GenerateShowListCommand($xh,$tables,$arguments,$name_application,$dir_name,$name_company)
    {
	
       $string_result = "";
       $xsl = new DOMDocument("1.0");	
	   $xml = new DOMDocument("1.0");
	   
	   $xml->load( 'dom_example.xml');	   
  
	   $xsl->load( "xslt/".$dir_name."/GeneracionCommadoConsultarList.xsl");
	   $xh->importStyleSheet($xsl);
       $string_result = "";
       for($i=0;$i<count($tables);$i++){
	   
           //contruye el nombre del archivo
           $file_name = $name_company . $name_application . "CmdShowList". ucfirst($tables[$i]) . ".class.php";
		   
		   $xh->setParameter('','tabla',$tables[$i]);
		   $xh->setParameter('','empresa',$name_company);
		   $xh->setParameter('','aplicacion',$name_application);
		   
		   $out=$xh->transformToXML($xml);
           $result =$this->SaveFile("../".$name_application."/web/commands/".$file_name,$out);		   
	   	   
	       if(!$result)
	          print "<font color='#FF0000'><strong>Error: ".$xh->error()."</strong></font>";
	       else
		      $string_result .= $file_name."\n" ;
       }
       return $string_result;
	

    }
    
    /*
    * Metodo que genera el comando consultar por id
    */
    function GenerateShowByIdCommand($xh,$tables,$arguments,$name_application,$dir_name,$name_company)
    {
	
       $string_result = "";
       $xsl = new DOMDocument("1.0");	
	   $xml = new DOMDocument("1.0");
	   
	   $xml->load( 'dom_example.xml');	   
  
	   $xsl->load( "xslt/".$dir_name."/GeneracionCommadoConsultarById.xsl");
	   $xh->importStyleSheet($xsl);
       $string_result = "";
       for($i=0;$i<count($tables);$i++){
	   
           //contruye el nombre del archivo
           $file_name = $name_company . $name_application . "CmdShowById". ucfirst($tables[$i]) . ".class.php";
		   
		   $xh->setParameter('','tabla',$tables[$i]);
		   $xh->setParameter('','empresa',$name_company);
		   $xh->setParameter('','aplicacion',$name_application);
		   
		   $out=$xh->transformToXML($xml);
           $result =$this->SaveFile("../".$name_application."/web/commands/".$file_name,$out);		   
	   	   
	       if(!$result)
	          print "<font color='#FF0000'><strong>Error: ".$xh->error()."</strong></font>";
	       else
		      $string_result .= $file_name."\n" ;
       }
       return $string_result;
	   

    }
    
    /*
    * Metodo que genera el comando cancelar consulta
    */
    function GenerateCancelShowListCommand($xh,$tables,$arguments,$name_application,$dir_name,$name_company)
    {
	
       $string_result = "";
       $xsl = new DOMDocument("1.0");	
	   $xml = new DOMDocument("1.0");
	   
	   $xml->load( 'dom_example.xml');	   
  
	   $xsl->load( "xslt/".$dir_name."/GeneracionCommadoCancelList.xsl");
	   $xh->importStyleSheet($xsl);
       $string_result = "";
       for($i=0;$i<count($tables);$i++){
	   
           //contruye el nombre del archivo
           $file_name = $name_company . $name_application . "CmdCancelShowList". ucfirst($tables[$i]) . ".class.php";
		   
		   $xh->setParameter('','tabla',$tables[$i]);
		   $xh->setParameter('','empresa',$name_company);
		   $xh->setParameter('','aplicacion',$name_application);
		   
		   $out=$xh->transformToXML($xml);
           $result =$this->SaveFile("../".$name_application."/web/commands/".$file_name,$out);		   
	   	   
	       if(!$result)
	          print "<font color='#FF0000'><strong>Error: ".$xh->error()."</strong></font>";
	       else
		      $string_result .= $file_name."\n" ;
       }
       return $string_result;
	

    }

    /*
    * Metodo que genera el template
    */
    function GenerateTemplate($xh,$tables,$arguments,$name_application,$dir_name,$name_company,$name_style)
    {
	
       $string_result = "";
       $xsl = new DOMDocument("1.0");	
	   $xml = new DOMDocument("1.0");
	   
	   $xml->load( 'dom_example.xml');	   
  
	   $xsl->load( "xslt/".$dir_name."/GeneracionVista.xsl");
	   $xh->importStyleSheet($xsl);
       $string_result = "";
       for($i=0;$i<count($tables);$i++){
	   
           //contruye el nombre del archivo
           $file_name = $name_company . $name_application . "Form_" . ucfirst($tables[$i]) . ".tpl";
		   
		   $xh->setParameter('','tabla',$tables[$i]);
		   $xh->setParameter('','empresa',$name_company);
		   $xh->setParameter('','aplicacion',$name_application);
		   $xh->setParameter('','style',$name_style);
		   
		   $out=$xh->transformToXML($xml);
           $result =$this->SaveFile("../".$name_application."/web/templates/".$file_name,$out);		   
	   	   
	       if(!$result)
	          print "<font color='#FF0000'><strong>Error: ".$xh->error()."</strong></font>";
	       else
		      $string_result .= $file_name."\n" ;
       }
       return $string_result;
	   
	
	
    }
    
    /*
    * Metodo que genera el template para consultar
    */
    function GenerateTemplateConsult($xh,$tables,$arguments,$name_application,$dir_name,$name_company,$name_style)
    {
	
       $string_result = "";
       $xsl = new DOMDocument("1.0");	
	   $xml = new DOMDocument("1.0");
	   
	   $xml->load( 'dom_example.xml');	   
  
	   $xsl->load( "xslt/".$dir_name."/GeneracionVistaConsult.xsl");
	   
	   $xh->importStyleSheet($xsl);
       $string_result = "";
       for($i=0;$i<count($tables);$i++){
	   
           //contruye el nombre del archivo
           $file_name =  $name_company . $name_application . "Form_". ucfirst($tables[$i]) . "_Consult.tpl";
		   
		   $xh->setParameter('','tabla',$tables[$i]);
		   $xh->setParameter('','empresa',$name_company);
		   $xh->setParameter('','aplicacion',$name_application);
		   $xh->setParameter('','style',$name_style);
		   $out="";
		   $out=$xh->transformToXML($xml);
           $result =$this->SaveFile("../".$name_application."/web/templates/".$file_name,$out);		   
	   	   
	       if(!$result)
	          print "<font color='#FF0000'><strong>Error: ".$xh->error()."</strong></font>";
	       else
		      $string_result .= $file_name."\n" ;
       }
       return $string_result;

    }

    /*
    * Metodo que genera el template del menu principal
    */
    function GenerateMainMenu($xh,$arguments,$name_application,$dir_name,$name_company,$name_style)
    {
	   $string_result = "";
       $xsl = new DOMDocument("1.0");	
	   $xml = new DOMDocument("1.0");
	   
	   $xml->load( 'dom_example.xml');	   
       //print_r("<br>Menu->"."xslt/".$dir_name."/GeneracionMenuPrincipal.xsl");
	   $xsl->load( "xslt/".$dir_name."/GeneracionMenuPrincipal.xsl");
	   $xh->importStyleSheet($xsl);
	   
           //contruye el nombre del archivo
           $file_name =  $name_company . $name_application . "Form_Menu.tpl";
		   
		   $xh->setParameter('','empresa',$name_company);
		   $xh->setParameter('','aplicacion',$name_application);
		   $xh->setParameter('','style',$name_style);
		   
		   $out=$xh->transformToXML($xml);
           $result =$this->SaveFile("../".$name_application."/web/templates/".$file_name,$out);		   
	   	   
	       if(!$result)
	          print "<font color='#FF0000'><strong>Error: ".$xh->error()."</strong></font>";
	       else
		      $string_result .= $file_name."\n" ;
       
       return $string_result;	
	
    }

    /*
    * Metodo que genera el archivo de configuracion SaveNavigationFile
    */
    function GenerateSaveNavigationFile($xh,$arguments,$name_application,$dir_name,$name_company)
    {
	
	   $string_result = "";
       $xsl = new DOMDocument("1.0");	
	   $xml = new DOMDocument("1.0");
	   
	   $xml->load( 'dom_example.xml');	   
  
	   $xsl->load( "xslt/".$dir_name."/GeneracionSaveNavigationFile.xsl");
	   
	   $xh->importStyleSheet($xsl);
	   
           //contruye el nombre del archivo
           $file_name = "SaveNavigationFile.php";
		   
		   $xh->setParameter('','empresa',$name_company);
		   $xh->setParameter('','aplicacion',$name_application);
		   
		   $out=$xh->transformToXML($xml);
           $result =$this->SaveFile("../".$name_application."/config/".$file_name,$out);		   
	   	   
	       if(!$result)
	          print "<font color='#FF0000'><strong>Error: ".$xh->error()."</strong></font>";
	       else
		      $string_result .= $file_name."\n" ;
       
       return $string_result;

    }
    
    /*
    * Metodo que genera el archivo de configuracion SaveConfigurationFile
    */
    function GenerateSaveConfigurationFile($xh,$arguments,$name_application,$type_db,$server,$user,$password,$catalogo,$dir_name,$name_company,$charset)
    {

	
	   $string_result = "";
       $xsl = new DOMDocument("1.0");	
	   $xml = new DOMDocument("1.0");
	   
	   $xml->load( 'dom_example.xml');	   
  
	   $xsl->load( "xslt/".$dir_name."/GeneracionSaveConfigurationFile.xsl");
	   $xh->importStyleSheet($xsl);
 
       //contruye el nombre del archivo
        $file_name = "SaveConfigurationFile.php";
       //asigna el nombre del tipo de la base de datos segun se maneje en la configuracion
       switch ($type_db) {
        case "mysql":
                     $type_data_base = "mysql";
                     break;
        case "pgsql":
                     $type_data_base = "postgres";
                     break;
        case "oci8":
                     $type_data_base = "oci8";
                     break;
       }
 	  
		   
		   $xh->setParameter('','type_db',$type_data_base);
		   $xh->setParameter('','catalogo',$catalogo);
		   $xh->setParameter('','host',$server);
		   $xh->setParameter('','user',$user);
		   $xh->setParameter('','pass',$password);
		   $xh->setParameter('','auth',"disabled");
		   $xh->setParameter('','charset',$charset);
		   $xh->setParameter('','empresa',$name_company);
		   $xh->setParameter('','aplicacion',$name_application);		   
		   
		   $out=$xh->transformToXML($xml);
           $result =$this->SaveFile("../".$name_application."/config/".$file_name,$out);		   
	   	   
	       if(!$result)
	          print "<font color='#FF0000'><strong>Error: ".$xh->error()."</strong></font>";
	       else
		      $string_result .= $file_name."\n" ;
       
       return $string_result;

    }
	
	function RecursiveCopy($source, $dest, $diffDir = ''){
    $sourceHandle = opendir($source);
  
    while($res = readdir($sourceHandle)){
        if($res == '.' || $res == '..')
            continue;
       
        if(is_dir($source . '/' . $res)){
            RecursiveCopy($source . '/' . $res, $dest, $diffDir . '/' . $res);
        } else {
            copy($source . '/' . $res, $dest . '/' . $diffDir . '/' . $res);
           
        }
    }
}

function generatelanguagefile($name_application,$structure_db)
{

     

	 //$fpTooltips = fopen("../".$name_application."/language/es/"."Tooltips.lan", "w");
	 //$fptemplates = fopen("../".$name_application."/language/es/"."Templates.lan", "w");
	 
	 //tables Genera Toolsbar
	 $Templates="";
	 $Toolsbar ="Toolsbar";
	 $Toolsbar="<?php $$Toolsbar = array ( 
	     'save' => 'Guardar',
         'new' => 'Nuevo',
         'back' => 'Atras',
         'del' => 'Borrar',
         'help' => 'Ayuda',
         'edit' => 'Editar',
         'close' => 'Cerrar',
         'refresh'=>'Refrescar',
         'condiction'=>'Condicion',
         'KeyWord'=>'Palabra Clave',
         'Filterby'=>'Filtrar Por',
         'ExactPhrase' =>'Frase Exacta',
         'Diff'       =>'Diferente',
         'BeginWith' =>'Comienza Por',
         'EndWith'  =>'Finaliza En',
         'Content'  =>'Contiene',
         'find'  =>'Buscar',
	 ";
	 
	 // Fin genera Toolsbar
	 
     /* */
     //Gneracion de Archivos de Lenguaje 
	 $num_tables = count($structure_db['tables']['list']);
	 $Tableheaders="Tableheaders";
	 $ToolTips = "Tooltips";
	 $Tableheader="<?php $$Tableheaders = array (\n";
	 $ToolTips ="<?php $$ToolTips = array (\n";
	 
     for($j = 0; $j < $num_tables; $j++){
         $name_table=$structure_db['tables']['list'][$j];
         $num_field = count($structure_db['tables'][$name_table]['columns']['list']);
		 $Templates.="[".strtolower($name_table)."]\n";
		 $Templates.="TITLE =Administracion(CRUD) of ".ucfirst(strtolower(strtoupper($name_table)))."\n";
		 $Templates.="TITLECONSULT =Consulta Maestra de ".ucfirst(strtolower(strtoupper($name_table)))."\n";
		 $Toolsbar .= "'".ucfirst(strtolower(strtoupper($name_table)))."' => 'Opcion ".ucfirst(strtolower(strtoupper($name_table)))."',\n";
         for($i = 0; $i < $num_field; $i++) {
             $name_column=$structure_db['tables'][$name_table]['columns']['list'][$i];
             $column=$structure_db['tables'][$name_table]['columns'][$name_column];
			   $Tableheader.="'".strtoupper($column['name'])."' => '".ucfirst(strtolower($column['name']))."',\n";
               $Templates.= strtoupper(strtolower($column['name']))." = ". ucfirst(strtolower($column['name']))."\n";
			   $ToolTips .= "'".strtoupper(strtolower($column['name']))."' => 'Ingrese un Valor para ".ucfirst(strtolower($column['name']))."',\n";
         } //End for
	 } 
	 $Tableheader.="); 
	            ?>";
	 $Toolsbar.="); 
	            ?>";
	 $ToolTips.="); 
	            ?>";				
				
	 $result =$this->SaveFile("../".$name_application."/language/es/"."Tableheader.lan",$Tableheader);	
     $result =$this->SaveFile("../".$name_application."/language/es/"."Templates.lan",$Templates);	 
	 $result =$this->SaveFile("../".$name_application."/language/es/"."Toolsbar.lan",$Toolsbar);
	 $result =$this->SaveFile("../".$name_application."/language/es/"."Tooltips.lan",$ToolTips);
     

}

function SaveFile($filename,$filecontent)
{

            $fp = fopen($filename, "w");
            if (!$fp) {
                return PEAR::raiseError("cannot open file $filename");
            }

            $write =  fwrite ( $fp, $filecontent );
            if (!$write) {
                return PEAR::raiseError("error writing  data to $filename");
            }
            $close = fclose ( $fp);
            if(!$close) {
                return PEAR::raiseError("error closing the  file $filename");
            }
            
            return true;			
}			

// removes files and non-empty directories
function rrmdir($dir) {
  if (is_dir($dir)) {
    $files = scandir($dir);
    foreach ($files as $file)
    if ($file != "." && $file != "..") rrmdir("$dir/$file");
    rmdir($dir);
  }
  else if (file_exists($dir)) unlink($dir);
}

// copies files and non-empty directories
function rcopy($src, $dst) {
  if (file_exists($dst)) $this->rrmdir($dst);
  if (is_dir($src)) {
    mkdir($dst);
    $files = scandir($src);
    foreach ($files as $file)
    if ($file != "." && $file != "..") $this->rcopy("$src/$file", "$dst/$file");
  }
  else if (file_exists($src)) copy($src, $dst);
} 

}// end Class GeneradorManager

?>	
 	
