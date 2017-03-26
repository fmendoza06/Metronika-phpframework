<?php

require_once("MDB_MetaData.php");

class GeneradorManager
{

    function generarAplicacion($dir_name,$type_db,$server,$user,$password,$catalogo,$name_application,$name_company,$charset,$name_style,$components,$tables,$gen_type)
    {

    if($type_db == "oci8"){
       $host_data = explode(":",$server);
       $server = "(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(HOST=".$host_data[0].")(PORT=".$host_data[1].")))(CONNECT_DATA=(SERVICE_NAME=".$host_data[2].")))";
    }

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
    echo "<pre>"; print_r($tables); echo "</pre><BR>";
    echo "=======================  Metadata  ==============================<BR>";
    echo "<pre>"; print_r($array_metadata); echo "</pre>";
    echo "==========================  XML  ==============================<BR>";
    echo "<textarea cols=500>".$document_xml."</textarea>";
*/	
	// Report all errors except E_NOTICE 
	// This is the default value set in php.ini 
//	error_reporting (E_ALL ^ E_NOTICE); 
	
    $process_result = "";

    $array_metadata = $this->getMetadata($type_db,$server,$catalogo,$user,$password,$tables);

    $document_xml = $this->getXML($type_db,$array_metadata);

    $process_result .= $this->CreateStructDirectory($name_application,$components,$type_db);

    $process_result .= $this->CopyFiles($name_application,$components);

    $process_result .= $this->GenerateFiles($document_xml,$name_application,$type_db,$tables,$server,$user,$password,$catalogo,$dir_name,$name_company,$charset,$name_style,$components,$gen_type);
    //echo "<pre>"; print_r($array_metadata); echo "</pre>";
    //echo "<textarea cols=500>".$document_xml."</textarea>";
    return $process_result;

    }

