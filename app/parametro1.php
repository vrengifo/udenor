<?php session_start(); ?>
<? include('includes/main.php'); ?>
<? include('adodb/tohtml.inc.php'); ?>
<?php

	extract($_REQUEST);
	
	if($iou=="i")
	{
	  $sql="insert into parametro (par_imgecu) values ('$da0')";
	}
	if($iou=="u")
	{
	  $sql="update parametro set par_imgecu='$da0' ";	
	}
	$rs=&$conn->Execute($sql);
	

//destino
$destino="location:".$principal."?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&principal=".$principal."&idp=".$idp;
header($destino);
?>