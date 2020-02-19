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
	<form action="par_upd1.php" method="post" name="form1">
	<?php				
		include_once("class/c_parroquia.php");
		$obj=new c_parroquia($conn);
		$obj->info($id);
		
		$sqlcan="select c.can_codigo,concat(p.pro_nombre,':',c.can_nombre) from canton c,provincia p where p.pro_codigo=c.pro_codigo  order by p.pro_nombre,c.can_nombre ";
		$campo=array(
						array("etiqueta"=>"* Cantón","nombre"=>"clp0","tipo_campo"=>"hidden","sql"=>$sqlcan,"valor"=>$obj->can_codigo),
						array("etiqueta"=>"* Nombre","nombre"=>"clp1","tipo_campo"=>"hidden","sql"=>"","valor"=>$obj->par_nombre),
						array("etiqueta"=>"* Foto","nombre"=>"clp2","tipo_campo"=>"text","sql"=>"","valor"=>$obj->par_foto),
						array("etiqueta"=>"* Población","nombre"=>"clp3","tipo_campo"=>"text","sql"=>"","valor"=>$obj->par_poblacion)
					);

		$campo_hidden=array(
							array("nombre"=>"id_aplicacion","valor"=>$id_aplicacion),
					  		array("nombre"=>"id_subaplicacion","valor"=>$id_subaplicacion),
							array("nombre"=>"id","valor"=>$id),
							array("nombre"=>"principal","valor"=>$principal)
							);
		//construye el html para los campos relacionados
		build_upd($conn,'false',"Actualizar Parroquia","images/360/memowrite.gif","50%",'true'
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

  define('clp1', 'string', 'Nombre');
  //define('clp2', 'string', 'Foto');
  define('clp3', 'string', 'Población');

}
</script>
<?php
		buildsubmenufooter();		
		//rs2html($recordSet,"border=3 bgcolor='#effee'");
		
?>
</body>
</html>