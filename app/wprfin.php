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
  
  
<p><strong>Si ingresó los datos requeridos por el asistente ha finalizado satisfactoriamente este asistente.</strong></p>
<p>
  Si desea generar la calificación de este proyecto de click en el botón "Generar Calificación"
</p>
<br>  
  <form action="wprambiental1.php" method="post" name="form1">
	<?php				
		include_once("class/c_datoProyecto.php");
		$obj=new c_datoProyecto($conn,$session_username);
		
		$obj->info($idp);
		
		$sqlcom="select com_codigo,com_descripcion from componente order by com_codigo ";
		$sqlpro="select pro_codigo,pro_descripcion from proyecto where com_codigo='$obj->com_codigo' order by com_codigo ";
		$sqltipo="select tip_codigo,tip_descripcion from tipo where com_codigo='$obj->com_codigo' and pro_codigo='$obj->pro_codigo' order by tip_codigo ";  
		$sqlestado="select est_codigo,est_nombre from estado_proyecto order by est_codigo ";
		
		$campo=array(
						array("etiqueta"=>"* Componente","nombre"=>"compo","tipo_campo"=>"select","sql"=>$sqlcom,"valor"=>$obj->com_codigo,"js"=>" onChange=submit();"),
						array("etiqueta"=>"* Subcomponente","nombre"=>"subcompo","tipo_campo"=>"select","sql"=>$sqlpro,"valor"=>$obj->pro_codigo,"js"=>" onChange=submit();"),
						array("etiqueta"=>"* Tipo","nombre"=>"tipo","tipo_campo"=>"select","sql"=>$sqltipo,"valor"=>$obj->tip_codigo,"js"=>" onChange=submit();"),
						array("etiqueta"=>"* Estado","nombre"=>"estado","tipo_campo"=>"select","sql"=>$sqlestado,"valor"=>$obj->est_codigo),
						array("etiqueta"=>"* Nombre Proyecto","nombre"=>"nombre","tipo_campo"=>"area","sql"=>"","valor"=>$obj->datpro_nombre),
						array("etiqueta"=>"* Código","nombre"=>"nombre","tipo_campo"=>"area","sql"=>"","valor"=>$obj->datpro_codigo)
					);

		$campo_hidden=array(
							array("nombre"=>"id_aplicacion","valor"=>$id_aplicacion),
					  		array("nombre"=>"id_subaplicacion","valor"=>$id_subaplicacion),
							array("nombre"=>"idp","valor"=>$idp),
							array("nombre"=>"principal","valor"=>$principal)
							);
		build_show($conn,'false','Proyecto',"images/360/taskwrite.gif","50%",'true',$campo,$campo_hidden,$id);
	?>
	<br>	
<?
  $param_sub="prcalificar.php?id_aplicacion=$id_aplicacion&id_subaplicacion=$id_subaplicacion&idp=$idp&principal=$principal";
  $param_sub1="?id_aplicacion=$id_aplicacion&id_subaplicacion=$id_subaplicacion&idp=$idp&principal=$principal";
  $param_atras="wprambiental.php?id_aplicacion=$id_aplicacion&id_subaplicacion=$id_subaplicacion&idp=$idp";
  $param_sig="wprcalificar.php?id_aplicacion=$id_aplicacion&id_subaplicacion=$id_subaplicacion&idp=$idp";
?>	
	<input type="button" name="bcalificar" value="Generar Calificación" onClick="fOpenWindow('<?=$param_sub?>','Calificar','450','550')">
	<input type="button" name="atras" value="Atrás" onClick="self.location='<?=$param_atras?>';">
	<input type="button" name="cerrar" value="Cerrar" onClick="window.close();">
    <a href="#" onclick="print();"><img src="images/360/print.gif" border="0" alt="Imprimir"></a>
    <input type="button" name="bver" value="Ver" onClick="fOpenWindow('verproyecto.php<?=$param_sub1?><?=$resto_sub?>','Ver','450','550')">			
	<br>
	<!--
	<input name="Apply" type="submit" value="Aplicar">
	<input type="button" name="Cerrar" value="Cerrar" onClick="window.close();">
	<a href="#" onclick="print();"><img src="images/360/print.gif" border="0" alt="Imprimir"></a>
	-->
	
