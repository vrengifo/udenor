<?php session_start(); ?>
<? include('includes/main.php'); ?>
<? include('adodb/tohtml.inc.php'); ?>
<? include('class/c_application.php'); ?>
<?php
  extract($_REQUEST);		  
?>
<?php
$cait=new c_application($conn);
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
  $cad_dest.=$c1."=".$$c1."&";
}


$idp=$cait->add();

$cad_dest=substr($cad_dest,0,(strlen($cad_dest)-1));
$destino="location:apli_add2.php?".$cad_dest."&id=".$idp;
$destinoE=$principal."?".$cad_dest."&id=".$idp;

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