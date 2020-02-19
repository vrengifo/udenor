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
	<form action="subcom_upd1.php" method="post" name="form1">
	<?php				
		include_once("class/c_proyecto.php");
		$obj=new c_proyecto($conn);
		$obj->info($id);
		
		$sql="select com_codigo,com_descripcion from componente order by com_codigo,com_descripcion ";
		$campo=array(
							array("etiqueta"=>"* Componente","nombre"=>"clp0","tipo_campo"=>"select","sql"=>$sql,"valor"=>$obj->com_codigo),
							array("etiqueta"=>"* Código Subcomponente","nombre"=>"clp1","tipo_campo"=>"text","sql"=>"","valor"=>$obj->pro_codigo),
							array("etiqueta"=>"* Nombre Subcomponente","nombre"=>"clp2","tipo_campo"=>"text","sql"=>"","valor"=>$obj->pro_descripcion)
					);

		$campo_hidden=array(
							array("nombre"=>"id_aplicacion","valor"=>$id_aplicacion),
					  		array("nombre"=>"id_subaplicacion","valor"=>$id_subaplicacion),
							array("nombre"=>"id","valor"=>$id),
							array("nombre"=>"principal","valor"=>$principal)
							);
		//construye el html para los campos relacionados
		build_upd($conn,'false',"Actualizar Subcomponente","images/360/memowrite.gif","50%",'true'
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

  define('clp1', 'string', 'Código Subcomponente');	
  define('clp2', 'string', 'Nombre Subcomponente');

}
</script>
<?php
		buildsubmenufooter();		
		//rs2html($recordSet,"border=3 bgcolor='#effee'");
		
?>
</body>
</html>