<SCRIPT LANGUAGE="JavaScript">
function valida() {
}
</script>	

<br>			
<?
  //objetivo udenor
?>			
	<TABLE WIDTH="50%" CELLSPACING=0 CELLPADDING=0 CLASS="homebox">
	<TR><TD>
			<table width="100%" border=0 cellspacing=0 cellpadding=0 CLASS="titletable">
			<tr>
				<td nowrap><SPAN class="title" STYLE="cursor:default;">
					<img src="images/360/yearview.gif" border=0 align=absmiddle HSPACE=2><font color="#FFFFFF">
					Objetivos UDENOR que cumple el proyecto</font></SPAN>
				</td>
			</TR>
			</TABLE>
			<TABLE WIDTH="100%" CELLSPACING=0 CELLPADDING=0 CLASS="tableinside">
			<TR><TD>
				<TABLE WIDTH='100%' border=0 CELLPADDING=2 CELLSPACING=1 BGCOLOR='#CCCCCC'>
					<TR BGCOLOR="#CCCCCC">						
                      <td nowrap class='table_hd'>Objetivo</td>
					</TR>
					<?php
					  $sql="select ou.objude_descripcion from objetivo_udenor ou,objxpri oxp "
							."where ou.objude_codigo=oxp.objude_codigo and oxp.datpro_id=$idp ";
					  $rs = &$conn->Execute($sql);
					  $cont=0;
					  if($rs->EOF)
					  {
						?>
					  <TR valign=top bgcolor='#ffffff'>
						<TD valign=top nowrap>
						  El proyecto no cumple con los objetivos de Udenor o no se han ingresado
						  datos.  Para ingresar datos de click en el botón "Atrás"
						</TD>
					  </TR>	
						<?	
					  }
					  else 
					  {
						while(!$rs->EOF)
						{
		  					$objetivo=$rs->fields[0];
					?>
					<TR valign=top bgcolor='#ffffff'>
						<TD valign=top nowrap><?=$objetivo?>&nbsp;</TD>						
					</TR>
					<?php
							$cont=$cont+1;
							$rs->MoveNext();
						}
					  }
					?>					
				</TABLE>
				</TD></TR>
			</TABLE>				
		</table>      
	</table>

<br>			
<?php	
//estado avance proyecto
        $sql="select e.estavapro_descripcion,"
        	."date_format(ep.estavaproxpri_fecha,'%Y-%m-%d') "
			."from estavaproxpri ep, estado_avancepro e "
			."where e.estavapro_codigo=ep.estavapro_codigo "
			."and ep.datpro_id=$idp "
			."order by ep.estavaproxpri_fecha asc ";
		//echo $sql."<br>";
		$recordSet = &$conn->Execute($sql);
        if (!$recordSet||$recordSet->EOF) 
          echo "No existen datos de Estados de Avance del Proyecto.";
		else
		{

			$mainheaders=array("Estado","Fecha");		
			build_table($recordSet,false,$mainheaders,'Estados Avance de Proyecto',
			'images/360/yearview.gif','50%','true','chc','dpubi_upd.php',$param_destino,"total");
			//variable con campos extras, son los usados como id_aplicacion,id_subaplicacion
			$cextra="id_aplicacion|id_subaplicacion|principal|idp";
		}
		echo "</table></table>";
?>	

