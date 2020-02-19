<?php session_start(); ?>
<? include('includes/main.php'); ?>
<? include('adodb/tohtml.inc.php'); ?>
<?php

		extract($_REQUEST);		
		require_once('includes/header.php');
		$username=$session_username;
		
		buildmenu($username);
		buildsubmenu($id_aplicacion,$id_subaplicacion);
		
		///todo  el html como se quiera
		$principal="subapplication.php";
	?>
<SCRIPT LANGUAGE="JavaScript">
function valida() {

}
</script>
	<br>
	<form action="subapli_upd1.php" method="post" name="form1">
	<?php				
		include_once("class/c_subapplication.php");
		$obj=new c_subapplication($conn);
		$obj->info($id);
		
		$sql_mod="select id_aplicacion,nombre_aplicacion from aplicacion order by nombre_aplicacion";
		$campo=array(
						array("etiqueta"=>"* Module","nombre"=>"clp0","tipo_campo"=>"select","sql"=>$sql_mod,"valor"=>$obj->id_aplicacion),
						array("etiqueta"=>"* SubModule","nombre"=>"clp1","tipo_campo"=>"text","sql"=>"","valor"=>$obj->nombre_subaplicacion),
						array("etiqueta"=>"* File","nombre"=>"clp2","tipo_campo"=>"text","sql"=>"","valor"=>$obj->file_subaplicacion),
						array("etiqueta"=>"* Image","nombre"=>"clp3","tipo_campo"=>"text","sql"=>"","valor"=>$obj->imagen_subaplicacion),
						array("etiqueta"=>"* Orden","nombre"=>"clp4","tipo_campo"=>"text","sql"=>"","valor"=>$obj->orden_subaplicacion)
					);

		$campo_hidden=array(
							array("nombre"=>"id_aplicacion","valor"=>$id_aplicacion),
					  		array("nombre"=>"id_subaplicacion","valor"=>$id_subaplicacion),
							array("nombre"=>"id","valor"=>$id),
							array("nombre"=>"principal","valor"=>$principal)
							);
		//construye el html para los campos relacionados
		build_upd($conn,'false',"SubMódulo Añadido","images/360/memowrite.gif","50%",'true'
		,$campo,$campo_hidden,$id);
		$param_destino="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion;
	?>
  
		<input type="submit" name="Update" value="Actualizar">
		<input type="button" name="Cancel" value="Cancelar" onClick="self.location='<?=$principal?><?=$param_destino?>'">
		<a href="#" onclick="print();"><img src="images/360/print.gif" border="0" alt="Imprimir"></a>
		<br>
		<br>			
	</form>	
<?php
		buildsubmenufooter();		
		//rs2html($recordSet,"border=3 bgcolor='#effee'");
		
?>
</body>
</html>
