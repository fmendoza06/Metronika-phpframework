<?php
/* Definición del Directorio de las fuentes */
//define ('FPDF_FONTPATH', DIR_FPDF . 'font/');
define ('FPDF_FONTPATH', '../../lib/fpdf/font/');
/* Incluir la librería de PDF */
require_once('fpdf.php');

/* Definición de la clase */
class pdfreports extends FPDF
{
   var $arParametros;
   var $boHeader = true;
   var $boFooter = false;
   var $widths;
   var $aligns;

   //Load data
   function LoadData($file)
   {
       //Read file lines
       $lines=file($file);
       $data=array();
       foreach($lines as $line)
        $data[]=explode(';',chop($line));
       return $data;
   }

   /* Carga de parámetros para encabezado y pie de página */
   function cargaParametros($arParametros)
   {
      $this->arParametros = $arParametros;
      $this->boHeader = isset($arParametros['boHeader']) ? 
                        $arParametros['boHeader'] : $this->boHeader;
      $this->boFooter = isset($arParametros['boFooter']) ? 
                        $arParametros['boFooter'] : $this->boFooter;
   }
   
   /* Encabezado */
   function Header()
   {
      if ($this->boHeader)
      {
         $inAncho = isset($this->arParametros['ancho']) ? $this->arParametros['ancho'] : 190;
         
         if(isset($this->arParametros['fontTitulo']))
         {
         	$font = $this->arParametros['fontTitulo'];
         	
         }else
         {
         	$font = 'Courier';         	
         }
         
         $this->SetFont($font, '', 8);         
         
         if($this->arParametros['cabecera'] == 'S')         
	      {
	      	$this->Cell(80, 5, $this->arParametros['empresa']);
	         $this->Cell(($inAncho - 180), 5, '');
	         $sbCiudFech = $this->arParametros['ciuddesc'] . ' ' . trim($this->arParametros['fecha']);
	         $this->Cell(100, 5, $sbCiudFech, 0, 1, R);
	         $this->Cell(25, 5, 'NIT       :');
	         $this->cell(55, 5, $this->arParametros['nit']);
	         $this->Cell(($inAncho - 115), 5, '');
	         $this->Cell(35, 5, 'REPORTE : ' . $this->arParametros['formrepo'], 0, 1, 'R');
	         $this->Cell(25, 5, 'GENERADO  :');
	         $this->Cell(100, 5, $this->arParametros['usuario'] . '@' . $this->arParametros['maquina']);
	         $this->Cell(($inAncho - 170), 5);
	         $this->Cell(48, 5, 'Pág. ' . $this->PageNo() . ' DE {nb}', 0, 1, 'R');
	         $this->Ln();
	      }else{
	      	$this->Ln(15);
	      }
         
         /* Características de la fuente empleada en el título */
         $sizeTitulo = isset($this->arParametros['tamTitulo']) ? $this->arParametros['tamTitulo'] : 8;
         $boldTitulo = isset($this->arParametros['tamTitulo']) ? $this->arParametros['boldTitulo'] : '';
         
         $this->SetFont($font, $boldTitulo, $sizeTitulo);
         
         /* Si el titulo tiene mas de una linea se especifica
         /* cuantas y se interpreta como una arreglo de cadenas
         */
         if(isset($this->arParametros['tituLineas']))
         {
         	foreach($this->arParametros['tituRepo'] as $lineaTitulo)
         	{
         		$this->Cell($inAncho, 5, $lineaTitulo, 0, 1, C);         	
         	}         
         }
         else
         {
         	//El titulo es de una solo linea, en este caso no se debe
         	//especiicar numero de lineas 
         	$this->Cell($inAncho, 5, $this->arParametros['tituRepo'], 0, 1, C);         
         }
         
         if($this->arParametros['pie'] != '')
         {         
         	$this->SetFont('Courier', '', 10);
         	$this->Cell(200, 5, $this->arParametros['pie']);
         	$this->Cell(48, 5, 'Pág. ' . $this->PageNo() . ' DE {nb}', 0, 1, 'R');
         	
         }         
         
         $this->SetFont('Courier', '', 8);
         //Line break
         $this->Cell($inAncho, 0, '', 1, 1);
         /* Despliege del encabezado de la tabla */
         if (isset($this->arParametros['encabezado']) && 
             isset($this->arParametros['dimensiones']))
         {
            $widths = $this->widths;
            if ($this->arParametros['lineasEncabezado'] > 1)
            {
               for ($i = 0; $i < $this->arParametros['lineasEncabezado']; $i++)
               {
                  $this->SetWidths($this->arParametros['dimensiones'][$i]);
                  $this->RowHeaderSimple($this->arParametros['encabezado'][$i]);
               }
               $this->Cell($inAncho, 0, '', 1);
            }
            else
            {
               $this->SetWidths($this->arParametros['dimensiones']);
               if (!isset($this->arParametros['TipoEncabezado']))
               {
                  $this->RowHeader($this->arParametros['encabezado']);
               }
               elseif ($this->arParametros['TipoEncabezado'] == 'LINEA')
               {
                  $this->RowHeaderLinea($this->arParametros['encabezado']);
               }
               elseif ($this->arParametros['TipoEncabezado'] == 'SIMPLE')
               {
                  $this->RowHeaderSimple($this->arParametros['encabezado']);
               }
            }
            $this->SetWidths($widths);
         }
      }
   }
   
