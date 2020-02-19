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
	<form action="dptec_add.php" method="post" name="form1">
	<?php				
		$principal="dptecnico.php";
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
		$sqle="select ent_codigo,ent_nombre from entidad order by ent_nombre";
		$sqlm="select mon_codigo,mon_nombre from moneda";
		$campo=array(
						array("etiqueta"=>"* Entidad","nombre"=>"da0","tipo_campo"=>"select","sql"=>$sqle,"valor"=>""),
						array("etiqueta"=>"* Monto","nombre"=>"da1","tipo_campo"=>"text","sql"=>"","valor"=>""),
						array("etiqueta"=>"* Moneda","nombre"=>"da2","tipo_campo"=>"select","sql"=>$sqlm,"valor"=>"$"),
					);
		$campo_hidden=array(
							array("nombre"=>"id_aplicacion","valor"=>$id_aplicacion),
					  		array("nombre"=>"id_subaplicacion","valor"=>$id_subaplicacion),
							array("nombre"=>"principal","valor"=>$principal),
							array("nombre"=>"idp","valor"=>$idp),
							array("nombre"=>"dattecId","valor"=>$dattecId)
							
							);
		//construye el html para los campos relacionados
		build_add($conn,'false',"Añadir Detalle Inversión","images/360/personwrite.gif","50%",'true'
		,$campo,$campo_hidden);
		//$param_destino="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion;
	?>

<SCRIPT LANGUAGE="JavaScript">
function valida() {

define('da1', 'string', 'Monto');

}
</script>
  
		<input type="submit" name="Add" onClick="cambiar_action(form1,'dptec_add1.php');validate();return returnVal;" value="Añadir">
		<input type="button" name="back" value="Atrás" onClick="self.location='dptecnico.php?idp=<?=$idp?>';">
		<input type="button" name="Cancel" value="Cerrar" onClick="window.close();">
		<a href="#" onclick="print();"><img src="images/360/print.gif" border="0" alt="Imprimir"></a>
		<br>			
	</form>	
<?php
//		buildsubmenufooter();		
		//rs2html($recordSet,"border=3 bgcolor='#effee'");
		
?>
</body>
</html>