    /*
    * Metodo que obtiene la Metadata de la base de datos, retorna
    * un Array Asociativo.
    */
    function getMetadata($db_type,$host,$db_name,$user,$pass,$tables)
    {

      $dsn = "$db_type://$user:$pass@$host/$db_name";
	
      $obj = new MDB_MetaData();

      $dbMetaData = $obj->connect($dsn);

      $name_db = $dbMetaData->getDataBaseName();

      if(isset($table) && isset($column)) {
          $results = $dbMetaData->getColumnList($table);
          $results = $dbMetaData->getColumnData($table, $column);
          $results = $dbMetaData->getPrimaryKeyTable($table);
          $results = $dbMetaData->getForeignKeyTable($table);
          $results = $dbMetaData->getIndex($table);
      }else {
          if (isset($table)) {
              $results = $dbMetaData->getColumnList($table);
              $results = $dbMetaData->getColumnData($table, '');
              $results = $dbMetaData->getPrimaryKeyTable($table);
              $results = $dbMetaData->getForeignKeyTable($table);
              $results = $dbMetaData->getIndex($table);
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

      $results = $dbMetaData->getSequence( );
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
     $dom = domxml_new_doc('1.0');
      
       
     // Create elements
     $raizElement = $dom->create_element('database');
     $namedbElement = $dom->create_element('name');
     $namedbTextElement = $dom->create_text_node($structure_db['name_db']);

     //optionals
     $namedbElement->add_child($namedbTextElement);
     $raizElement->add_child($namedbElement);

     $num_tables = count($structure_db['tables']['list']);

     //tables
     for($j = 0; $j < $num_tables; $j++){
         $tableElement= $dom->create_element('table');
         $nametableElement = $dom->create_element('name');
         $name_table=$structure_db['tables']['list'][$j];

         $nametableTextElement = $dom->create_text_node($name_table);
         $nametableElement->add_child($nametableTextElement);
         $tableElement->add_child($nametableElement);
         $raizElement->add_child($tableElement);
         $declaretableElement= $dom->create_element('declaration');

         $num_field = count($structure_db['tables'][$name_table]['columns']['list']);

         for($i = 0; $i < $num_field; $i++) {
             $name_column=$structure_db['tables'][$name_table]['columns']['list'][$i];
             $column=$structure_db['tables'][$name_table]['columns'][$name_column];

             $fieldtableElement = $dom->create_element('field');
             $namefieldElement = $dom->create_element('name');
             $namefieldTextElement = $dom->create_text_node($column['name']);
             $typefieldElement = $dom->create_element('type');
             $typefieldTextElement = $dom->create_text_node(strtolower($column['type']));
             $notnullfieldElement = $dom->create_element('null');
             $notnullfieldTextElement = $dom->create_text_node(strtolower($column['null']));

             $namefieldElement->add_child($namefieldTextElement);
             $typefieldElement->add_child($typefieldTextElement);
             $notnullfieldElement->add_child($notnullfieldTextElement);
             $fieldtableElement->add_child($namefieldElement);
             $fieldtableElement->add_child($typefieldElement);

             if($column['precision']!='null'){
                $precisionfieldElement = $dom->create_element('precision');
                $precisionfieldTextElement = $dom->create_text_node($column['precision']);
                $precisionfieldElement->add_child($precisionfieldTextElement);
                $fieldtableElement->add_child($precisionfieldElement);
             }
             if($column['scale']!='null'){
                $scalefieldElement = $dom->create_element('scale');
                $scalefieldTextElement = $dom->create_text_node($column['scale']);
                $scalefieldElement->add_child($scalefieldTextElement);
                $fieldtableElement->add_child($scalefieldElement);
             }
             $fieldtableElement->add_child($notnullfieldElement);
             if($column['default']!='null'){
                $defaultfieldElement = $dom->create_element('default');
                $defaultfieldTextElement = $dom->create_text_node($column['default']);
                $defaultfieldElement->add_child($defaultfieldTextElement);
                $fieldtableElement->add_child($defaultfieldElement);
             }
             if($column['counter']!='null'){
                $counterfieldElement = $dom->create_element('counter');
                $counterfieldTextElement = $dom->create_text_node($column['counter']);
                $counterfieldElement->add_child($counterfieldTextElement);
                $fieldtableElement->add_child($counterfieldElement);
             }
             $declaretableElement->add_child($fieldtableElement);
         } //End for

         //primary-key
        $num_prim = count($structure_db['tables'][$name_table]['primary_key']);

        $primary=$structure_db['tables'][$name_table]['primary_key'];
        $primaryElement= $dom->create_element('primary_key');

        for($m = 0; $m < $num_prim; $m++) {
            $fieldprimaryElement = $dom->create_element('field');
            $namepriElement = $dom->create_element('name');
            $namepriTextElement = $dom->create_text_node($primary[$m]);

            $namepriElement->add_child($namepriTextElement);
            $fieldprimaryElement->add_child($namepriElement);
            $primaryElement->add_child($fieldprimaryElement);
        }//end for primary-key

        $declaretableElement->add_child($primaryElement);

        //foreign-key
        for($varhemer=0;$varhemer < count($structure_db['tables'][$name_table]['foreign_key']);$varhemer++){
            $foreign=$structure_db['tables'][$name_table]['foreign_key'][$varhemer];
            if ($foreign != ''){
                $foreignElement= $dom->create_element('foreign_key');
                $nameforElement = $dom->create_element('name');
                $nameforTextElement = $dom->create_text_node($foreign['name']);
                $nameforElement->add_child($nameforTextElement);
                $foreignElement->add_child($nameforElement);

                //local-table
                $localtableElement = $dom->create_element('local_table');

                $num_field_for = count($structure_db['tables'][$name_table]['foreign_key'][$varhemer]['local_table_columns']);

                for($n = 0; $n < $num_field_for; $n++) {
                    $fieldfor=$structure_db['tables'][$name_table]['foreign_key'][$varhemer]['local_table_columns'];

                    $fieldforElement =$dom->create_element('field');
                    $namefieldforElement=$dom->create_element('name');
                    $namefieldforTextElement = $dom->create_text_node($fieldfor[$n]);

                    $namefieldforElement->add_child($namefieldforTextElement);
                    $fieldforElement->add_child($namefieldforElement);
                    $localtableElement->add_child($fieldforElement);
                    $foreignElement->add_child($localtableElement);
                }// End for local-table

                //reference-table
                $refertableElement = $dom->create_element('reference_table');

                $num_field_ref = count($structure_db['tables'][$name_table]['foreign_key'][$varhemer]['reference_table_columns']);

                $namerefElement = $dom->create_element('name');
                $namerefTextElement = $dom->create_text_node($foreign['reference_table']);
                $namerefElement->add_child($namerefTextElement);
                $refertableElement->add_child($namerefElement);

                for($p = 0; $p < $num_field_ref; $p++) {
                    $fieldref=$structure_db['tables'][$name_table]['foreign_key'][$varhemer]['reference_table_columns'];
                    $fieldrefElement =$dom->create_element('field');
                    $namefieldrefElement=$dom->create_element('name');
                    $namefieldrefTextElement = $dom->create_text_node($fieldref[$p]);

                    $namefieldrefElement->add_child($namefieldrefTextElement);
                    $fieldrefElement->add_child($namefieldrefElement);
                    $refertableElement->add_child($fieldrefElement);
                    $foreignElement->add_child($refertableElement);
                }//End for reference-table
                $declaretableElement->add_child($foreignElement);
            }//end if foreign-key
        }// end for foreign-key

        $tableElement->add_child($declaretableElement);

        //index
        $numindex = count($structure_db['tables'][$name_table]['index']);
        $getindex=$structure_db['tables'][$name_table]['index'];

        if ($getindex != ''){
            for($t = 0; $t < $numindex; $t++) {
                $index=$getindex[$t];

                $indextableElement= $dom->create_element('index');
                $nameindexElement = $dom->create_element('name');
                $nameindexTextElement = $dom->create_text_node($index['name']);
                $typeindexElement = $dom->create_element('type');
                $typeindexTextElement = $dom->create_text_node($index['type']);
                $accessindexElement = $dom->create_element('access_method');
                $accessindexTextElement = $dom->create_text_node($index['access_method']);
                $collationindexElement = $dom->create_element('collation');
                $collationindexTextElement = $dom->create_text_node($index['collation']);

                $nameindexElement->add_child($nameindexTextElement);
                $typeindexElement->add_child($typeindexTextElement);
                $accessindexElement->add_child($accessindexTextElement);
                $collationindexElement->add_child($collationindexTextElement);

                $indextableElement->add_child($nameindexElement);
                $indextableElement->add_child($typeindexElement);
                $indextableElement->add_child($accessindexElement);
                $indextableElement->add_child($collationindexElement);

                //field index
                $numfieldindex = count($structure_db['tables'][$name_table]['index'][$t]['columns_name']);

                for($q=0; $q<$numfieldindex; $q++) {
                    $fieldindex=$structure_db['tables'][$name_table]['index'][$t]['columns_name'];
                    $fieldindexElement = $dom->create_element('field');
                    $namefieldindexElement=$dom->create_element('name');
                    $namefieldindexTextElement = $dom->create_text_node($fieldindex[$q]);

                    $namefieldindexElement->add_child($namefieldindexTextElement);
                    $fieldindexElement->add_child($namefieldindexElement);
                    $indextableElement->add_child($fieldindexElement);
                }// End for field index

                $declaretableElement->add_child($indextableElement);
            }//End for index
        }//End if index
     }//End for tables

     //Sequences
     if ($db_type != "mysql"){
         $num_sequence = count($structure_db['sequences']['list']);
         for($k = 0; $k < $num_sequence; $k++){
             $name_sequence=$structure_db['sequences']['list'][$k];
             $attsequence=$structure_db['sequences'][$name_sequence];

             $sequenceElement= $dom->create_element('sequence');
             $nameseqElement = $dom->create_element('name');
             $nameseqTextElement = $dom->create_text_node($name_sequence);
             $startseqElement = $dom->create_element('start');
             $startseqTextElement = $dom->create_text_node($attsequence['Start']);
             $incrementvalueseqElement = $dom->create_element('increment');
             $incrementvalueseqTextElement = $dom->create_text_node($attsequence['Increment']);
             $minvalueseqElement = $dom->create_element('min_value');
             $minvalueseqTextElement = $dom->create_text_node($attsequence['Min_value']);
             $maxvalueseqElement = $dom->create_element('max_value');
             $maxvalueseqTextElement = $dom->create_text_node($attsequence['Max_value']);
             $cycleseqElement = $dom->create_element('cycle');
             $cycleseqTextElement = $dom->create_text_node($attsequence['Cycle']);
             $cacheseqElement = $dom->create_element('cache');
             $cacheseqTextElement = $dom->create_text_node($attsequence['Cache']);

             $nameseqElement->add_child($nameseqTextElement);
             $startseqElement->add_child($startseqTextElement);
             $incrementvalueseqElement->add_child($incrementvalueseqTextElement);
             $minvalueseqElement->add_child($minvalueseqTextElement);
             $maxvalueseqElement->add_child($maxvalueseqTextElement);
             $cycleseqElement->add_child($cycleseqTextElement);
             $cacheseqElement->add_child($cacheseqTextElement);

             $sequenceElement->add_child($nameseqElement);
             $sequenceElement->add_child($startseqElement);
             $sequenceElement->add_child($incrementvalueseqElement);
             $sequenceElement->add_child($minvalueseqElement);
             $sequenceElement->add_child($maxvalueseqElement);
             $sequenceElement->add_child($cycleseqElement);
             $sequenceElement->add_child($cacheseqElement);
             $raizElement->add_child($sequenceElement);
         }//end for sequence
     }//end if sequence

    // Add the root element to the document
    $dom->append_child($raizElement);

    return $dom->dump_mem(1);
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
		 	   if(!ereg("^\.", $file)){
			  	  copy("files/js/$file","../".$name_application."/web/js/$file");
				  $string_result .= "../".$name_application."/web/js/$file\n";
			   }
		 }
	
	     // imagenes
	    $handle=opendir("files/images/");
		 while (false !== ($file = readdir($handle))){
		 	   if(!ereg("^\.", $file) && ($file!=='default')){
			  	  copy("files/images/$file","../".$name_application."/web/images/$file");
				  $string_result .= "../".$name_application."/web/images/$file\n";
			   }
		 }
	     // imagenes
	    $handle=opendir("files/images/default/tools_bar_page/");
		 while (false !== ($file = readdir($handle))){
		 	   if(!ereg("^\.", $file)){
			  	  copy("files/images/default/tools_bar_page/$file","../".$name_application."/web/images/default/tools_bar_page/$file");
				  $string_result .= "../".$name_application."/web/images/default/tools_bar_page/$file\n";
			   }
		 }
	
	     // plugins
	     //Modificacion para que copie cualquier plugin dentro de la carpeta
	     $handle=opendir("files/plugins/");
	 	 while (false !== ($file = readdir($handle))){
			 if(!ereg("^\.", $file)){
				copy("files/plugins/$file","../".$name_application."/web/plugins/$file");
				$string_result .= "../".$name_application."/web/plugins/$file\n";
			 }
		 }
	
	     // hojas de estilo
	    $handle=opendir("files/css/");
		 while (false !== ($file = readdir($handle))){
		 	   if(!ereg("^\.", $file)){
			  	  copy("files/css/$file","../".$name_application."/web/css/$file");
				  $string_result .= "../".$name_application."/web/css/$file\n";
			   }
		 }
	     // Remote Scripting
	    $handle=opendir("files/rs/");
		 while (false !== ($file = readdir($handle))){
		 	   if(!ereg("^\.", $file)){
			  	  copy("files/rs/$file","../".$name_application."/web/rs/$file");
				  $string_result .= "../".$name_application."/web/rs/$file\n";
			   }
		 }
	 }
	 	
     return $string_result;
    }


