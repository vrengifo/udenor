<?php session_start(); ?>
<? include('includes/main.php'); ?>
<? include('adodb/tohtml.inc.php'); ?>
<?php

	extract($_REQUEST);
	include_once("class/c_benambxpri.php");

	$datpro=$idp;
	
	$clase=new c_benambxpri($conn);
	$clase->delall($datpro);

  for($i=0;$i<$total;$i++)
  {
	if(isset($chc[$i]))
	{
		$clase->benamb_id=$chc[$i];
		$clase->datpro_id=$datpro;
		$clase->add();
	}		
  }	

//destino
$principal="wprfin.php";
$destino="location:".$principal."?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&principal=".$principal."&idp=".$idp;
header($destino);
?>