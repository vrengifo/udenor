<?php session_start(); ?>
<? include('includes/main.php'); ?>
<? include('adodb/tohtml.inc.php'); ?>
<?php

	extract($_REQUEST);
	include_once("class/c_contrapartida.php");

	$datpro=$idp;
	
	$clase=new c_contrapartida($conn);
	
	$clase->datpro_id=$datpro;
	$clase->contra_beneficiarios=$da0;
	$clase->contra_proponente=$da1;
	
	$clase->crearoactualizar();


//destino
$principal="wprambiental.php";
$destino="location:".$principal."?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&principal=".$principal."&idp=".$idp;
header($destino);
?>