    function GenerateFiles($document_xml,$name_application,$db_type,$tables,$server,$user,$password,$catalogo,$dir_name,$name_company,$charset,$name_style,$components,$gen_type)
    {
     $string_result = "";

     $xh = xslt_create();
     $path = Application::getBaseDirectory()."/";
     xslt_set_base($xh, "file://".$path);
     $arguments = array('/_xml' => $document_xml);

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
             $string_result .= $this->GenerateDataGatewayADODB($xh,$tables,$arguments,$name_application,$dir_name,$name_company);
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
       //recorre las tablas seleccionadas
       for($i=0;$i<count($tables);$i++){
           //contruye el nombre del archivo
           $file_name = $name_company . $name_application . "Mysql" . ucfirst($tables[$i]) . ".class.php";
           //asgina los parametros requeridos por el xslt
	       $params = array("tabla" => $tables[$i], "empresa" => $name_company, "aplicacion" => $name_application );
	       $result = xslt_process($xh,'arg:/_xml',"xslt/".$dir_name."/GeneracionCompuertaFilaMysql.xsl","../".$name_application."/data/Mysql/".$file_name,$arguments,$params);
	       if(!$result)
	          print "<font color='#FF0000'><strong>Error: ".xslt_error($xh)."</strong></font>";
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
       for($i=0;$i<count($tables);$i++){
           //contruye el nombre del archivo
	       $file_name = "Pgsql" . ucfirst($tables[$i]) . ".class.php";
           //asgina los parametros requeridos por el xslt
	       $params = array("tabla" => $tables[$i], "empresa" => $name_company, "aplicacion" => $name_application );
	       $result = xslt_process($xh,'arg:/_xml',"xslt/".$dir_name."/GeneracionCompuertaFilaPgSQL.xsl","../".$name_application."/data/Pgsql/".$file_name,$arguments,$params);
	       if(!$result)
	          print "<font color='#FF0000'><strong>Error: ".xslt_error($xh)."</strong></font>";
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
       for($i=0;$i<count($tables);$i++){
           //contruye el nombre del archivo
	       $file_name = $name_company . $name_application . "Oracle" . ucfirst($tables[$i]) . ".class.php";
           //asgina los parametros requeridos por el xslt
	       $params = array("tabla" => $tables[$i], "empresa" => $name_company, "aplicacion" => $name_application );
	       $result = xslt_process($xh,'arg:/_xml',"xslt/".$dir_name."/GeneracionCompuertaFilaOracle.xsl","../".$name_application."/data/Oracle/".$file_name,$arguments,$params);
	       if(!$result)
	          print "<font color='#FF0000'><strong>Error: ".xslt_error($xh)."</strong></font>";
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
       $string_result = "";
       for($i=0;$i<count($tables);$i++){
           //contruye el nombre del archivo
	       $file_name = $name_company . $name_application . "adodb" . ucfirst($tables[$i]) . ".class.php";
           //asgina los parametros requeridos por el xslt
	       $params = array("tabla" => $tables[$i], "empresa" => $name_company, "aplicacion" => $name_application );
	       $result = xslt_process($xh,'arg:/_xml',"xslt/".$dir_name."/GeneracionCompuertaFilaADODB.xsl","../".$name_application."/data/adodb/".$file_name,$arguments,$params);
	       if(!$result)
	          print "<font color='#FF0000'><strong>Error: ".xslt_error($xh)."</strong></font>";
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
       for($i=0;$i<count($tables);$i++){
           //contruye el nombre del archivo
	       $file_name = ucfirst($tables[$i]) . "Manager.class.php";
           //asgina los parametros requeridos por el xslt
	       $params = array("tabla" => $tables[$i], "empresa" => $name_company, "aplicacion" => $name_application );
	       $result = xslt_process($xh,'arg:/_xml',"xslt/".$dir_name."/GeneracionControl.xsl","../".$name_application."/domain/".$file_name,$arguments,$params);
	       if(!$result)
	          print "<font color='#FF0000'><strong>Error: ".xslt_error($xh)."</strong></font>";
	       else
		      $string_result .= $file_name."\n";
       }
       return $string_result;
    }

    /*
    * Metodo que genera el comando por default de cada forma.
    */
    function GenerateDefaultCommand($xh,$tables,$arguments,$name_application,$dir_name,$name_company)
    {
       $string_result = "";
       for($i=0;$i<count($tables);$i++){
           //contruye el nombre del archivo
	       $file_name = "CmdDefault". ucfirst($tables[$i]) . ".class.php";
           //asgina los parametros requeridos por el xslt
	       $params = array("tabla" => $tables[$i], "empresa" => $name_company, "aplicacion" => $name_application );
	       $result = xslt_process($xh,'arg:/_xml',"xslt/".$dir_name."/GeneracionCommadoDefault.xsl","../".$name_application."/web/commands/".$file_name,$arguments,$params);
	       if(!$result)
	          print "<font color='#FF0000'><strong>Error: ".xslt_error($xh)."</strong></font>";
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
       for($i=0;$i<count($tables);$i++){
           //contruye el nombre del archivo
	       $file_name = "CmdAdd" . ucfirst($tables[$i]) . ".class.php";
           //asgina los parametros requeridos por el xslt
	       $params = array("tabla" => $tables[$i], "empresa" => $name_company, "aplicacion" => $name_application );
	       $result = xslt_process($xh,'arg:/_xml',"xslt/".$dir_name."/GeneracionCommadoAdicionar.xsl","../".$name_application."/web/commands/".$file_name,$arguments,$params);
	       if(!$result)
	          print "<font color='#FF0000'><strong>Error: ".xslt_error($xh)."</strong></font>";
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
       for($i=0;$i<count($tables);$i++){
           //contruye el nombre del archivo
           $file_name ="CmdUpdate" . ucfirst($tables[$i]) . ".class.php";
           //asgina los parametros requeridos por el xslt
           $params = array("tabla" => $tables[$i], "empresa" => $name_company, "aplicacion" => $name_application );
           $result = xslt_process($xh,'arg:/_xml',"xslt/".$dir_name."/GeneracionCommadoModificar.xsl","../".$name_application."/web/commands/".$file_name,$arguments,$params);
           if(!$result)
              print "<font color='#FF0000'><strong>Error: ".xslt_error($xh)."</strong></font>";
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
       for($i=0;$i<count($tables);$i++){
           //contruye el nombre del archivo
           $file_name = "CmdDelete" . ucfirst($tables[$i]) . ".class.php";
           //asgina los parametros requeridos por el xslt
           $params = array("tabla" => $tables[$i], "empresa" => $name_company, "aplicacion" => $name_application );
           $result = xslt_process($xh,'arg:/_xml',"xslt/".$dir_name."/GeneracionCommadoBorrar.xsl","../".$name_application."/web/commands/".$file_name,$arguments,$params);
           if(!$result)
               print "<font color='#FF0000'><strong>Error: ".xslt_error($xh)."</strong></font>";
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
       for($i=0;$i<count($tables);$i++){
           //contruye el nombre del archivo
	       $file_name ="CmdClear". ucfirst($tables[$i]) . ".class.php";
           //asgina los parametros requeridos por el xslt
	       $params = array("tabla" => $tables[$i], "empresa" => $name_company, "aplicacion" => $name_application );
	       $result = xslt_process($xh,'arg:/_xml',"xslt/".$dir_name."/GeneracionCommadoClear.xsl","../".$name_application."/web/commands/".$file_name,$arguments,$params);
	       if(!$result)
	          print "<font color='#FF0000'><strong>Error: ".xslt_error($xh)."</strong></font>";
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
       for($i=0;$i<count($tables);$i++){
           //contruye el nombre del archivo
           $file_name = "CmdShowList" . ucfirst($tables[$i]) . ".class.php";
           //asgina los parametros requeridos por el xslt
           $params = array("tabla" => $tables[$i], "empresa" => $name_company, "aplicacion" => $name_application );
           $result = xslt_process($xh,'arg:/_xml',"xslt/".$dir_name."/GeneracionCommadoConsultarList.xsl","../".$name_application."/web/commands/".$file_name,$arguments,$params);
           if(!$result)
              print "<font color='#FF0000'><strong>Error: ".xslt_error($xh)."</strong></font>";
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
       for($i=0;$i<count($tables);$i++){
           //contruye el nombre del archivo
           $file_name = "CmdShowById" . ucfirst($tables[$i]) . ".class.php";
           //asgina los parametros requeridos por el xslt
           $params = array("tabla" => $tables[$i], "empresa" => $name_company, "aplicacion" => $name_application );
           $result = xslt_process($xh,'arg:/_xml',"xslt/".$dir_name."/GeneracionCommadoConsultarById.xsl","../".$name_application."/web/commands/".$file_name,$arguments,$params);
           if(!$result)
              print "<font color='#FF0000'><strong>Error: ".xslt_error($xh)."</strong></font>";
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
       for($i=0;$i<count($tables);$i++){
           //contruye el nombre del archivo
           $file_name = "CmdCancelShowList" . ucfirst($tables[$i]) . ".class.php";
           //asgina los parametros requeridos por el xslt
           $params = array("tabla" => $tables[$i], "empresa" => $name_company, "aplicacion" => $name_application );
           $result = xslt_process($xh,'arg:/_xml',"xslt/".$dir_name."/GeneracionCommadoCancelList.xsl","../".$name_application."/web/commands/".$file_name,$arguments,$params);
           if(!$result)
               print "<font color='#FF0000'><strong>Error: ".xslt_error($xh)."</strong></font>";
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
       for($i=0;$i<count($tables);$i++){
        $file_name = "Form_" . ucfirst($tables[$i]) . ".tpl";
        //asgina los parametros requeridos por el xslt
        $params = array("tabla" => $tables[$i], "empresa" => $name_company, "aplicacion" => $name_application, "style" => $name_style);
        $result = xslt_process($xh,'arg:/_xml',"xslt/".$dir_name."/GeneracionVista.xsl","../".$name_application."/web/templates/".$file_name,$arguments,$params);
        if(!$result)
            print "<font color='#FF0000'><strong>Error: ".xslt_error($xh)."</strong></font>";
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
       for($i=0;$i<count($tables);$i++){
        $file_name = "Form_". ucfirst($tables[$i]) . "_Consult.tpl";
        //asgina los parametros requeridos por el xslt
        $params = array("tabla" => $tables[$i], "empresa" => $name_company, "aplicacion" => $name_application, "style" => $name_style );
        $result = xslt_process($xh,'arg:/_xml',"xslt/".$dir_name."/GeneracionVistaConsult.xsl","../".$name_application."/web/templates/".$file_name,$arguments,$params);
        if(!$result)
            print "<font color='#FF0000'><strong>Error: ".xslt_error($xh)."</strong></font>";
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
       $file_name ="Form_Menu.tpl";
       //asgina los parametros requeridos por el xslt
       $params = array("empresa" => $name_company, "aplicacion" => $name_application, "style" => $name_style );
       $result = xslt_process($xh,'arg:/_xml',"xslt/".$dir_name."/GeneracionMenuPrincipal.xsl","../".$name_application."/web/templates/".$file_name,$arguments,$params);
       if(!$result)
           print "<font color='#FF0000'><strong>Error: ".xslt_error($xh)."</strong></font>";
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
       $file_name = "SaveNavigationFile.php";
       //asgina los parametros requeridos por el xslt
       $params = array("empresa" => '', "aplicacion" => '' );
       $result = xslt_process($xh,'arg:/_xml',"xslt/".$dir_name."/GeneracionSaveNavigationFile.xsl","../".$name_application."/config/".$file_name,$arguments,$params);
       if(!$result)
           print "<font color='#FF0000'><strong>Error: ".xslt_error($xh)."</strong></font>";
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

       $file_name = "SaveConfigurationFile.php";
       //$host=explode(':',$server);
       $params = array(
                       "type_db" => $type_data_base,
                       "catalogo" => $catalogo,
                       "host" => $server,
                       "user" => $user,
                       //"port"=> $host[1],
                       "pass" => $password,
                       "empresa" => $name_company,
                       "aplicacion" => $name_application,
                       "charset" => $charset,
                       "auth" => "disabled"                                    //OJO <--------------------------- OJO Cambiar
                       );

       $result = xslt_process($xh,'arg:/_xml',"xslt/".$dir_name."/GeneracionSaveConfigurationFile.xsl","../".$name_application."/config/".$file_name,$arguments,$params);
       if(!$result)
           print "<font color='#FF0000'><strong>Error: ".xslt_error($xh)."</strong></font>";
       else
	       $string_result .= $file_name."\n" ;

       return $string_result;
    }

}// end Class GeneradorManager

?>	
 	
