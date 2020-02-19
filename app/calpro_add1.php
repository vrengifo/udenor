<?php session_start(); ?>
<? include('includes/main.php'); ?>
<? include('adodb/tohtml.inc.php'); ?>
<?php

  extract($_REQUEST);
  include_once("class/c_priorizacionProyecto.php");

  $clase=new c_priorizacionProyecto($conn,$session_username);

  for($i=0;$i<$total;$i++)
  {
	if(isset($chc[$i]))
	{
		$clase->datpro_id=$chc[$i];
		$clase->datpro_codigo=$chidden[$i];
		$clase->crearoactualizar();
	}		
  }	

//destino
$destino="location:".$principal."?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&principal=".$principal."&idp=".$idp;
header($destino);
?>