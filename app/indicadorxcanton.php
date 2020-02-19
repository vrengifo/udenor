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
	<form action="indxcan_del.php" method="post" name="form1">
	<?php
		$principal="indicadorxcanton.php";
		$param_destino="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&principal=".$principal;
	?>
	<input type="hidden" name="principal" value="<?=$principal?>">
	<input type="hidden" name="id_aplicacion" value="<?=$id_aplicacion?>">
	<input type="hidden" name="id_subaplicacion" value="<?=$id_subaplicacion?>">	
    <input type="button" name="Add" value="Añadir" onClick="self.location='indxcan_add.php<?=$param_destino?>'">
	<input type="submit" name="Del" value="Eliminar" onClick="return confirmdeletef();">
	<a href="#" onclick="print();"><img src="images/360/print.gif" border="0" alt="Imprimir"></a>
		<br>			
<?php	
		$sql="select concat(ixc.can_codigo,':',ixc.ind_codigo) t1,p.pro_nombre,c.can_nombre,i.ind_descripcion,ixc.indxcan_valor,concat(ixc.can_codigo,':',ixc.ind_codigo) t2 "
			."from indicadorxcanton ixc,canton c, indicador i,provincia p "
			."where c.can_codigo=ixc.can_codigo and i.ind_codigo=ixc.ind_codigo and p.pro_codigo=c.pro_codigo "
			."order by p.pro_nombre,c.can_nombre,i.ind_descripcion";
		//echo $sql."<br>";
		$recordSet = &$conn->Execute($sql);
        if (!$recordSet||$recordSet->EOF) 
			die(texterror('No Records found.'));
		else
		{
			//u.usu_codigo u1,u.usu_codigo u2,u.usu_nombre,u.usu_codigo u3
			$mainheaders=array("Eliminar","Provincia","Cantón","Indicador","Valor","Modificar");		
			build_table_admin($recordSet,false,$mainheaders,'Indicador x Cantón ',
			'images/360/yearview.gif','50%','true','chc','indxcan_upd.php',$param_destino,"total");
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
