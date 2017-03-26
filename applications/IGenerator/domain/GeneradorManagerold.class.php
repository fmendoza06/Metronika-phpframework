<?php

require_once("MDB_MetaData.php");

class GeneradorManager
{

    function generarAplicacion($dir_name,$type_db,$server,$user,$password,$catalogo,$name_application,$name_company,$charset,$name_style,$components,$tables)
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
    $process_result .= $this->CreateStructDirectory($name_application,$components);
    $process_result .= $this->CopyFiles($name_application,$components);
    $process_result .= $this->GenerateFiles($document_xml,$name_application,$type_db,$tables,$server,$user,$password,$catalogo,$dir_name,$name_company,$charset,$name_style,$components);

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
     //$dom = domxml_new_doc('1.0');
     $dom = new DOMDocument('1.0', 'iso-8859-1');

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

    //return $dom->dump_mem(1);
    return $dom->getElementsByTagName('database');
    

    }// end metodo getXML
    
    //Metodo que crea toda la estructura de directorios para la aplicacion
    //generada.
    function CreateStructDirectory($name_application,$components)
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
	     mkdir ("../".$name_application."/web/css", 0700);
	     $string_result .= "../".$name_application."/web/css\n";
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
	     mkdir ("../".$name_application."/data/Mysql", 0700);
	     $string_result .= "../".$name_application."/data/Mysql\n";
	     mkdir ("../".$name_application."/data/Pgsql", 0700);
	     $string_result .= "../".$name_application."/data/Pgsql\n";
	     mkdir ("../".$name_application."/data/Oracle", 0700);
	     $string_result .= "../".$name_application."/data/Oracle\n";
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
		 	   if(!ereg("^\.", $file)){
			  	  copy("files/images/$file","../".$name_application."/web/images/$file");
				  $string_result .= "../".$name_application."/web/images/$file\n";
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
	 }
	 	
     return $string_result;
    }


    function GenerateFiles($document_xml,$name_application,$db_type,$tables,$server,$user,$password,$catalogo,$dir_name,$name_company,$charset,$name_style,$components)
    {
     $string_result = "";

     //$xh = xslt_create();
     $xh = new XSLTProcessor();
     $path = Application::getBaseDirectory()."/";
     //xslt_set_base($xh, "file://".$path);
     $arguments = array('/_xml' => $document_xml);
     print_r('<pre>');
     print_r($arguments);
     print_r('</pre>');
     //valida si se deben generar las compuertas
	 if(isset($components["data"])){
		 $string_result .= "=============Compuertas de Fila Generadas============\n";
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
	       //$result = xslt_process($xh,'arg:/_xml',"xslt/".$dir_name."/GeneracionCompuertaFilaMysql.xsl","../".$name_application."/data/Mysql/".$file_name,$arguments,$params);
	       $result = $xh->transformToDoc('arg:/_xml',"xslt/".$dir_name."/GeneracionCompuertaFilaMysql.xsl","../".$name_application."/data/Mysql/".$file_name,$arguments,$params);
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
	       $file_name = $name_company . $name_application . "Pgsql" . ucfirst($tables[$i]) . ".class.php";
           //asgina los parametros requeridos por el xslt
	       $params = array("tabla" => $tables[$i], "empresa" => $name_company, "aplicacion" => $name_application );
	       //$result = xslt_process($xh,'arg:/_xml',"xslt/".$dir_name."/GeneracionCompuertaFilaPgSQL.xsl","../".$name_application."/data/Pgsql/".$file_name,$arguments,$params);
	       $result = $xh->transformToDoc('arg:/_xml',"xslt/".$dir_name."/GeneracionCompuertaFilaPgSQL.xsl","../".$name_application."/data/Pgsql/".$file_name,$arguments,$params);

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
	       //$result = xslt_process($xh,'arg:/_xml',"xslt/".$dir_name."/GeneracionCompuertaFilaOracle.xsl","../".$name_application."/data/Oracle/".$file_name,$arguments,$params);
	       $result = $xh->transformToDoc('arg:/_xml',"xslt/".$dir_name."/GeneracionCompuertaFilaOracle.xsl","../".$name_application."/data/Oracle/".$file_name,$arguments,$params);
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
	       $file_name = $name_company . $name_application . ucfirst($tables[$i]) . "Manager.class.php";
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
	       $file_name = $name_company . $name_application . "CmdDefault". ucfirst($tables[$i]) . ".class.php";
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
	       $file_name = $name_company . $name_application . "CmdAdd" . ucfirst($tables[$i]) . ".class.php";
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
           $file_name = $name_company . $name_application . "CmdUpdate" . ucfirst($tables[$i]) . ".class.php";
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
           $file_name = $name_company . $name_application . "CmdDelete" . ucfirst($tables[$i]) . ".class.php";
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
	       $file_name = $name_company . $name_application . "CmdClear". ucfirst($tables[$i]) . ".class.php";
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
           $file_name = $name_company . $name_application . "CmdShowList" . ucfirst($tables[$i]) . ".class.php";
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
           $file_name = $name_company . $name_application . "CmdShowById" . ucfirst($tables[$i]) . ".class.php";
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
           $file_name = $name_company . $name_application . "CmdCancelShowList" . ucfirst($tables[$i]) . ".class.php";
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
        $file_name = $name_company . $name_application . "Form_" . ucfirst($tables[$i]) . ".tpl";
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
        $file_name =  $name_company . $name_application . "Form_". ucfirst($tables[$i]) . "_Consult.tpl";
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
       $file_name =  $name_company . $name_application . "Form_Menu.tpl";
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
       $params = array("empresa" => $name_company, "aplicacion" => $name_application );
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
                     $type_data_base = "Mysql";
                     break;
        case "pgsql":
                     $type_data_base = "Pgsql";
                     break;
        case "oci8":
                     $type_data_base = "Oracle";
                     break;
      }

       $file_name = "SaveConfigurationFile.php";

       $params = array(
                       "type_db" => $type_data_base,
                       "catalogo" => $catalogo,
                       "host" => $server,
                       "user" => $user,
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
 	
