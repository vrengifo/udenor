<?php session_start(); ?>
<? include('includes/main.php'); ?>
<? include('adodb/tohtml.inc.php'); ?>
<?php

		extract($_REQUEST);		
		require_once('includes/header.php');
		$username=$session_username;
		
		//buildmenu($username);
		//buildsubmenu($id_aplicacion,$id_subaplicacion);
		
		$vf_actual=date("Y-m-d");
?>
  <form action="wdatpro_add.php" method="post" name="form1">
  
<p><strong>Bienvenido al Asistente para ingresar los datos del proyecto.</strong></p>
<p>A continuaci&oacute;n se le indicar&aacute;n los pasos a seguir, una vez completado el asistente Ud. genera en el sistema el ingreso de los datos de un proyecto.</p>
<p>Nota: Use los botones &quot;Continuar&quot; y &quot;Atr&aacute;s&quot; para navegar en el asistente. El bot&oacute;n &quot;Cerrar&quot; cerrar&aacute; el asistente eliminando el proyecto. En caso de tener complicaciones con el ingreso notificar al administrador del sistema. </p>

<table border="1" width="80%">
  <tr>
    <td><strong>Paso</strong></td>
	<td><strong>Descripción</strong></td>
	<td><strong>Estado</strong></td>
  </tr>
  <tr class="tab">
    <td>1</td>
	<td>Ingresar datos del Proyecto: Componente, Subcomponente, Tipo, Estado actual del proyecto y Nombre del Proyecto</td>
	<td>Ingresando</td>
  </tr>
  <tr>
    <td>2</td>
	<td>Ubicación y Objetivo</td>
	<td>Pendiente</td>
  </tr>
  <tr>
    <td>3</td>
	<td>Datos Técnicos</td>
	<td>Pendiente</td>
  </tr>
  <tr>
    <td>4</td>
	<td>Entidades</td>
	<td>Pendiente</td>
  </tr>
  <tr>
    <td>5</td>
	<td>Documentación</td>
	<td>Pendiente</td>
  </tr>
</table>  
<br>  
  
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
							/*
							array("nombre"=>"id_aplicacion","valor"=>$id_aplicacion),
					  		array("nombre"=>"id_subaplicacion","valor"=>$id_subaplicacion),
							array("nombre"=>"idp","valor"=>$idp),
							array("nombre"=>"principal","valor"=>$principal)
							*/
							);
		//construye el html para los campos relacionados
		build_show($conn,'false',"Información de Carpeta de Proyectos","images/360/taskwrite.gif","50%",'true'
		,$campo,$campo_hidden,$idp);		
	?>
	
	<br>
	
	<?php				
		$sqlcom="select com_codigo,com_descripcion from componente order by com_codigo ";
		if(!isset($compo))
		{
		  $rscom=&$conn->Execute($sqlcom);
		  if(!$rscom->EOF)
		  {
		    $com1ro=$rscom->fields[0];	
		  }
		}
		else
		  $com1ro=$compo;
		  
		$sqlpro="select pro_codigo,pro_descripcion from proyecto where com_codigo='$com1ro' order by com_codigo ";
		if(!isset($subcompo))
		{
		  $rspro=&$conn->Execute($sqlpro);
		  if(!$rspro->EOF)
		  {
		    $pro1ro=$rspro->fields[0];	
		  }
		}
		else
		  $pro1ro=$subcompo;
		  
		$sqltipo="select tip_codigo,tip_descripcion from tipo where com_codigo='$com1ro' and pro_codigo='$pro1ro' order by tip_codigo ";  
		
		$sqlestado="select est_codigo,est_nombre from estado_proyecto order by est_codigo ";
		
		$campo=array(
						array("etiqueta"=>"* Componente","nombre"=>"compo","tipo_campo"=>"select","sql"=>$sqlcom,"valor"=>$compo,"js"=>" onChange=submit();"),
						array("etiqueta"=>"* Subcomponente","nombre"=>"subcompo","tipo_campo"=>"select","sql"=>$sqlpro,"valor"=>$subcompo,"js"=>" onChange=submit();"),
						array("etiqueta"=>"* Tipo","nombre"=>"tipo","tipo_campo"=>"select","sql"=>$sqltipo,"valor"=>$tipo,"js"=>" onChange=submit();"),
						array("etiqueta"=>"* Estado","nombre"=>"estado","tipo_campo"=>"select","sql"=>$sqlestado,"valor"=>$estado),
						array("etiqueta"=>"* Nombre Proyecto","nombre"=>"nombre","tipo_campo"=>"area","sql"=>"","valor"=>$nombre)
					);
		$campo_hidden=array(
							array("nombre"=>"id_aplicacion","valor"=>$id_aplicacion),
					  		array("nombre"=>"id_subaplicacion","valor"=>$id_subaplicacion),
							array("nombre"=>"idp","valor"=>$idp),
							array("nombre"=>"principal","valor"=>$principal)		
							);
		//construye el html para los campos relacionados
		build_add($conn,'false',"Añadir Dato Proyecto","images/360/personwrite.gif","50%",'true'
		,$campo,$campo_hidden);
		$param_destino="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&idp=".$idp;
		
		//ingproxpro.php?id_aplicacion=4&id_subaplicacion=41&principal=datoproyecto.php&id=1
	?>
  
		<input type="submit" name="Añadir" value="Añadir" onClick="cambiar_action(form1,'wdatpro_add1.php');validate();return returnVal;">
		
		<input type="button" name="Cerrar" value="Cerrar" onClick="window.close();">
		<a href="#" onclick="print();"><img src="images/360/print.gif" border="0" alt="Imprimir"></a>
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