<?php 
session_start(); 
// idp es el id del padre, o id de la cabecera
?>
<? include('includes/main.php'); ?>
<? include('adodb/tohtml.inc.php'); ?>
<?php

		extract($_REQUEST);		
		require_once('includes/header.php');
		$username=$session_username;
		//buildmenu($username);
		//buildsubmenu($id_aplicacion,$id_subaplicacion);
		///todo  el html como se quiera
	?>
	
	<br>
	<form action="dpubi_del.php" method="post" name="form1">
	<?php				
		$principal="dpubicacion.php";
		$param_destino="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&principal=".$principal."&idp=".$idp;
		
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
	
	<?php
				
		//$idp es el id del componente
	?>

<SCRIPT LANGUAGE="JavaScript">
function valida() {
}
</script>	
  <input type="button" name="Add" value="Añadir" onClick="self.location='dpubi_add.php<?=$param_destino?>'">  
  <input type="submit" name="Del" value="Eliminar" onClick="return confirmdeletef();">
  
  <input type="button" name="back" value="Cerrar" onClick="self.opener.location.reload();window.close();">
  <a href="#" onclick="print();"><img src="images/360/print.gif" border="0" alt="Imprimir"></a>
  <!--<input type="button" name="back" value="Close" onClick="self.opener.location.reload();window.close();">-->
    <br>			
<?php	
        $sql="select dpu.ubi_codigo,p.pro_nombre,c.can_nombre,par.par_nombre,dpu.ubi_comunidad,dpu.ubi_observacion,dpu.ubi_codigo "
			."from dp_ubicacion dpu, provincia p, canton c, parroquia par "
			."where p.pro_codigo=dpu.pro_codigo and c.can_codigo=dpu.can_codigo and par.par_codigo=dpu.par_codigo "
			."and dpu.datpro_id=$idp "
			."order by p.pro_nombre,c.can_nombre,par.par_nombre ";
		//echo $sql."<br>";
		$recordSet = &$conn->Execute($sql);
        if (!$recordSet||$recordSet->EOF) 
			die(texterror('No existen datos de Ubicación del proyecto.'));
		else
		{

			$mainheaders=array("Eliminar","Provincia","Cantón","Parroquia","Comunidades","Observación","Modificar");		
			build_table_admin($recordSet,false,$mainheaders,'Datos de Ubicación ',
			'images/360/yearview.gif','50%','true','chc','dpubi_upd.php',$param_destino,"total");
			//variable con campos extras, son los usados como id_aplicacion,id_subaplicacion
			$cextra="id_aplicacion|id_subaplicacion|principal|idp";
		}
?>



		<input type="hidden" name="cextra" value="<?=$cextra?>">
	</form>	
<?php
		buildsubmenufooter();		
		//rs2html($recordSet,"border=3 bgcolor='#effee'");
		
?>
</body>
</html>
