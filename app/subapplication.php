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
	<form action="subapli_del.php" method="post" name="form1">
	<?php
		$principal="subapplication.php";
		$param_destino="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&principal=".$principal;		
	?>
	<input type="hidden" name="principal" value="<?=$principal?>">
	<input type="hidden" name="id_aplicacion" value="<?=$id_aplicacion?>">
	<input type="hidden" name="id_subaplicacion" value="<?=$id_subaplicacion?>">	
    <input type="button" name="Add" value="A�adir" onClick="self.location='subapli_add.php<?=$param_destino?>'">
	<input type="submit" name="Del" value="Eliminar" onClick="return confirmdeletef();">
	<a href="#" onclick="print();"><img src="images/360/print.gif" border="0" alt="Imprimir"></a>
		<br>			
<?php	
		$sql="select s.id_subaplicacion,a.nombre_aplicacion,s.nombre_subaplicacion,s.file_subaplicacion,s.imagen_subaplicacion,s.orden_subaplicacion,s.id_subaplicacion "
			."from subaplicacion s,aplicacion a "
			."where a.id_aplicacion=s.id_aplicacion "
			."order by a.nombre_aplicacion,s.orden_subaplicacion";
		//echo $sql."<br>";
		$recordSet = &$conn->Execute($sql);
        if (!$recordSet||$recordSet->EOF) 
			die(texterror('No Records found.'));
		else
		{
			//$mainheaders=array("Eliminar","Class Part","Part Number","Description","Applicability","Modify");		
			$mainheaders=array("Eliminar","M�dulo","Subm�dulo","Archivo","Imagen","Orden","Modificar");		
			build_table_admin($recordSet,false,$mainheaders,'SubM�dulos ',
			'images/360/yearview.gif','50%','true','chc','subapli_upd.php',$param_destino,"total");
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
