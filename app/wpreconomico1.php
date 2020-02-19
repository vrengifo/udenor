<?php session_start(); ?>
<? include('includes/main.php'); ?>
<? include('adodb/tohtml.inc.php'); ?>
<?php

	extract($_REQUEST);
	include_once("class/c_beneficioEconomico.php");

	$datpro=$idp;
	
	$clase=new c_beneficioEconomico($conn);
	
	$clase->datpro_id=$datpro;
	$clase->beneco_tmr=$da0;
	$clase->beneco_tir=$da1;
	$clase->beneco_van=$da2;
	$clase->beneco_gastosadmin=$da3;
	
	$clase->crearoactualizar();


//destino
$principal="wprvialidad.php";
$destino="location:".$principal."?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&principal=".$principal."&idp=".$idp;
header($destino);
?>