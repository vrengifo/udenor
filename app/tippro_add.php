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
	<form action="tippro_add1.php" method="post" name="form1">
	<?php				
		$sql1="select concat(com_codigo,':',pro_codigo),pro_descripcion from proyecto order by pro_descripcion ";
		$campo=array(
							array("etiqueta"=>"* Subcomponente","nombre"=>"clp1","tipo_campo"=>"select","sql"=>$sql1,"valor"=>""),
							array("etiqueta"=>"* Código Tipo","nombre"=>"clp2","tipo_campo"=>"text","sql"=>"","valor"=>""),
							array("etiqueta"=>"* Descripción Tipo","nombre"=>"clp3","tipo_campo"=>"text","sql"=>"","valor"=>""),
							array("etiqueta"=>"* Desde","nombre"=>"clp4","tipo_campo"=>"text","sql"=>"","valor"=>""),
							array("etiqueta"=>"* Hasta","nombre"=>"clp5","tipo_campo"=>"text","sql"=>"","valor"=>""),
							array("etiqueta"=>"* Actual / Inicial","nombre"=>"clp6","tipo_campo"=>"text","sql"=>"","valor"=>"")
					);
		$campo_hidden=array(
							array("nombre"=>"id_aplicacion","valor"=>$id_aplicacion),
					  		array("nombre"=>"id_subaplicacion","valor"=>$id_subaplicacion),
							array("nombre"=>"principal","valor"=>$principal)
							);
		//construye el html para los campos relacionados
		build_add($conn,'false',"Añadir Tipo","images/360/personwrite.gif","50%",'true'
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