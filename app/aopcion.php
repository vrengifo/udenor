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
	<form action="aopc_del.php" method="post" name="form1">
	<?php
		$principal="aopcion.php";
		$param_destino="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&principal=".$principal;
	?>
	<input type="hidden" name="principal" value="<?=$principal?>">
	<input type="hidden" name="id_aplicacion" value="<?=$id_aplicacion?>">
	<input type="hidden" name="id_subaplicacion" value="<?=$id_subaplicacion?>">	
    <input type="button" name="Add" value="Añadir" onClick="self.location='aopc_add.php<?=$param_destino?>'">
	<input type="submit" name="Del" value="Eliminar" onClick="return confirmdeletef();">
	<a href="#" onclick="print();"><img src="images/360/print.gif" border="0" alt="Imprimir"></a>
		<br>			
<?php	
		$sql="select o.opc_id t1,i.ite_nombre,o.opc_nombre,o.opc_regla,o.opc_puntaje,o.opc_id t2 "
			."from opcion o,item i "
			."where i.ite_id=o.ite_id "
			."order by i.ite_nombre,o.opc_id";
		//echo $sql."<br>";
		$recordSet = &$conn->Execute($sql);
        if (!$recordSet||$recordSet->EOF) 
			die(texterror('No se encontraron registros.'));
		else
		{
			$mainheaders=array("Eliminar","Item","Opción","Regla","Puntaje","Modificar");		
			build_table_admin($recordSet,false,$mainheaders,'Items de Calificación de Proyectos',
			'images/360/yearview.gif','50%','true','chc','aopc_upd.php',$param_destino,"total");
			//variable con campos extras, son los usados como id_aplicacion,id_subaplicacion
			$cextra="id_aplicacion|id_subaplicacion|principal";
		}
?>
		<input type="hidden" name="cextra" value="<?=$cextra?>">
	</form>	
<?php
		buildsubmenufooter();		
?>
</body>
</html>