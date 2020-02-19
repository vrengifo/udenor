<?php session_start(); ?>
<? include('includes/main.php'); ?>
<? include('adodb/tohtml.inc.php'); ?>
<? include('class/c_dpUbicacion.php'); ?>
<?php

		extract($_REQUEST);		

		///todo  el html como se quiera
	?>
<?php
  //destino
  $cextra=explode("|",$campo_extra);
  $t_cextra=count($cextra);
  for ($i=0;$i<$t_cextra;$i++)
  {
	$c1=$cextra[$i];
	if($c1=="principal")
	{
	  $destino="location:".$$c1."?";
	  $url=$$c1."?";
	}  
	else	
	  $cad_dest.=$c1."=".$$c1."&";
  }
  $cad_dest=substr($cad_dest,0,(strlen($cad_dest)-1));
  $destino=$destino.$cad_dest;

//pv
  $cait=new c_dpUbicacion($conn);
  //recuperar todos los datos de la otra forma
  $cbase=explode("|",$campo_base);
  $t_cbase=count($cbase);

  for ($i=0;$i<$t_cbase;$i++)
  {
	$dato[$i]=$$cbase[$i];
  }
  $cait->cargar_dato($dato);
  $cait->datpro_id=$idp;
  //$cait->mostrar_dato();
  $res=$cait->add();
if($res==0)
{
  require_once('includes/header.php');
  echo "<center>";
  echo "<hr><br>Error!!!<br>";
  echo "";
  echo "</center>";
  echo "<a href='$url$cad_dest'>Click aquí para intentar de nuevo</a>";
  //http://localhost/simai/maintenance_requi.php?id_aplicacion=3&id_subaplicacion=43&idp=447
  echo "<hr>";
  
  buildsubmenufooter();		
}  
else
{
  //echo "$destino";
  header($destino);
}
?>	
	<br>
<?php
		
		//rs2html($recordSet,"border=3 bgcolor='#effee'");
		
?>
</body>
</html>