<br>
<?			
	//beneficio social
	include_once("class/c_datoProyecto.php");
	$opadre=new c_datoProyecto($conn,$session_username);
	$opadre->info($idp);

	include_once("class/c_beneficioSocial.php");
	$obj=new c_beneficioSocial($conn);
	
	$res=$obj->info($idp);//$idp tiene el datpro_id
	if(!$res)
	{
	  $obj->ben_totalparroquias=$opadre->totalbeneficiarios($idp);	
	}
	
		$campo=array(
						array("etiqueta"=>"* Total de Beneficiarios Directos","nombre"=>"da0","tipo_campo"=>"text","sql"=>"","valor"=>$obj->ben_directos),
						array("etiqueta"=>"  Total de Beneficiarios de Parroquias que intervienen","nombre"=>"da1","tipo_campo"=>"text","sql"=>"","valor"=>$obj->ben_totalparroquias)
					);
		$campo_hidden=array(
							array("nombre"=>"id_aplicacion","valor"=>$id_aplicacion),
					  		array("nombre"=>"id_subaplicacion","valor"=>$id_subaplicacion),
							array("nombre"=>"principal","valor"=>$principal),
							array("nombre"=>"idp","valor"=>$idp)
							
							);
		//construye el html para los campos relacionados
		build_show($conn,'false',"Beneficio Social","images/360/personwrite.gif","50%",'true',$campo,$campo_hidden,$id);				
?>


<br>
<?			
	//beneficio economico
	include_once("class/c_beneficioEconomico.php");
	$obj=new c_beneficioEconomico($conn);
	
	$res=$obj->info($idp);//$idp tiene el datpro_id
	
		$campo=array(
						array("etiqueta"=>"* Tasa Mínima Requerida","nombre"=>"da0","tipo_campo"=>"text","sql"=>"","valor"=>$obj->beneco_tmr),
						array("etiqueta"=>"* Tasa Interna de Retorno","nombre"=>"da1","tipo_campo"=>"text","sql"=>"","valor"=>$obj->beneco_tir),
						array("etiqueta"=>"* Valor Actual Neto","nombre"=>"da2","tipo_campo"=>"text","sql"=>"","valor"=>$obj->beneco_van),
						array("etiqueta"=>"* Porcentaje Gastos Administrativos","nombre"=>"da3","tipo_campo"=>"text","sql"=>"","valor"=>$obj->beneco_gastosadmin)
					);
		$campo_hidden=array(
							array("nombre"=>"id_aplicacion","valor"=>$id_aplicacion),
					  		array("nombre"=>"id_subaplicacion","valor"=>$id_subaplicacion),
							array("nombre"=>"principal","valor"=>$principal),
							array("nombre"=>"idp","valor"=>$idp)
							
							);
		//construye el html para los campos relacionados
		build_show($conn,'false',"Beneficio Económico","images/360/personwrite.gif","50%",'true'
		,$campo,$campo_hidden,$id);
?>

<br>			
<?
  //Vialidad participativa
?>
	<TABLE WIDTH="50%" CELLSPACING=0 CELLPADDING=0 CLASS="homebox">
	<TR><TD>
			<table width="100%" border=0 cellspacing=0 cellpadding=0 CLASS="titletable">
			<tr>
				<td nowrap><SPAN class="title" STYLE="cursor:default;">
					<img src="images/360/yearview.gif" border=0 align=absmiddle HSPACE=2><font color="#FFFFFF">
					Vialidad Participativa</font></SPAN>
				</td>
			</TR>
			</TABLE>
			<TABLE WIDTH="100%" CELLSPACING=0 CELLPADDING=0 CLASS="tableinside">
			<TR><TD>
				<TABLE WIDTH='100%' border=0 CELLPADDING=2 CELLSPACING=1 BGCOLOR='#CCCCCC'>
					<TR BGCOLOR="#CCCCCC">						
                      <td nowrap class='table_hd'>Item</td>
					</TR>
					<?php
					  $sql="select vp.viapar_descripcion from vialidad_participativa vp,viaparxpri vxp "
							."where vp.viapar_id=vxp.viapar_id and vxp.datpro_id=$idp ";
					  $rs = &$conn->Execute($sql);
					  $cont=0;
					  if($rs->EOF)
					  {
						?>
					  <TR valign=top bgcolor='#ffffff'>
						<TD valign=top nowrap>
						  El proyecto no tiene Vialidad Participativa.  Para ingresar datos de click en el botón "Atrás"
						</TD>
					  </TR>	
						<?	
					  }
					  else 
					  {
						while(!$rs->EOF)
						{
		  					$vialidad=$rs->fields[0];
					?>
					<TR valign=top bgcolor='#ffffff'>
						<TD valign=top nowrap><?=$vialidad?>&nbsp;</TD>						
					</TR>
					<?php
							$cont=$cont+1;
							$rs->MoveNext();
						}
					  }
					?>					
				</TABLE>
				</TD></TR>
			</TABLE>				
		</table>      
	</table>

