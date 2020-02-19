<?php session_start(); ?>
<? include('includes/main.php'); ?>
<? include('adodb/tohtml.inc.php'); ?>
<?php

	extract($_REQUEST);
	include_once("class/c_objxpri.php");
	//$conn->debug=true;
	$datpro=$idp;
	
	$clase=new c_objxpri($conn);
	$clase->delall($datpro);

  for($i=0;$i<$total;$i++)
  {
	if(isset($chc[$i]))
	{
		$clase->objude_codigo=$chc[$i];
		$clase->datpro_id=$datpro;
		$clase->add();
	}		
  }	

$principal="wprestadoava.php";  
//destino
$destino="location:".$principal."?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&principal=".$principal."&idp=".$idp;

header($destino);
?>