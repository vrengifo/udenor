<?php 
session_start(); 
//comentario
// idp es el id del padre, o id de la cabecera
// en este caso idp es el id del componente 
?>
<? include('includes/main.php'); ?>
<? include('adodb/tohtml.inc.php'); ?>
<?php

		extract($_REQUEST);		
		require_once('includes/header.php');
		$username=$session_username;
		
		$principal="probjetivo.php";
		$param_destino="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&principal=".$principal."&idp=".$idp;		
?>
	
	<br>
	<form action="probjetivo1.php" method="post" name="form1">
	<?php				
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

	<input name="Apply" type="submit" id="Apply"  value="Aplicar">
	<input type="button" name="back" value="Cerrar" onClick="window.close();">	
	
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