   //Page footer
   function Footer()
   {
      if ($this->boFooter)
      {
         //Position at 1.5 cm from bottom
         $this->SetY(-15);
         //Arial italic 8
         $this->SetFont('Arial','I',8);
         //Page number
         $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
      }
   }
   
   /**
   * Draws text within a box defined by width = w, height = h, and aligns
   * the text vertically within the box ($valign = M/B/T for middle, bottom, or top)
   * Also, aligns the text horizontally ($align = L/C/R/J for left, centered, right or justified)
   * drawTextBox uses drawRows
   *
   * This function is provided by TUFaT.com
   */
   function drawTextBox($strText, $w, $h, $align='L', $valign='T', $border=1)
   {
      $xi=$this->GetX();
      $yi=$this->GetY();
       
      $hrow=$this->FontSize;
      $textrows=$this->drawRows($w,$hrow,$strText,0,$align,0,0,0);
      $maxrows=floor($h/$this->FontSize);
      $rows=min($textrows,$maxrows);
      
      $dy=0;
      if (strtoupper($valign)=='M')
         $dy=($h-$rows*$this->FontSize)/2;
      if (strtoupper($valign)=='B')
         $dy=$h-$rows*$this->FontSize;
      
      $this->SetY($yi+$dy);
      $this->SetX($xi);
      
      $this->drawRows($w,$hrow,$strText,0,$align,0,$rows,1);
      
      if ($border==1)
         $this->Rect($xi,$yi,$w,$h);
   }

