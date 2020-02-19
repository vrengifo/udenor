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
  
  
<p><strong>Bienvenido al Asistente para Priorización de Proyectos.</strong></p>
<p>
  A continuaci&oacute;n se le indicar&aacute;n los pasos a seguir, una vez completado el asistente Ud. genera en el sistema 
  el ingreso de la priorización de un proyecto.
</p>
<p>
  Nota: Use los botones &quot;Continuar&quot; y &quot;Atr&aacute;s&quot; para navegar en el asistente. 
  El bot&oacute;n &quot;Cerrar&quot; cerrar&aacute; el asistente. En caso de tener complicaciones con el ingreso 
  notificar al administrador del sistema. 
</p>

<table border="1" width="80%">
  <tr>
    <td><strong>Paso</strong></td>
	<td><strong>Descripción</strong></td>
	<td><strong>Estado</strong></td>
  </tr>
  <tr class="tab">
    <td>1</td>
	<td>Ingresar valores para determinar si el proyecto cumple con los Objetivos de Udenor</td>
	<td>Ingresando</td>
  </tr>
  <tr>
    <td>2</td>
	<td>Ingresar los estados del avance del proyecto</td>
	<td>Pendiente</td>
  </tr>
  <tr>
    <td>3</td>
	<td>Ingresar el Beneficio Social</td>
	<td>Pendiente</td>
  </tr>
  <tr>
    <td>4</td>
	<td>Ingresar el Beneficio Económico</td>
	<td>Pendiente</td>
  </tr>
  <tr>
    <td>5</td>
	<td>Ingresar la Vialidad participativa</td>
	<td>Pendiente</td>
  </tr>
  <tr>
    <td>6</td>
	<td>Ingresar la Contrapartida</td>
	<td>Pendiente</td>
  </tr>
  <tr>
    <td>7</td>
	<td>Ingresar el Beneficio Ambiental</td>
	<td>Pendiente</td>
  </tr>
</table>  
<br>  
  <form action="wprobjetivo1.php" method="post" name="form1">
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
	<input name="Apply" type="submit" value="Continuar">
	<input type="button" name="Cerrar" value="Cerrar" onClick="window.close();">
	<a href="#" onclick="print();"><img src="images/360/print.gif" border="0" alt="Imprimir"></a>
	
<SCRIPT LANGUAGE="JavaScript">
function valida() {
}
</script>	
<br>			
			
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
                      <td nowrap class='table_hd'>&nbsp;</td>						
                      
                    <td nowrap class='table_hd'>Objetivo</td>
					</TR>
					<?php
						$sql="select objude_codigo,objude_descripcion from objetivo_udenor order by objude_codigo ";
						$rs = &$conn->Execute($sql);
						$cont=0;
						while(!$rs->EOF)
						{
		  					$core_id=$rs->fields[0];
							$core_des=$rs->fields[1];
					?>
					<TR valign=top bgcolor='#ffffff'>
						<TD valign=top nowrap> <input type='checkbox' name='chc[<?=$cont?>]' value='<?=$core_id?>' 
						<?php
						  $sql_si="select objude_codigo from objxpri "
						  		."where datpro_id=$idp and objude_codigo='$core_id' ";
						  $rs1 = &$conn->Execute($sql_si);
						  if(!$rs1->EOF)
						    echo " checked";
						?>
						>&nbsp;</TD>
						<TD valign=top nowrap><?=$core_des?>&nbsp;</TD>						
					</TR>
					<?php
							$cont=$cont+1;
							$rs->MoveNext();
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