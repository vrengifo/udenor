<?php session_start(); ?>
<? include('includes/main.php'); ?>
<? include('adodb/tohtml.inc.php'); ?>
<?php

		extract($_REQUEST);		
		require_once('includes/header.php');
		$username=$session_username;
//		buildmenu($username);
//		buildsubmenu($id_aplicacion,$id_subaplicacion);
		///todo  el html como se quiera
		// cambio de destino en variable principal
		$principal="maintenance_requi.php";
	?>
	
	<br>
	<form action="dpubi_upd.php" method="post" name="form1">
	
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
		include_once("class/c_dpUbicacion.php");
		$obj=new c_dpUbicacion($conn);
		
		$obj->info($id);
		
		$sqlpro="select pro_codigo,pro_nombre from provincia order by pro_nombre";
		if(!isset($pro))
		{
		  $pro1ro=$obj->pro_codigo;
		}
		else
		  $pro1ro=$pro;
		  
		$sqlcan="select can_codigo,can_nombre from canton where pro_codigo=$pro1ro order by can_nombre";
		if(!isset($can))
		{
		  $can1ro=$obj->can_codigo;
		}
		else
		  $can1ro=$can;
		  
		$sqlpar="select par_codigo,par_nombre from parroquia where can_codigo=$can1ro order by par_nombre";
		
		if(!isset($par))
		{
		  $par1ro=$obj->par_codigo;	
		}
		else 
		  $par1ro=$par;
		  
		if(!isset($comu))
		{
		  $comu1ro=$obj->ubi_comunidad;	
		}
		else 
		  $comu1ro=$comu;
		  
		if(!isset($obs))
		{
		  $obs1ro=$obj->ubi_observacion;	
		}
		else 
		  $obs1ro=$obs;    
		
		$campo=array(
						array("etiqueta"=>"* Provincia","nombre"=>"pro","tipo_campo"=>"selectset","sql"=>$sqlpro,"valor"=>$pro1ro,"js"=>" onChange=submit();"),
						array("etiqueta"=>"* Cantón","nombre"=>"can","tipo_campo"=>"selectset","sql"=>$sqlcan,"valor"=>$can1ro,"js"=>" onChange=submit();"),
						array("etiqueta"=>"* Parroquia","nombre"=>"par","tipo_campo"=>"selectset","sql"=>$sqlpar,"valor"=>$par1ro),
						array("etiqueta"=>"* Comunidades","nombre"=>"comu","tipo_campo"=>"area","sql"=>"","valor"=>$comu1ro),
						array("etiqueta"=>"* Observación","nombre"=>"obs","tipo_campo"=>"area","sql"=>"","valor"=>$obs1ro)
					);
		$campo_hidden=array(
							array("nombre"=>"id_aplicacion","valor"=>$id_aplicacion),
					  		array("nombre"=>"id_subaplicacion","valor"=>$id_subaplicacion),
							array("nombre"=>"principal","valor"=>$principal),
							array("nombre"=>"idp","valor"=>$idp),
							array("nombre"=>"id","valor"=>$id)
							);
		//construye el html para los campos relacionados
		//build_add($conn,'false',"Add Maintenance Requirement","","50%",'true'
		//,$campo,$campo_hidden);
		build_upd($conn,'false',"Actualizar Dato Ubicación","images/360/memowrite.gif","50%",'true'
		,$campo,$campo_hidden,$id);
		//$param_destino="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion;
	?>

<SCRIPT LANGUAGE="JavaScript">
function valida() {

define('pro', 'string', 'Provincia');
define('can', 'string', 'Cantón');
define('par', 'string', 'Parroquia');
define('comu', 'string', 'Comunidades');
define('obs', 'string', 'Observación');

}
</script>
  
		<input type="submit" name="Upd" onClick="cambiar_action(form1,'dpubi_upd1.php');validate();return returnVal;" value="Actualizar">
		<input type="button" name="Cancel" value="Cancel" onClick="window.close();">
		<a href="#" onclick="print();"><img src="images/360/print.gif" border="0" alt="Imprimir"></a>
		<br>			
	</form>	
<?php
//		buildsubmenufooter();		
		//rs2html($recordSet,"border=3 bgcolor='#effee'");
		
?>
</body>
</html>