<br>
<?php
//contrapartida	
	include_once("class/c_contrapartida.php");
	$obj=new c_contrapartida($conn);
	
	$res=$obj->info($idp);//$idp tiene el datpro_id
	
		$campo=array(
						array("etiqueta"=>"* Porcentaje de la Contrapartida de los Beneficiarios","nombre"=>"da0","tipo_campo"=>"text","sql"=>"","valor"=>$obj->contra_beneficiarios),
						array("etiqueta"=>"* Porcentaje de la Contrapartida del Proponente","nombre"=>"da1","tipo_campo"=>"text","sql"=>"","valor"=>$obj->contra_proponente)
					);
		$campo_hidden=array(
							array("nombre"=>"id_aplicacion","valor"=>$id_aplicacion),
					  		array("nombre"=>"id_subaplicacion","valor"=>$id_subaplicacion),
							array("nombre"=>"principal","valor"=>$principal),
							array("nombre"=>"idp","valor"=>$idp)
							
							);
		//construye el html para los campos relacionados
		build_show($conn,'false',"Contrapartida","images/360/personwrite.gif","50%",'true'
		,$campo,$campo_hidden,$id);
?>
<br>	
<?
  //beneficio ambiental
?>	
  <TABLE WIDTH="50%" CELLSPACING=0 CELLPADDING=0 CLASS="homebox">
	<TR><TD>
			<table width="100%" border=0 cellspacing=0 cellpadding=0 CLASS="titletable">
			<tr>
				<td nowrap><SPAN class="title" STYLE="cursor:default;">
					<img src="images/360/yearview.gif" border=0 align=absmiddle HSPACE=2><font color="#FFFFFF">
					Beneficio Ambiental</font></SPAN>
				</td>
			</TR>
			</TABLE>
			<TABLE WIDTH="100%" CELLSPACING=0 CELLPADDING=0 CLASS="tableinside">
			<TR><TD>
				<TABLE WIDTH='100%' border=0 CELLPADDING=2 CELLSPACING=1 BGCOLOR='#CCCCCC'>
					<TR BGCOLOR="#CCCCCC">						
                      <td nowrap class='table_hd'>Item</td>
					</TR>
					<?php
					  $sql="select ba.benamb_descripcion "
							."from beneficio_ambiental ba,benambxpri bxp "
							."where ba.benamb_id=bxp.benamb_id and datpro_id=$idp ";
					  $rs = &$conn->Execute($sql);
					  $cont=0;
					  if($rs->EOF)
					  {
						?>
					  <TR valign=top bgcolor='#ffffff'>
						<TD valign=top nowrap>El proyecto no tiene Beneficio Ambiental</TD>						
					  </TR>	
						<?	
					  }
					  else 
					  {
						while(!$rs->EOF)
						{
		  					$benamb=$rs->fields[0];
					?>
					<TR valign=top bgcolor='#ffffff'>
						<TD valign=top nowrap><?=$benamb?></TD>						
					</TR>
					<?php
							$cont=$cont+1;
							$rs->MoveNext();
						}
					  }
					?>					
				</TABLE>
				</TD></TR>
			</TABLE>				
			<TR><TD>
				<input type='hidden' name='total' value='<?=$cont?>'>
				<input type="hidden" name="cextra" value="id_aplicacion|id_subaplicacion|principal|id">	
				</td>
        		</tr>
				</table>      

		</table>
	
  </form>

<?php
		buildsubmenufooter();		
		//rs2html($recordSet,"border=3 bgcolor='#effee'");
		
?>
</body>
</html>