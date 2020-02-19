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
		
		$principal="prcontra.php";
		$param_destino="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&principal=".$principal."&idp=".$idp;		
?>
	
	<br>
	<form action="prcontra1.php" method="post" name="form1">
	<?php				
		include_once("class/c_datoProyecto.php");
		$opadre=new c_datoProyecto($conn,$session_username);
		$opadre->info($idp);
		
		$campo=array(
						array("etiqueta"=>"* Código Proyecto","nombre"=>"clp0","tipo_campo"=>"text","sql"=>"","valor"=>$opadre->datpro_codigo),
						array("etiqueta"=>"* Descripción Proyecto","nombre"=>"clp1","tipo_campo"=>"text","sql"=>"","valor"=>$opadre->datpro_nombre)
					);

		$campo_hidden=array(
							array("nombre"=>"id_aplicacion","valor"=>$id_aplicacion),
					  		array("nombre"=>"id_subaplicacion","valor"=>$id_subaplicacion),
							array("nombre"=>"idp","valor"=>$idp),
							array("nombre"=>"principal","valor"=>$principal)
							);
		//construye el html para los campos relacionados
		build_show($conn,'false',"Proyecto","images/360/taskwrite.gif","50%",'true'
		,$campo,$campo_hidden,$idp);
	?>
	<hr width="100%" align="center" size="2">

	<input name="Apply" type="submit" id="Apply"  value="Aplicar">
	<input type="button" name="back" value="Cerrar" onClick="window.close();">	
	
<SCRIPT LANGUAGE="JavaScript">
function valida() {
}
</script>	
<br>			
<?			
	include_once("class/c_contrapartida.php");
	$obj=new c_contrapartida($conn);
	
	$res=$obj->info($idp);//$idp tiene el datpro_id
	
		$campo=array(
						array("etiqueta"=>"* Porcentaje de la Contrapartida de los Beneficiarios","nombre"=>"da0","tipo_campo"=>"text","sql"=>"","valor"=>$obj->contra_beneficiarios),
						array("etiqueta"=>"* Porcentaje de la Contrapartida del Proponente","nombre"=>"da1","tipo_campo"=>"text","sql"=>"","valor"=>$obj->contra_proponente)
					);
		$campo_hidden=array(
							array("nombre"=>"id_aplicacion","valor"=>$id_aplicacion),
					  		array("nombre"=>"id_subaplicacion","valor"=>$id_subaplicacion),
							array("nombre"=>"principal","valor"=>$principal),
							array("nombre"=>"idp","valor"=>$idp)
							
							);
		//construye el html para los campos relacionados
		build_add($conn,'false',"Crear o Actualizar Contrapartida","images/360/personwrite.gif","50%",'true'
		,$campo,$campo_hidden);				
?>
	</form>	
<?php
		buildsubmenufooter();		
		//rs2html($recordSet,"border=3 bgcolor='#effee'");
		
?>
</body>
</html>