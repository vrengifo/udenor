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
	<form action="dpent_del.php" method="post" name="form1">
	<?php				
		$principal="dpentidad.php";
		$param_destino="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&principal=".$principal."&idp=".$idp;
		
		include_once("class/c_datoProyecto.php");
		$opadre=new c_datoProyecto($conn,$session_username);
		$opadre->info($idp);
		
		$campo=array(
						array("etiqueta"=>"* C�digo Proyecto","nombre"=>"clp0","tipo_campo"=>"text","sql"=>"","valor"=>$opadre->datpro_codigo),
						array("etiqueta"=>"* Descripci�n Proyecto","nombre"=>"clp1","tipo_campo"=>"text","sql"=>"","valor"=>$opadre->datpro_nombre)
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
  <input type="button" name="Add" value="A�adir" onClick="self.location='dpent_add.php<?=$param_destino?>'">  
  <input type="submit" name="Del" value="Eliminar" onClick="return confirmdeletef();">
  
  <input type="button" name="back" value="Cerrar" onClick="self.opener.location.reload();window.close();">
  <a href="#" onclick="print();"><img src="images/360/print.gif" border="0" alt="Imprimir"></a>
  <!--<input type="button" name="back" value="Close" onClick="self.opener.location.reload();window.close();">-->
    <br>			
<?php	
        $sql="select concat(dpe.datpro_id,':',dpe.tipent_codigo,':',dpe.ent_codigo) a1,"
        	."te.tipent_nombre,e.ent_nombre,"
        	."concat(dpe.datpro_id,':',dpe.tipent_codigo,':',dpe.ent_codigo) a2 "
			."from dp_entidades dpe, entidad e, tipo_entidad te "
			."where te.tipent_codigo=dpe.tipent_codigo and e.ent_codigo=dpe.ent_codigo "
			."and dpe.datpro_id=$idp "
			."order by te.tipent_orden,e.ent_nombre ";
		//echo $sql."<br>";
		$recordSet = &$conn->Execute($sql);
        if (!$recordSet||$recordSet->EOF) 
			echo('No existen datos de Entidades, crear dando click en el bot�n A�adir.');
		else
		{

			$mainheaders=array("Eliminar","Tipo Entidad","Entidad","Modificar");		
			build_table_admin($recordSet,false,$mainheaders,'Datos de Entidades ',
			'images/360/yearview.gif','50%','true','chc','dpent_upd.php',$param_destino,"total");
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
