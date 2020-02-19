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
	<form action="mdatpro_del.php" method="post" name="form1">
	<?php
		$principal="modipriorizacion.php";
		$param_destino="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&principal=".$principal."&idp=".$idp;
	?>
	
	<br>
	<input type="hidden" name="principal" value="<?=$principal?>">
	<input type="hidden" name="id_aplicacion" value="<?=$id_aplicacion?>">
	<input type="hidden" name="id_subaplicacion" value="<?=$id_subaplicacion?>">	
    <!--
	<input type="button" name="Add" value="Añadir" onClick="self.location='datpro_add.php<?=$param_destino?>'">
    <input type="button" name="AddW" value="Añadir con Asistente" onClick="fOpenWindow('wdatpro_add.php<?=$param_destino?>','WizardDatoProyecto','750','650')">
    -->
	<input type="button" name="Filter" value="Filtro" onClick="fOpenWindow('modipriorizacion_filter.php<?=$param_destino?>','Filtro','450','350')">
    			
<?php	
		$sql="select pp.usu_audit,date_format(pp.usu_faudit,'%Y-%m-%d %H:%i:%S'),pp.datpro_codigo,dp.datpro_nombre,pp.datpro_id "
			."from priorizacion_proyecto pp, dato_proyecto dp "
			."where dp.datpro_id=pp.datpro_id "
			."and pp.usu_audit='$username' ";
		
		
	if ($apply_filter==1){

		if($filter1!=""){
			$sqlfilter[0]="pp.datpro_codigo like '$filter1%'";
		}
		
		if($filter2!=""){
			$sqlfilter[1]="dp.datpro_nombre like '$filter2%'";
		}

		if (count($sqlfilter)>0){
   			$sql_where=join (" and ",$sqlfilter);
			$sql=$sql." and ".$sql_where;
			$sql_filter_text="Filtrado por Código: $filter1 y Descripción $filter2 ";
			echo '<input type="button" name="RemoveFilter" value="Quitar Filtro" onClick="self.location=\''.$principal."?id_aplicacion=".$id_aplicacion."&apply_filter=0"."&id_subaplicacion=".$id_subaplicacion.'\'">';
			
			session_register("apply_filter");
			session_register("filter1");
			session_register("filter2");
			
		}
			
	}
	else
	{
	  session_unregister("apply_filter");	
	  session_register("filter1");
	  session_register("filter2");
	  
	  unset($apply_filter);	
	  unset($filter1);
	  unset($filter2);
	  
	}				
		
			
		$sql.="order by pp.datpro_codigo ";
	?>
	<input type="submit" name="Del" value="Eliminar" onClick="return confirmdeletef();">
	<a href="#" onclick="print();"><img src="images/360/print.gif" border="0" alt="Imprimir"></a>
		<br>
	<?
	  if($apply_filter)
	    echo "$sql_filter_text <br>";
	?>	
	<?
		
		//echo $sql."<br>";
		$recordSet = &$conn->Execute($sql);
        if (!$recordSet||$recordSet->EOF) 
			die(texterror('No se han ingresado proyectos.'));
		else
		{
			//u.usu_codigo u1,u.usu_codigo u2,u.usu_nombre,u.usu_codigo u3
			$mainheaders=array("Usuario","Fecha","Código","Descripción","Modificar");		
			build_table_sindel($recordSet,false,$mainheaders,'Proyectos ',
			'images/360/yearview.gif','50%','true','mpriorizacion.php',$param_destino,"total");
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