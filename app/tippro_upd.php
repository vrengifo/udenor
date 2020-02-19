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
	<form action="tippro_upd1.php" method="post" name="form1">
	<?php				
		include_once("class/c_tipo.php");
		$obj=new c_tipo($conn);
		$obj->info($id);
		
		$sql1="select concat(com_codigo,':',pro_codigo),pro_descripcion from proyecto order by pro_descripcion ";
		$campo=array(
							array("etiqueta"=>"* Subcomponente","nombre"=>"clp1","tipo_campo"=>"hidden","sql"=>$sql1,"valor"=>$obj->com_codigo.":".$obj->pro_codigo),
							array("etiqueta"=>"* Código Tipo","nombre"=>"clp2","tipo_campo"=>"hidden","sql"=>"","valor"=>$obj->tip_codigo),
							array("etiqueta"=>"* Descripción Tipo","nombre"=>"clp3","tipo_campo"=>"text","sql"=>"","valor"=>$obj->tip_descripcion),
							array("etiqueta"=>"* Desde","nombre"=>"clp4","tipo_campo"=>"text","sql"=>"","valor"=>$obj->tip_desde),
							array("etiqueta"=>"* Hasta","nombre"=>"clp5","tipo_campo"=>"text","sql"=>"","valor"=>$obj->tip_hasta),
							array("etiqueta"=>"* Actual / Inicial","nombre"=>"clp6","tipo_campo"=>"text","sql"=>"","valor"=>$obj->tip_actual)
					);

		$campo_hidden=array(
							array("nombre"=>"id_aplicacion","valor"=>$id_aplicacion),
					  		array("nombre"=>"id_subaplicacion","valor"=>$id_subaplicacion),
							array("nombre"=>"id","valor"=>$id),
							array("nombre"=>"principal","valor"=>$principal)
							);
		//construye el html para los campos relacionados
		build_upd($conn,'false',"Actualizar Tipo","images/360/memowrite.gif","50%",'true'
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

  define('clp1', 'string', 'Subcomponente');
  define('clp2', 'string', 'Código Tipo');
  define('clp3', 'string', 'Descripción Tipo');
  define('clp4', 'string', 'Desde');
  define('clp5', 'string', 'Hasta');
  define('clp6', 'string', 'Actual / Inicial');

}
</script>
<?php
		buildsubmenufooter();		
		//rs2html($recordSet,"border=3 bgcolor='#effee'");
		
?>
</body>
</html>
