<?php 
session_start(); 
// idp es el id del padre, o id de la cabecera
?>
<? include('includes/main.php'); ?>
<? include('adodb/tohtml.inc.php'); ?>
<?php

		extract($_REQUEST);		
		require_once('includes/header.php');
		$username=$session_username;
		//buildmenu($username);
		//buildsubmenu($id_aplicacion,$id_subaplicacion);
		
		//id=datpro_id
		//idp=ingpro_codigo
		
		$param_sub="dptecnico.php?id_aplicacion=$id_aplicacion&id_subaplicacion=$id_subaplicacion&idp=$id&principal=wpubicacion.php";
		$param_sub1="?id_aplicacion=$id_aplicacion&id_subaplicacion=$id_subaplicacion&idp=$id&principal=wpubicacion.php";
		$param_atras="wdpubicacion.php?id_aplicacion=$id_aplicacion&id_subaplicacion=$id_subaplicacion&id=$id&idp=$idp";
		$param_sig="wdpentidad.php?id_aplicacion=$id_aplicacion&id_subaplicacion=$id_subaplicacion&id=$id&idp=$idp";
		
	?>	
	<br>
	
<p><strong>Bienvenido al Asistente para ingresar los datos del proyecto.</strong></p>
<p>A continuaci&oacute;n se le indicar&aacute;n los pasos a seguir, una vez completado el asistente Ud. genera en el sistema el ingreso de los datos de un proyecto.</p>
<p>Nota: Use los botones &quot;Continuar&quot; y &quot;Atr&aacute;s&quot; para navegar en el asistente. El bot&oacute;n &quot;Cerrar&quot; cerrar&aacute; el asistente eliminando el proyecto. En caso de tener complicaciones con el ingreso notificar al administrador del sistema. </p>

<table border="1" width="80%">
  <tr>
    <td><strong>Paso</strong></td>
	<td><strong>Descripci�n</strong></td>
	<td><strong>Estado</strong></td>
  </tr>
  <tr>
    <td>1</td>
	<td>Ingresar datos del Proyecto: Componente, Subcomponente, Tipo, Estado actual del proyecto y Nombre del Proyecto</td>
	<td>Ingresado</td>
  </tr>
  <tr>
    <td>2</td>
	<td>Ubicaci�n y Objetivo</td>
	<td>Ingresado</td>
  </tr>
  <tr class="tab">
    <td>3</td>
	<td>Datos T�cnicos</td>
	<td>Ingresando</td>
  </tr>
  <tr>
    <td>4</td>
	<td>Entidades</td>
	<td>Pendiente</td>
  </tr>
  <tr>
    <td>5</td>
	<td>Documentaci�n</td>
	<td>Pendiente</td>
  </tr>
</table>  
<p> 
  Si Ud. no ha ingresado datos T�cnicos por favor de click en el bot&oacute;n &quot;Ingresar / Eliminar / Modificar Datos T�cnicos&quot;. 
  Aqu&iacute; usted podr&aacute; ingresar o eliminar o modificar el estado de Desarrollo, fecha inicial y final, duraci�n, beneficiarios,
   monto, moneda del proyecto as� como un detalle de valores que inviertan Entidades para dicho proyecto. 
