<?php session_start(); ?>
<? include('includes/main.php'); ?>
<? include('adodb/tohtml.inc.php'); ?>
<?php

		extract($_REQUEST);		
		require_once('includes/header.php');
		$username=$session_username;
		
		buildmenu($username);
		buildsubmenu($id_aplicacion,$id_subaplicacion);
		
		$idp=$id;//si viene de datoproyecto.php
	?>
	
	<br>
	<form action="datpro_del.php" method="post" name="form1">
	<?php
		$principal="ingproxpro.php";
		$param_destino="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&principal=".$principal."&idp=".$idp;
	?>
	
<?
		
		include_once("class/c_ingresoProyecto.php");
		$cdp=new c_ingresoProyecto($conn,$username);
		$cdp->info($idp);
		
		$sqlemp="select emp_codigo,emp_nombre from empleado order by emp_nombre ";
		$campo=array(
						array("etiqueta"=>" Fecha Creación","nombre"=>"clp1","tipo_campo"=>"date","sql"=>"","valor"=>$cdp->ingpro_fecha),
						array("etiqueta"=>" Nro. Dpto. Técnico","nombre"=>"clp2","tipo_campo"=>"text","sql"=>"","valor"=>$cdp->ingpro_nrodptotecnico),
						array("etiqueta"=>" Nro. Recepción","nombre"=>"clp3","tipo_campo"=>"text","sql"=>"","valor"=>$cdp->ingpro_nrorecepcion),
						array("etiqueta"=>" Nro. Doc. Interno","nombre"=>"clp4","tipo_campo"=>"text","sql"=>"","valor"=>$cdp->ingpro_nrodocint),
						array("etiqueta"=>" Empleado entrega","nombre"=>"clp5","tipo_campo"=>"select","sql"=>$sqlemp,"valor"=>$cdp->ingpro_empentrega),
						array("etiqueta"=>" Nro. de Proyectos","nombre"=>"clp6","tipo_campo"=>"text","sql"=>"","valor"=>$cdp->ingpro_nroproyectos)
					);

		$campo_hidden=array(
							array("nombre"=>"id_aplicacion","valor"=>$id_aplicacion),
					  		array("nombre"=>"id_subaplicacion","valor"=>$id_subaplicacion),
							array("nombre"=>"idp","valor"=>$idp),
							array("nombre"=>"principal","valor"=>$principal)
							);
		//construye el html para los campos relacionados
		build_show($conn,'false',"Información de Carpeta de Proyectos","images/360/taskwrite.gif","50%",'true'
		,$campo,$campo_hidden,$idp);
?>	
	<br>
	<input type="hidden" name="principal" value="<?=$principal?>">
	<input type="hidden" name="id_aplicacion" value="<?=$id_aplicacion?>">
	<input type="hidden" name="id_subaplicacion" value="<?=$id_subaplicacion?>">	
    <!--
	<input type="button" name="Add" value="Añadir" onClick="self.location='datpro_add.php<?=$param_destino?>'">
	-->
    <?
    $dispone=$cdp->disponibles($idp);
    if($dispone>0)
    {
      echo "Faltan por ingresar $dispone proyecto(s) a la Carpeta de Proyectos <br>";	  
    ?>
    <input type="button" name="AddW" value="Añadir con Asistente" onClick="fOpenWindow('wdatpro_add.php<?=$param_destino?>','WizardDatoProyecto','750','650')">
    <?
    }
    else 
    {
      $cad="Ya no puede Añadir más proyectos a esta carpeta debido a que el límite de proyectos (".$cdp->ingpro_nroproyectos.") ha sido ingresado <br>";	
      echo($cad);
    }
    ?>
	<input type="submit" name="Del" value="Eliminar" onClick="return confirmdeletef();">
	<input type="button" name="Back" value="Atrás" onClick="self.location='datoproyecto.php<?=$param_destino?>'">
	<a href="#" onclick="print();"><img src="images/360/print.gif" border="0" alt="Imprimir"></a>
		<br>			
<?php	
		$sql="select dp.datpro_id,e.est_nombre,dp.datpro_codigo,dp.datpro_nombre,dp.datpro_id "
			."from dato_proyecto dp, estado_proyecto e "
			."where e.est_codigo=dp.est_codigo "
			."and dp.ingpro_codigo=$idp "
			."order by dp.datpro_id ";
		//echo $sql."<br>";
		$recordSet = &$conn->Execute($sql);
        if (!$recordSet||$recordSet->EOF) 
			die(texterror('No se han ingresado proyectos.'));
		else
		{
			//u.usu_codigo u1,u.usu_codigo u2,u.usu_nombre,u.usu_codigo u3
			$mainheaders=array("Eliminar","Estado","Código","Descripción","Modificar");		
			build_table_admin($recordSet,false,$mainheaders,'Proyectos ',
			'images/360/yearview.gif','50%','true','chc','datpro_upd.php',$param_destino,"total");
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