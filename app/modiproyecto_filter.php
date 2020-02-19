<?php session_start(); ?>
<? include('includes/main.php'); ?>
<? 
  include('adodb/tohtml.inc.php'); 
  require_once('includes/header.php');
?>

<html>
<head>
<!--
<link rel="stylesheet" type="text/css" href="includes/style/bluish.css">
-->
<SCRIPT LANGUAGE="Javascript">
function filter_action(forma)
{
    	
    location_url="modiproyecto.php";
    location_url=location_url+"?filter1="+forma.filter1.value+"&filter2="+forma.filter2.value+"&filter3="+forma.filter3.value;
    location_url=location_url+"&apply_filter="+forma.apply_filter.value+"&id_aplicacion="+forma.id_aplicacion.value+"&id_subaplicacion="+forma.id_subaplicacion.value
    opener.location=location_url;  	
    window.close();
}       
</script>

</head>
<body>
<form action="#" name="form1" method="post" target="_top">
	<input type="hidden" name="apply_filter" value="1">
	<input type="hidden" name="id_aplicacion" value="<?=$id_aplicacion?>">
	<input type="hidden" name="id_subaplicacion" value="<?=$id_subaplicacion?>">
	<input type="button" name="FilterNow" value="Filtrar" onClick="filter_action(form1);">
	<input type="button" name="Cancel" value="Cerrar" onClick="window.close();">

<TABLE WIDTH="100%" CELLSPACING=0 CELLPADDING=0 CLASS="tableinside">
<TR>
<TD>
<TABLE WIDTH='100%' border=0 CELLPADDING=2 CELLSPACING=1 BGCOLOR='#CCCCCC'>
<?php
	$sql_est="select est_codigo,est_nombre from estado_proyecto";
	$campo=array(
			array("etiqueta"=>"Estado","nombre"=>"filter1","tipo_campo"=>"select","sql"=>$sql_est,"valor"=>""),
			array("etiqueta"=>"Código Proyecto (Ej: DP:1:A:1)","nombre"=>"filter2","tipo_campo"=>"text","sql"=>"","valor"=>""),
			array("etiqueta"=>"Descripción","nombre"=>"filter3","tipo_campo"=>"text","sql"=>"","valor"=>"")
		);
	//construye el html para los campos relacionados
	build_filter($conn,'false',"Filtro de Proyectos","images/360/blank.gif","50%",'true'
	,$campo,$campo_hidden);


?>

 
</TABLE>
</form>
</body>
<html>