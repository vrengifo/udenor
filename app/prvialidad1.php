<?php session_start(); ?>
<? include('includes/main.php'); ?>
<? include('adodb/tohtml.inc.php'); ?>
<?php

	extract($_REQUEST);
	include_once("class/c_viaparxpri.php");

	$datpro=$idp;
	
	$clase=new c_viaparxpri($conn);
	$clase->delall($datpro);

  for($i=0;$i<$total;$i++)
  {
	if(isset($chc[$i]))
	{
		$clase->viapar_id=$chc[$i];
		$clase->datpro_id=$datpro;
		$clase->add();
	}		
  }	

//destino

$destino="location:".$principal."?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&principal=".$principal."&idp=".$idp;
header($destino);
?>