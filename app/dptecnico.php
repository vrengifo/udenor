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
		///todo  el html como se quiera
	?>
	
	<br>
	<form action="dptec_del.php" method="post" name="form1">
	<?php				
		$principal="dptecnico.php";
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
	  $sql_dt="select dattec_codigo from dp_datotecnico where datpro_id=$idp ";
	  $rs_dt=&$conn->Execute($sql_dt);
	  if($rs_dt->EOF)
	  {
	?>
	  <input type="button" name="creacab" value="Crear Datos Técnicos" onclick="self.location='dpteccab.php?idp=<?=$idp?>';">
	  <input type="button" name="cerrar" value="Cerrar" onclick="self.opener.location.reload();window.close();">
	  <p>
	    El botón "Crear Datos Técnicos" nos permite ingresar datos técnicos del proyecto como por ejemplo: 
	    estado de Desarrollo, fecha inicial y final, duración, beneficiarios, monto, moneda del proyecto
	  </p>
	<?
	  }			
	  else
	  {
	?>
	  <input type="button" name="creacab" value="Modificar Datos Técnicos" onclick="self.location='dpteccab.php?idp=<?=$idp?>';">
	  <input type="button" name="cerrar" value="Cerrar" onclick="self.opener.location.reload();window.close();">
	  <p>
	    El botón "Modificar Datos Técnicos" nos permite modificar datos técnicos del proyecto como por ejemplo: 
	    estado de Desarrollo, fecha inicial y final, duración, beneficiarios, monto, moneda del proyecto
	  </p>
	<?
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
						array("etiqueta"=>"* Duración","nombre"=>"clp1","tipo_campo"=>"text","sql"=>"","valor"=>$odtec->dattec_duracion),
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
		build_show($conn,'false',"Datos Técnicos (Cabecera)","images/360/taskwrite.gif","50%",'true'
		,$campo,$campo_hidden,$idp);	  	
	  }	
	?>
<hr width="100%" align="center" size="2">
<SCRIPT LANGUAGE="JavaScript">
function valida() {
}
</script>
<?
  if($dattecId!=0)
  {
?>	
  <p><strong>Detalle de la Inversión</strong></p>
  <p>
    Aquí usted puede ingresar, eliminar o actualizar el Detalle de las Inversiones para el proyecto.
    <br>El botón "Añadir" permite crear un nuevo Detalle de Inversión, el botón "Eliminar" permite eliminar 
    el o los Detalles de Inversión seleccionados en la caja de chequeo <input type="checkbox" name="basura" value="" checked>,
    en la columna "Modificar" existen vínculos <a href="#">Click aquí</a> que permiten modificar la fila del detalle.
  </p>
  <input type="button" name="Add" value="Añadir" onClick="self.location='dptec_add.php<?=$param_destino?>&dattecId=<?=$dattecId?>'">  
  <input type="submit" name="Del" value="Eliminar" onClick="return confirmdeletef();">
  
  <input type="button" name="back" value="Cerrar" onClick="self.opener.location.reload();window.close();">
  <a href="#" onclick="print();"><img src="images/360/print.gif" border="0" alt="Imprimir"></a>
  <input type="hidden" name="dattecId" value="<?=$dattecId?>">
  <!--<input type="button" name="back" value="Close" onClick="self.opener.location.reload();window.close();">-->
    <br>			
<?php	
        $sql="select concat(dtxe.dattec_codigo,':',dtxe.ent_codigo) t1,e.ent_nombre,concat(dtxe.mon_codigo,' ',dtxe.dte_monto),concat(dtxe.dattec_codigo,':',dtxe.ent_codigo) t2 "
			."from dattecxent dtxe, entidad e "
			."where e.ent_codigo=dtxe.ent_codigo "
			."and dtxe.dattec_codigo=$dattecId "
			."order by e.ent_nombre ";
		//echo $sql."<br>";
		$recordSet = &$conn->Execute($sql);
        if (!$recordSet||$recordSet->EOF) 
			die(texterror('No existe Detalle de Inversión.'));
		else
		{

			$mainheaders=array("Eliminar","Entidad","Monto","Modificar");		
			build_table_admin($recordSet,false,$mainheaders,'Datos de Detalle Inversión ',
			'images/360/yearview.gif','50%','true','chc','dptec_upd.php',$param_destino,"total");
			//variable con campos extras, son los usados como id_aplicacion,id_subaplicacion
			$cextra="id_aplicacion|id_subaplicacion|principal|idp";
		}
?>
		<input type="hidden" name="cextra" value="<?=$cextra?>">
<?
  }//fin del dattecId
?>		
	</form>	
<?php
		buildsubmenufooter();		
		//rs2html($recordSet,"border=3 bgcolor='#effee'");
		
?>
</body>
</html>
