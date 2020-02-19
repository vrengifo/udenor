<?php 
session_start(); 
//comentario
// idp es el id del padre, o id de la cabecera
// en este caso idp es el id del componente 
?>
<? include('includes/main.php'); ?>
<? include('adodb/tohtml.inc.php'); ?>
<?php

		extract($_REQUEST);		
		require_once('includes/header.php');
		$username=$session_username;
		
		buildmenu($username);
		buildsubmenu($id_aplicacion,$id_subaplicacion);
		
		$principal="parametro.php";
		$param_destino="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&principal=".$principal."&idp=".$idp;		
?>
	
	<br>
	<form action="parametro1.php" method="post" name="form1">

	<input name="Apply" type="submit" id="Apply"  value="Aplicar">
	<input type="button" name="back" value="Cerrar" onClick="window.close();">	
	
<SCRIPT LANGUAGE="JavaScript">
function valida() {
}
</script>	
<br>			
<?			
	$sql="select par_imgecu from parametro ";
	$rs=&$conn->Execute($sql);
	if($rs->EOF)
	{
	  $iou="i";	
	  $imagenecu="";
	}
	else 
	{
	  $iou="u";	
	  $imagenecu=$rs->fields[0];
	}
	
	
		$campo=array(
			array("etiqueta"=>"* Imagen General","nombre"=>"da0","tipo_campo"=>"area","sql"=>"","valor"=>$imagenecu)
					);
		$campo_hidden=array(
							array("nombre"=>"id_aplicacion","valor"=>$id_aplicacion),
					  		array("nombre"=>"id_subaplicacion","valor"=>$id_subaplicacion),
							array("nombre"=>"principal","valor"=>$principal),
							array("nombre"=>"iou","valor"=>$iou)
							
							);
		//construye el html para los campos relacionados
		build_add($conn,'false',"Crear o Actualizar Parámetros","images/360/personwrite.gif","50%",'true'
		,$campo,$campo_hidden);				
?>
	</form>	
<?php
		buildsubmenufooter();		
		//rs2html($recordSet,"border=3 bgcolor='#effee'");
		
?>
</body>
</html>