</p>
<p>Para continuar con el siguiente paso de click en el bot&oacute;n &quot;Continuar&quot; </p>
<br>	
	<input type="button" name="bubi" value="Ingresar / Eliminar / Modificar Datos T�cnicos" onClick="fOpenWindow('<?=$param_sub?>','DPUbicacion','450','550')">
	<input type="button" name="continuar" value="Continuar" onclick="self.location='<?=$param_sig?>';">
	<input type="button" name="atras" value="Atr�s" onClick="self.location='<?=$param_atras?>';">
	<input type="button" name="cerrar" value="Cerrar" onClick="self.opener.location.reload();window.close();">
    <a href="#" onclick="print();"><img src="images/360/print.gif" border="0" alt="Imprimir"></a>
    <input type="button" name="bver" value="Ver" onClick="fOpenWindow('verproyecto.php<?=$param_sub1?><?=$resto_sub?>','Ver','450','550')">	
	<?
		include_once("class/c_ingresoProyecto.php");
		$cdp=new c_ingresoProyecto($conn,$username);
		$cdp->info($idp);
		
		$sqlemp="select emp_codigo,emp_nombre from empleado order by emp_nombre ";
		$campo=array(
						array("etiqueta"=>" Fecha Creaci�n","nombre"=>"clp1","tipo_campo"=>"date","sql"=>"","valor"=>$cdp->ingpro_fecha),
						array("etiqueta"=>" Nro. Dpto. T�cnico","nombre"=>"clp2","tipo_campo"=>"text","sql"=>"","valor"=>$cdp->ingpro_nrodptotecnico),
						array("etiqueta"=>" Nro. Recepci�n","nombre"=>"clp3","tipo_campo"=>"text","sql"=>"","valor"=>$cdp->ingpro_nrorecepcion),
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
		build_show($conn,'false',"Informaci�n de Carpeta de Proyectos","images/360/taskwrite.gif","50%",'true'
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
						array("etiqueta"=>"* Componente","nombre"=>"compo","tipo_campo"=>"select","sql"=>$sqlcom,"valor"=>$obj->com_codigo,"js"=>" onChange=submit();"),
						array("etiqueta"=>"* Subcomponente","nombre"=>"subcompo","tipo_campo"=>"select","sql"=>$sqlpro,"valor"=>$obj->pro_codigo,"js"=>" onChange=submit();"),
						array("etiqueta"=>"* Tipo","nombre"=>"tipo","tipo_campo"=>"select","sql"=>$sqltipo,"valor"=>$obj->tip_codigo,"js"=>" onChange=submit();"),
						array("etiqueta"=>"* Estado","nombre"=>"estado","tipo_campo"=>"select","sql"=>$sqlestado,"valor"=>$obj->est_codigo),
						array("etiqueta"=>"* Nombre Proyecto","nombre"=>"nombre","tipo_campo"=>"area","sql"=>"","valor"=>$obj->datpro_nombre),
						array("etiqueta"=>"* C�digo","nombre"=>"nombre","tipo_campo"=>"area","sql"=>"","valor"=>$obj->datpro_codigo)
					);

		$campo_hidden=array(
							//array("nombre"=>"id_aplicacion","valor"=>$id_aplicacion),
					  		//array("nombre"=>"id_subaplicacion","valor"=>$id_subaplicacion),
							//array("nombre"=>"id","valor"=>$id),
							//array("nombre"=>"idp","valor"=>$idp),
							//array("nombre"=>"principal","valor"=>$principal)
							);
		//construye el html para los campos relacionados
		
		//build_upd($conn,'false',"Proyecto A�adido","images/360/memowrite.gif","50%",'true'
		//,$campo,$campo_hidden,$id);
		
		build_show($conn,'false','Proyecto',"images/360/taskwrite.gif","50%",'true',$campo,$campo_hidden,$id);
		

?>	
	<input type="button" name="bubi" value="Ingresar / Eliminar / Modificar Datos T�cnicos" onClick="fOpenWindow('<?=$param_sub?>','DPUbicacion','450','550')">
	<input type="button" name="continuar" value="Continuar" onclick="self.location='<?=$param_sig?>';">
	<input type="button" name="atras" value="Atr�s" onClick="self.location='<?=$param_atras?>';">
	<input type="button" name="cerrar" value="Cerrar" onClick="self.opener.location.reload();window.close();">
    <a href="#" onclick="print();"><img src="images/360/print.gif" border="0" alt="Imprimir"></a>
    <input type="button" name="bver" value="Ver" onClick="fOpenWindow('verproyecto.php<?=$param_sub1?><?=$resto_sub?>','Ver','450','550')">
	
  <!--<input type="button" name="back" value="Close" onClick="self.opener.location.reload();window.close();">-->
    <br>
    <br>			
	<?php
	  $sql_dt="select dattec_codigo from dp_datotecnico where datpro_id=$id ";
	  $rs_dt=&$conn->Execute($sql_dt);
	  if($rs_dt->EOF)
	  {
	?>
	  <p>No se han ingresado datos t�cnicos</p>
	<?
	  }			
	  else
	  {
		$dattecId=$rs_dt->fields[0];
	  	
	  	include_once("class/c_dpDatoTecnico.php");
		$odtec=new c_dpDatoTecnico($conn);
		
		$odtec->info($dattecId);
		
		include_once("class/c_estadoDesarrollo.php");
		$oestdes=new c_estadoDesarrollo($conn);
		$oestdes->info($odtec->estdes_codigo);
		
		$campo=array(
						array("etiqueta"=>"* Estado Desarrollo","nombre"=>"clp0","tipo_campo"=>"text","sql"=>"","valor"=>$oestdes->estdes_nombre),
						array("etiqueta"=>"* Fecha Inicio","nombre"=>"clp1","tipo_campo"=>"text","sql"=>"","valor"=>$odtec->dattec_finicio),
						array("etiqueta"=>"* Fecha Final","nombre"=>"clp1","tipo_campo"=>"text","sql"=>"","valor"=>$odtec->dattec_ffinal),
						array("etiqueta"=>"* Duraci�n","nombre"=>"clp1","tipo_campo"=>"text","sql"=>"","valor"=>$odtec->dattec_duracion),
						array("etiqueta"=>"* Beneficiarios","nombre"=>"clp1","tipo_campo"=>"text","sql"=>"","valor"=>$odtec->dattec_beneficiario),
						array("etiqueta"=>"* Monto","nombre"=>"clp1","tipo_campo"=>"text","sql"=>"","valor"=>$odtec->dattec_monto),
						array("etiqueta"=>"* Moneda","nombre"=>"clp1","tipo_campo"=>"text","sql"=>"","valor"=>$odtec->mon_codigo)
					);

		$campo_hidden=array(
							array("nombre"=>"id_aplicacion","valor"=>$id_aplicacion),
					  		array("nombre"=>"id_subaplicacion","valor"=>$id_subaplicacion),
							array("nombre"=>"idp","valor"=>$idp),
							array("nombre"=>"principal","valor"=>$principal)
							);
		//construye el html para los campos relacionados
		build_show($conn,'false',"Datos T�cnicos (Cabecera)","images/360/taskwrite.gif","50%",'true'
		,$campo,$campo_hidden,$idp);	  	
	  }	
	?>
<SCRIPT LANGUAGE="JavaScript">
function valida() {
}
</script>
<?
  if($dattecId!=0)
  {
?>	
  <strong>Detalle de la Inversi�n</strong>
  <br>
<?php	
        $sql="select e.ent_nombre,concat(dtxe.mon_codigo,' ',dtxe.dte_monto) "
			."from dattecxent dtxe, entidad e "
			."where e.ent_codigo=dtxe.ent_codigo "
			."and dtxe.dattec_codigo=$dattecId "
			."order by e.ent_nombre ";
		//echo $sql."<br>";
		$recordSet = &$conn->Execute($sql);
        if (!$recordSet||$recordSet->EOF) 
			echo('No existe Detalle de Inversi�n.');
		else
		{

			$mainheaders=array("Entidad","Monto");		
			build_table($recordSet,false,$mainheaders,'Datos de Detalle Inversi�n ',
			'images/360/yearview.gif','50%','true','chc','dptec_upd.php',$param_destino,"total");
			//variable con campos extras, son los usados como id_aplicacion,id_subaplicacion
		}
  }	
?>


<?php
		buildsubmenufooter();		
		//rs2html($recordSet,"border=3 bgcolor='#effee'");
		
?>
</body>
</html>
