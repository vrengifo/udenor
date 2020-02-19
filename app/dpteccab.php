<?php 
session_start(); 
//comentario
// idp es el id del padre, o id de la cabecera
// en este caso idp es el id del componente 
?>
<? include('includes/main.php'); ?>
<? include('adodb/tohtml.inc.php'); ?>
<?php

		extract($_REQUEST);		
		require_once('includes/header.php');
		$username=$session_username;
		
		//$principal="dpteccab.php";
		$principal="dptecnico.php";
		$param_destino="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&principal=".$principal."&idp=".$idp;		
?>
	
	<br>
	<form action="dpteccab1.php" method="post" name="form1">
	<?php				
		include_once("class/c_datoProyecto.php");
		$opadre=new c_datoProyecto($conn,$session_username);
		$opadre->info($idp);
		
		$campo=array(
						array("etiqueta"=>"* Código Proyecto","nombre"=>"clp0","tipo_campo"=>"text","sql"=>"","valor"=>$opadre->datpro_codigo),
						array("etiqueta"=>"* Descripción Proyecto","nombre"=>"clp1","tipo_campo"=>"text","sql"=>"","valor"=>$opadre->datpro_nombre)
					);

		$campo_hidden=array(
							array("nombre"=>"id_aplicacion","valor"=>$id_aplicacion),
					  		array("nombre"=>"id_subaplicacion","valor"=>$id_subaplicacion),
							array("nombre"=>"idp","valor"=>$idp),
							array("nombre"=>"principal","valor"=>$principal)
							);
		//construye el html para los campos relacionados
		build_show($conn,'false',"Proyecto","images/360/taskwrite.gif","50%",'true'
		,$campo,$campo_hidden,$idp);
		
	//indicar si se ha ingresado datos o aún no y recuperar su info	
	include_once("class/c_dpDatoTecnico.php");
	$obj=new c_dpDatoTecnico($conn);
	
	$res=$obj->buscarxdatpro($idp);//$idp tiene el datpro_id
	if($res)
	{
	  $fuecreado=$obj->info($res);
	}
		
	?>
	<hr width="100%" align="center" size="2">

	<input name="Apply" type="submit" id="Apply"  value="Aplicar">
	<?
	  if($fuecreado)
	    $tbot="Continuar";
	  else
	   $tbot="Atrás"; 
	?>
	<input type="button" name="back1" value="<?=$tbot?>" onClick="self.location='dptecnico.php?idp=<?=$idp?>';">	
	<input type="button" name="back" value="Cerrar" onClick="window.close();">

	<p>
	  Si la información se encuentra en blanco en algunos campos es porque Ud. no la ha ingresado.
	  Ingrese esta información y de click en el botón "Aplicar" lo cual le permite guardar los cambios hechos en esta parte.
	  
	</p>
	
<SCRIPT LANGUAGE="JavaScript">
function valida() {
}
</script>	
<br>			
<?			
	
	

		$sqlest="select estdes_codigo,estdes_nombre from estado_desarrollo order by estdes_codigo";
		$sqlmon="select mon_codigo,mon_nombre from moneda";
		$campo=array(
						array("etiqueta"=>"* Estado Desarrollo","nombre"=>"clp0","tipo_campo"=>"select","sql"=>$sqlest,"valor"=>$obj->estdes_codigo),
						array("etiqueta"=>"* Fecha Inicio","nombre"=>"clp1","tipo_campo"=>"date","sql"=>"","valor"=>$obj->dattec_finicio),
						array("etiqueta"=>"* Fecha Final","nombre"=>"clp2","tipo_campo"=>"date","sql"=>"","valor"=>$obj->dattec_ffinal),
						array("etiqueta"=>"* Duración","nombre"=>"clp3","tipo_campo"=>"text","sql"=>"","valor"=>$obj->dattec_duracion),
						array("etiqueta"=>"* Beneficiarios","nombre"=>"clp4","tipo_campo"=>"text","sql"=>"","valor"=>$obj->dattec_beneficiario),
						//array("etiqueta"=>"* Monto","nombre"=>"clp5","tipo_campo"=>"text","sql"=>"","valor"=>$obj->dattec_monto),
						array("etiqueta"=>"* Moneda","nombre"=>"clp6","tipo_campo"=>"select","sql"=>$sqlmon,"valor"=>$obj->mon_codigo)
					);
		$campo_hidden=array(
							array("nombre"=>"id_aplicacion","valor"=>$id_aplicacion),
					  		array("nombre"=>"id_subaplicacion","valor"=>$id_subaplicacion),
							array("nombre"=>"principal","valor"=>$principal),
							array("nombre"=>"idp","valor"=>$idp)
							
							);
		//construye el html para los campos relacionados
		build_add($conn,'false',"Crear o Actualizar Cabecera Dato Técnico","images/360/personwrite.gif","50%",'true'
		,$campo,$campo_hidden);				
?>
	</form>	
<?php
		buildsubmenufooter();		
		//rs2html($recordSet,"border=3 bgcolor='#effee'");
		
?>
</body>
</html>