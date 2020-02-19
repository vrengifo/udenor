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
	<form action="indxcan_add1.php" method="post" name="form1">
	<?php				
		$sqlc="select c.can_codigo,concat(p.pro_nombre,':',c.can_nombre) from canton c,provincia p where p.pro_codigo=c.pro_codigo order by p.pro_nombre,c.can_nombre ";
		$sqli="select ind_codigo,ind_descripcion from indicador order by ind_descripcion ";
		$campo=array(
							array("etiqueta"=>"* Cantón","nombre"=>"clp0","tipo_campo"=>"select","sql"=>$sqlc,"valor"=>""),
							array("etiqueta"=>"* Indicador","nombre"=>"clp1","tipo_campo"=>"select","sql"=>$sqli,"valor"=>""),
							array("etiqueta"=>"* Valor","nombre"=>"clp2","tipo_campo"=>"text","sql"=>"","valor"=>"")
					);
		$campo_hidden=array(
							array("nombre"=>"id_aplicacion","valor"=>$id_aplicacion),
					  		array("nombre"=>"id_subaplicacion","valor"=>$id_subaplicacion),
							array("nombre"=>"principal","valor"=>$principal)
							);
		//construye el html para los campos relacionados
		build_add($conn,'false',"Añadir Indicador x Componente","images/360/personwrite.gif","50%",'true'
		,$campo,$campo_hidden);
		$param_destino="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion;
	?>
  
		<input type="submit" name="Añadir" value="Añadir" onClick="validate();return returnVal;">
		<input type="button" name="Cancelar" value="Cancelar" onClick="self.location='<?=$principal?><?=$param_destino?>'">
		<a href="#" onclick="print();"><img src="images/360/print.gif" border="0" alt="Imprimir"></a>
		<br>			
	</form>	
<SCRIPT LANGUAGE="JavaScript">
function valida() 
{
  define('clp2', 'string', 'Valor');
}
</script>
<?php
		buildsubmenufooter();		
		//rs2html($recordSet,"border=3 bgcolor='#effee'");
		
?>
</body>
</html>