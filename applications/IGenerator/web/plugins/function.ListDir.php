<?php
/*
 * Smarty plugin
 * --------------------------------------------------------------------
 * Type:     function
 * Name:     ListDir
 * Version:  1.0
 * Date:     Julio 12, 2004
 * Author:	SpyroFrameWork
 * Purpose:
 * Input:
 *
 * Examples : {ListDir dir="../Documentos/"}
 *
 *
 * --------------------------------------------------------------------
 */
function smarty_function_ListDir($params, &$smarty)
{
  extract($params);

  $dh = opendir($dir);

  while (false !== ($filename = readdir($dh))) {
         if(is_dir($dir.$filename)){
            $files[] = $filename;
         }
  }

  $result = "";

  if(is_array($files)){

      sort($files);

      $result .= "<fieldset><legend>Directories</legend>";
      $result .= "<table border='0'>";

      for($i=0; $i < count($files); $i++){

          if(($files[$i] != ".") && ($files[$i] != "..")){
              $result .= "<tr>";
              
              if($files[$i] == "Base"){
                $result .= "<td width='32'><input name='dir_name' type='radio' value='".$files[$i]."' checked></td>";
              }else{
                $result .= "<td width='32'><input name='dir_name' type='radio' value='".$files[$i]."'></td>";
              }

              $result .= "<td width='32' height='16'><img src='web/images/foldericon.gif'></td>";
              $result .= "<td>".$files[$i]."</td>";
              $result .= "</tr>";
          }

      }

      $result .= "</table>";
      $result .= "</fieldset>";
  }

  print $result;

}

?>
