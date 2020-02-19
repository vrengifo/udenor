<?php session_start(); ?>
<? include('includes/main.php'); ?>
<? include('adodb/tohtml.inc.php'); ?>
<?php

	extract($_REQUEST);
	include_once("class/c_beneficioSocial.php");

	$datpro=$idp;
	
	$clase=new c_beneficioSocial($conn);
	
	$clase->ben_directos=$da0;
	$clase->datpro_id=$datpro;
	
	//$clase->mostrar_dato();
	
	$clase->crearoactualizar();


//destino
$principal="wpreconomico.php";
$destino="location:".$principal."?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&principal=".$principal."&idp=".$idp;
header($destino);
?>