<?php session_start(); ?>
<? include('includes/main.php'); ?>
<? include('adodb/tohtml.inc.php'); ?>
<? include('class/c_datoProyecto.php'); ?>
<?php

		extract($_REQUEST);		
/*		require_once('includes/header.php');
		$username=$session_username;
		buildmenu($username);
		buildsubmenu($id_aplicacion,$id_subaplicacion); */
		///todo  el html como se quiera
	?>
<?php
//pv
$cait=new c_datoProyecto($conn,$session_username);
$cait->ingpro_codigo=$idp;
//recuperar todos los datos de la otra forma
$cbase=explode("|",$campo_base);
$t_cbase=count($cbase);

for ($i=0;$i<$t_cbase;$i++)
{
	$dato[$i]=$$cbase[$i];
}
$cait->cargar_dato($dato);
//$cait->mostrar_dato();
$id=$cait->add();
/*
if($id=="0")
  echo "Error";
*/

//destino
$cextra=explode("|",$campo_extra);
$t_cextra=count($cextra);
for ($i=0;$i<$t_cextra;$i++)
{
	$c1=$cextra[$i];
/*	if($c1=="principal")	
	  $destino="location:".$$c1."?";

	else	
*/	
	  $cad_dest.=$c1."=".$$c1."&";
}
$cad_dest=substr($cad_dest,0,(strlen($cad_dest)-1));
$destino="location:wdatpro_add2.php?".$cad_dest."&id=".$id;
//echo "$destino";
header($destino);

?>	
	<br>
<?php
		buildsubmenufooter();		
		//rs2html($recordSet,"border=3 bgcolor='#effee'");
		
?>
</body>
</html>