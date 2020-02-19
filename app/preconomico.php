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
		
		$principal="preconomico.php";
		$param_destino="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&principal=".$principal."&idp=".$idp;		
?>
	
	<br>
	<form action="preconomico1.php" method="post" name="form1">
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
	include_once("class/c_beneficioEconomico.php");
	$obj=new c_beneficioEconomico($conn);
	
	$res=$obj->info($idp);//$idp tiene el datpro_id
	
		$campo=array(
						array("etiqueta"=>"* Tasa Mínima Requerida","nombre"=>"da0","tipo_campo"=>"text","sql"=>"","valor"=>$obj->beneco_tmr),
						array("etiqueta"=>"* Tasa Interna de Retorno","nombre"=>"da1","tipo_campo"=>"text","sql"=>"","valor"=>$obj->beneco_tir),
						array("etiqueta"=>"* Valor Actual Neto","nombre"=>"da2","tipo_campo"=>"text","sql"=>"","valor"=>$obj->beneco_van),
						array("etiqueta"=>"* Porcentaje Gastos Administrativos","nombre"=>"da3","tipo_campo"=>"text","sql"=>"","valor"=>$obj->beneco_gastosadmin)
					);
		$campo_hidden=array(
							array("nombre"=>"id_aplicacion","valor"=>$id_aplicacion),
					  		array("nombre"=>"id_subaplicacion","valor"=>$id_subaplicacion),
							array("nombre"=>"principal","valor"=>$principal),
							array("nombre"=>"idp","valor"=>$idp)
							
							);
		//construye el html para los campos relacionados
		build_add($conn,'false',"Crear o Actualizar Beneficio Económico","images/360/personwrite.gif","50%",'true'
		,$campo,$campo_hidden);				
?>
	</form>	
<?php
		buildsubmenufooter();		
		//rs2html($recordSet,"border=3 bgcolor='#effee'");
		
?>
</body>
</html>