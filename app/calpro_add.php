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
		
		buildmenu($username);
		buildsubmenu($id_aplicacion,$id_subaplicacion);
		
		$principal="calpro_add.php";
		$param_destino="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&principal=".$principal."&idp=".$idp;		
?>
	
	<br>
	<form action="calpro_add1.php" method="post" name="form1">

	<input type="hidden" name="principal" value="<?=$principal?>">
	<input type="hidden" name="id_aplicacion" value="<?=$id_aplicacion?>">
	<input type="hidden" name="id_subaplicacion" value="<?=$id_subaplicacion?>">
	<input type="hidden" name="idp" value="<?=$idp?>">
		
	<input name="Apply" type="submit" id="Apply"  value="Aplicar">
	<input type="button" name="back" value="Atrás" onClick="self.location='calificaproyecto.php<?=$param_destino?>';">	
	
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
					Proyectos por Priorizar &nbsp;</font></SPAN>
				</td>
			</TR>
			</TABLE>
			<TABLE WIDTH="100%" CELLSPACING=0 CELLPADDING=0 CLASS="tableinside">
			<TR><TD>
				<TABLE WIDTH='100%' border=0 CELLPADDING=2 CELLSPACING=1 BGCOLOR='#CCCCCC'>
					<TR BGCOLOR="#CCCCCC">						
                      <td nowrap class='table_hd'>&nbsp;</td>						
                      
                    <td nowrap class='table_hd'>Datos Ingreso Proyecto</td>
                    <td nowrap class='table_hd'>Proyecto Código</td>
                    <td nowrap class='table_hd'>Proyecto Descripción</td>
					</TR>
					<?php
						$sqlprio="select distinct datpro_id from priorizacion_proyecto ";
						$cadprio="";
						$rsprio=&$conn->Execute($sqlprio);
						if(!$rsprio->EOF)
						{
						  while(!$rsprio->EOF)
						  {
						  	$cadprio.=$rsprio->fields[0].",";
						  	$rsprio->MoveNext();
						  }	
						  $cadprio=substr($cadprio,0,(strlen($cadprio)-1));
						  
						  $sql="select dp.datpro_id,dp.datpro_codigo,"
							."date_format(ip.ingpro_fecha,'%Y-%m-%d'),ip.ingpro_nrodptotecnico,"
							."ip.ingpro_nrorecepcion,ip.ingpro_nrodocint,dp.datpro_nombre "
							."from dato_proyecto dp,ingreso_proyecto ip "
							."where dp.datpro_id not in ($cadprio) "
							."and ip.ingpro_codigo=dp.ingpro_codigo";
						}
						else
						{
						  $sql="select dp.datpro_id,dp.datpro_codigo,"
							."date_format(ip.ingpro_fecha,'%Y-%m-%d'),ip.ingpro_nrodptotecnico,"
							."ip.ingpro_nrorecepcion,ip.ingpro_nrodocint,dp.datpro_nombre "
							."from dato_proyecto dp,ingreso_proyecto ip "
							."where ip.ingpro_codigo=dp.ingpro_codigo";  	
						}
					    //echo "<hr>$sql<hr>";
						
						$rs = &$conn->Execute($sql);
						$cont=0;
						
						if($rs->EOF)
						{
						?>
					   <tr valign=top bgcolor='#ffffff'>
						<td valign=top nowrap colspan="4"> 
						  No hay proyectos por priorizar
						</td></tr>	  
						<?  	
						}
						
						while(!$rs->EOF)
						{
		  					$core_id=$rs->fields[0];
							$core_code=$rs->fields[1];
							$core_desc=$rs->fields[6];
							
							$cading=$rs->fields[2].":".$rs->fields[3].":".$rs->fields[4].":".$rs->fields[5];
					?>
					<TR valign=top bgcolor='#ffffff'>
						<TD valign=top nowrap> 
						  <input type='checkbox' name='chc[<?=$cont?>]' value='<?=$core_id?>' >&nbsp;
						  <input type='hidden' name='chidden[<?=$cont?>]' value='<?=$core_code?>' >
						</TD>
						<TD valign=top nowrap><?=$cading?></TD>
						<TD valign=top nowrap><?=$core_code?></TD>
						<TD valign=top nowrap><?=$core_desc?></TD>
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