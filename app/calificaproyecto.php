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

<?
  include_once("class/c_user.php");
  $ouser=new c_user($conn);
  $ouser->info($session_username);
?>
	
	<br>
	<form action="calproy_del.php" method="post" name="form1">
	<?php
		$principal="calificaproyecto.php";
		$param_destino="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&principal=".$principal;
	?>
	<input type="hidden" name="principal" value="<?=$principal?>">
	<input type="hidden" name="id_aplicacion" value="<?=$id_aplicacion?>">
	<input type="hidden" name="id_subaplicacion" value="<?=$id_subaplicacion?>">	
    
	<input type="button" name="Add" value="Añadir" onClick="self.location='calpro_add.php<?=$param_destino?>'">
	
	<!--
	<input type="submit" name="Del" value="Eliminar" onClick="return confirmdeletef();">
	-->
	
<?php	
	  if($ouser->tipusu_codigo=="A")
	  {
		echo('<input type="submit" name="Del" value="Eliminar" onClick="return confirmdeletef();">');
		?>
		<a href="#" onclick="print();"><img src="images/360/print.gif" border="0" alt="Imprimir"></a>
		<br>		
		<?
	  	
	  	$sql="select pp.datpro_id,pp.usu_audit,pp.datpro_codigo,dp.datpro_nombre,pp.datpro_id "
			."from priorizacion_proyecto pp, dato_proyecto dp "
			."where dp.datpro_id=pp.datpro_id "
			//."and pp.usu_audit='$username' "
			."order by pp.datpro_codigo ";
		//echo $sql."<br>";
		$recordSet = &$conn->Execute($sql);
        if (!$recordSet||$recordSet->EOF) 
			die(texterror('No existen datos.'));
		else
		{
			//u.usu_codigo u1,u.usu_codigo u2,u.usu_nombre,u.usu_codigo u3
			$mainheaders=array("Eliminar","Usuario","Código Proyecto","Descripción Proyecto","Ingresar Priorización");
			
			build_table_admin($recordSet,false,$mainheaders,'Priorización de Proyectos ',
			'images/360/yearview.gif','50%','true','chc','priorizacion.php',$param_destino,"total");
			
			//variable con campos extras, son los usados como id_aplicacion,id_subaplicacion
			$cextra="id_aplicacion|id_subaplicacion|principal";
		}	  	
	  }
	  else
	  {
		?>
		<a href="#" onclick="print();"><img src="images/360/print.gif" border="0" alt="Imprimir"></a>
		<br>		
		<?	  
	  	$sql="select pp.usu_audit,pp.datpro_codigo,dp.datpro_nombre,pp.datpro_id "
			."from priorizacion_proyecto pp, dato_proyecto dp "
			."where dp.datpro_id=pp.datpro_id "
			."and pp.usu_audit='$username' "
			."order by pp.datpro_codigo ";
		//echo $sql."<br>";
		$recordSet = &$conn->Execute($sql);
        if (!$recordSet||$recordSet->EOF) 
			die(texterror('No existen datos.'));
		else
		{
			//u.usu_codigo u1,u.usu_codigo u2,u.usu_nombre,u.usu_codigo u3
			$mainheaders=array("Usuario","Código Proyecto","Descripción Proyecto","Ingresar Priorización");
			/*
			build_table_admin($recordSet,false,$mainheaders,'Ingreso de Proyectos ',
			'images/360/yearview.gif','50%','true','chc','proy_upd.php',$param_destino,"total");
			*/
			build_table_sindel($recordSet,false,$mainheaders,'Priorización de Proyectos',
			'images/360/yearview.gif','50%','true','priorizacion.php',$param_destino,"total");
			//variable con campos extras, son los usados como id_aplicacion,id_subaplicacion
			$cextra="id_aplicacion|id_subaplicacion|principal";
		}
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