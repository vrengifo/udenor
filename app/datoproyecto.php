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
	<form action="#" method="post" name="form1">
	<?php
		$principal="datoproyecto.php";
		$param_destino="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&principal=".$principal;
	?>
	<input type="hidden" name="principal" value="<?=$principal?>">
	<input type="hidden" name="id_aplicacion" value="<?=$id_aplicacion?>">
	<input type="hidden" name="id_subaplicacion" value="<?=$id_subaplicacion?>">	
    <!--
	<input type="button" name="Add" value="A�adir" onClick="self.location='proy_add.php<?=$param_destino?>'">
	<input type="submit" name="Del" value="Eliminar" onClick="return confirmdeletef();">
	-->
    <a href="#" onclick="print();"><img src="images/360/print.gif" border="0" alt="Imprimir"></a>
		<br>			
<?php	
		$sql="select p.ingpro_usuario,date_format(p.ingpro_fecha,'%Y-%m-%d'),p.ingpro_nrodptotecnico,p.ingpro_nrorecepcion,p.ingpro_nrodocint,e.emp_nombre,p.ingpro_nroproyectos,p.ingpro_codigo "
			."from ingreso_proyecto p, empleado e "
			."where e.emp_codigo=p.ingpro_empentrega "
			."and p.ingpro_usuario='$username' "
			."order by p.ingpro_fecha desc";
		//echo $sql."<br>";
		$recordSet = &$conn->Execute($sql);
        if (!$recordSet||$recordSet->EOF) 
			die(texterror('No Records found.'));
		else
		{
			//u.usu_codigo u1,u.usu_codigo u2,u.usu_nombre,u.usu_codigo u3
			$mainheaders=array("Usuario","Fecha Creaci�n","Nro. Dpto. T�cnico","Nro. Recepci�n","Nro. Doc. Interno","Empleado Entrega","Nro. Proyectos","Modificar");		
			/*
			build_table_admin($recordSet,false,$mainheaders,'Ingreso de Proyectos ',
			'images/360/yearview.gif','50%','true','chc','proy_upd.php',$param_destino,"total");
			*/
			build_table_sindel($recordSet,false,$mainheaders,'Carpetas de Proyectos Creadas (Ingreso de Proyectos)',
			'images/360/yearview.gif','50%','true','ingproxpro.php',$param_destino,"total");
			//variable con campos extras, son los usados como id_aplicacion,id_subaplicacion
			$cextra="id_aplicacion|id_subaplicacion|principal";
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