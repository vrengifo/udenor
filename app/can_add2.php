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
		$principal="canton.php";
	?>
	
	<br>
	<form action="can_upd1.php" method="post" name="form1">
	<?php				
		include_once("class/c_canton.php");
		$obj=new c_canton($conn);
		$obj->info($id);
		
		$sqlpro="select pro_codigo,pro_nombre from provincia order by pro_nombre ";
		$campo=array(
						array("etiqueta"=>"* Provincia","nombre"=>"clp0","tipo_campo"=>"hidden","sql"=>$sqlpro,"valor"=>$obj->pro_codigo),
						array("etiqueta"=>"* Nombre","nombre"=>"clp1","tipo_campo"=>"text","sql"=>"","valor"=>$obj->can_nombre),
						array("etiqueta"=>"* Foto","nombre"=>"clp2","tipo_campo"=>"text","sql"=>"","valor"=>$obj->can_foto)
					);

		$campo_hidden=array(
							array("nombre"=>"id_aplicacion","valor"=>$id_aplicacion),
					  		array("nombre"=>"id_subaplicacion","valor"=>$id_subaplicacion),
							array("nombre"=>"id","valor"=>$id),
							array("nombre"=>"principal","valor"=>$principal)
							);
		//construye el html para los campos relacionados
		build_upd($conn,'false',"Cant�n A�adido","images/360/memowrite.gif","50%",'true'
		,$campo,$campo_hidden,$id);
		$param_destino="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion;
	?>
  
		<input type="submit" name="Update" value="Actualizar">
		<input type="button" name="Cancel" value="Atr�s" onClick="self.location='<?=$principal?><?=$param_destino?>'">
		<a href="#" onclick="print();"><img src="images/360/print.gif" border="0" alt="Imprimir"></a>
		<br>
		<br>			
	</form>	
<SCRIPT LANGUAGE="JavaScript">
function valida() 
{
  define('clp1', 'string', 'Nombre');
  define('clp2', 'string', 'Foto');
}
</script>
<?php
		buildsubmenufooter();		
		//rs2html($recordSet,"border=3 bgcolor='#effee'");
		
?>
</body>
</html>