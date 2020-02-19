<?php session_start(); ?>
<? include('includes/main.php'); ?>
<? include('adodb/tohtml.inc.php'); ?>
<? include('class/c_objetivoUdenor.php'); ?>
<?php
  extract($_REQUEST);		
?>
<?php
//pv
$cait=new c_objetivoUdenor($conn);
//recuperar todos los datos de la otra forma
$cbase=explode("|",$campo_base);
$t_cbase=count($cbase);

for ($i=0;$i<$t_cbase;$i++)
{
	$dato[$i]=$$cbase[$i];
}
$cait->cargar_dato($dato);
//$cait->mostrar_dato();
//destino
$cextra=explode("|",$campo_extra);
$t_cextra=count($cextra);
for ($i=0;$i<$t_cextra;$i++)
{
	$c1=$cextra[$i];
	if(($c1=="id") || ($c1=="principal"))
	{
	  if($c1=="principal")
	    $destino=$$c1."?";
	  if($c1=="id")
	    $id_dato=$$c1;		
	}
	else	
	  $cad_dest.=$c1."=".$$c1."&";
}

$cait->update($id_dato);

$cad_dest=substr($cad_dest,0,(strlen($cad_dest)-1));
$destinoE=$destino.$cad_dest;
$destino="location:".$destino.$cad_dest;

if(strlen($cait->msg)>0)
{
   ?>
   <html>
   <script language="javascript">
     function mensaje(msg)
	 {
	   alert(msg);
	 }
   </script>
     <body onLoad="mensaje('<?=$cait->msg?>');self.location='<?=$destinoE?>';">
	 </body>
   </html>
   <?
}
else
{
  //echo "$destino";
  header($destino);
}

?>