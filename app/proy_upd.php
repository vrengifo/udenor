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
	?>
	
	<br>
	<form action="proy_upd1.php" method="post" name="form1">
	<?php				
		include_once("class/c_ingresoProyecto.php");
		$obj=new c_ingresoProyecto($conn,$username);
		$obj->info($id);
		
		$sqlemp="select emp_codigo,emp_nombre from empleado order by emp_nombre ";
		$campo=array(
						array("etiqueta"=>"* Fecha Creación","nombre"=>"clp1","tipo_campo"=>"hidden","sql"=>"","valor"=>$obj->ingpro_fecha),
						array("etiqueta"=>"* Nro. Dpto. Técnico","nombre"=>"clp2","tipo_campo"=>"hidden","sql"=>"","valor"=>$obj->ingpro_nrodptotecnico),
						array("etiqueta"=>"* Nro. Recepción","nombre"=>"clp3","tipo_campo"=>"hidden","sql"=>"","valor"=>$obj->ingpro_nrorecepcion),
						array("etiqueta"=>"* Nro. Doc. Interno","nombre"=>"clp4","tipo_campo"=>"hidden","sql"=>"","valor"=>$obj->ingpro_nrodocint),
						array("etiqueta"=>"* Empleado entrega","nombre"=>"clp5","tipo_campo"=>"hidden","sql"=>$sqlemp,"valor"=>$obj->ingpro_empentrega),
						array("etiqueta"=>"* Nro. de Proyectos","nombre"=>"clp6","tipo_campo"=>"text","sql"=>"","valor"=>$obj->ingpro_nroproyectos)
					);

		$campo_hidden=array(
							array("nombre"=>"id_aplicacion","valor"=>$id_aplicacion),
					  		array("nombre"=>"id_subaplicacion","valor"=>$id_subaplicacion),
							array("nombre"=>"id","valor"=>$id),
							array("nombre"=>"principal","valor"=>$principal)
							);
		//construye el html para los campos relacionados
		build_upd($conn,'false',"Actualizar Ingreso Carpeta de Proyectos","images/360/memowrite.gif","50%",'true'
		,$campo,$campo_hidden,$id);
		$param_destino="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion;
	?>
  
		<input type="submit" name="Update" value="Actualizar">
		<input type="button" name="Cancel" value="Atrás" onClick="self.location='<?=$principal?><?=$param_destino?>'">
		<a href="#" onclick="print();"><img src="images/360/print.gif" border="0" alt="Imprimir"></a>

		<br>
		<br>			
	</form>	
<SCRIPT LANGUAGE="JavaScript">
function valida() {

  define('clp1', 'string', 'Fecha Creación');
  define('clp2', 'string', 'Nro. Dpto. Técnico');
  define('clp3', 'string', 'Nro. Recepción');
  define('clp4', 'string', 'Nro. Doc. Interno');
  define('clp5', 'string', 'Empleado entrega');
  define('clp6', 'string', 'Nro. de Proyectos');

}
</script>
<?php
		buildsubmenufooter();		
		//rs2html($recordSet,"border=3 bgcolor='#effee'");
		
?>
</body>
</html>