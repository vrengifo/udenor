<?php session_start(); ?>
<? include('includes/main.php'); ?>
<? include('adodb/tohtml.inc.php'); ?>
<?php

		extract($_REQUEST);		
		require_once('includes/header.php');
		$username=$session_username;
//		buildmenu($username);
//		buildsubmenu($id_aplicacion,$id_subaplicacion);
		///todo  el html como se quiera
		// cambio de destino en variable principal
	?>
	
	<br>
	<form action="prestava_upd.php" method="post" name="form1">
	
	<?php				
		$principal="prestadoava.php";
		$param_destino="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&principal=".$principal."&idp=".$idp;
		
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
	?>
	<hr width="100%" align="center" size="2">	
	<?php				
		include_once("class/c_estavaproxpri.php");
		$obj=new c_estavaproxpri($conn,$username);
		//echo "id: $id <br>";
		$obj->info($id);
		//$obj->mostrar_dato();
		$sqle="select estavapro_codigo,estavapro_descripcion from estado_avancepro order by estavapro_descripcion";

		$campo=array(
						array("etiqueta"=>"* Estado Avance Proyecto","nombre"=>"da0","tipo_campo"=>"select","sql"=>$sqle,"valor"=>$obj->estavapro_codigo),
						array("etiqueta"=>"* Fecha","nombre"=>"da1","tipo_campo"=>"date","sql"=>"","valor"=>$obj->estavaproxpri_fecha)
					);
		$campo_hidden=array(
							array("nombre"=>"id_aplicacion","valor"=>$id_aplicacion),
					  		array("nombre"=>"id_subaplicacion","valor"=>$id_subaplicacion),
							array("nombre"=>"principal","valor"=>$principal),
							array("nombre"=>"idp","valor"=>$idp),
							array("nombre"=>"id","valor"=>$id)
							);
		//construye el html para los campos relacionados
		//build_add($conn,'false',"Add Maintenance Requirement","","50%",'true'
		//,$campo,$campo_hidden);
		build_upd($conn,'false',"Actualizar Estado Avance Proyecto","images/360/memowrite.gif","50%",'true'
		,$campo,$campo_hidden,$id);
		//$param_destino="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion;
	?>

<SCRIPT LANGUAGE="JavaScript">
function valida() {

define('da0', 'string', 'Estado Avance Proyecto');
define('da1', 'string', 'fecha');
}
</script>
  
		<input type="submit" name="Upd" onClick="cambiar_action(form1,'prestava_upd1.php');validate();return returnVal;" value="Actualizar">
		<input type="button" name="Cancel" value="Cancel" onClick="window.close();">
		<a href="#" onclick="print();"><img src="images/360/print.gif" border="0" alt="Imprimir"></a>
		<br>			
	</form>	
<?php
//		buildsubmenufooter();		
		//rs2html($recordSet,"border=3 bgcolor='#effee'");
		
?>
</body>
</html>