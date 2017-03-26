<?php
/*
 * Proyecto  : AIRE
 * Paquete   : 
 * Archivo   : Crear_Fuente.php 
 * Creado    : 
 * Utilidad  :
 *
 * Historia de Modificaciones
 * Autor     Fecha     Descripcion
 *
 *
 * Pendiente :
 * @TODO
 *
 */
  
  	require('font/makefont/makefont.php');  
	$FileTTF = "3of9.ttf";
  	$FileAFM = "3of9.afm";
	MakeFont($FileTTF,$FileAFM);
  //MakeFont('calligra.ttf','calligra.afm');
?>