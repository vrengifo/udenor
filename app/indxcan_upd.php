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
	<form action="indxcan_upd1.php" method="post" name="form1">
	<?php				
		include_once("class/c_indicadorxcanton.php");
		$obj=new c_indicadorxcanton($conn);
		$obj->info($id);
		
		$sqlc="select c.can_codigo,concat(p.pro_nombre,':',c.can_nombre) from canton c,provincia p where p.pro_codigo=c.pro_codigo order by p.pro_nombre,c.can_nombre ";
		$sqli="select ind_codigo,ind_descripcion from indicador order by ind_descripcion ";
		$campo=array(
							array("etiqueta"=>"* Cantón","nombre"=>"clp0","tipo_campo"=>"hidden","sql"=>$sqlc,"valor"=>$obj->can_codigo),
							array("etiqueta"=>"* Indicador","nombre"=>"clp1","tipo_campo"=>"hidden","sql"=>$sqli,"valor"=>$obj->ind_codigo),
							array("etiqueta"=>"* Valor","nombre"=>"clp2","tipo_campo"=>"text","sql"=>"","valor"=>$obj->indxcan_valor)
					);

		$campo_hidden=array(
							array("nombre"=>"id_aplicacion","valor"=>$id_aplicacion),
					  		array("nombre"=>"id_subaplicacion","valor"=>$id_subaplicacion),
							array("nombre"=>"id","valor"=>$id),
							array("nombre"=>"principal","valor"=>$principal)
							);
		//construye el html para los campos relacionados
		build_upd($conn,'false',"Actualizar Indicador x Componente","images/360/memowrite.gif","50%",'true'
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

  define('clp2', 'string', 'Valor');

}
</script>
<?php
		buildsubmenufooter();		
		//rs2html($recordSet,"border=3 bgcolor='#effee'");
		
?>
</body>
</html>