   function drawRows($w,$h,$txt,$border=0,$align='J',$fill=0,$maxline=0,$prn=0)
   {
      $cw=&$this->CurrentFont['cw'];
      if($w==0)
      $w=$this->w-$this->rMargin-$this->x;
      $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
      $s=str_replace("\r",'',$txt);
      $nb=strlen($s);
      if($nb>0 and $s[$nb-1]=="\n")
         $nb--;
      $b=0;
      if($border)
      {
         if($border==1)
         {
            $border='LTRB';
            $b='LRT';
            $b2='LR';
         }
         else
         {
            $b2='';
            if(is_int(strpos($border,'L')))
               $b2.='L';
            if(is_int(strpos($border,'R')))
               $b2.='R';
            $b=is_int(strpos($border,'T')) ? $b2.'T' : $b2;
         }
      }
      $sep=-1;
      $i=0;
      $j=0;
      $l=0;
      $ns=0;
      $nl=1;
      while($i<$nb)
      {
         //Get next character
         $c=$s[$i];
         if($c=="\n")
         {
            //Explicit line break
            if($this->ws>0)
            {
               $this->ws=0;
               if ($prn==1) $this->_out('0 Tw');
            }
            if ($prn==1) {
               $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
            }
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $ns=0;
            $nl++;
            if($border and $nl==2)
               $b=$b2;
            if ( $maxline && $nl > $maxline )
               return substr($s,$i);
            continue;
         }
         if($c==' ')
         {
            $sep=$i;
            $ls=$l;
            $ns++;
         }
         $l+=$cw[$c];
         if($l>$wmax)
         {
            //Automatic line break
            if($sep==-1)
            {
               if($i==$j)
                  $i++;
               if($this->ws>0)
               {
                  $this->ws=0;
                  if ($prn==1) $this->_out('0 Tw');
               }
               if ($prn==1) {
                  $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
               }
            }
            else
            {
               if($align=='J')
               {
                  $this->ws=($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
                  if ($prn==1) $this->_out(sprintf('%.3f Tw',$this->ws*$this->k));
               }
               if ($prn==1){
                  $this->Cell($w,$h,substr($s,$j,$sep-$j),$b,2,$align,$fill);
               }
               $i=$sep+1;
            }
            $sep=-1;
            $j=$i;
            $l=0;
            $ns=0;
            $nl++;
            if($border and $nl==2)
               $b=$b2;
            if ( $maxline && $nl > $maxline )
               return substr($s,$i);
         }
         else
            $i++;
      }
      //Last chunk
      if($this->ws>0)
      {
         $this->ws=0;
         if ($prn==1) $this->_out('0 Tw');
      }
      if($border and is_int(strpos($border,'B')))
         $b.='B';
      if ($prn==1) {
         $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
      }
      $this->x=$this->lMargin;
      return $nl;
   }
   
   /* The goal of this script is to show how to build a table from MultiCells.
    * As MultiCells go to the next line after being output, the base idea
    * consists in saving the current position, printing the MultiCell and
    * resetting the position to its right.
    * There is a difficulty, however, if the table is too long: page breaks.
    * Before outputting a row, it is necessary to know whether it will cause a
    * break or not. If it does overflow, a manual page break must be done first.
    * To do so, the height of the row must be known in advance; it is the
    * maximum of the heights of the MultiCells it is made up of. To know the
    * height of a MultiCell, the NbLines() method is used: it returns the number
    * of lines a MultiCell will occupy.
    */
   function SetWidths($w)
   {
       //Set the array of column widths
       $this->widths=$w;
   }

   function SetAligns($a)
   {
       //Set the array of column alignments
       $this->aligns=$a;
   }
   
   function Row($data)
   {
       //Calculate the height of the row
       $nb=0;
       for($i=0;$i<count($data);$i++)
           $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
       $h=5*$nb;
       //Issue a page break first if needed
       $this->CheckPageBreak($h);
       //Draw the cells of the row
       for($i=0;$i<count($data);$i++)
       {
           $w=$this->widths[$i];
           $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
           //Save the current position
           $x=$this->GetX();
           $y=$this->GetY();
           //Draw the border
           $this->Rect($x,$y,$w,$h);
           //Print the text
           $this->MultiCell($w,5,$data[$i],0,$a);
           //Put the position to the right of the cell
           $this->SetXY($x+$w,$y);
       }
       //Go to the next line
       $this->Ln($h);
   }

   function RowSimple($data, $height = 5)
   {
       //Calculate the height of the row
       $nb=0;
       for($i=0;$i<count($data);$i++)
           $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
       $h=$height*$nb;
       //Issue a page break first if needed
       $this->CheckPageBreak($h);
       //Draw the cells of the row
       for($i=0;$i<count($data);$i++)
       {
           $w=$this->widths[$i];
           $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
           //Save the current position
           $x=$this->GetX();
           $y=$this->GetY();
           //Print the text
           $this->MultiCell($w,$height,$data[$i],0,$a);
           //Put the position to the right of the cell
           $this->SetXY($x+$w,$y);
       }
       //Go to the next line
       $this->Ln($h);
   }

   function RowHeader($data)
   {
       //Calculate the height of the row
       $nb=0;
       for($i=0;$i<count($data);$i++)
           $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
       $h=5*$nb;
       //Issue a page break first if needed
       $this->CheckPageBreak($h);
       //Draw the cells of the row
       for($i=0;$i<count($data);$i++)
       {
           $w=$this->widths[$i];
           $a = 'C';
           //Save the current position
           $x=$this->GetX();
           $y=$this->GetY();
           //Draw the border
           $this->Rect($x,$y,$w,$h);
           //Print the text
           $this->MultiCell($w,5,$data[$i],0,$a);
           //Put the position to the right of the cell
           $this->SetXY($x+$w,$y);
       }
       //Go to the next line
       $this->Ln($h);
   }
   
   function RowHeaderLinea($data)
   {
       //Calculate the height of the row
       $nb=0;
       for($i=0;$i<count($data);$i++)
           $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
       $h=5*$nb;
       //Issue a page break first if needed
       if ($this->CheckPageBreak($h+5))
       {
         $this->AddPage();
       }
       $this->CheckPageBreak($h);
       //Draw the cells of the row
       for($i=0;$i<count($data);$i++)
       {
           $w=$this->widths[$i];
           $a = 'C';
           //Save the current position
           $x=$this->GetX();
           $y=$this->GetY();
           //Print the text
           $this->Cell(1, 5);
           $this->MultiCell($w-2,5,$data[$i],'B',$a);
           $this->Cell(1, 5);
           //Put the position to the right of the cell
           $this->SetXY($x+$w,$y);
       }
       //Go to the next line
       $this->Ln($h);
   }

 	function RowColumnLinea($data,$height = 5)
   {
   	 //Calculate the height of the row
       $nb=0;
       for($i=0;$i<count($data);$i++)
           $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
       $h=$height*$nb;
       //Issue a page break first if needed
       if ($this->CheckPageBreak($h+$height))
       {
         $this->AddPage();
       }
       $this->CheckPageBreak($h);
       //Draw the cells of the row
       $this->Cell(0.1, $height,'',1);
       for($i=0;$i<count($data);$i++)
       {
           $w=$this->widths[$i];
           $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
           //Save the current position
           $x=$this->GetX();
           $y=$this->GetY();
           //Print the text
           //$this->Cell(1, $height);         
           $this->MultiCell($w-0.1,$height,$data[$i],'R',$a);           
           //Put the position to the right of the cell
           $this->SetXY($x+$w,$y);
       }
       //Go to the next line
       $this->Ln($h);
   }
   function RowHeaderSimple($data)
   {
       //Calculate the height of the row
       $nb=0;
       for($i=0;$i<count($data);$i++)
           $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
       $h=5*$nb;
       //Issue a page break first if needed
       $this->CheckPageBreak($h);
       //Draw the cells of the row
       for($i=0;$i<count($data);$i++)
       {
           $w=$this->widths[$i];
           $a = 'C';
           //Save the current position
           $x=$this->GetX();
           $y=$this->GetY();
           //Draw the border
           //$this->Rect($x,$y,$w,$h);
           //Print the text
           $this->MultiCell($w,5,$data[$i],0,$a);
           //Put the position to the right of the cell
           $this->SetXY($x+$w,$y);
       }
       //Go to the next line
       $this->Ln($h);
   }
   
   function CheckPageBreak($h)
   {
       //If the height h would cause an overflow, add a new page immediately
       if($this->GetY()+$h>$this->PageBreakTrigger)
           $this->AddPage($this->CurOrientation);
   }
   
   function NbLines($w,$txt)
   {
       //Computes the number of lines a MultiCell of width w will take
       $cw=&$this->CurrentFont['cw'];
       if($w==0)
           $w=$this->w-$this->rMargin-$this->x;
       $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
       $s=str_replace("\r",'',$txt);
       $nb=strlen($s);
       if($nb>0 and $s[$nb-1]=="\n")
           $nb--;
       $sep=-1;
       $i=0;
       $j=0;
       $l=0;
       $nl=1;
       while($i<$nb)
       {
           $c=$s[$i];
           if($c=="\n")
           {
               $i++;
               $sep=-1;
               $j=$i;
               $l=0;
               $nl++;
               continue;
           }
           if($c==' ')
               $sep=$i;
           $l+=$cw[$c];
           if($l>$wmax)
           {
               if($sep==-1)
               {
                   if($i==$j)
                       $i++;
               }
               else
                   $i=$sep+1;
               $sep=-1;
               $j=$i;
               $l=0;
               $nl++;
           }
           else
               $i++;
       }
       return $nl;
   }
   
   /* Tabla Sencilla */
   function BasicTable($header,$data)
   {
       //Header
       foreach($header as $col)
           $this->Cell(40,7,$col,1);
       $this->Ln();
       //Data
       foreach($data as $row)
       {
           foreach($row as $col)
               $this->Cell(40,6,$col,1);
           $this->Ln();
       }
   }
}
?>