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
		$principal="ingproxpro.php";
	?>		
	<form action="datpro_add2.php" method="post" name="form1">
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
		build_show($conn,'false',"Información de Ingreso de Proyectos","images/360/taskwrite.gif","50%",'true'
		,$campo,$campo_hidden,$idp);		
	?>	
	<br>
	<?php				
		include_once("class/c_datoProyecto.php");
		$obj=new c_datoProyecto($conn,$session_username);
		
		$obj->info($id);
		
		$sqlcom="select com_codigo,com_descripcion from componente order by com_codigo ";
		if(!isset($compo))
		{
		  $com1ro=$obj->com_codigo;
		}
		else
		  $com1ro=$compo;
		  
		$sqlpro="select pro_codigo,pro_descripcion from proyecto where com_codigo='$com1ro' order by com_codigo ";
		if(!isset($subcompo))
		{
		  $pro1ro=$obj->pro_codigo;
		}
		else
		  $pro1ro=$subcompo;
		  
		$sqltipo="select tip_codigo,tip_descripcion from tipo where com_codigo='$com1ro' and pro_codigo='$pro1ro' order by tip_codigo ";  
		
		$sqlestado="select est_codigo,est_nombre from estado_proyecto order by est_codigo ";
		
		if(!isset($tipo))
		  $tip1ro=$obj->tip_codigo;
		else
		  $tip1ro=$tipo;
		  
		if(!isset($estado))
		  $est1ro=$obj->est_codigo;
		else
		  $est1ro=$estado; 
		  
		if(!isset($nombre))
		  $nombre1ro=$obj->datpro_nombre;
		else
		  $nombre1ro=$nombre;      
		
		$campo=array(
						array("etiqueta"=>"* Componente","nombre"=>"compo","tipo_campo"=>"hidden","sql"=>$sqlcom,"valor"=>$com1ro,"js"=>" onChange=submit();"),
						array("etiqueta"=>"* Subcomponente","nombre"=>"subcompo","tipo_campo"=>"hidden","sql"=>$sqlpro,"valor"=>$pro1ro,"js"=>" onChange=submit();"),
						array("etiqueta"=>"* Tipo","nombre"=>"tipo","tipo_campo"=>"select","sql"=>$sqltipo,"valor"=>$tipo,"js"=>" onChange=submit();"),
						array("etiqueta"=>"* Estado","nombre"=>"estado","tipo_campo"=>"select","sql"=>$sqlestado,"valor"=>$est1ro),
						array("etiqueta"=>"* Nombre Proyecto","nombre"=>"nombre","tipo_campo"=>"area","sql"=>"","valor"=>$nombre1ro)
					);

		$campo_hidden=array(
							array("nombre"=>"id_aplicacion","valor"=>$id_aplicacion),
					  		array("nombre"=>"id_subaplicacion","valor"=>$id_subaplicacion),
							array("nombre"=>"id","valor"=>$id),
							array("nombre"=>"idp","valor"=>$idp),
							array("nombre"=>"principal","valor"=>$principal)
							);
		//construye el html para los campos relacionados
		build_upd($conn,'false',"Proyecto Añadido","images/360/memowrite.gif","50%",'true'
		,$campo,$campo_hidden,$id);
		$param_destino="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&idp=".$idp;
		$param_destino1="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&id=".$idp;
		
		
	?>
  
		<input type="submit" name="Update" value="Actualizar" onclick="cambiar_action(form1,'datpro_upd1.php');">
		<input type="button" name="Cancel" value="Atrás" onClick="self.location='<?=$principal?><?=$param_destino1?>'">
		<a href="#" onclick="print();"><img src="images/360/print.gif" border="0" alt="Imprimir"></a>
		
<?
		$param_sub="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&idp=".$id;
		$resto_sub="&principal=datpro_add2.php";
?>		
		<input type="button" name="bubi" value="Ubicación" onClick="fOpenWindow('dpubicacion.php<?=$param_sub?><?=$resto_sub?>','DPUbicacion','450','550')">
		<input type="button" name="bdattec" value="Datos Técnicos" onClick="fOpenWindow('dptecnico.php<?=$param_sub?><?=$resto_sub?>','DPDatoTecnico','450','550')">
		<input type="button" name="bent" value="Entidades" onClick="fOpenWindow('dpentidad.php<?=$param_sub?><?=$resto_sub?>','DPEntidad','450','550')">
		<input type="button" name="bdoc" value="Documentación" onClick="fOpenWindow('dpdocumento.php<?=$param_sub?><?=$resto_sub?>','DPDocumentac','450','550')">
		<input type="button" name="bver" value="Ver" onClick="fOpenWindow('verproyecto.php<?=$param_sub?><?=$resto_sub?>','Ver','450','550')">
		
		<!--<input type="button" name="compos" value="Component Position" onClick="fOpenWindow('comxpos.php<?=$param_destino?><?=$resto?>','ComponentPosition','450','550')">-->
		<br>			
	</form>	
<SCRIPT LANGUAGE="JavaScript">
function valida() 
{
  define('compo', 'string', 'Componente');
  define('subcompo', 'string', 'Subcomponente');
  define('tipo', 'string', 'Tipo');
  define('estado', 'string', 'Estado');
  define('nombre', 'string', 'Nombre');
}
</script>
<?php
		buildsubmenufooter();		
		//rs2html($recordSet,"border=3 bgcolor='#effee'");
		
?>
</body>
</html>