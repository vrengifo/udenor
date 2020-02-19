<?php session_start(); ?>
<? include('includes/main.php'); ?>
<? include('adodb/tohtml.inc.php'); ?>
<?php

	extract($_REQUEST);
	include_once("class/c_dpDatoTecnico.php");

	$datpro=$idp;
	
	$clase=new c_dpDatoTecnico($conn);
	
	$clase->datpro_id=$datpro;
	$clase->estdes_codigo=$clp0;
	$clase->dattec_finicio=$clp1;
	$clase->dattec_ffinal=$clp2;
	$clase->dattec_duracion=$clp3;
	$clase->dattec_beneficiario=$clp4;
	//$clase->dattec_monto=$clp5;
	$clase->mon_codigo=$clp6;
	$clase->crearoactualizar();


//destino
$destino="location:".$principal."?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&principal=".$principal."&idp=".$datpro;
header($destino);
?>